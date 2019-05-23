<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Files_model extends CI_Model {

    public function __construct() {
        //parent::__construct();
    }

    /**
     * returns all the files.
     * @param  n/a
     * @return $response [array with all the units data.]
     */
    public function get_files() {
        $response["result"] = "RESPONSE_OK";

        $files_query = $this->db->get("cupu_sound_files");
        $files_array = $files_query->result_array();
        $response["response_data"] = $files_array;
        return $response;
    }
    /**
     * returns all the files.
     * @param  n/a
     * @return $response [array with all the units data.]
     */
    public function get_files_Endcustomer($user_logged_relatedTo) {
        $response["result"] = "RESPONSE_OK";

        $this->db->where("EndCustomerNo", $user_logged_relatedTo);
        $files_query = $this->db->get("cupu_sound_files");
        $files_array = $files_query->result_array();
        $response["response_data"] = $files_array;
        return $response;
    }
    /**
     * returns all the files.
     * @param  n/a
     * @return $response [array with all the units data.]
     */
    public function get_files_integrator($user_logged_relatedTo) {
        $response["result"] = "RESPONSE_OK";

        $this->db->where_in("EndCustomerNo", $user_logged_relatedTo);
        $files_query = $this->db->get("cupu_sound_files");
        $files_array = $files_query->result_array();
        $response["response_data"] = $files_array;
        return $response;
    }

    /**
     * Saves a file in the database.
     * @param  $file_data [Array with file data]
     * @return $response [array with confirmation code]
     */
    public function save_file($file_data) {
        $response["result"] = "RESPONSE_ERROR";

        

        if (empty($file_data["FileTitle"])) {
            return $response;
        }

//check for FileName isn't in db yet.
        $files_request = $this->Files_model->get_files();
        $fileNamePresent = false;
        if ($files_request["result"] == "RESPONSE_OK") {
            $files = $files_request["response_data"];
            if (is_array($files)) {
                foreach ($files as $key => $value) {
                    if ($value["FileName"] == $file_data["FileName"]) {
                        $fileNamePresent = true;
                    }
                }
            }
        }
        if (!$fileNamePresent) {
            $this->db->insert("cupu_sound_files", $file_data);


            $destination_path = getcwd() . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;

            $target_path = $destination_path . basename($_FILES['myfile']['name']);

            if (@move_uploaded_file($_FILES['myfile']['tmp_name'], $target_path)) {
                $response["result"] = "RESPONSE_OK";
            } else
                $response["description"] = "failed. File name available, but saving file failed.";
        }
        return $response;
    }

    /**
     * Deletes a file from the database and uploads directory
     * @param  $conditions [Array with unit data]
     * @return $response [array with confirmation code]
     */
    public function delete_file($conditions = array()) {
        $response["result"] = "RESPONSE_ERROR";

        if ($this->checkData($conditions)) {
            $response["result"] = "RESPONSE_OK";

            $this->db->select("cupu_sound_files.*");
            $this->db->where($conditions);
            $db_result = $this->db->get("cupu_sound_files")->result_array();

            if (!empty($db_result)) {
                $file = $db_result[0];
                $destination_path = getcwd() . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
                $target_path = $destination_path . $file["FileName"];
                if (is_file($target_path)) {
                    unlink($target_path);
                }

                $this->db->where($conditions);
                $this->db->delete("cupu_sound_files");
            }
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
            $response["result"] = "RESPONSE_OK";
            $this->db->where("SerialNo", $unit_data["SerialNo"]);
            $this->db->update("CUPU_unit", $unit_data);
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
    public function get_all_playlist($SerialNo='') {
        $response["result"] = "RESPONSE_ERROR";
		
        if (!empty($SerialNo)) {
            $this->db->where("SerialNo", $SerialNo);
            $reaponse_array = array();
            $playlist_query = $this->db->get("CUPU_playlists");
			$playlist_array = $playlist_query->result_array();
			if(!empty($playlist_array)){
                $counting_playlist = 0;
                foreach($playlist_array as $playlist_array_single){
                    $file_single_array = $this->get_sound_file(array('FileNo'=>$playlist_array_single['FileNo']));
                    if(!empty($file_single_array['response_data']) &&  $file_single_array['result'] == 'RESPONSE_OK'){
                        foreach($file_single_array['response_data'] as $key => $val){
                            $reaponse_array[$counting_playlist]['FileNo']=  $val['FileNo'];
                            $reaponse_array[$counting_playlist]['FileName']= $val['FileName'];
                        }
                         $counting_playlist++;
                    }
                }
               // print_r($reaponse_array);
               // print_r($playlist_array);
               // die();
				$response["response_data"] = $reaponse_array;
				$response["result"] = "RESPONSE_OK";
			}else{
				$response["description"] = "Data is empty";
			}
        } else {
            $response["description"] = "Serial no is empty";
        }

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
     * Returns the log of uploads from the database from the given container number.
     * @param  $conditions [Array with container number]
     * @return $name [variable with the name]
     */
    public function get_sound_playlist($sound_data = array()) {
        $response["result"] = "RESPONSE_OK";
        //$this->db->select('CUPU_playlists.SerialNo, CUPU_playlists.FileNo,cupu_sound_files.FileName');
        $this->db->select('CUPU_playlists.FileNo as FN,cupu_sound_files.FileName as SName');
		$this->db->from("CUPU_playlists");
		$this->db->join('cupu_sound_files', 'cupu_sound_files.FileNo  = CUPU_playlists.FileNo');
        $this->db->where("SerialNo", $sound_data["SerialNo"]);
        //$this->db->where("SerialNo", '3046323932350306000400');
        $playlists_query = $this->db->get();
        $playlists_array = $playlists_query->result_array();
        $response["response_data"] = $playlists_array;
        return $response;
    }
    /**
     * Returns the log of uploads from the database from the given container number.
     * @param  $conditions [Array with container number]
     * @return $name [variable with the name]
     */
    public function delete_playlist($SerialNo) {
        $this->db->where("SerialNo", $SerialNo);
        $this->db->delete("CUPU_playlists");
    }
    /**
     * Returns the log of uploads from the database from the given container number.
     * @param  $conditions [Array with container number]
     * @return $name [variable with the name]
     */
    public function update_playlist($playlist_data) {
        foreach($playlist_data['select_data'] as $playlist_data_single){
            $playlist_data_insert['SerialNo'] = $playlist_data['SerialNo'];
            $playlist_data_insert['FileNo'] = $playlist_data_single;
            $this->db->insert("CUPU_playlists", $playlist_data_insert);
        }
    }
    /**
     * Returns the log of uploads from the database from the given container number.
     * @param  $conditions [Array with container number]
     * @return $name [variable with the name]
     */
    public function get_sound_file($sound_data = array()) {
        $response["result"] = "RESPONSE_OK";
		$this->db->select('FileName, FileNo'); 
        $this->db->where("FileNo", $sound_data["FileNo"]); 
        $playlists_query = $this->db->get("cupu_sound_files");
        $playlists_array = $playlists_query->result_array();
        $response["response_data"] = $playlists_array;
        return $response;
    }

    /**
     * Returns the log of uploads from the database from the given container number.
     * @param  $conditions [Array with container number]
     * @return $name [variable with the name]
     */
    public function save_log($data) {
        $response["result"] = "RESPONSE_OK";
        $this->db->insert('CUPU_log', $data);
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
