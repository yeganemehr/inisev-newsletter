<?php

namespace Inisev\Newsletter\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Inisev\Newsletter\Models\Website;

/**
 * @extends Factory<Website>
 */
class WebsiteFactory extends Factory
{
    protected $model = Website::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'domain' => fake()->domainName(),
            'title' => fake()->word(),
        ];
    }
}
