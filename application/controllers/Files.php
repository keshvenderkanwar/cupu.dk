<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Files extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("Files_model");
        $this->load->model("Endcustomer_model");
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
        $this->load->view('Files', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Calls the get_units-method from the model-class, it then creates a JSON array based on the return values of the method.
     * @param  n/a
     * @return json-array [json-array with confirmation code and data]
     */
    public function get_files() {
        $response["result"] = "RESPONSE_ERROR";

        $files_request = $this->Files_model->get_files();

        if ($files_request["result"] == "RESPONSE_OK") {
            $files = $files_request["response_data"];
            if (is_array($files)) {
                $indexed_files = array();
                foreach ($files as $key => $value) {
                    $indexed_files[$value["FileNo"]] = $key;
                }
            }

            $response["result"] = "RESPONSE_OK";
            $response["response_data"]["files"] = $files;
            $response["response_data"]["indexed_files"] = $indexed_files;
        } else {
            $response["description"] = $files_request["description"];
        }
        echo json_encode($response);
    }

    /**
     * Reads and validates the input from the browser, and calls the save_file-method from the model-class, it then creates a JSON array based on the return values of the method.
     * @param  n/a
     * @return json-array [json-array with confirmation code]
     */
    public function save_file() {
        $file_data = $this->input->post(NULL, TRUE);
        $file_data = array("Description" => $file_data["Description"], "FileName" => $_FILES['myfile']['name'],"EndCustomerNo" => $file_data["EndCustomerNo"]);
		$ext = pathinfo($file_data['FileName'], PATHINFO_EXTENSION);
		$ext = strtolower($ext);
		
		if($ext == 'mp3' || $ext == 'aac' || $ext == 'wma' || $ext == 'wav' || $ext == 'midi' || $ext == 'm4a'){
			if (empty($file_data["Description"])) {
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
					$response["description"] = "Error! File name available, but saving file failed.";
			}else{
                $response["result"] = "RESPONSE_ERROR";
                $response["description"] = "Error! Sound with that filename already exists";
            }
			echo json_encode($response);
	//        $model_response = $this->files_model->save_file($file_data);
	//
	//        return $model_response;
	//
	//            sleep(1);
	//            echo '<script src=http://cupu.dk/assets/js/File-Controller.js>stopUpload(' . $result . ');</script>';
	//echo "<script>window.location.href = '/files';</script>";
		}else{
			$response["result"] = "RESPONSE_ERROR";
			$response["description"] = "Upload failed. Please upload a file of type mp3,aac,wma,wav,midi";
			echo json_encode($response);
		}
    }

    /**
     * Checks the database if the file has been saved.
     * @param  n/a
     * @return json-array [json-array with confirmation code and the saved data]
     */
    public function check_upload_status() {
        $file_data = $this->input->post(null, true);

        $files_request = $this->Files_model->get_files();
        $fileNoPresent = false;
        if ($files_request["result"] == "RESPONSE_OK") {
            $files = $files_request["response_data"];
            if (is_array($files)) {
                foreach ($files as $key => $value) {
                    if ($value["FileNo"] == $file_data["FileNo"]) {
                        $fileNoPresent = true;
                    }
                }
            }
        }
        if ($fileNoPresent) {
            $response["Result"] = "RESPONSE_OK";
            $response["description"] = "Success. Filed saved";
        } else {
            $response["Result"] = "RESPONSE_ERROR";
            $response["description"] = "File not saved yet.";
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

        $file_data = $this->input->post(NULL, TRUE);

        if ($this->checkData($file_data)) {
            $file_insertion = $this->Units_model->update_unit($file_data);
            if ($file_insertion["result"] == "RESPONSE_OK") {
                $response["result"] = "RESPONSE_OK";
                $response["response_data"] = $file_data;
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
    public function delete_file() {
        $response["result"] = "RESPONSE_ERROR";

        $file_data["FileNo"] = $this->input->post("FileNo");
        $file_delete = $this->Files_model->delete_file($file_data);

        if ($file_delete["result"] == "RESPONSE_OK") {
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
    public function get_all_files() {
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
    public function get_files_Endcustomer() {

       $user_logged_data = $this->session->userdata('logged_in');
       $user_logged_relatedTo = $user_logged_data['RelatedTo'];
        $response["result"] = "RESPONSE_ERROR";

        $files_request = $this->Files_model->get_files_Endcustomer($user_logged_relatedTo);

        if ($files_request["result"] == "RESPONSE_OK") {
            $files = $files_request["response_data"];
            if (is_array($files)) {
                $indexed_files = array();
                foreach ($files as $key => $value) {
                    $indexed_files[$value["FileNo"]] = $key;
                }
            }

            $response["result"] = "RESPONSE_OK";
            $response["response_data"]["files"] = $files;
            $response["response_data"]["indexed_files"] = $indexed_files;
        } else {
            $response["description"] = $files_request["description"];
        }
        echo json_encode($response);
    }
	
    /**
     * Reads the input from the browser, and calls the get_log-method from the model-class, it then creates a JSON array based on the return values of the method.
     * @param  n/a
     * @return json-array [json-array with confirmation code and the log]
     */
    public function get_files_integrator() {
        $response["result"] = "RESPONSE_ERROR";
       $user_logged_data = $this->session->userdata('logged_in');
       $user_associated_endcustomer = $this->Endcustomer_model->get_user_ID_related_to($user_logged_data['RelatedTo']);
       $endcustomer_data = array();
       if(isset($user_associated_endcustomer["result"]) && $user_associated_endcustomer["result"] = "RESPONSE_OK"){
            foreach($user_associated_endcustomer['response_data']['related_to_ID'] as $single_result){
                $endcustomer_data[] = $single_result['EndCustomerNo'];
             }
             $files_request = $this->Files_model->get_files_integrator($endcustomer_data);

            if ($files_request["result"] == "RESPONSE_OK") {
                $files = $files_request["response_data"];
                if (is_array($files)) {
                    $indexed_files = array();
                    foreach ($files as $key => $value) {
                        $indexed_files[$value["FileNo"]] = $key;
                    }
                }

                $response["result"] = "RESPONSE_OK";
                $response["response_data"]["files"] = $files;
                $response["response_data"]["indexed_files"] = $indexed_files;
            } else {
                $response["description"] = $files_request["description"];
            }
            echo json_encode($response);
           }
    }
	/**
     * Reads the input from the browser, and calls the get_log-method from the model-class, it then creates a JSON array based on the return values of the method.
     * @param  n/a
     * @return json-array [json-array with confirmation code and the log]
     */
    public function get_all_playlist() {
        $response["result"] = "RESPONSE_ERROR";
		$SerialNo = $this->input->post("SerialNo");
		
		$playlist_request = $this->Files_model->get_all_playlist($SerialNo);
        if ($playlist_request["result"] == "RESPONSE_OK") {
			$response['playlist_data'] = $playlist_request["response_data"];
            $playlists = $playlist_request["response_data"];
			$response["result"] = "RESPONSE_OK";
        }else{
			$response["result"] = "RESPONSE_ERROR";
		}
        echo json_encode($response);
		
	}
	
    /**
     * Reads the input from the browser, and calls the get_log-method from the model-class, it then creates a JSON array based on the return values of the method.
     * @param  n/a
     * @return json-array [json-array with confirmation code and the log]
     */
    public function update_playlist() {
         $playlist_data = $this->input->post(NULL, TRUE);
            $this->delete_playlist($playlist_data['SerialNo']);
         if(!empty($playlist_data['select_data'])){
                 $this->Files_model->update_playlist($playlist_data); 
            }       
            $response["result"] = "RESPONSE_OK";
            echo json_encode($response);
    }
    
    /**
     * Reads the input from the browser, and calls the get_log-method from the model-class, it then creates a JSON array based on the return values of the method.
     * @param  n/a
     * @return json-array [json-array with confirmation code and the log]
     */
    public function delete_playlist($SerialNo) {
        $this->Files_model->delete_playlist($SerialNo);
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
