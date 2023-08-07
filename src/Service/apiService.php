<?php

namespace App\Service;

use DateTime;
use DateTimeZone;
use InfluxDB2\Client;
use InfluxDB2\Model\BucketRetentionRules;
use InfluxDB2\Model\DeletePredicateRequest;
use InfluxDB2\Model\Organization;
use InfluxDB2\Model\PostBucketRequest;
use InfluxDB2\Model\Query;
use InfluxDB2\Model\WritePrecision;
use InfluxDB2\Point;
use InfluxDB2\Service\BucketsService;
use InfluxDB2\Service\DeleteService;
use InfluxDB2\Service\OrganizationsService;
use InfluxDB2\WriteType;
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