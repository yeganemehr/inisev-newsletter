<?php

namespace Inisev\Newsletter\Tests\Feature\Http\Controllers;

use Inisev\Newsletter\Models\Subscriber;
use Inisev\Newsletter\Models\Website;
use Inisev\Newsletter\Tests\TestCase;

class SubscriberControllerTest extends TestCase
{
    public function testList(): void
    {
        $website = Website::factory()->create();
        Subscriber::factory(5)->withWebsite($website)->create();

        $response = $this->getJson(route('websites.subscribers.index', ['website' => $website->id]))
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'website_id',
                        'email',
                        'name',
                        'created_at',
                        'updated_at',
                    ],
                ],
                'meta' => [
                    'path',
                    'per_page',
                    'next_cursor',
                    'prev_cursor',
                ],
                'links' => [
                    'first',
                    'last',
                    'next',
                    'prev',
                ],
            ]);
        $this->assertCount(5, $response['data']);
    }

    public function testStore(): void
    {
        $website = Website::factory()->create();

        $data = [
            'email' => fake()->email(),
            'name' => fake()->name(),
        ];
        $this->postJson(route('websites.subscribers.store', ['website' => $website->id]), $data)
            ->assertCreated()
            ->assertJson([
                'data' => $data,
            ]);
    }

    public function testDuplicateStore(): void
    {
        $subscriber = Subscriber::factory()->create();

        $this->postJson(route('websites.subscribers.store', ['website' => $subscriber->website_id]), [
            'email' => $subscriber->email,
            'name' => fake()->name(),
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('email');
    }

    public function testShow(): void
    {
        $subscriber = Subscriber::factory()->create();

        $this->getJson(route('websites.subscribers.show', ['website' => $subscriber->website_id, 'subscriber' => $subscriber->id]))
            ->assertOk()
            ->assertJson([
                'data' => [
                    'website_id' => $subscriber->website_id,
                    'email' => $subscriber->email,
                    'name' => $subscriber->name,
                ],
            ]);
    }

    public function testUpdate(): void
    {
        $subscriber = Subscriber::factory()->create();

        $data = [
            'email' => fake()->email(),
            'name' => fake()->name(),
        ];
        $this->putJson(route('websites.subscribers.update', ['website' => $subscriber->website_id, 'subscriber' => $subscriber->id]), $data)
            ->assertOk()
            ->assertJson([
                'data' => $data,
            ]);
    }

    public function testUpdateDuplicate(): void
    {
        $subscriber1 = Subscriber::factory()->create();
        $subscriber2 = Subscriber::factory()->withWebsite($subscriber1->website_id)->create();

        $this->putJson(route('websites.subscribers.update', ['website' => $subscriber1->website_id, 'subscriber' => $subscriber1->id]), [
            'email' => $subscriber2->email,
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('email');
    }

    public function testDestroy(): void
    {
        $subscriber = Subscriber::factory()->create();

        $this->deleteJson(route('websites.subscribers.destroy', ['website' => $subscriber->website_id, 'subscriber' => $subscriber->id]))
            ->assertNoContent();
        $this->assertDatabaseMissing($subscriber, ['id' => $subscriber->id]);
    }
}
