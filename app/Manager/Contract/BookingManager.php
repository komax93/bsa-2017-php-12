<?php

namespace App\Manager\Contract;

use App\Entity\Booking;
use App\Entity\Car;
use App\Entity\User;
use App\Request\SaveBookingRequest;
use Illuminate\Support\Collection;

interface BookingManager
{
    /**
     * Find All Records
     *
     * @return Collection
     */
    public function findAll(): Collection;

    /**
     * Find Booked car by id
     *
     * @param int $id
     * @return User|null
     */
    public function findById(int $id);

    /**
     * Find user's car
     *
     * @param User $user
     * @param Car $car
     * @return mixed
     */
    public function findUserCar(User $user, Car $car);

    /**
     * Check if car is booked
     *
     * @param Car $car
     * @return mixed
     */
    public function isBooked(Car $car);

    /**
     * Check if user has car
     *
     * @param User $user
     * @return mixed
     */
    public function isUserHasCar(User $user);

    /**
     * Create or Update Booking
     *
     * @param SaveBookingRequest $request
     * @return Booking
     */
    public function saveBooking(SaveBookingRequest $request): Booking;

    /**
     * Delete booking by id
     *
     * @param int $id
     * @return mixed
     */
    public function deleteBooking(int $id);
}