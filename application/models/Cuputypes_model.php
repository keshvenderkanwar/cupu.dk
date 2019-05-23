<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cuputypes_model extends CI_Model {

    public function __construct() {
       // parent::__construct();
    }

    /**
     * returns all the CUPU units.
     * @param  n/a
     * @return $response [array with all the units data.]
     */
    public function get_cuputypes() {
        $response["result"] = "RESPONSE_OK";
        $this->db->select("CUPU_types.*");
        $this->db->from('CUPU_types');

        $units_query = $this->db->get();
        $units_array = $units_query->result_array();
        $response["response_data"] = $units_array;
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
