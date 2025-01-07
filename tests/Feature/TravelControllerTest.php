<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use App\Models\Travel;
use App\Http\Controllers\TravelController;
use App\Services\TravelService;
use Illuminate\Http\Request;

class TravelControllerTest extends TestCase
{
    public function testListTravel()
    {
        $mockTravelService = Mockery::mock(TravelService::class);
        $mockTravelService->shouldReceive('getAllTravelPlans')
            ->once()
            ->andReturn(collect([
                ['id' => 1, 'destination' => 'Paris', 'start_date' => '2025-01-01', 'end_date' => '2025-01-10', 'description' => 'Vacation'],
                ['id' => 2, 'destination' => 'Tokyo', 'start_date' => '2025-02-01', 'end_date' => '2025-02-05', 'description' => 'Business Trip'],
            ]));

        $controller = new TravelController($mockTravelService);

        $response = $controller->list();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertStringContainsString('Paris', $response->getContent());
        $this->assertStringContainsString('Tokyo', $response->getContent());
    }

    public function testCreateTravel()
    {
        $mockTravelService = Mockery::mock(TravelService::class);
        $mockTravelService->shouldReceive('createTravelPlan')
            ->once()
            ->andReturn(new Travel([
                'id' => 1,
                'destination' => 'Paris',
                'start_date' => '2025-01-01',
                'end_date' => '2025-01-10',
                'description' => 'Vacation',
            ]));

        $controller = new TravelController($mockTravelService);

        $request = Request::create('/create', 'POST', [
            'destination' => 'Paris',
            'start_date' => '2025-01-01',
            'end_date' => '2025-01-10',
            'description' => 'Vacation',
        ]);

        $response = $controller->create($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertStringContainsString('Successfully Created', $response->getContent());
    }

    public function testUpdateTravel()
    {
        $mockTravelService = Mockery::mock(TravelService::class);
        $mockTravelService->shouldReceive('updateTravelPlan')
            ->once()
            ->with(1, [
                'destination' => 'Paris Updated',
                'start_date' => '2025-01-02',
                'end_date' => '2025-01-12',
                'description' => 'Updated Vacation',
            ])
            ->andReturn(new Travel([
                'id' => 1,
                'destination' => 'Paris Updated',
                'start_date' => '2025-01-02',
                'end_date' => '2025-01-12',
                'description' => 'Updated Vacation',
            ]));

        $controller = new TravelController($mockTravelService);

        $request = Request::create('/update', 'PUT', [
            'destination' => 'Paris Updated',
            'start_date' => '2025-01-02',
            'end_date' => '2025-01-12',
            'description' => 'Updated Vacation',
        ]);

        $response = $controller->update($request, 1);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertStringContainsString('Successfully Updated', $response->getContent());
    }

    public function testRemoveTravel()
    {
        $mockTravelService = Mockery::mock(TravelService::class);
        $mockTravelService->shouldReceive('deleteTravelPlan')
            ->once()
            ->with(1)
            ->andReturn(true);

        $controller = new TravelController($mockTravelService);

        $response = $controller->remove(1);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertStringContainsString('Successfully Deleted', $response->getContent());
    }
}
