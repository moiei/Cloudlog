<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
	Controller to interact with the Clublog API
*/

class Clublog extends CI_Controller {

	// Show frontend if there is one
	public function index() {

	}

	// Upload ADIF to Clublog
	public function upload($username) {
		$this->load->helper('file');

		$this->load->model('logbook_model');

		$this->load->model('clublog_model');

		$clublog_info = $this->clublog_model->get_clublog_auth_info($username);

		if(!isset($clublog_info['user_name'])) {
			echo "Username unknown";
			exit;
		}


		print_r($clublog_info);

		$data['qsos'] = $this->logbook_model->get_clublog_qsos();

		// Create ADIF File of contacts not uploaded to Clublog
		$string = $this->load->view('adif/data/clublog', $data, TRUE);

		if ( ! write_file('uploads/clublog.adi', $string)) {
		     echo 'Unable to write the file - Make the folder Upload folder has write permissions.';
		}
		else {
		    echo "uploads/clublog.adi file created.";
		}


	}
	
	
}