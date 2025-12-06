<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class CargolistTest extends TestCase
{
    //use RefreshDatabase;  // don't run on real database!
    use DatabaseMigrations;
    public function test_load_cargolist_site()
    {
        //$user = User::factory()->create();
        $user = User::create([
            'name' => 'ganz egal',
            'email' => 'egal@hermine.global',
            'google_id' => 'test-google-id',
            'hd' => '1',
            'avatar' => ':(',
        ]);

        $response = $this->actingAs($user)->get('/iz/cargolist');


        $response->assertStatus(200);
    }
}
