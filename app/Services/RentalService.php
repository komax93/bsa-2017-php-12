<?php

namespace App\Services;

use App\Entity\User;
use App\Entity\Car;
use App\Entity\Booking;
use Carbon\Carbon;

class RentalService
{
    /**
     * Fixed const price
     * @int
     */
    const PRICE = 50;

    /**
     * @var User
     */
    private $user;

    /**
     * @var Car
     */
    private $car;

    /**
     * RentalService constructor.
     *
     * @param User $user
     * @param Car $car
     */
    public function __construct(User $user, Car $car)
    {
        $this->user = $user;
        $this->car = $car;
    }

    /**
     * Rent a car
     * This method rent car by current user
     */
    public function rentCar()
    {
        $booking = new Booking();
        $booking->user_id = $this->user->id;
        $booking->car_id = $this->car->id;
        $booking->rented_from = Carbon::now();
        $booking->price = self::PRICE;
        $booking->save();
    }
}