<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use App\Entity\User;
use App\Entity\Car;

class Booking extends Model
{
    /**
     * @var string
     */
    protected $table = 'booking';

    /**
     * @var bool
     */
    protected $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'car_id',
        'user_id',
        'rented_from',
        'rented_at',
        'returned_to',
        'returned_at',
        'price',
    ];

    /**
     * Belongs to User
     */
    public function user()
    {
        $this->belongsTo(User::class);
    }

    /**
     * Belongs to car
     */
    public function car()
    {
        $this->belongsTo(Car::class);
    }
}
