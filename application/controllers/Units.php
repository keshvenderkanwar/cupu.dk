<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Units extends CI_Controller {

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
        $data['section'] = 'Units';
        $this->load->view('templates/header');
        $this->load->view('templates/navbar', $data);
        $this->load->view('Units', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Calls the get_units-method from the model-class, it then creates a JSON array based on the return values of the method.
     * @param  n/a
     * @return json-array [json-array with confirmation code and data]
     */
    public function get_units() {
        $response["result"] = "RESPONSE_ERROR";
		//echo "<pre>"; print_r($this->session->userdata()); echo "</pre>"; die();
        $logged_in_userdata = $this->session->userdata('logged_in');
        $logged_in_userdata_ID = $logged_in_userdata['ID'];
		$user_related_to_id_array = $this->User_model->get_related_to_ID($logged_in_userdata_ID);
		
			$user_related_to_id = $user_related_to_id_array["response_data"]["related_to_ID"][0]['RelatedTo'];
			if ($user_related_to_id_array["result"] == "RESPONSE_OK") {
		}else{
			$user_related_to_id = '';
		}
        $units_request = $this->Units_model->get_units($user_related_to_id);
        if ($units_request["result"] == "RESPONSE_OK") {
            $containers = $units_request["response_data"];
            if (is_array($containers)) {
                $indexed_units = array();
                foreach ($containers as $key => $value) {
                    $indexed_units[$value["SerialNo"]] = $key;
                }
            }
            $response["result"] = "RESPONSE_OK";
            $response["response_data"]["units"] = $containers;
            $response["response_data"]["indexed_units"] = $indexed_units;
        } else {
            $response["description"] = $units_request["description"];
        }
        echo json_encode($response);
    }

    /**
     * Calls the get_units-method from the model-class, it then creates a JSON array based on the return values of the method.
     * @param  n/a
     * @return json-array [json-array with confirmation code and data]
     */
    public function get_unit_stats() {
       // $response["result"] = "RESPONSE_ERROR";
		$unit_data = $this->input->post(NULL, TRUE);
		$units_stat_request = $this->Units_model->get_units_stat($unit_data['SerialNo']);
		
        if ($units_stat_request["result"] == "RESPONSE_OK") {
            $stat_containers = $units_stat_request["response_data"];
            $response["result"] = "RESPONSE_OK";
            $response["response_data"]["units_stats"] = $stat_containers;
        } else {
            $response["description"] = $units_request["description"];
        }
        echo json_encode($response);
    }

    /**
     * Reads and validates the input from the browser, and calls the save_container-method from the model-class, it then creates a JSON array based on the return values of the method.
     * @param  n/a
     * @return json-array [json-array with confirmation code and the saved data]
     */
    public function save_unit() {
        $response["result"] = "RESPONSE_ERROR";

        $unit_data = $this->input->post(NULL, TRUE);

        if ($this->checkData($unit_data)) {
            $unit_insertion = $this->Units_model->save_unit($unit_data);
            if ($unit_insertion["result"] == "RESPONSE_OK") {
                $response["result"] = "RESPONSE_OK";
            } else {
                $response["description"] = "Insertion error";
            }
        } else {
            $response["description"] = "Empty Input";
        }
        echo json_encode($response);
    }

    /**
     * Reads and validates the input from the browser, and calls the update_container-method from the model-class, it then creates a JSON array based on the return values of the method.
     * @param  n/a
     * @return json-array [json-array with confirmation code and the saved data]
     */
    public function update_unit() {
        $response["result"] = "RESPONSE_ERROR";

        $unit_data = $this->input->post(NULL, TRUE);

        /*if ($this->checkData($unit_data)) {*/
        if (!empty($unit_data['SerialNo'])) {
            $unit_insertion = $this->Units_model->update_unit($unit_data);
            if ($unit_insertion["result"] == "RESPONSE_OK") {
                $response["result"] = "RESPONSE_OK";
                $response["response_data"] = $unit_data;
            } else {
                $response["description"] = "Update error";
            }
        } else {
            $response["description"] = "Empty Input";
        }
        echo json_encode($response);
    }

    /**
     * Internal method - Finds the associated unit from the specified SerialNo.
     * @param  $SerialNo [SerialNo]
     * @return $associated_unit [Array with unit data]
     */
    private function get_associated_unit($SerialNo) {
        $unit_data["SerialNo"] = $SerialNo;

        $associated_unit = array();
        $associated_unit_query = $this->Units_model->get_unit($unit_data);

        if ($associated_unit_query["result"] == "RESPONSE_OK") {
            $associated_unit = $associated_unit_query["response_data"][0];
        }
        return $associated_unit;
    }

    /**
     * Reads the input from the browser, and calls the delete_container-method from the model-class, it then creates a JSON array based on the return values of the method.
     * @param  n/a
     * @return json-array [json-array with confirmation code]
     */
    public function delete_unit() {
        $response["result"] = "RESPONSE_ERROR";

        $unit_data["SerialNo"] = $this->input->post("SerialNo");
        $unit_delete = $this->Units_model->delete_unit($unit_data);

        if ($unit_delete["result"] == "RESPONSE_OK") {
            $response["result"] = "RESPONSE_OK";
        } else {
            $response["description"] = "Delete error";
        }
        echo json_encode($response);
    }

    /**
     * Reads the input from the browser, and calls the get_log-method from the model-class, it then creates a JSON array based on the return values of the method.
     * @param  n/a
     * @return json-array [json-array with confirmation code and the log]
     */
    public function get_log() {
        $response["result"] = "RESPONSE_ERROR";

        $unit_data["SerialNo"] = $this->input->get("SerialNo");
        $unit_log = $this->Units_model->get_log($unit_data);

        if ($unit_log["response_data"] != FALSE) {
            $response["result"] = "RESPONSE_OK";
            $response['log_data'] = $unit_log["response_data"];
        } else {
            $response["result"] = "RESPONSE_ERROR";
            $response["description"] = "No Log or bad parameters";
        }
        echo json_encode($response);
    }
    /**
     * Reads the input from the browser, and calls the get_log-method from the model-class, it then creates a JSON array based on the return values of the method.
     * @param  n/a
     * @return json-array [json-array with confirmation code and the log]
     */
    public function get_predective_mentainance() {
        $response["result"] = "RESPONSE_ERROR";
		
        $logged_in_userdata = $this->session->userdata('logged_in');
        $logged_in_userdata_ID = $logged_in_userdata['ID'];
		$user_related_to_id_array = $this->User_model->get_related_to_ID($logged_in_userdata_ID);
		
			$user_related_to_id = $user_related_to_id_array["response_data"]["related_to_ID"][0]['RelatedTo'];
			if ($user_related_to_id_array["result"] == "RESPONSE_OK") {
		}else{
			$user_related_to_id = '';
		}
        $units_request = $this->Units_model->get_predective_mentainance($user_related_to_id);
        if ($units_request["result"] == "RESPONSE_OK") {
            $containers = $units_request["response_data"];
            if (is_array($containers)) {
                $indexed_units = array();
                foreach ($containers as $key => $value) {
                    $indexed_units[$value["SerialNo"]] = $key;
                }
            }
            $response["result"] = "RESPONSE_OK";
            $response["response_data"]["units"] = $containers;
            $response["response_data"]["indexed_units"] = $indexed_units;
        } else {
            $response["description"] = $units_request["description"];
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
                    if (is_null($value) | $value === '') {
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
