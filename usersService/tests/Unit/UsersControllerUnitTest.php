<?php 

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;

class UsersControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_store_user_and_return_success_response()
    {
        // Arrange
        $userData = [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'john@example.com',
        ];

        // Act
        $response = $this->postJson('/api/users', $userData);

        // Assert
        $response->assertStatus(Response::HTTP_CREATED)
                 ->assertJson(['message' => 'User created successfully']);

        $this->assertDatabaseHas('users', $userData);
    }

    /** @test */
    public function it_should_return_error_response_if_validation_fails()
    {
        // Arrange: Prepare invalid user data
        $userData = [
            'firstName' => '', // Missing required field
            'lastName' => 'Doe',
            'email' => 'invalid-email', // Invalid email format
        ];

        // Act: Make a POST request with invalid data
        $response = $this->postJson('/api/users', $userData);

        // Assert: Check for error response
        $response->assertStatus(Response::HTTP_BAD_REQUEST)
                 ->assertJsonStructure(['errors' => ['firstName', 'email']]);
    }
}