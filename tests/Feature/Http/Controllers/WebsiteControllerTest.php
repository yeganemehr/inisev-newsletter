<?php

namespace Inisev\Newsletter\Tests\Feature\Http\Controllers;

use Inisev\Newsletter\Models\Website;
use Inisev\Newsletter\Tests\TestCase;

class WebsiteControllerTest extends TestCase
{
    public function testList(): void
    {
        Website::factory(5)->create();

        $response = $this->getJson(route('websites.index'))
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'domain',
                        'title',
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
        $this->postJson(route('websites.store'), [
            'domain' => 'inisev.com',
            'title' => 'INformation IS Everything',
        ])
            ->assertCreated()
            ->assertJson([
                'data' => [
                    'domain' => 'inisev.com',
                    'title' => 'INformation IS Everything',
                ],
            ]);
    }

    public function testDuplicateStore(): void
    {
        $website = Website::factory()->create();
        $this->postJson(route('websites.store'), [
            'domain' => $website->domain,
            'title' => 'Whatever',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('domain');
    }

    public function testShow(): void
    {
        $website = Website::factory()->create();

        $this->getJson(route('websites.show', ['website' => $website->id]))
            ->assertOk()
            ->assertJson([
                'data' => [
                    'domain' => $website->domain,
                    'title' => $website->title,
                ],
            ]);
    }

    public function testUpdate(): void
    {
        $website = Website::factory()->create();

        $this->putJson(route('websites.update', ['website' => $website->id]), [
            'domain' => 'inisev.com',
            'title' => 'INformation IS Everything',
        ])
            ->assertOk()
            ->assertJson([
                'data' => [
                    'domain' => 'inisev.com',
                    'title' => 'INformation IS Everything',
                ],
            ]);
    }

    public function testUpdateDuplicate(): void
    {
        $website1 = Website::factory()->create();
        $website2 = Website::factory()->create();

        $this->putJson(route('websites.update', ['website' => $website1->id]), [
            'domain' => $website2->domain,
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('domain');
    }

    public function testDestroy(): void
    {
        $website = Website::factory()->create();

        $this->delete(route('websites.destroy', ['website' => $website->id]))
            ->assertNoContent();
        $this->assertDatabaseMissing($website, ['id' => $website->id]);
    }
}
