<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'ganz egal',
            'email' => 'egal@hermine.global',
            'google_id' => 'test-google-id',
            'hd' => '1',
            'avatar' => ':(',
        ];
    }
}
