<?php

use App\Models\Star;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertModelMissing;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

it('get all starts', function () {
    Star::factory(2)->create();

    get('api/stars')
        ->assertJsonCount(2, 'data')
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'first_name',
                    'last_name',
                    'profil_url',
                    'description',
                    'created_at',
                    'updated_at',
                ]
            ]
        ])
        ->assertSuccessful();
});

it('get one star', function () {
    $star = Star::factory(1)->createOne();

    get('api/stars/'.$star->getKey())
        ->assertJsonStructure([
            'data' => [
                'id',
                'first_name',
                'last_name',
                'profil_url',
                'description',
                'created_at',
                'updated_at',
            ]
        ])
        ->assertSuccessful();
});

it('can add a star', function () {
    post('/api/stars', [
        'first_name' => 'John',
        'last_name' => 'Smith',
        'profil_url' => 'https://example.com',
        'description' => 'A normal person',

    ])->assertCreated();

    assertDatabaseCount('stars', 1);
});

it('can update a star', function () {
    $star = Star::factory(1)->createOne([
        'first_name' => 'orignal_value',
    ]);

    put('/api/stars/'.$star->getKey(), [
        'first_name' => 'new_value',
    ])->assertSuccessful();

    $star->refresh();

    expect($star->first_name)->toEqual('new_value');

});

it('can delete a star', function () {
    $star = Star::factory(1)->createOne();

    delete('/api/stars/'.$star->getKey())->assertSuccessful();

    assertModelMissing($star);
});

it('return a placeholder image url when none is given', function () {

    $star = Star::factory(1)->createOne([
        'profil_url' => null
    ]);

    expect($star->getRawOriginal('profil_url'))->toBeEmpty()
        ->and($star->profil_url)->toBeString();
});
