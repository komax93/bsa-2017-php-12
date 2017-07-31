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
    public $timestamps = false;

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
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Belongs to car
     */
    public function cars()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }
}
