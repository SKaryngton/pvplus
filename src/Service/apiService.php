<?php

namespace App\Service;

use DateTime;
use DateTimeZone;
use Exception;
use InfluxDB2\Client;
use InfluxDB2\Model\WritePrecision;
use InfluxDB2\Point;
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

    /**
     * @throws Exception
     */
    public  function  loadData(): array
    {

        $client= $this->connect();
        $writeAPi=$client->createWriteApi(["writeType"=>WriteType::SYNCHRONOUS]);
        $p =new Point("Inverters");


        $i=0;
        foreach ($this->csvToarray()['json'] as $inverter){

            $i++;
            {
                $p->addTag("inv", $inverter["inv"])
                    -> addField("db_id", (int)$inverter["db_id"])
                    ->addField("anl_id", (int)$inverter["anl_id"])
                    ->addField("inv", (int)$inverter["inv"])
                    ->addField("group_ac", (float)$inverter["group_ac"])
                    ->addField("group_dc", (float)$inverter["group_dc"])
                    ->addField("unit", (float)$inverter["unit"])
                    ->addField("wr_idc", (float)$inverter["wr_idc"])
                    ->addField("wr_pac", (float)$inverter["wr_pac"])
                    ->addField("wr_udc", (float)$inverter["wr_udc"])
                    ->addField("p_ac_blind", (float)$inverter["p_ac_blind"])
                    ->addField("i_ac", (float)$inverter["i_ac"])
                    ->addField("i_ac_p1", (float)$inverter["i_ac_p1"])
                    ->addField("i_ac_p2", (float)$inverter["i_ac_p2"])
                    ->addField("i_ac_p3", (float)$inverter["i_ac_p3"])
                    ->addField("u_ac", (float)$inverter["u_ac"])
                    ->addField("u_ac_p1", (float)$inverter["u_ac_p1"])
                    ->addField("u_ac_p2", (float)$inverter["u_ac_p2"])
                    ->addField("u_ac_p3", (float)$inverter["u_ac_p3"])
                    ->addField("p_ac_apparent", (float)$inverter["p_ac_apparent"])
                    ->addField("frequency", (float)$inverter["frequency"])
                    ->addField("wr_temp", (float)$inverter["wr_temp"])
                    ->addField("wr_cos_phi_korrektur", (float)$inverter["wr_cos_phi_korrektur"])
                    ->addField("e_z_evu", (float)$inverter["e_z_evu"])
                    ->addField("temp_corr", (float)$inverter["temp_corr"])
                    ->addField("theo_power", (float)$inverter["theo_power"])
                    ->addField("pa_0", (float)$inverter["pa_0"])
                    ->addField("pa_1", (float)$inverter["pa_1"])
                    ->addField("pa_2", (float)$inverter["pa_2"])
                    ->addField("pa_0_reason", (float)$inverter["pa_0_reason"])
                    ->addField("pa_1_reason", (float)$inverter["pa_1_reason"])
                    ->addField("pa_2_reason", (float)$inverter["pa_2_reason"])
                    ->time($this->strToSecond($inverter["stamp"]));


                $writeAPi->write($p);

            }


        }

        $writeAPi->close();
        $client->close();
        return [$this->csvToarray()['fake'], $i];
    }




    public function csvToarray(): array
    {

        $data = array();
        $stream=fopen('db/g4n.csv','r');

        while(!feof($stream)){
            $lineToArray=fgetcsv($stream, null ,
                ";" , "\"" , "\\");
            $data[]=$lineToArray;
        }

        $headers = $data[0];
        $jsonArray = array();
        $nonJsonArray = array();
        $rowCount = count($data);
        for ($i=1;$i<$rowCount;$i++) {
            if (is_array($data[$i])){
                foreach ($data[$i] as $key => $column) {
                    $jsonArray[$i][$headers[$key]] = $column;
                }
            }else{
                $nonJsonArray[]=$data[$i];
            }

        }
        return ['json'=>$jsonArray, 'fake'=>$nonJsonArray];
    }


    /**
     * @throws Exception
     */
    public  function  strToSecond(string $x): int
    {
        $d=new DateTime($x, new  DateTimeZone('UTC'));
        $d->setTimezone(new  DateTimeZone('Europe/Berlin'));
        return $d->getTimestamp();
    }
}