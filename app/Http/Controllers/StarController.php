<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStarRequest;
use App\Http\Requests\UpdateStarRequest;
use App\Http\Resources\StarResource;
use App\Models\Star;
use Illuminate\Http\Response;

class StarController extends Controller
{
    public function index()
    {
        return StarResource::collection(Star::all());
    }

    public function store(StoreStarRequest $request)
    {
        $star = new Star();
        $star->fill($request->validated());
        $star->save();

        return response()->json(status: Response::HTTP_CREATED);
    }

    public function show(Star $star)
    {
        return StarResource::make($star);
    }

    public function update(UpdateStarRequest $request, Star $star)
    {
        $star->update($request->validated());

        return response()->json(status: Response::HTTP_OK);
    }

    public function destroy(Star $star)
    {
        $star->delete();

        return response()->json(status: Response::HTTP_OK);
    }
}
