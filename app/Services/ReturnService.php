<?php

namespace App\Services;

use App\Entity\User;
use App\Entity\Car;
use App\Entity\Booking;
use Carbon\Carbon;

class ReturnService
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var Car
     */
    private $car;

    /**
     * ReturnService constructor.
     *
     * @param User $user
     * @param Car $car
     */
    public function __construct(User $user, Car $car)
    {
        $this->user = $user;
        $this->car = $car;
    }

    public function returnCar()
    {
        $rentedCar = Booking::where('user_id', '=', $this->user->id)->where('car_id', '=', $this->car->id);
        $rentedCar->returned_to = '';
        $rentedCar->returned_at = Carbon::now();
        $rentedCar->save();
    }
}