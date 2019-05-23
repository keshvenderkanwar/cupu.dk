<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Units_model extends CI_Model {

    public function __construct() {
        //parent::__construct();
    }

    /**
     * returns all the CUPU units.
     * @param  n/a
     * @return $response [array with all the units data.]
     */
    public function get_units($logged_in_userdata_ID=NULL) {
        $logged_in_userdata = $this->session->userdata('logged_in');
        
        $response["result"] = "RESPONSE_OK";
        $this->db->select("CUPU_unit.SerialNo, CUPU_unit.HardwareCode, CUPU_types.HardwareName,CUPU_unit.Lat, CUPU_unit.Note,CUPU_unit.EndCustomerNo,CUPU_unit.IntegratorNo,CUPU_unit.Lng,CUPU_unit.AirCompressorTimeout,CUPU_unit.AudioOutVolume");
        if(!empty($logged_in_userdata_ID) && $logged_in_userdata_ID > 0){
            $where = "CUPU_unit.IntegratorNo=".$logged_in_userdata_ID." OR CUPU_unit.EndCustomerNo=".$logged_in_userdata_ID;
            $this->db->where($where);
        }else if($logged_in_userdata['Type'] != 'Admin'){
			return $response["response_data"] = array();
		}
        $this->db->from('CUPU_unit');
        $this->db->join('CUPU_types', "CUPU_types.HardwareCode = CUPU_unit.HardwareCode", 'left');

        $units_query = $this->db->get();
        $units_array = $units_query->result_array();
       /* foreach(){

        }*/
        $response["response_data"] = $units_array;
        return $response;
    }
    /**
     * returns all the CUPU units.
     * @param  n/a
     * @return $response [array with all the units data.]
     */
    public function get_predective_mentainance($logged_in_userdata_ID=NULL) {
        $logged_in_userdata = $this->session->userdata('logged_in');
        
        $response["result"] = "RESPONSE_OK";
        $this->db->select("DISTINCT(CUPU_log.ErrorCode), CUPU_unit.TotalOperatingHours, CUPU_unit.TotalNoOfActivations,CUPU_unit.SerialNo");
		 $this->db->where("CUPU_unit.SerialNo<>''");
        if(!empty($logged_in_userdata_ID) && $logged_in_userdata_ID > 0){
            $where = "AND CUPU_unit.IntegratorNo=".$logged_in_userdata_ID." OR CUPU_unit.EndCustomerNo=".$logged_in_userdata_ID;
            $this->db->where($where);
        }else if($logged_in_userdata['Type'] != 'Admin'){
			return $response["response_data"] = array();
		}
        $this->db->from('CUPU_log');
        $this->db->join('CUPU_unit', "CUPU_unit.SerialNo = CUPU_log.SerialNo", 'left');

        $units_query = $this->db->get();
        $units_array = $units_query->result_array();
       /* foreach(){

        }*/
		//echo $this->db->last_query();
        $response["response_data"] = $units_array;
        return $response;
    }

    /**
     * Saves a unit in the database.
     * @param  $unit_data [Array with unit data]
     * @return $response [array with confirmation code]
     */
    public function save_unit($unit_data) {
        $response["result"] = "RESPONSE_ERROR";
        $required_unit_data = $unit_data;
        if ($this->checkData($required_unit_data)) {
            $this->db->where('SerialNo',$unit_data['SerialNo']);
            $query = $this->db->get('CUPU_unit');
            if ($query->num_rows() > 0){
                $this->db->where('SerialNo', $unit_data['SerialNo']);
                $this->db->update('CUPU_unit', $unit_data);
                $response["result"] = "RESPONSE_OK";
            }
            else{
                $this->db->insert("CUPU_unit", $unit_data);
                $response["result"] = "RESPONSE_OK";
            }
        } else {
            $response["description"] = "No field can be empty";
        }

        return $response;
    }

    /**
     * Deletes a unit from the database
     * @param  $conditions [Array with unit data]
     * @return $response [array with confirmation code]
     */
    public function delete_unit($conditions = array()) {
        $response["result"] = "RESPONSE_ERROR";

        if ($this->checkData($conditions)) {
            $response["result"] = "RESPONSE_OK";
            $this->db->where($conditions);
            $this->db->delete("CUPU_unit");
        } else {
            $response["description"] = "No field can be empty";
        }

        return $response;
    }

    /**
     * Updates a unit in the database.
     * @param  $unit_data [Array with unit data]
     * @return $response [array with confirmation code]
     */
    public function update_unit($unit_data) {
        $response["result"] = "RESPONSE_ERROR";

        $required_unit_data = $unit_data;

        if ($this->checkData($required_unit_data)) {
			//unset($unit_data['HardwareName']);
            $response["result"] = "RESPONSE_OK";
			$this->db->where("SerialNo", $unit_data["SerialNo"]);
			$db_response = $this->db->update("CUPU_unit", $unit_data);
			/*$this->db->set('a.AirCompressorTimeout', $unit_data['AirCompressorTimeout']);
			$this->db->set('a.Lat', $unit_data['Lat']);
			$this->db->set('a.Lng', $unit_data['Lng']);
			$this->db->set('b.HardwareName', $unit_data['HardwareName']);
            $this->db->where("a.SerialNo", $unit_data["SerialNo"]);
            $this->db->where("a.HardwareCode = b.HardwareCode");
            $this->db->update("CUPU_unit as a , CUPU_types as b");*/
        } else {
            $response["description"] = "No field can be empty";
        }

        return $response;
    }

    /**
     * Returns a unit from the database from the given SerialNo.
     * @param  $conditions [Array with SerialNo]
     * @return $response [array with confirmation code and container group data]
     */
    public function get_unit($conditions = array()) {
        $response["result"] = "RESPONSE_OK";
        $this->db->select("*");
        $this->db->where($conditions);
        $unit_query = $this->db->get("CUPU_unit");
        $unit_array = $unit_query->result_array();
        $response["response_data"] = $unit_array;
        return $response;
    }

    /**
     * Returns a unit from the database from the given SerialNo.
     * @param  $conditions [Array with SerialNo]
     * @return $response [array with confirmation code and container group data]
     */
    public function get_units_stat($SerialNo) {
        $response["result"] = "RESPONSE_OK";
        $this->db->select("DISTINCT(Timestamp),Temperature");
        $this->db->where("(SerialNo LIKE '".$SerialNo."'  AND Timestamp >= DATE_ADD(CURDATE(),INTERVAL -7 DAY))");
		$this->db->group_by('date(Timestamp)'); 
        $unit_query = $this->db->get("CUPU_log");
        $unit_array = $unit_query->result_array();
        $response["response_data"] = $unit_array;
        return $response;
    }

    /**
     * Returns the column names of container table in the database.
     * @param  n/a
     * @return $fields [array with data]
     */
    public function get_fields() {
        $fields = $this->db->list_fields('CUPU_unit');
        return $fields;
    }

    /**
     * Returns the log of uploads from the database from the given container number.
     * @param  $conditions [Array with container number]
     * @return $name [variable with the name]
     */
    public function get_log($conditions = array()) {
        $response["result"] = "RESPONSE_OK";
        $this->db->where($conditions);
        $this->db->order_by('Timestamp', 'asc');
        $unit_query = $this->db->get("CUPU_log");
        $unit_array = $unit_query->result_array();
        $response["response_data"] = $unit_array;
        return $response;
    }

    /**
     * saves the log of an upload to the database 
     * @param  $data [Array with upload data]
     * @return $response [string representing success or failure]
     */
    public function save_log($data) {

        //Check if inputs are column titles in table.
        $query = $this->db->get('CUPU_log');
        $columnNames = array();
        foreach ($query->result()[0] as $key => $value) {
            array_push($columnNames, $key);
        }
        foreach ($data as $key => $value) {
            if (!in_array($key, $columnNames)) {
                unset($data[$key]);
            }
        }
        
        //insert data
        if ($this->db->insert('CUPU_log', $data)) {
            $response["result"] = "RESPONSE_OK";
        } else {
            $response["result"] = "RESPONSE_ERROR";
        }
        return $response;
    }

    /**
     * Returns the log of uploads from the database from the given container number.
     * @param  $conditions [Array with container number]
     * @return $name [variable with the name]
     */
    public function get_log_error_code($SerialNo = NULL) {
        $response["result"] = "RESPONSE_OK";
        $this->db->where(array('SerialNo'=>$SerialNo));
        $this->db->order_by('ID', 'desc');
        $this->db->limit(0,1);
        $unit_query = $this->db->get("CUPU_log");
        $unit_array = $unit_query->row();
       
        $error_code = isset($unit_array->ErrorCode)?$unit_array->ErrorCode:0;
        
        $response["response_data"] = $error_code;
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
