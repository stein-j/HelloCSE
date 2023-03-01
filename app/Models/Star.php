<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $profil_url
 * @property string $description
 */
class Star extends Model
{
    use HasFactory;

    protected function profilUrl(): Attribute
    {
        return Attribute::make(
            get: fn($profilUrl) => $profilUrl ?: $this->getPlaceholderProfileUrl()
        );
    }

    /**
     * Return a custom placeholder for the model
     */
    public function getPlaceholderProfileUrl(): string
    {
        $colorCode = base64_encode($this->first_name.$this->last_name);

        // Retrieve the first letter of each word from the first and last name
        $text = implode('',
            str("$this->first_name $this->last_name")
                ->explode(" ")
                ->map(fn($word) => $word[0] ?? '')
                ->toArray()
        );

        return "https://via.placeholder.com/500x500.png/$colorCode?text=$text";
    }
}
