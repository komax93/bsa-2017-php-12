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

interface ReturnService
{
    /**
     * Return car interface method
     *
     * @param User $user
     * @param Car $car
     * @param $returnedTo
     * @return mixed
     */
    public function returnCar(User $user, Car $car, $returnedTo);
}