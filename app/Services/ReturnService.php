<?php

namespace App\Services;

use App\Exceptions\UserHasNotCarException;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\CarNotFoundException;
use App\Request\SaveBookingRequest;
use App\Manager\BookingManager;
use App\Services\Contract\ReturnService as ReturnServiceContract;
use App\Entity\User;
use App\Entity\Car;
use DateTime;

class ReturnService implements ReturnServiceContract
{
    /**
     * @var BookingManager
     */
    protected $bookingManager;

    /**
     * ReturnService constructor.
     *
     * @param BookingManager $bookingManager
     */
    public function __construct(BookingManager $bookingManager)
    {
        $this->bookingManager = $bookingManager;
    }

    /**
     * This method return a car
     *
     * @param User $user
     * @param Car $car
     * @param $returnedTo
     * @return \App\Entity\Booking
     * @throws CarNotFoundException
     * @throws UserHasNotCarException
     * @throws UserNotFoundException
     */
    public function returnCar(User $user, Car $car, $returnedTo)
    {
        $booking = $this->bookingManager->findUserCar($user, $car);

        if(!$user->exists()) {
            throw new UserNotFoundException("{$user->first_name} not found!");
        }

        if(!$car->exists()) {
            throw new CarNotFoundException("{$car->model} not found!");
        }

        if(is_null($booking)) {
            throw new UserHasNotCarException("{$user->first_name} can't return this car, because car belongs another user");
        }

        $request = new SaveBookingRequest([
            'booking' => $booking,
            'returned_to' => $returnedTo,
            'returned_at' => new DateTime,
        ], $user, $car);

        return $this->bookingManager->saveBooking($request);
    }
}