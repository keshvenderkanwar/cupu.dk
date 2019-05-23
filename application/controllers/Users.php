<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("User_model");
        $this->load->model("Integrator_model");
        $this->load->model("Endcustomer_model");
        if (!$this->session->userdata('logged_in')) {
            redirect('http://www.cupu.dk/');
        }
    }

    /**
     * Creates the html page
     * @param  n/a
     * @return n/a
     */
    public function index() {
		
       $data = array();
        $data['section'] = 'Users';
        $this->load->view('templates/header');
        $this->load->view('templates/navbar', $data);
        $this->load->view('Users');
        $this->load->view('templates/footer');
    }

    /**
     * Calls the get_users-method from the model-class, it then creates a JSON array based on the return values of the method.
     * @param  n/a
     * @return json-array [json-array with confirmation code and data]
     */
    public function get_users() {

        $user_request = $this->User_model->get_users();

        echo json_encode($user_request);
    }

/**
     * Calls the get_users-method from the model-class, it then creates a JSON array based on the return values of the method.
     * @param  n/a
     * @return json-array [json-array with confirmation code and data]
     */
    public function get_users_Endcustomer() {
       $loggedin_related_to =  $this->get_logged_userRelatedTo();
       $associated_array = $this->Endcustomer_model->get_Endcustomers();
       $associate_array = array();
       if(isset($associated_array['result']) && $associated_array['result'] == 'RESPONSE_OK'){
            foreach($associated_array['response_data'] as $singleAssociated){
                 $associate_array[] = $singleAssociated['EndCustomerNo'];
            }
       }
	   $user_type = 'End Customer';
         $user_request = $this->User_model->get_users_integrator($loggedin_related_to['RelatedTo'],false,$user_type);

        echo json_encode($user_request);
    }

/**
     * Calls the get_users-method from the model-class, it then creates a JSON array based on the return values of the method.
     * @param  n/a
     * @return json-array [json-array with confirmation code and data]
     */
    public function get_users_integrator() {
       $loggedin_related_to =  $this->get_logged_userRelatedTo();
       $associated_array = $this->Endcustomer_model->get_Endcustomers();
       $associate_array = array();
       if(isset($associated_array['result']) && $associated_array['result'] == 'RESPONSE_OK'){
            foreach($associated_array['response_data'] as $singleAssociated){
                 $associate_array[] = $singleAssociated['EndCustomerNo'];
            }
       }
         $user_request = $this->User_model->get_users_integrator($loggedin_related_to['RelatedTo'],$associate_array,false);

        echo json_encode($user_request);
    }


    /**
     * Reads the input from the browser, and calls the save_users-method from the model-class, it then creates a JSON array based on the return values of the method.
     * @param  n/a
     * @return json-array [json-array with confirmation code and the saved data]
     */
    public function save_user() {        
        $response["result"] = "RESPONSE_ERROR";

        $user_data = $this->input->post(NULL, TRUE);
        
        //Sets the relation to the user, that is logged in and has created the new user.
        //$user_data["RelatedTo"] = $this->get_Logged_UserID();        
        if (!$this->checkData($user_data)) {            
            $response["description"] = "Error. null values detected";
            return json_encode($response);
        }
        $db_response = $this->User_model->save_user($user_data);
        
        if ($db_response) {
            $response["result"] = "RESPONSE_OK";
            $response["response_data"] = $db_response;
        } else {
            $response["description"] = "Saving user failed.";
        }

        echo json_encode($response);
    }

    /**
     * Reads the input from the browser, and calls the update_user-method from the model-class, it then creates a JSON array based on the return values of the method.
     * @param  n/a
     * @return json-array [json-array with confirmation code and the new data]
     */
    public function update_user() {
        $response["result"] = "RESPONSE_ERROR";

        $user_data = $this->input->post(NULL, TRUE);
        $checkifPaswordischanged = $user_data['changedPassword'];
        unset($user_data['changedPassword']);
        if (!$this->checkData($user_data)) {

            $response["description"] = "Error. null values detected";
            return json_encode($response);
        }
        $db_response = $this->User_model->update_user($user_data);

        if ($db_response) {
            $response["result"] = "RESPONSE_OK";
            $response["response_data"] = $db_response;
            if($checkifPaswordischanged == 'yes'){
                $this->load->library('email');

                $this->email->from('password@cupu.dk', 'Akji');
                $this->email->to($user_data['Email']);
                $this->email->cc('');
                $this->email->bcc('');

                $this->email->subject('New Akji Password');
                $this->email->message('Hi your new password is ----> '.$user_data['Password']);

                @$this->email->send();
            }
        } else {
            $response["description"] = "Update error. " . $db_response;
        }
        echo json_encode($response);
    }

    /**
     * Reads the input from the browser, and calls the delete_user-method from the model-class, it then creates a JSON array based on the return values of the method.
     * @param  n/a
     * @return json-array [json-array with confirmation code]
     */
    public function delete_user() {
        $response["result"] = "RESPONSE_ERROR";

        $id = $this->input->post("id");


        $user_delete = $this->User_model->delete_user($id);
        if ($user_delete) {
            $response["result"] = "RESPONSE_OK";
        } else {
            $response["description"] = "Error deleting user";
        }
        echo json_encode($response);
    }
    
    /**
     * Returns the ID of the user that is logged in.
     * @param  n/a
     * @return json-array [json-array with confirmation code]
     */
    public function get_Logged_UserID() {
        return $this->session->userdata("logged_in")["ID"];
    }
    
    /**
     * Returns the Type of the user that is logged in.
     * @param  n/a
     * @return json-array [json-array with confirmation code]
     */
    public function get_Logged_UserType() {
        return $this->session->userdata("logged_in")["Type"];
    }
    
    /**
     * Returns the Type of the user that is logged in.
     * @param  n/a
     * @return json-array [json-array with confirmation code]
     */
    public function get_logged_in_usertype() {
        echo $this->session->userdata("logged_in")["Type"];
    }
    /**
     * Returns the Type of the user that is logged in.
     * @param  n/a
     * @return json-array [json-array with confirmation code]
     */
    public function get_logged_in_userRelatedTo() {
        $logged_session_data['RelatedTo'] =  $this->session->userdata("logged_in")["RelatedTo"];
        $logged_session_data['Type'] =  $this->session->userdata("logged_in")["Type"];
        echo json_encode($logged_session_data);
    }
	
    /**
     * Returns the Type of the user that is logged in.
     * @param  n/a
     * @return json-array [json-array with confirmation code]
     */
    public function get_logged_userRelatedTo() {
        $logged_session_data['RelatedTo'] =  $this->session->userdata("logged_in")["RelatedTo"];
        return $logged_session_data;
    }
    
	/**
     * Reads the input from the browser, and calls the save_users-method from the model-class, it then creates a JSON array based on the return values of the method.
     * @param  n/a
     * @return json-array [json-array with confirmation code and the saved data]
     */
    public function save_user_logo() {        
        $response["result"] = "RESPONSE_ERROR";
        if(isset( $_FILES['file'])){
			$config['upload_path']          = realpath(APPPATH . '../uploads/userlogos');
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 100;
            $config['max_width']            = 1024;
            $config['max_height']           = 768;

            $this->load->library('upload', $config);
			$this->upload->initialize($config);
            if ( ! $this->upload->do_upload('file'))
            {
                    $error = array('error' => $this->upload->display_errors());

                    echo json_encode($error);
            }
            else
            { 
            	 $response["result"] = "RESPONSE_OK";
				 $UserPictureImageName = $this->upload->data();
            	 $response["UserPictureImageName"] = $UserPictureImageName['raw_name'].$UserPictureImageName['file_ext'];
				echo json_encode($response);
            }
        }else{
        	$response["result"] = "RESPONSE_OK";
        	$response["UserPictureImageName"] = '';
			echo json_encode($response);
        }
    }

		function get_users_logo(){
			$response["result"] = "RESPONSE_ERROR";
			$loggedin_user_ID = $this->get_Logged_UserID();
			$image_name = $this->User_model->get_users_logo($loggedin_user_ID);
			if(!empty($image_name)){
				$response["result"] = "RESPONSE_OK";
				$response["logo_name"] = $image_name;
			}
			echo json_encode($response);
			
		}

    public function get_all_related_to(){
        $response["result"] = "RESPONSE_ERROR";
        $userType = $this->input->post("userType");
       // echo $userType;
		if($userType == 'End Customer'){
			$all_related_to = $this->Endcustomer_model->get_Endcustomers();
		}else if($userType == 'Integrator'){
			$all_related_to = $this->Integrator_model->get_Integrators();
		}else{
			$all_related_to = $this->Endcustomer_model->get_Endcustomers();
		}
        	
        if ($all_related_to["response_data"] != FALSE) {
            $response["result"] = "RESPONSE_OK";
            $response['all_related_to'] = $all_related_to["response_data"];
            if($all_related_to['user_type'] == 'End Customer'){
                $response['user_type'] = 'End Customer';
            }else if($all_related_to['user_type'] == 'Integrator'){
                $response['user_type'] = 'Integrator';
            }else{
                $response['user_type'] = 'Admin';
            }
        } else {
            $response["result"] = "RESPONSE_ERROR";
            $response["description"] = "No Log or bad parameters";
        }
        echo json_encode($response);
    }

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
                    if ((is_null($value) | $value === '') && $key != "container_groups") {
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
