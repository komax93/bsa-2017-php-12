<?php
/**
 * Created by PhpStorm.
 * User: maxym
 * Date: 31.07.17
 * Time: 0:53
 */

namespace App\Services\Contract;

use App\Entity\Car;
use App\Entity\User;

interface RentalService
{
    /**
     * RentCar interface method
     *
     * @param User $user
     * @param Car $car
     * @param $rentedFrom
     * @return mixed
     */
    public function rentCar(User $user, Car $car, $rentedFrom);
}