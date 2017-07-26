<?php

namespace App\Services;

use DateTime;
use App\Manager\BookingManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalService
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
     * Rent a car
     * This method rent car by current user
     */
    public function rentCar(Request $request)
    {
        $data = [
            'car_id' => $request->car_id,
            'user_id' => Auth::user()->id,
            'price' => self::price,
            'rented_from' => $request->rented_from,
            'rented_at' => new DateTime
        ];

        return $this->bookingManager->saveBooking($data);
    }
}