<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Predictive_maintenance extends CI_Controller {

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
        $data['section'] = 'predictive_maintenance';
        $this->load->view('templates/header');
        $this->load->view('templates/navbar', $data);
        $this->load->view('Predictivemaintenance', $data);
        $this->load->view('templates/footer');
    }

}
