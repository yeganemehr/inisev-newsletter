<?php

namespace Inisev\Newsletter\Tests\Feature\Console\Commands;

use Inisev\Newsletter\Tests\TestCase;

class SendNotificationsTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
