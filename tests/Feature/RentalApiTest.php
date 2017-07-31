<?php
/**
 * Created by PhpStorm.
 * User: maksym
 * Date: 31.07.17
 * Time: 19:10
 */

namespace Tests\Feature;

use App\Services\RentalService;
use Faker\Factory;
use Illuminate\Support\Facades\Artisan;
use Tests\BookingsHelper;
use Tests\TestCase;

class RentalApiTest extends TestCase
{
    /**
     * BookingsHelper trait
     */
    use BookingsHelper;

    /**
     * Set up RentalServiceTest
     */
    public function setUp()
    {
        parent::setUp();
        Artisan::call("migrate:refresh");
    }

    /**
     * Test rent car by api route
     */
    public function testRentCar()
    {
        $user = $this->createUser();
        $car = $this->createCar();
        $rentedFrom = Factory::create()->address;

        $this->actingAs($user)
            ->json('POST', '/api/cars/rent/', [
                'user' => $user->id,
                'car' => $car->id,
                'rented_from' => $rentedFrom
            ])
            ->assertStatus(200)
            ->assertJson([
                'user_id' => $user->id,
                'car_id' => $car->id,
                'rented_from' => $rentedFrom,
                'price' => RentalService::PRICE,
                'returned_to' => null,
                'returned_at' => null
            ]);

        $newUser = $this->createUser();
        $this->actingAs($newUser)
            ->json('POST', '/api/cars/rent/', [
                'user' => $newUser->id,
                'car' => $car->id,
                'rented_from' => $rentedFrom
            ])
            ->assertStatus(200)
            ->assertJson([
                'error' => "{$car->model} is rented now"
            ]);
    }
}