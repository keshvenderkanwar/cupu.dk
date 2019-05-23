<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cuputypes extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("Cuputypes_model");
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
        $data['section'] = 'Cuputypes';
        $this->load->view('templates/header');
        $this->load->view('templates/navbar', $data);
        $this->load->view('Cuputypes', $data);
        $this->load->view('templates/footer');
    }
	/**
     * Calls the get_units-method from the model-class, it then creates a JSON array based on the return values of the method.
     * @param  n/a
     * @return json-array [json-array with confirmation code and data]
     */
    public function get_Cuputypes() {
        $response["result"] = "RESPONSE_ERROR";

        $units_request = $this->Cuputypes_model->get_cuputypes();

        if ($units_request["result"] == "RESPONSE_OK") {
            $containers = $units_request["response_data"];
            if (is_array($containers)) {
                $indexed_units = array();
                foreach ($containers as $key => $value) {
                    $indexed_units[$value["HardwareCode"]] = $key;
                }
            }
            $response["result"] = "RESPONSE_OK";
            $response["response_data"]["cuputypes"] = $containers;
            $response["response_data"]["indexed_units"] = $indexed_units;
        } else {
            $response["description"] = $units_request["description"];
        }
        echo json_encode($response);
    }
}
