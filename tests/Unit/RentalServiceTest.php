<?php
/**
 * Created by PhpStorm.
 * User: maxym
 * Date: 31.07.17
 * Time: 1:17
 */

namespace Tests\Unit;


use App\Entity\Booking;
use App\Exceptions\BookedCarException;
use App\Exceptions\CarNotFoundException;
use App\Exceptions\UserHasCarException;
use App\Exceptions\UserNotFoundException;
use App\Services\RentalService;
use Faker\Factory;
use Illuminate\Support\Facades\Artisan;
use Tests\BookingsHelper;
use Tests\CreatesApplication;
use Tests\TestCase;

class RentalServiceTest extends TestCase
{
    /**
     * CreatesApplication trait
     */
    use CreatesApplication;

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
     * This test checks if car was booked
     */
    public function testBookedCar()
    {
        $user = $this->createUser();
        $car = $this->createCar();
        $rentedFrom = Factory::create()->address;

        $bookedCar = $this->rentCar($user, $car, $rentedFrom);
        $this->assertTrue($bookedCar->exists);
        $this->assertInstanceOf(Booking::class, $bookedCar);
        $this->assertArraySubset([
            "user_id" => $user->id,
            "car_id" => $car->id,
            "rented_from" => $rentedFrom,
            "price" => RentalService::PRICE,
            "returned_to" => null,
            "returned_at" => null
        ], $bookedCar->toArray());
    }

    /**
     * This test checks if user exists
     */
    public function testUserNotExists()
    {
        $this->expectException(UserNotFoundException::class);
        $user = $this->createUser();
        $car = $this->createCar();
        $rented_from = Factory::create()->address;
        $user->delete();
        $this->rentCar($user, $car, $rented_from);
    }

    /**
     * This test checks if car exists
     */
    public function testCarNotExists()
    {
        $this->expectException(CarNotFoundException::class);
        $user = $this->createUser();
        $car = $this->createCar();
        $rented_from = Factory::create()->address;
        $car->delete();
        $this->rentCar($user, $car, $rented_from);
    }

    /**
     * This test checks if user has car now
     */
    public function testUserHasCar()
    {
        $this->expectException(UserHasCarException::class);
        $user = $this->createUser();
        $car1 = $this->createCar();
        $car2 = $this->createCar();
        $rented_from = Factory::create()->address;
        $this->rentCar($user, $car1, $rented_from);
        $this->rentCar($user, $car2, $rented_from);
    }

    /**
     * This test checks if car is booked now
     */
    public function testCarBookedNow()
    {
        $this->expectException(BookedCarException::class);
        $user1 = $this->createUser();
        $user2 = $this->createUser();
        $car = $this->createCar();
        $rented_from = Factory::create()->address;
        $this->rentCar($user1, $car, $rented_from);
        $this->rentCar($user2, $car, $rented_from);
    }
}