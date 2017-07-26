<?php
/**
 * Created by PhpStorm.
 * User: maxym
 * Date: 26.07.17
 * Time: 23:00
 */

namespace App\Request\Contract;

use App\Entity\Booking;
use App\Entity\User;
use App\Entity\Car;

interface SaveBookingRequest
{
    /**
     * @return Booking
     */
    public function getBooking(): Booking;

    /**
     * @return Car
     */
    public function getCar(): Car;

    /**
     * @return User
     */
    public function getUser(): User;

    /**
     * @return mixed|null
     */
    public function getRentedFrom();

    /**
     * @return mixed|null
     */
    public function getRentedAt();

    /**
     * @return mixed|null
     */
    public function getReturnedTo();

    /**
     * @return mixed|null
     */
    public function getReturnedAt();

    /**
     * @return mixed|null
     */
    public function getPrice();
}