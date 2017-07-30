<?php
/**
 * Created by PhpStorm.
 * User: maxym
 * Date: 31.07.17
 * Time: 0:40
 */

namespace tests;

use App\Entity\Car;
use App\Entity\User;
use App\Services\RentalService;
use App\Services\ReturnService;

trait BookingsHelper
{
    /**
     * Create car factory
     *
     * @return mixed
     */
    protected function createCar()
    {
        return factory(Car::class)->create();
    }

    /**
     * Create user factory
     *
     * @return mixed
     */
    protected function createUser()
    {
        return factory(User::class)->create();
    }

    /**
     * Rent car helper
     *
     * @param User $user
     * @param Car $car
     * @param $rentedFrom
     * @return mixed
     */
    protected function rentCar(User $user, Car $car, $rentedFrom)
    {
        return app(RentalService::class)->rentCar($user, $car, $rentedFrom);
    }

    /**
     * Return car helper
     *
     * @param User $user
     * @param Car $car
     * @param $rentedFrom
     * @return mixed
     */
    protected function returnCar(User $user, Car $car, $rentedFrom)
    {
        return app(ReturnService::class)->returnCar($user, $car, $rentedFrom);
    }
}