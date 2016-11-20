<?php

namespace house\util;
class loadCities {
    protected $cities ;
    public function __construct($country) {
        $fileToGet = __DIR__.'/../files/city.json';
        $this->cities = json_decode(file_get_contents($fileToGet))->$country;
    }
    public function getCities(){
        return $this->cities;
    }
}
