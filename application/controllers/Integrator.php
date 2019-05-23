<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Integrator extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("Integrator_model");
        $this->load->model("User_model");
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
        $data['section'] = 'Integrators';
        $this->load->view('templates/header');
        $this->load->view('templates/navbar', $data);
        $this->load->view('Integrators');
        $this->load->view('templates/footer');
    }

    /**
     * Calls the get_Integrators-method from the model-class, it then creates a JSON array based on the return values of the method.
     * @param  n/a
     * @return json-array [json-array with confirmation code and data]
     */
    public function get_Integrators() {

        

        $response["result"] = "RESPONSE_ERROR";

        $Integrator_request = $this->Integrator_model->get_Integrators();

        if ($Integrator_request["result"] == "RESPONSE_OK") {
            $Integrators = $Integrator_request["response_data"];
            if (is_array($Integrators)) {
                $indexed_Integrators = array();
                foreach ($Integrators as $key => $value) {
                    $indexed_Integrators[$value["IntegratorNo"]] = $key;
                }
            }

            $response["result"] = "RESPONSE_OK";
            $response["response_data"]["Integrators"] = $Integrators;
            $response["response_data"]["indexed_Integrators"] = $indexed_Integrators;
        } else {
            $response["description"] = $Integrator_request["description"];
        }
        echo json_encode($response);
    }

    /**
     * Reads the input from the browser, and calls the save_Integrators-method from the model-class, it then creates a JSON array based on the return values of the method.
     * @param  n/a
     * @return json-array [json-array with confirmation code and the saved data]
     */
    public function save_integrator() {
        $response["result"] = "RESPONSE_ERROR";

        $Integrator_data = $this->input->post(NULL, TRUE);

        if (!$this->checkData($Integrator_data)) {
            $response["description"] = "Error. null values detected";
            return $response;
        }

        $db_response = $this->Integrator_model->save_Integrator($Integrator_data);

        if ($db_response) {
            $response["result"] = "RESPONSE_OK";
            $response["response_data"] = $db_response;
        } else {
            $response["description"] = "Saving Integrator failed.";
        }

        echo json_encode($response);
    }

    /**
     * Reads the input from the browser, and calls the update_Integrator-method from the model-class, it then creates a JSON array based on the return values of the method.
     * @param  n/a
     * @return json-array [json-array with confirmation code and the new data]
     */
    public function update_Integrator() {
        $response["result"] = "RESPONSE_ERROR";

        $Integrator_data = $this->input->post(NULL, TRUE);
        
        if (!$this->checkData($Integrator_data)) {
            $response["description"] = "Error. null values detected";
            return $response;
        }

        $db_response = $this->Integrator_model->update_Integrator($Integrator_data);

        if ($db_response) {
            $response["result"] = "RESPONSE_OK";
            $response["response_data"] = $db_response;
        } else {
            $response["description"] = "Update error. " . $db_response;
        }

        echo json_encode($response);
    }

    /**
     * Reads the input from the browser, and calls the delete_Integrator-method from the model-class, it then creates a JSON array based on the return values of the method.
     * @param  n/a
     * @return json-array [json-array with confirmation code]
     */
    public function delete_Integrator() {
        $response["result"] = "RESPONSE_ERROR";
        
        $id = $this->input->post(NULL, TRUE);
        
        $Integrator_delete = $this->Integrator_model->delete_Integrator($id);
        if ($Integrator_delete) {
            $response["result"] = "RESPONSE_OK";
        } else {
            $response["description"] = "Error deleting Integrator";
        }
        echo json_encode($response);
    }
     public function save_Integrators_logo() {        
        $response["result"] = "RESPONSE_ERROR";
        if(isset( $_FILES['file'])){
            $config['upload_path']          = realpath(APPPATH . '../uploads/Integrator_logo');
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
                 $Integrator_picture_data = $this->upload->data();
                 $response["IntegratorPictureImageName"] = $Integrator_picture_data['raw_name'].$Integrator_picture_data['file_ext'];
                echo json_encode($response);
            }
        }else{
            $response["IntegratorPictureImageName"] = '';
            echo json_encode($response);
        }
    }
    /**
     * Returns the ID of the user that is logged in.
     * @param  n/a
     * @return json-array [json-array with confirmation code]
     */
    public function get_Logged_UserID() {
        return $this->session->userdata("logged_in")["ID"];
    }
    
    function get_integrator_logo(){
            $response["result"] = "RESPONSE_ERROR";
            $loggedin_user_ID = $this->get_Logged_UserID();
            $related_to_data = $this->User_model->get_related_to_ID($loggedin_user_ID);
            if($related_to_data['result'] != '' && $related_to_data['result']== 'RESPONSE_OK' ){
                $image_name = $this->Integrator_model->get_integrator_logo($related_to_data['response_data']['related_to_ID'][0]['RelatedTo']);
            }
            if(!empty($image_name)){
                $response["result"] = "RESPONSE_OK";
                $response["logo_name"] = $image_name;
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
