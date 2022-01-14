<?php

	class NotFound extends CI_Controller
	{

		protected $CI;

		public function __construct()
		{

			parent::__construct ();

			$this -> CI = & get_instance();

		}

		public function index ()
		{

			$this -> CI -> output
						-> set_content_type('application/json')
						-> set_status_header (404)
				        -> set_output (json_encode(array (
							'status' => 'error',
							'message' => 'Not Found'
						)))
						-> _display ();

			exit ;

		}

	}

?>
