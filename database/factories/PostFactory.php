<?php

namespace Inisev\Newsletter\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Inisev\Newsletter\Models\Post;
use Inisev\Newsletter\Models\Website;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'website_id' => Website::factory(),
            'local_id' => fake()->uuid(),
            'title' => fake()->words(asText: true),
            'description' => fake()->sentences(asText: true),
            'url' => fake()->url(),
        ];
    }

    public function withWebsite(int|Website|WebsiteFactory $website): static
    {
        return $this->state(fn () => [
            'website_id' => $website,
        ]);
    }
}
