<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Integrator_model extends CI_Model {

    public function __construct() {
        //parent::__construct();
    }

    /**
     * returns all the CUPU Integrators.
     * @param  n/a
     * @return $response [array with all the Integrators data.]
     */
    public function get_Integrators() {
		
        $response["result"] = "RESPONSE_OK";
        $user_type_logedin =  $this->session->userdata("logged_in")["Type"];
        
        $this->db->select("*");
        $this->db->from('CUPU_Integrator');
		
        $response['user_type'] = 'Admin';
        if($user_type_logedin == 'Integrator' ){
            $this->db->where("associatedIntegrator", $user_ID_logedin);
            $response['user_type'] = 'Integrator';
        }if($user_type_logedin == 'End Customer'){
            $this->db->where("EndCustomerNo ", $user_ID_logedin);
            $response['user_type'] = 'End Customer';
        }
        
        $Integrators_query = $this->db->get();
        $Integrators_array = $Integrators_query->result_array();
        $response["response_data"] = $Integrators_array;
        return $response;
    }

    /**
     * Saves a Integrator in the database.
     * @param  $Integrator_data [Array with Integrator data]
     * @return $response [array with confirmation code]
     */
    public function save_Integrator($Integrator_data) {
        $response["result"] = "RESPONSE_ERROR";
        $required_Integrator_data = $Integrator_data;

        if ($this->checkData($required_Integrator_data)) {
            $response["result"] = "RESPONSE_OK";
            $this->db->insert("CUPU_Integrator", $Integrator_data);
        } else {
            $response["description"] = "No field can be empty";
        }

        return $response;
    }

    /**
     * Deletes a Integrator from the database
     * @param  $conditions [Array with Integrator data]
     * @return $response [array with confirmation code]
     */
    public function delete_Integrator($conditions = array()) {
        $response["result"] = "RESPONSE_ERROR";
        
        if ($this->checkData($conditions)) {
            $response["result"] = "RESPONSE_OK";
            $this->db->where("IntegratorNo",$conditions['IntegratorNo']);
            $this->db->delete("CUPU_Integrator");
        } else {
            $response["description"] = "No field can be empty";
        }

        return $response;
    }

    /**
     * Updates a Integrator in the database.
     * @param  $Integrator_data [Array with Integrator data]
     * @return $response [array with confirmation code]
     */
    public function update_Integrator($Integrator_data) {
        $response["result"] = "RESPONSE_ERROR";

        $required_Integrator_data = $Integrator_data;

        if ($this->checkData($required_Integrator_data)) {
            $response["result"] = "RESPONSE_OK";
            $this->db->where("IntegratorNo", $Integrator_data["IntegratorNo"]);
            $this->db->update("CUPU_Integrator", $Integrator_data);
        } else {
            $response["description"] = "No field can be empty";
        }

        return $response;
    }

    /**
     * Returns a Integrator from the database from the given IntegratorNo.
     * @param  $conditions [Array with IntegratorNo]
     * @return $response [array with confirmation code and container group data]
     */
    public function get_Integrator($conditions = array()) {
        $response["result"] = "RESPONSE_OK";
        $this->db->select("*");
        $this->db->where($conditions);
        $Integrator_query = $this->db->get("CUPU_Integrator");
        $Integrator_array = $Integrator_query->result_array()[0];
        $response["response_data"] = $Integrator_array;
        return $response;
    }

    /**
     * Returns a Integrator from the database from the given IntegratorNo.
     * @param  $conditions [Array with IntegratorNo]
     * @return $response [array with confirmation code and container group data]
     */
    public function get_Integrator_from_UserID($userID) {
        $this->db->select("IntegratorNo");
        $this->db->where("UserID", $userID);
        $Integrator_query = $this->db->get("Integrator_Users");
        $IntegratorNo = $Integrator_query->result_array()[0];
        $response = $this->get_Integrator($IntegratorNo);
        return $response;
    }

    /**
     * Returns the column names of container table in the database.
     * @param  n/a
     * @return $fields [array with data]
     */
    public function get_fields() {
        $fields = $this->db->list_fields('CUPU_Integrator');
        return $fields;
    }

    public function get_integrator_logo($ID) {
        $response["result"] = "RESPONSE_ERROR";

        $this->db->select("IntegratorLogo");
        $this->db->where("IntegratorNo",$ID);
        $user_request = $this->db->get("CUPU_Integrator")->result_array();

        if (!empty($user_request)) {
            $response = $user_request[0]['IntegratorLogo'];
        } else {
            $response = "Error.";
        }
        return $response;
    }

    /**
     * internal method that check the validity of the input data.
     * @param  n/a
     * @return boolean [true if all the values are filled out, false otherwise]
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
