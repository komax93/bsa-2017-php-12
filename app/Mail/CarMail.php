<?php

namespace App\Mail;

use App\Entity\Car;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CarMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Car
     */
    public $car;

    /**
     * Create a new message instance.
     *
     * @param Car $car
     */
    public function __construct(Car $car)
    {
        $this->car = $car;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.cars')->withCar($this->car);
    }
}
