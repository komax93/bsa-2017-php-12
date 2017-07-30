<?php
/**
 * Created by PhpStorm.
 * User: maxym
 * Date: 31.07.17
 * Time: 1:17
 */

namespace Tests\Unit;


use Illuminate\Support\Facades\Artisan;
use Tests\BookingsHelper;
use Tests\CreatesApplication;
use Tests\TestCase;

class RentalServiceTest extends TestCase
{
    use CreatesApplication;
    use BookingsHelper;

    public function setUp()
    {
        parent::setUp();
        Artisan::call("migrate:refresh");
    }

    public function testRentedCar()
    {
        $car = $this->createCar();
        $user = $this->createUser();
    }
}