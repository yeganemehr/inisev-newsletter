<?php

namespace Inisev\Newsletter\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Inisev\Newsletter\Models\Subscriber;
use Inisev\Newsletter\Models\Website;

/**
 * @extends Factory<Subscriber>
 */
class SubscriberFactory extends Factory
{
    protected $model = Subscriber::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'website_id' => Website::factory(),
            'email' => fake()->email(),
            'name' => fake()->name(),
        ];
    }

    public function withWebsite(int|Website|WebsiteFactory $website): static
    {
        return $this->state(fn () => [
            'website_id' => $website,
        ]);
    }
}
