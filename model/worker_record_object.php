<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");



/********************************************************************************
 * This object represents a row/worker in 2D_workers table,
 * plus joining the 2 tables to get the parking spot label as well.
 ********************************************************************************/
class worker_record_object{
    public $worker_id;
    public $worker_name;

    public $parked_at_spot_id;
    public $parked_at_spot_label;

    public $start_timestamp;
    public $end_timestamp;
    public $duration;

    public $db_handle;
    function __construct($worker_id,$worker_name,$parked_at_spot_id,$parked_at_spot_label,$start_timestamp,$end_timestamp,$db_handle){
        $this->db_handle=$db_handle;
        $this->worker_id=$worker_id;
        $this->worker_name=$worker_name;
        $this->parked_at_spot_id=$parked_at_spot_id;
        $this->parked_at_spot_label=$parked_at_spot_label;
        $this->start_timestamp=$start_timestamp;
        $this->end_timestamp=$end_timestamp;
        $this->duration=$this->calc_duration();
    }

    function calc_duration(){
        // $date1 = "2008-11-01 22:45:00"; 

        // $date2 = "2009-12-04 13:44:01";
        $date1=$this->start_timestamp;
        $date2=$this->end_timestamp;
        if ($this->end_timestamp==="now"){
            date_default_timezone_set("America/Los_Angeles");
            $now = new DateTime(); //this returns the current date time
            $date2=date_format($now,"Y-m-d H:i:s");
        }

        $seconds_in_a_day=60*60*24;
        $seconds_in_a_year=365*$seconds_in_a_day;
        $seconds_in_a_month=30*$seconds_in_a_day;


        $diff = abs(strtotime($date2) - strtotime($date1));


        $years   = floor($diff / ($seconds_in_a_year));
        $months  = floor(($diff - $years * $seconds_in_a_year) / ($seconds_in_a_month));
        $days    = floor(($diff - $years * $seconds_in_a_year - $months*$seconds_in_a_month)/ ($seconds_in_a_day));

        $hours   = floor(($diff - $years * $seconds_in_a_year - $months*$seconds_in_a_month - $days*$seconds_in_a_day)/ (60*60));

        $minuts  = floor(($diff - $years * $seconds_in_a_year - $months*$seconds_in_a_month - $days*$seconds_in_a_day - $hours*60*60)/ 60);

        $seconds = floor(($diff - $years * $seconds_in_a_year - $months*$seconds_in_a_month - $days*$seconds_in_a_day - $hours*60*60 - $minuts*60));

        // printf("%d years, %d months, %d days, %d hours, %d minuts\n, %d seconds\n", $years, $months, $days, $hours, $minuts, $seconds);
        $duration="";
        // var_dump($years);
        $float_zero=0.0;
        if ($years!==$float_zero){
            $duration.=$years." Years ";
        }
        if ($months!==$float_zero){
            $duration.=$months." Months ";
        }
        if ($days!==$float_zero){
            $duration.=$days." Days ";
        }
        if ($hours!==$float_zero){
            $duration.=$hours." Hrs ";
        }
        if ($minuts!==$float_zero){
            $duration.=$minuts." Min ";
        }
        if ($seconds!==$float_zero){
            $duration.=$seconds." Sec ";
        }

        // $this->duration=$duration;
        if ($this->end_timestamp==="now") {
            $duration.="(Until Now)";
        }
        return $duration;
    }
}


/*******************************************
 *test cases:
 *******************************************/
// echo "<pre>";
// require_once __DIR__.'/../database/dbcontroller.php';
// $db_handle=new DBController();
// $stock=new stock($db_handle);
// var_dump($stock->all_stock);