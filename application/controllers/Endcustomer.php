<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Endcustomer extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 function __construct() {
        parent::__construct();
        $this->load->model("Files_model");
        $this->load->model("Endcustomer_model");
        $this->load->model("User_model");
        date_default_timezone_set('Europe/Copenhagen');
        if (!$this->session->userdata('logged_in')) {
            redirect('http://www.cupu.dk/');
        }
    }
	public function index()
	{
		$data = array();
        $data['section'] = 'Units';
		$this->load->view('templates/header');
        $this->load->view('templates/navbar', $data);
        $this->load->view('Endcustomer', $data);
        $this->load->view('templates/footer');
	}
	/**
     * Calls the get_Endcustomer-method from the model-class, it then creates a JSON array based on the return values of the method.
     * @param  n/a
     * @return json-array [json-array with confirmation code and data]
     */
    public function get_Endcustomers() {


        $response["result"] = "RESPONSE_ERROR";

        $Endcustomer_request = $this->Endcustomer_model->get_Endcustomers();

        if ($Endcustomer_request["result"] == "RESPONSE_OK") {
            $Endcustomers = $Endcustomer_request["response_data"];
            if (is_array($Endcustomers)) {
                $indexed_Endcustomers = array();
                foreach ($Endcustomers as $key => $value) {
                    $indexed_Endcustomers[$value["EndCustomerNo"]] = $key;
                }
            }

            $response["result"] = "RESPONSE_OK";
            $response["response_data"]["Endcustomers"] = $Endcustomers;
            $response["response_data"]["indexed_Endcustomers"] = $indexed_Endcustomers;
        } else {
            $response["description"] = $Integrator_request["description"];
        }
        echo json_encode($response);
    }
    
	/**
     * Calls the get_Endcustomer-method from the model-class, it then creates a JSON array based on the return values of the method.
     * @param  n/a
     * @return json-array [json-array with confirmation code and data]
     */
    public function get_Endcustomers_of_integrator() {
		$IntegratorNo = $this->input->post("IntegratorNo");
		//echo $IntegratorNo;
        $response["result"] = "RESPONSE_ERROR";
		$conditions = array('associatedIntegrator' => $IntegratorNo);
        $Endcustomer_associated_request = $this->Endcustomer_model->get_Endcustomer_associated($conditions);
		//print_r($Endcustomer_associated_request);
        if ($Endcustomer_associated_request["result"] == "RESPONSE_OK") {
            $Endcustomer_associated = $Endcustomer_associated_request["response_data"];
            if (is_array($Endcustomer_associated)) {
                $indexed_Endcustomer_associated = array();
                foreach ($Endcustomer_associated as $key => $value) {
                    $indexed_Endcustomer_associated[$value["EndCustomerNo"]] = $key;
                }
            }

            $response["result"] = "RESPONSE_OK";
            $response["response_data"]["Endcustomer_associated"] = $Endcustomer_associated;
            $response["response_data"]["indexed_Endcustomer_associated"] = $indexed_Endcustomer_associated;
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
    public function save_Endcustomer() {
        $response["result"] = "RESPONSE_ERROR";

        $Endcustomer_data = $this->input->post(NULL, TRUE);

        if (!$this->checkData($Endcustomer_data)) {
            $response["description"] = "Error. null values detected";
            return $response;
        }

        $db_response = $this->Endcustomer_model->save_Endcustomer($Endcustomer_data);

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
    public function update_Endcustomer() {
        $response["result"] = "RESPONSE_ERROR";

        $Endcustomer_data = $this->input->post(NULL, TRUE);
        
        if (!$this->checkData($Endcustomer_data)) {
            $response["description"] = "Error. null values detected";
            return $response;
        }

        $db_response = $this->Endcustomer_model->update_Endcustomer($Endcustomer_data);

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
    public function delete_Endcustomer() {
        $response["result"] = "RESPONSE_ERROR";
        
        $id = $this->input->post(NULL, TRUE);
        
        $Endcustomer_delete = $this->Endcustomer_model->delete_Endcustomer($id);
        if ($Endcustomer_delete) {
            $response["result"] = "RESPONSE_OK";
        } else {
            $response["description"] = "Error deleting Integrator";
        }
        echo json_encode($response);
    }
	
	/**
     * Reads the input from the browser, and calls the save_users-method from the model-class, it then creates a JSON array based on the return values of the method.
     * @param  n/a
     * @return json-array [json-array with confirmation code and the saved data]
     */
    public function save_Endcustomer_logo() {        
        $response["result"] = "RESPONSE_ERROR";
        if(isset( $_FILES['file'])){
			$config['upload_path']          = realpath(APPPATH . '../uploads/endcustomer_logo');
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
				 $Endcustomer_picture_data = $this->upload->data();
            	 $response["EndcustomerPictureImageName"] = $Endcustomer_picture_data['raw_name'].$Endcustomer_picture_data['file_ext'];
				echo json_encode($response);
            }
        }else{
        	$response["result"] = "RESPONSE_OK";
        	$response["UserPictureImageName"] = '';
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
	
	function get_endcustomer_logo(){
			$response["result"] = "RESPONSE_ERROR";
			$loggedin_user_ID = $this->get_Logged_UserID();
			$related_to_data = $this->User_model->get_related_to_ID($loggedin_user_ID);
			if($related_to_data['result'] != '' && $related_to_data['result']== 'RESPONSE_OK' ){
				$image_name = $this->Endcustomer_model->get_endcustomer_logo($related_to_data['response_data']['related_to_ID'][0]['RelatedTo']);
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
