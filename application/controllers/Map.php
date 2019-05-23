<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Map extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("Units_model");
        $this->load->model("User_model");
        date_default_timezone_set('Europe/Copenhagen');
        if (!$this->session->userdata('logged_in')) {
            redirect('http://www.cupu.dk/');
        }
    }

    /**
     * Creates an html page
     * @param  n/a
     * @return n/a
     */
    public function index() {
        $data = array();
        $data['section'] = 'Map';


        $logged_in_userdata = $this->session->userdata('logged_in');
        $logged_in_userdata_ID = $logged_in_userdata['ID'];
        $user_related_to_id_array = $this->User_model->get_related_to_ID($logged_in_userdata_ID);
        
            $user_related_to_id = $user_related_to_id_array["response_data"]["related_to_ID"][0]['RelatedTo'];
            if ($user_related_to_id_array["result"] == "RESPONSE_OK") {
        }else{
            $user_related_to_id = '';
        }
        //$units_request = $this->Units_model->get_units($user_related_to_id);


        $data['Units'] = $this->Units_model->get_units($user_related_to_id)["response_data"];
        $unitErrorcode = array();
        foreach($data['Units'] as $datasingle){
               $unitErrorcode[$datasingle['SerialNo']] = $this->Units_model->get_log_error_code($datasingle['SerialNo'])['response_data'];
        }
        $data['ErrorCodes'] = $unitErrorcode;
        $this->load->view('templates/header');
        $this->load->view('templates/navbar', $data);
        $this->load->view('Map', $data);
        $this->load->view('templates/footer');
    }

}
