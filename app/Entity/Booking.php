<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    /**
     * @var string
     */
    protected $table = 'booking';

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
}
