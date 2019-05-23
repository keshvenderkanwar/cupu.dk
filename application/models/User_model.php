<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

Class User_model extends CI_Model {

    /**
     * Login user
     * @param  n/a
     * @return $response [array with the id and username.]
     */
    function login($username, $password) {
        $this->db->select('ID, Username,Email, Password, Type,RelatedTo');
        $this->db->from('users');
        $this->db->where('Username', $username);
        $this->db->limit(1);
		$userArray = $this->db->get()->result_array();
		if(!empty($userArray)){
        //$query = $this->db->get()->result_array()[0];
		$query = $userArray[0];
			if (hash_equals($query["Password"], crypt($password, $query["Password"]))) {
				unset($query["Password"]);
				return $query;
			} else {
				return false;
			}
		}else{
			return false;
		}
    }

    /**
     * Calls the get_users-method from the model-class, it then creates a JSON array based on the return values of the method.
     * @param  n/a
     * @return json-array [json-array with confirmation code and data]
     */
    public function get_users() {
        $response["result"] = "RESPONSE_ERROR";

        $this->db->select("ID,Username,Email,Type,RelatedTo,UserPicture");
        $user_request = $this->db->get("users")->result_array();

        if (!empty($user_request)) {
            if (is_array($user_request)) {
                $indexed_volume = array();
                foreach ($user_request as $key => $value) {
                    $indexed_volume[$value["ID"]] = $key;
                }
            }

            $response["result"] = "RESPONSE_OK";
            $response["response_data"]["users"] = $user_request;
            $response["response_data"]["indexed_users"] = $indexed_volume;
        } else {
            $response["description"] = "Error.";
        }

        return $response;
    }

    /**
     * Calls the get_users-method from the model-class, it then creates a JSON array based on the return values of the method.
     * @param  n/a
     * @return json-array [json-array with confirmation code and data]
     */
    public function get_users_integrator($logged_user_related_to,$associated_array,$userType) {
        $response["result"] = "RESPONSE_ERROR";

        $this->db->select("ID,Username,Email,Type,RelatedTo,UserPicture");
        $where = "RelatedTo='".$logged_user_related_to."' ";
        if(!empty($associated_array)){
            $where .= "OR RelatedTo IN(".implode(',',$associated_array).")";
        }
		if(!empty($userType)){
			$where .= " AND Type='".$userType."'";
		}
        $this->db->where($where);
        $user_request = $this->db->get("users")->result_array();

        if (!empty($user_request)) {
            if (is_array($user_request)) {
                $indexed_volume = array();
                foreach ($user_request as $key => $value) {
                    $indexed_volume[$value["ID"]] = $key;
                }
            }

            $response["result"] = "RESPONSE_OK";
            $response["response_data"]["users"] = $user_request;
            $response["response_data"]["indexed_users"] = $indexed_volume;
        } else {
            $response["description"] = "Error.";
        }

        return $response;
    }

	 public function get_users_logo($ID) {
        $response["result"] = "RESPONSE_ERROR";

        $this->db->select("UserPicture");
        $this->db->where("ID",$ID);
        $user_request = $this->db->get("users")->result_array();

        if (!empty($user_request)) {
            $response = $user_request[0]['UserPicture'];
        } else {
            $response = "Error.";
        }
        return $response;
    }
	
    /**
     * Inserts the user data into the database
     * @param  n/a
     * @return json-array [json-array with confirmation code and the saved data]
     */
    public function save_user($user_data) {

        if (isset($user_data["Password"]) && !empty($user_data["Password"])) {
            $cost = 10;
            $salt = strtr(base64_encode(random_bytes ( 16 )), '+', '.');
            $salt = sprintf("$2a$%02d$", $cost) . $salt;
            $user_data["Password"] = crypt($user_data["Password"], $salt);
        }
        $db_response = $this->db->insert("users", $user_data);

        return $db_response;
    }

    /**
     * updates a user in the database
     * @param  n/a
     * @return json-array [json-array with confirmation code and the new data]
     */
    public function update_user($user_data) {
        $update_values = $user_data;
        unset($update_values["id"]);

        if (isset($user_data["Password"]) && !empty($user_data["Password"])) {
            $cost = 10;
            $salt = strtr(base64_encode(random_bytes ( 16 )), '+', '.');
            $salt = sprintf("$2a$%02d$", $cost) . $salt;
            $update_values["Password"] = crypt($user_data["Password"], $salt);
        }
        $this->db->where("ID", $user_data["id"]);
        $db_response = $this->db->update("users", $update_values);

        return $db_response;
    }

    /**
     * Reads the input from the browser, and calls the delete_user-method from the model-class, it then creates a JSON array based on the return values of the method.
     * @param  n/a
     * @return json-array [json-array with confirmation code]
     */
    public function delete_user($id) {

        if ($this->checkData($id)) {
            $response["result"] = "RESPONSE_OK";
            $this->db->where("ID",$id);
            $this->db->delete("users");
        } else {
            $response["result"] = "RESPONSE_ERROR";
            $response["description"] = "No field can be empty";
        }
        return $response;
    }

    public function get_all_related_to(){
        $response["result"] = "RESPONSE_ERROR";

        $this->db->select("ID,Username");
        $where = "Type='Integrator' OR Type='End Customer'";
            $this->db->where($where);
            $all_related_to = $this->db->get("users")->result_array();
        if(!empty($all_related_to)){
            $response["result"] = "RESPONSE_OK";
            $response["response_data"]["all_related_to"] = $all_related_to;
        } else {
            $response["description"] = "Error.";
        }

        return $response;
    }
    public function get_related_to_ID($loggedInUserID){
        $response["result"] = "RESPONSE_ERROR";

        $this->db->select("RelatedTo");
        $where = "ID=".$loggedInUserID;
            $this->db->where($where);
            $all_related_to = $this->db->get("users")->result_array();
        if(!empty($all_related_to)){
            $response["result"] = "RESPONSE_OK";
            $response["response_data"]["related_to_ID"] = $all_related_to;
        } else {
            $response["description"] = "Error.";
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

?>