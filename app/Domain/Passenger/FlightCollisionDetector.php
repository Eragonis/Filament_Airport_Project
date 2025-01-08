<?php

namespace App\Domain\Passenger;

use App\Models\Passenger;

class FlightCollisionDetector
{
    public static function run(Passenger $passenger): string
    {
 

        /*
        dd($passenger->flights);
        return "Collision!";
        */
        foreach ($passenger->flights as $flight) {
            foreach ($passenger->flights as $flightControl) {
                if ($flight == $flight) {
                    return "skip";
                }
                if($flight != $flightControl) {
                    return "skip";
                }
                if($flight == $flightControl) {
                    return "COLLISION!!!";
            }
    }
}
}
}