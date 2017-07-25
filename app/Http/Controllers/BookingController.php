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
        $user = $this->userManager->findById($request->user_id);
        $car = $this->carManager->findById($request->car_id);

        if(is_null($user) || is_null($car)) {
            return response()->json(['error' => 'data not found'], 404);
        }
    }
}
