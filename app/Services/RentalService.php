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
use App\Services\Contract\RentalService as RentalServiceContract;
use DateTime;

class RentalService implements RentalServiceContract
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
     * This method rent a car
     *
     * @param User $user
     * @param Car $car
     * @param $rentedFrom
     * @return \App\Entity\Booking
     * @throws BookedCarException
     * @throws CarNotFoundException
     * @throws UserHasCarException
     * @throws UserNotFoundException
     */
    public function rentCar(User $user, Car $car, $rentedFrom)
    {
        if(!$user->exists()) {
            throw new UserNotFoundException("{$user->first_name} not found!");
        }

        if(!$car->exists()) {
            throw new CarNotFoundException("{$car->model} not found!");
        }

        if($this->bookingManager->isUserHasCar($user)) {
            throw new UserHasCarException("{$user->first_name} rented a car now!");
        }

        if($this->bookingManager->isBooked($car)) {
            throw new BookedCarException("{$car->model} is rented now");
        }

        $request = new SaveBookingRequest([
            'rented_from' => $rentedFrom,
            'rented_at' => new DateTime,
            'price' => self::PRICE
        ], $user, $car);

        return $this->bookingManager->saveBooking($request);
    }
}