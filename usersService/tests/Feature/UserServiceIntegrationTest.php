<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersControllerIntegrationTest extends TestCase
{

    // use RefreshDatabase;

    /** @test */
    public function it_should_publish_user_data_to_redis_and_log_user()
    {
        $redisSpy = Redis::spy();
        // Arrange: Prepare valid user data
        $userData = [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'john@example.com',
        ];

        // Mock Redis and Log facades
        $redisSpy->shouldReceive('publish')->once()->with('notify', json_encode($userData));
        Log::shouldReceive('info')->once()->with(json_encode($userData));

        // Act: Make a POST request to store user
        $response = $this->postJson('/api/users', $userData);

        // Assert: Check for success response
        $response->assertStatus(Response::HTTP_CREATED)
                 ->assertJson(['message' => 'User created successfully']);

        // Assert: Check if user data is stored in the database
        $this->assertDatabaseHas('users', $userData);
    }
}
