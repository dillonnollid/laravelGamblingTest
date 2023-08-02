<?php

namespace App\Models;

/*
I wanted to create a model to represent Affiliates, but I didn't want to have to store this user data in a database
So, I've created a Plain Old PHP Object that does the trick.
*/
//use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;

class Affiliate
{
    private $latitude;
    private $longitude;
    private $affiliate_id;
    private $name;
    private $distance;

    public function __construct($latitude, $longitude, $affiliate_id, $name)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->affiliate_id = $affiliate_id;
        $this->name = $name;
    }

    public function getLatitude(){
        return $this->latitude;
    }

    public function getLongitude(){
        return $this->longitude;
    }

    public function getID(){
        return $this->affiliate_id;
    }

    public function getName(){
        return $this->name;
    }

    public function getDistanceFromDublinOffice(){
        return $this->distance;
    }

    public function setDistanceFromDublinOffice($distance){
        $this->distance = $distance;
    }
}
