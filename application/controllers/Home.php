<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//session_start(); //we need to call PHP's session object to access it through CI

class Home extends CI_Controller {

    function __construct() {
        parent::__construct();
		$this->load->library('session');
    }

    function index() {
		//echo "<pre>"; print_r($this->session->userdata); echo "</pre>"; //die();
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $data['Username'] = $session_data['Username'];
            $this->load->view('templates/header');
            $this->load->view('templates/navbar', $data);
            $this->load->view('home_view', $data);
            $this->load->view('templates/footer');
			//$this->session->set_userdata('logged_in', array('1','2'));
        } else {
            //If no session, redirect to login page
            redirect('Login', 'refresh');
        }
    }

    function logout() {
        $this->session->unset_userdata('logged_in');
        session_destroy();
        redirect('home', 'refresh');
    }

}

?>
