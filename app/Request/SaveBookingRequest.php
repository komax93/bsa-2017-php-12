<?php
/**
 * Created by PhpStorm.
 * User: maxym
 * Date: 26.07.17
 * Time: 22:40
 */

namespace App\Request;

use App\Request\Contract\SaveBookingRequest as SaveBookingRequestContract;
use App\Entity\Booking;
use App\Entity\User;
use App\Entity\Car;

class SaveBookingRequest extends AbstractRequest implements SaveBookingRequestContract
{
    /**
     * SaveBookingRequest constructor.
     * @param array $options
     * @param User|null $user
     * @param Car|null $car
     */
    public function __construct(array $options, User $user = null, Car $car = null)
    {
        parent::__construct(array_merge([
            'car' => $car,
            'user' => $user
        ], $options));
    }

    /**
     * @return Booking
     */
    public function getBooking(): Booking
    {
        return $this->get('booking', new Booking());
    }

    /**
     * @return Car
     */
    public function getCar(): Car
    {
        return $this->get('car');
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->get('user');
    }

    /**
     * @return mixed|null
     */
    public function getRentedFrom()
    {
        return $this->get('rented_from');
    }

    /**
     * @return mixed|null
     */
    public function getRentedAt()
    {
        return $this->get('rented_at');
    }

    /**
     * @return mixed|null
     */
    public function getReturnedTo()
    {
        return $this->get('returned_to');
    }

    /**
     * @return mixed|null
     */
    public function getReturnedAt()
    {
        return $this->get('returned_at');
    }

    /**
     * @return mixed|null
     */
    public function getPrice()
    {
        return (float) ($this->get('price')) ?? 0.0;
    }
}