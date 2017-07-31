<?php
/**
 * Created by PhpStorm.
 * User: maxym
 * Date: 31.07.17
 * Time: 21:19
 */

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Faker\Factory;
use Tests\BookingsHelper;

class ReturnApiTest extends TestCase
{
    /**
     * BookingsHelper trait
     */
    use BookingsHelper;

    /**
     * @var
     */
    private $bookedCar;

    /**
     * Set up RentalServiceTest
     */
    public function setUp()
    {
        parent::setUp();
        Artisan::call("migrate:refresh");
        $user = $this->createUser();
        $car = $this->createCar();
        $rented_from = Factory::create()->address;
        $this->bookedCar = $this->rentCar($user, $car, $rented_from);
    }

    /**
     * Test return car
     */
    public function testReturnCar()
    {
        $user = $this->createUser();
        $car = $this->createCar();
        $returnedTo = Factory::create()->address;

        $this->actingAs($user)
            ->json('POST', '/api/cars/return/', [
                'user' => $user->id,
                'car' => $car->id,
                'returned_to' => $returnedTo
            ])
            ->assertStatus(200);

        $this->actingAs($user)
            ->json('POST', '/api/cars/return/', [
                'user' => $user->id,
                'car' => $car->id,
                'returned_to' => $returnedTo
            ])
            ->assertStatus(200)
            ->assertJson([
                'error' => "{$user->first_name} can't return this car, because car belongs another user"
            ]);
    }
}