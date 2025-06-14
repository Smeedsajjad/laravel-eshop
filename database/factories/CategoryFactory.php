<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        $catName = $this->faker->words(2, true);

        // Generate themed Picsum URLs
        $mainUrl   = $this->faker->imageUrl(640, 480);
        $bannerUrl = $this->faker->imageUrl(960, 240);

        return [
            'cat_name'     => $catName,
            'main_image'   => $mainUrl,
            'banner_image' => $bannerUrl,
        ];
    }
}
