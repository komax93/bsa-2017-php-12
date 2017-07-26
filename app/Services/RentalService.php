<?php

namespace App\Services;

use App\Entity\Car;
use App\Entity\User;
use App\Manager\BookingManager;
use App\Exceptions\UserHasCarException;
use App\Exceptions\BookedCarException;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\CarNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalService
{
    /**
     * Fixed const price
     * @int
     */
    const PRICE = 50;

    /**
     * @var BookingManager
     */
    protected $bookingManager;

    /**
     * RentalService constructor.
     *
     * @param BookingManager $bookingManager
     */
    public function __construct(BookingManager $bookingManager)
    {
        $this->bookingManager = $bookingManager;
    }

    /**
     * Rent a car
     * This method rent car by current user
     */
    public function rentCar(User $user, Car $car, string $rented_from)
    {
        if(is_null($user)) {
            throw new UserNotFoundException("{$user} not found!");
        }

        if(is_null($car)) {
            throw new CarNotFoundException("{$car} not found!");
        }

        if($this->bookingManager->isUserHasCar($user)) {
            throw new UserHasCarException("{$user} rented a car now!");
        }

        if($this->bookingManager->isBooked($car)) {
            throw new BookedCarException("{$car} is rented now");
        }




        //return $this->bookingManager->saveBooking($data);
    }
}