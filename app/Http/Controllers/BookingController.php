<?php

namespace App\Http\Controllers;

use App\Manager\CarManager;
use App\Manager\UserManager;
use App\Request\SaveBookingRequest;
use App\Services\RentalService;
use App\Services\ReturnService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    private $carManager;
    private $userManager;
    private $rentalService;
    private $returnService;

    public function __construct(
        CarManager $carManager,
        UserManager $userManager,
        RentalService $rentalService,
        ReturnService $returnService)
    {
        $this->carManager = $carManager;
        $this->userManager = $userManager;
        $this->rentalService = $rentalService;
        $this->returnService = $returnService;
    }

    public function rent(Request $request)
    {
        $data = $request->toArray();
        $user = $this->userManager->findById(1);
        $car = $this->carManager->findById(1);

        $request = new SaveBookingRequest($data, $user, $car);

        $this->rentalService->rentCar($request);
    }
}
