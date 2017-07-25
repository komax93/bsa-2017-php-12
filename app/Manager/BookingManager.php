<?php

namespace App\Manager;

use App\Entity\Booking;
use App\Entity\Car;
use App\Entity\User;
use App\Manager\Contract\BookingManager as BookingManagerContract;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class BookingManager implements BookingManagerContract
{
    /**
     * Find All Records
     *
     * @return Collection
     */
    public function findAll(): Collection
    {
        return Booking::all();
    }

    /**
     * Find Booked car by id
     *
     * @param int $id
     * @return User|null
     */
    public function findById(int $id)
    {
        return Booking::find($id);
    }

    /**
     * Find user's car
     *
     * @param User $user
     * @param Car $car
     * @return mixed
     */
    public function findUserCar(User $user, Car $car)
    {
        return Booking::where([
            ['car_id' => $car->id],
            ['user_id' => $user->id]
        ])->whereNull('returned_to')->whereNull('returned_at')->first();
    }

    /**
     * Check if car is booked
     *
     * @param Car $car
     * @return mixed
     */
    public function isBooked(Car $car)
    {
        $bookedCar = Booking::where('car_id', $car->id)
                        ->whereNotNull('user_id')->whereNull('returned_to')->whereNull('returned_at')->first();

        return !is_null($bookedCar);
    }

    /**
     * Check if user has car
     *
     * @param User $user
     * @return mixed
     */
    public function isUserHasCar(User $user)
    {
        $bookedByUser = Booking::where('user_id', $user->id)
            ->whereNotNull('user_id')->whereNull('returned_to')->whereNull('returned_at')->first();

        return !is_null($bookedByUser);
    }

    /**
     * Create or Update Booking
     *
     * @param Request $request
     * @return Booking
     */
    public function saveBooking(Request $request): Booking
    {
        $booking = new Booking();
        $booking->user_id = $request->user_id;
        $booking->car_id = $request->car_id;
        $booking->rented_from = $request->rented_at;
        $booking->rented_at = $request->rented_at;
        $booking->returned_to = $request->returned_to;
        $booking->returned_at = $request->returned_at;
        $booking->price = $request->price;
        $booking->save();

        return $booking;
    }

    /**
     * Delete booking by id
     *
     * @param int $id
     * @return mixed
     */
    public function deleteBooking(int $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();
    }
}