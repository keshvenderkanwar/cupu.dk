<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Upload extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("User_model");
        $this->load->model("Integrator_model");
        $this->load->model("Units_model");
    }

    /**
     * Creates the html page
     * @param  n/a
     * @return n/a
     */
    public function index() {
        
    }

    /**
     * Creates a unit from the uploaded data
     * @param  n/a
     * @return n/a
     */
    public function new_unit() {
        $data = json_decode(file_get_contents('php://input'), true);
        if (is_array($data) && !empty($data)) {
                foreach($data as $key => $value){
                    if(empty($value)){
                        unset($data[$key]);
                    }
                }
               $response = $this->Units_model->save_unit($data);
            // print_r($response);
           
        }else{
             $response = "";
        }
        if ($response["result"] == "RESPONSE_OK") {
            echo "1";
        } else {
            echo "0";
        }
    }

    /**
     * Creates a unit from the uploaded data
     * @param  n/a
     * @return n/a
     */
    public function check_version() {
        $data = json_decode(file_get_contents('php://input'), true);
        if (is_array($data) && !empty($data) && isset($data["VersionNo"])) {
            $this->db->select("Valid");
            $this->db->from("CUPU_Connector_Version");
            $this->db->where("VersionNo", $data["VersionNo"]);
            $result = $this->db->get()->result_array();
            if (is_array($result) && !empty($result) && isset($result[0]["Valid"]) && $result[0]["Valid"] == "1") {
                echo json_encode($result[0]);
            } else {
                echo json_encode(array("Valid" => "0",
                    "url" => base_url("AKJI_CUPU1_Connector_161202_Setup.exe")));
            }
        } else {
            echo "Failure to read json-object";
        }
    }

    /**
     * Creates a new log entry from the uploaded data
     * @param  n/a
     * @return n/a
     */
    public function new_log_entry() {
       
       $data = json_decode(file_get_contents('php://input'), true);
        if (is_array($data) && !empty($data) && isset($data["SerialNo"])) {
            $unit = $this->Units_model->get_unit(array("SerialNo" => $data["SerialNo"]))["response_data"];
               // $unit_response = $unit;
            if (empty($unit)) {
                $this->Units_model->save_unit(array("SerialNo" => $data["SerialNo"]));
            }
            //Saves time in Copenhagen time
            $timezone = new DateTimeZone("Europe/Copenhagen");
            $date = new DateTime("now", $timezone);
            $data["Timestamp"] = $date->format("Y-m-d H:i:s");

            $data["json"] = file_get_contents('php://input');
            $response = $this->Units_model->save_log($data);
            if ($response["result"] == "RESPONSE_OK") {
                echo "1";
            } else {
                echo "0";
            }
        }
    }

    /**
     * Checks the user information in the database. This is used by the Cupu Connector software.
     * @param  n/a
     * @return n/a
     */
    public function check_login() {
//        $arrContextOptions = array(
//            "ssl" => array(
//                "verify_peer" => false,
//                "verify_peer_name" => false,
//            ),
//        );
//        $data = json_decode(file_get_contents('php://input'), true,stream_context_create($arrContextOptions));
        $data = json_decode(file_get_contents('php://input'), true);
       // print_r($data);
        if (isset($data["Username"]) && isset($data["Password"])) {
            //query the database
            $result = $this->User_model->login($data["Username"], $data["Password"]);
            if ($result) {
                if ($result["Type"] == "Integrator") {
                    //$Integrator = $this->Integrator_model->get_Integrator_from_UserID($result["RelatedTo"]);
                   // echo $Integrator["response_data"]["IntegratorNo"];
                    echo $result["RelatedTo"];
//                    print_r($Integrator);
                } else {
                    echo "FALSE";
                }
            } else {
                echo "FALSE";
            }
        } else {
            echo "Failure to read json-object";
        }
//        print_r(file_get_contents('php://input'));
//        echo var_dump($data);
//        echo json_last_error_msg();
//        if ($data) {
//            print_r($data);
//        } else {
//            echo json_last_error_msg();
//            echo "json_decode returned false.";
//        }
    }

    /**
     * Creates a new log entry from the uploaded data
     * @param  n/a
     * @return n/a
     */
//    public function create_log_entries() {
//        $OpenWeatherMapAPIKey = "0a64ba277299ac1a01f95345117f2ee0";
//        $units = $this->Units_model->get_units()["response_data"];
////        print_r($units);
////        $timestamp = time();
////        for ($x = 0; $x <= 100; $x++) {
////            $pastTime = $timestamp - $x * 3600;
//
//        foreach ($units as $unit) {
//            $response = file_get_contents('http://api.openweathermap.org/data/2.5/weather?lat=' . $unit["Lat"] . '&lon=' . $unit["Lng"] . '&APPID=' . $OpenWeatherMapAPIKey);
//            $response = json_decode($response, true); //convert stdclass to json array.
//
//            $currentTemp = floatval($response['main']['temp']) - 272.15; //get kelvin and convert to celsius
//
//            $data["SerialNo"] = $unit["SerialNo"];
//            $data["Timestamp"] = date("Y-m-d H:i:s", time()+60*60); //Saves time in CET
////                $data["Timestamp"] = date("Y-m-d H:i:s", $pastTime);
////                $data["Temperature"] = rand(16, 24);
//            $data["Temperature"] = $currentTemp;
//            if ($this->checkData($data)) {
//                $this->Units_model->save_log($data);
//            }
//        }
////        }
//    }

    /**
     * Internal method to check the validity of the specified data.
     * @param  $data [variable to be checked]
     * @return boolean [true if the all the values are filed out, otherwise false]
     */
    private function checkData($data) {
        if (!is_null($data)) {
            if (is_array($data)) {
                foreach ($data as $key => $value) {
                    //$this->checkData($value);
                    if ((is_null($value) | $value === '')) {
                        return false;
                    }
                }
            } else {
                if (is_null($data) | $data === '') {
                    return false;
                }
            }
        } else {
            return false;
        }

        return true;
    }

}
