<?php

namespace App\Services;

use App\Entity\Car;
use App\Entity\User;
use App\Manager\BookingManager;
use App\Exceptions\UserHasCarException;
use App\Exceptions\BookedCarException;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\CarNotFoundException;
use App\Request\SaveBookingRequest;
use DateTime;

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
    public function rentCar(SaveBookingRequest $request)
    {
        /*if(is_null($request->getUser())) {
            throw new UserNotFoundException("{$request->getUser()->first_name} not found!");
        }

        if(is_null($request->getCar())) {
            throw new CarNotFoundException("{$request->getCar()->model} not found!");
        }

        if($this->bookingManager->isUserHasCar($request->getUser())) {
            throw new UserHasCarException("{$request->getUser()->first_name} rented a car now!");
        }

        if($this->bookingManager->isBooked($request->getCar())) {
            throw new BookedCarException("{$request->getCar()->model} is rented now");
        }*/

        return $this->bookingManager->saveBooking($request);
    }
}