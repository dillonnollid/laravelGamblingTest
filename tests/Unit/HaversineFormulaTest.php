<?php
namespace Tests\Unit;

use App\Http\Controllers\AffiliateController;
use Tests\TestCase;

class HaversineFormulaTest extends TestCase
{
    /**
     * Test the haversine formula method in the AffiliateController.
     * @dataProvider coordinatesDataProvider
     */
    public function test_haversine_formula_method($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $expectedDistance)
    {
        //Create a new instance of AffiliateController so we can access the haversineFormula function
        $testController = new AffiliateController();

        //Run the haversine formula method with the provided coordinates
        $calculatedDistance = $testController->haversineFormula($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo);

        //Assert that the rounded calculated distance is equal to the expected distance (https://www.movable-type.co.uk/scripts/latlong.html)
        $this->assertEquals($expectedDistance, round($calculatedDistance));
    }

    /**
     * Data provider for sets of coordinates and their expected distances.
     * Array items contain [latitudeFrom, longitudeFrom, latitudeTo, longitudeTo, expectedDistance].
     * @return array
     */
    public function coordinatesDataProvider()
    {
        //Sample data from Dublin Office to 1. Westport and 2. Castlebar
        //Distances calculated with https://www.movable-type.co.uk/scripts/latlong.html
        return [
            [deg2rad(53.3340285), deg2rad(-6.2535495), deg2rad(53.801140), deg2rad(-9.522290), 222],
            [deg2rad(53.3340285), deg2rad(-6.2535495), deg2rad(53.855000), deg2rad(-9.287926), 208],
        ];
    }
}
