<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use App\Models\User;
use App\Http\Controllers\UserController;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserControllerTest extends TestCase
{
    public function testListUsers()
    {
        // Mocking the UserService
        $mockUserService = Mockery::mock(UserService::class);
        $mockUserService->shouldReceive('getAllUsers')
            ->once()
            ->andReturn(collect([
                ['id' => 1, 'name' => 'test It', 'email' => 'testit@example.com'],
                ['id' => 2, 'name' => 'Jan Cruz', 'email' => 'juan@example.com']
            ]));

        // Instantiate the controller with the mock
        $controller = new UserController($mockUserService);

        // Call the method
        $response = $controller->list();

        // Assert the response
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertStringContainsString('John Doe', $response->getContent());
        $this->assertStringContainsString('Jane Doe', $response->getContent());
    }

    public function testCreateUser()
    {
        $mockUserService = Mockery::mock(UserService::class);
        $mockUserService->shouldReceive('createUser')
            ->once()
            ->andReturn(new User([
                'id' => 1,
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'role' => 'admin'
            ]));

        $controller = new UserController($mockUserService);

        $request = Request::create('/create', 'POST', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'secret',
            'role' => 'admin'
        ]);

        $response = $controller->create($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertStringContainsString('Successfully Created', $response->getContent());
    }

    public function testUpdateUser()
    {
        $mockUserService = Mockery::mock(UserService::class);
        $mockUserService->shouldReceive('updateUser')
            ->once()
            ->with(1, [
                'name' => 'John Doe Updated',
                'email' => 'john_updated@example.com'
            ])
            ->andReturn(new User([
                'id' => 1,
                'name' => 'John Doe Updated',
                'email' => 'john_updated@example.com',
                'role' => 'admin'
            ]));

        $controller = new UserController($mockUserService);

        $request = Request::create('/update', 'PUT', [
            'name' => 'John Doe Updated',
            'email' => 'john_updated@example.com'
        ]);

        $response = $controller->update($request, 1);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertStringContainsString('Successfully Updated', $response->getContent());
    }

    public function testRemoveUser()
    {
        $mockUserService = Mockery::mock(UserService::class);
        $mockUserService->shouldReceive('deleteUser')
            ->once()
            ->with(1)
            ->andReturn(true);

        $controller = new UserController($mockUserService);

        $response = $controller->remove(1);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertStringContainsString('Successfully Deleted', $response->getContent());
    }
}
