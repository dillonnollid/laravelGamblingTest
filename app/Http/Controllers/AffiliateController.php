<?php
namespace App\Http\Controllers;

use App\Models\Affiliate;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class AffiliateController extends Controller
{
    public function inviteAffiliates(): View
    {
        //Declare variables for latitude and longitude of the Dublin Office, converted to radians.
        $dublinOfficeLatitude = deg2rad(53.3340285);
        $dublinOfficeLongitude = deg2rad(-6.2535495);

        //Declare the file path of the affiliates text file in storage/app/
        $filePath = storage_path('app/affiliates.txt');

        //Use File Facade to confirm the file exists
        if(File::exists($filePath)){
            /* The file provided for the exercise was not in the expected JSON format, since I'm not allowed to alter the file,
            I'll explode the lines of the text file using preg_split(regex for new line chars, \n|\r\n? matches either a LF or a CR that may be followed by a LF */
            $affiliatesTextArray = preg_split("/\r\n|\n|\r/", File::get($filePath));

            //Initialize array for storing matching affiliates within 100km.
            $matchingAffiliates = [];

            //Iterate through text array, ensuring the line is not null or empty
            foreach($affiliatesTextArray as $line){
                if(isset($line) && $line !== ""){
                    //Decode the json in each line and make an associative array
                    $lineValues = json_decode($line, true);

                    //Instantiate Affiliate object using values provided, note radian values are being passed to constructor
                    $affiliate = new Affiliate(deg2rad($lineValues['latitude']), deg2rad($lineValues['longitude']), $lineValues['affiliate_id'], $lineValues['name']);

                    //Calculate the distance using the Haversine formula
                    $distance = $this->haversineFormula($affiliate->getLatitude(), $affiliate->getLongitude(), $dublinOfficeLatitude, $dublinOfficeLongitude);

                    // If the affiliate is within 100km, add the object to the matchingAffiliates array
                    if($distance <= 100){
                        //Set objects distance from dublin office, rounding up to integer
                        $affiliate->setDistanceFromDublinOffice(ceil($distance));
                        $matchingAffiliates[] = $affiliate;
                    }
                }
            }

            // Sort the matchingAffiliates array by Affiliate ID (asc)
            usort($matchingAffiliates, function ($a, $b) {
                return $a->getID() <=> $b->getID();
            });

            //Return view file alongside the necessary values, affiliate array and boolean for displaying errors if the file cannot be found
            return view('invite-affiliates', ['matchingAffiliates' => $matchingAffiliates, 'fileNotFound' => false]);
        } else {
            //Else the file is not found, return empty affiliate array and boolean
            return view('invite-affiliates', ['matchingAffiliates' => [], 'fileNotFound' => true]);
        }
    }

    // Haversine formula to calculate the great-circle distance between two points
    public function haversineFormula($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
    {
        $earthRadius = 6371; // Radius of the earth in kilometers

        $deltaLatitude = $latitudeTo - $latitudeFrom;
        $deltaLongitude = $longitudeTo - $longitudeFrom;

        $a = sin($deltaLatitude / 2) * sin($deltaLatitude / 2) + cos($latitudeFrom) * cos($latitudeTo) * sin($deltaLongitude / 2) * sin($deltaLongitude / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return ($earthRadius * $c);//Distance
    }

}
