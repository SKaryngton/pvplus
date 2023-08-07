<?php

namespace App\Service;

use InfluxDB2\Client;
use InfluxDB2\Model\WritePrecision;

class apiService
{

    public  function  connect():Client
    {


        return new  Client([
            "url"=>"http://178.254.20.178:8086",
            "token"=>"elCxqDEccl1ne3Z96WqjOnDRWvHOWugdTh8Syp0ceAsitkKZtGyztLU-VgkXYMbzUWsHSftwfNrC0ax30N2ixQ==",
            "bucket"=>"pvplus",
            "org"=>"G4N",
            "precision"=>WritePrecision::S,
            //"allow_redirects"=>true,
            "debug"=>false,
            //"logFile"=>"php://output",
            "timeout"=>0,

        ]);
    }
}