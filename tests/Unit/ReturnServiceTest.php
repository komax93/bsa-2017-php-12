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
     * This test checks if car which not exists return
     */
    public function testReturnCarWhichNotExists()
    {
        $this->expectException(CarNotFoundException::class);
        $returnTo = Factory::create()->address;

        $this->bookedCar->cars->delete();
        $this->returnCar($this->bookedCar->users, $this->bookedCar->cars, $returnTo);
    }

    /**
     * This test checks if user not exists
     */
    public function testUserNotExists()
    {
        $this->expectException(UserNotFoundException::class);

        $returnTo = Factory::create()->address;
        $user = $this->bookedCar->users;
        $car = $this->bookedCar->cars;
        $user->delete();

        $this->returnCar($user, $car, $returnTo);
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

    public function testReturnNotUserCar()
    {
        $user = $this->createUser();
        $car = $this->createCar();
        $rentedFrom = Factory::create()->address;

        $this->rentCar($user, $car, $rentedFrom);

        $returnedTo = Factory::create()->address;
        $this->returnCar($this->bookedCar->users, $this->bookedCar->cars, $returnedTo);
    }
}