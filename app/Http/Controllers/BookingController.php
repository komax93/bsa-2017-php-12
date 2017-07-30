<?php

namespace App\Http\Controllers;

use App\Manager\CarManager;
use App\Manager\UserManager;
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
        $requestData = $request->only([
            'user',
            'car',
            'address'
        ]);

        $user = $this->userManager->findById($requestData['user']);
        $car = $this->carManager->findById($requestData['car']);

        $this->rentalService->rentCar($user, $car, $requestData['address']);
    }
}
