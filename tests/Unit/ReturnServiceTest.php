<?php
/**
 * Created by PhpStorm.
 * User: maksym
 * Date: 31.07.17
 * Time: 14:31
 */

namespace Tests\Unit;

use App\Entity\Booking;
use App\Exceptions\CarNotFoundException;
use App\Exceptions\UserHasNotCarException;
use App\Exceptions\UserNotFoundException;
use App\Services\RentalService;
use Faker\Factory;
use Illuminate\Support\Facades\Artisan;
use Tests\BookingsHelper;
use Tests\CreatesApplication;
use Tests\TestCase;

class ReturnServiceTest extends TestCase
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
     * This test checks if car was returned
     */
    public function testReturnCar()
    {
        $user = $this->bookedCar->users;
        $car = $this->bookedCar->cars;
        $returnTo = Factory::create()->address;

        $returnedCar = $this->returnCar($user, $car, $returnTo);

        $this->assertInstanceOf(Booking::class, $returnedCar);
        $this->assertTrue($returnedCar->exists);
        $this->assertArraySubset([
            "id" => $this->bookedCar->id,
            "user_id" => $user->id,
            "car_id" => $car->id,
            "rented_from" => null,
            "price" => 0.0,
            "returned_to" => $returnTo,
        ], $returnedCar->toArray());
    }

    /**
     * This test checks if user exists
     */
   /* public function testUserNotExists()
    {
        $this->expectException(UserNotFoundException::class);
        $user = $this->createUser();
        $car = $this->createCar();
        $returned_to = Factory::create()->address;
        $user->delete();
        $this->rentCar($user, $car, $returned_to);
    }*/

    /**
     * This test checks if car exists
     */
    /*public function testCarNotExists()
    {
        $this->expectException(CarNotFoundException::class);
        $user = $this->createUser();
        $car = $this->createCar();
        $returned_to = Factory::create()->address;
        $car->delete();
        $this->rentCar($user, $car, $returned_to);
    }*/

    /**
     * This test checks if car was returned
     */
    /*public function testReturnCar()
    {
        $user = $this->createUser();
        $car = $this->createCar();
        $rentedFrom = Factory::create()->address;

        $returnedCar = $this->returnCar($user, $car, $rentedFrom);

        $this->assertTrue($returnedCar->exists);
        $this->assertInstanceOf(Booking::class, $returnedCar);
        $this->assertArraySubset([
            "id" => $this->bookedCar->id,
            "user_id" => $user->id,
            "car_id" => $car->id,
            "rented_from" => $rentedFrom,
            "price" => RentalService::PRICE,
            "returned_to" => null,
            "returned_at" => null
        ], $returnedCar->toArray());
    }*/

    /**
     * This test checks if user return alien car
     */
    /*public function testReturnNotUserCar()
    {
        $this->expectException(UserHasNotCarException::class);
        $user = $this->createUser();
        $car = $this->createCar();
        $returned_from = Factory::create()->address;
        $this->rentCar($user, $car, $returned_from);
        $returned_to = Factory::create()->address;

        $this->returnCar($this->bookedCar->car, $user, $returned_to);
    }*/
}