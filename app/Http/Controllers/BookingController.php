<?php

namespace App\Http\Controllers;

use App\Exceptions\UserHasNotCarException;
use App\Manager\CarManager;
use App\Manager\UserManager;
use App\Services\RentalService;
use App\Services\ReturnService;
use App\Exceptions\UserHasCarException;
use App\Exceptions\BookedCarException;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\CarNotFoundException;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * @var CarManager
     */
    private $carManager;

    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * @var RentalService
     */
    private $rentalService;

    /**
     * @var ReturnService
     */
    private $returnService;

    /**
     * BookingController constructor.
     *
     * @param CarManager $carManager
     * @param UserManager $userManager
     * @param RentalService $rentalService
     * @param ReturnService $returnService
     */
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

    /**
     * This action rent a car
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function rent(Request $request)
    {
        $requestData = $request->only([
            'user',
            'car',
            'rented_from'
        ]);

        $user = $this->userManager->findById($requestData['user']);
        $car = $this->carManager->findById($requestData['car']);

        if(is_null($user)) {
            return response()->json(['error' => 'user not found']);
        }

        if(is_null($car)) {
            return response()->json(['error' => 'car not found']);
        }

        try {
            $booked = $this->rentalService->rentCar($user, $car, $requestData['rented_from']);
            return response()->json([$booked]);
        } catch (UserNotFoundException | CarNotFoundException | UserHasCarException | BookedCarException $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * This action return a car
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function return(Request $request)
    {
        $requestData = $request->only([
            'user',
            'car',
            'returned_to'
        ]);

        $user = $this->userManager->findById($requestData['user']);
        $car = $this->carManager->findById($requestData['car']);

        if(is_null($user)) {
            return response()->json(['error' => 'user not found']);
        }

        if(is_null($car)) {
            return response()->json(['error' => 'car not found']);
        }

        try {
            $returned = $this->returnService->returnCar($user, $car, $requestData['returned_to']);
            return response()->json([$returned]);
        } catch (UserNotFoundException | CarNotFoundException | UserHasNotCarException $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
