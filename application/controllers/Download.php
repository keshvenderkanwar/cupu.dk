<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Download extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("User_model");
        $this->load->model("Integrator_model");
        $this->load->model("Units_model");
        $this->load->model("Files_model");
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
    public function get_aircompressor_timeout() {
        $data = json_decode(file_get_contents('php://input'), true);
        $resultResponse = '';
        if (is_array($data) && !empty($data)) {
            $response = $this->Units_model->get_unit($data);
            if ($response["result"] == "RESPONSE_OK" && !empty($response['response_data'])) {
                $resultResponse = $response['response_data']['0']['AirCompressorTimeout'];
            }
           
        }
        echo $resultResponse;
    }
    /**
     * Creates a unit from the uploaded data
     * @param  n/a
     * @return n/a
     */
    public function get_audio_out_volume() {
        $data = json_decode(file_get_contents('php://input'), true);
        $resultResponse = '';
        if (is_array($data) && !empty($data)) {
            $response = $this->Units_model->get_unit($data);
            if ($response["result"] == "RESPONSE_OK" && !empty($response['response_data'])) {
                $resultResponse = $response['response_data']['0']['AudioOutVolume'];
            }
           
        }
        echo $resultResponse;
    }
    /**
     * Creates a unit from the uploaded data
     * @param  n/a
     * @return n/a
     */
    public function get_playlist() {
		
		$data = json_decode(file_get_contents('php://input'),true);
// $data = json_decode(file_get_contents('php://input'), true);
        $resultResponse = '';
        if (is_array($data) && !empty($data)) {
            $response = $this->Files_model->get_sound_playlist($data);
            if ($response["result"] == "RESPONSE_OK" && !empty($response['response_data'])) {
                $resultResponse = $response['response_data'];
            }
           
        }
        echo json_encode($resultResponse);
    }
    /**
     * Creates a unit from the uploaded data
     * @param  n/a
     * @return n/a
     */
    public function get_sound_file() {
        $data = json_decode(file_get_contents('php://input'), true);
        //$resultResponse = '';
        if (is_array($data) && !empty($data)) {
            $response = $this->Files_model->get_sound_file($data);
            if ($response["result"] == "RESPONSE_OK" && !empty($response['response_data'])) {
			
				$resultResponse['FilePath'] = base_url() . "uploads/".$response['response_data']['0']['FileName']; 
				
				$resultResponse['FileName'] = $response['response_data']['0']['FileName'];
				//$resultResponse['content'] = $mediaFile_content;
            }
			else{
				$resultResponse='';
			}
           
        }
        echo json_encode($resultResponse);
    }
}

?>