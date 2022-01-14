<?php

	class Api extends CI_Controller
	{

		private $api_key = NULL;
		private $site_url = 'http://localhost/api-eticaret/';
		private $user = NULL;

		public function __construct()
		{

			parent::__construct ();

			$this -> output
				  -> set_content_type ('application/json')
				  -> set_header ('Access-Control-Allow-Origin: *')
				  -> set_header ('Access-Control-Allow-Methods: *');

			$this -> api_key = $this -> input -> get_request_header ('X-API-KEY', TRUE);

			if (!is_null($this -> api_key)) {

				$this -> load -> model ('Api_model');

				$person = $this -> Api_model -> get ($this -> api_key);

				if (!is_null($person) && $person -> request_limit > 0) {

					$this -> user = $person;

					$this -> Api_model -> update ($this -> user -> key_id, array (
						'request_limit' => $this -> user -> request_limit - 1
					));

				} else {

					$this -> output
						  -> set_status_header (401)
						  -> set_output (json_encode(array (
							  'status' => 'error',
							  'message' => 'Authorization Error'
						  )))
						  -> _display ();

					exit ;

				}

			} else {

				$this -> output
					  -> set_status_header (401)
				      -> set_output (json_encode(array (
						  'status' => 'error',
						  'message' => 'Authorization Error'
					  )))
					  -> _display ();

				exit ;

			}

		}

		public function user ($id = NULL)
		{

			if (!is_null($id)) {

				$id = html_escape($this -> security -> xss_clean($id));

				if ($this -> input -> method(TRUE) == 'GET') {

					if ($this -> user -> level >= 1) {

						$this -> load -> model ('User_model', 'users');

						$this -> load -> model ('Orders_model', 'orders');

						$user = $this -> users -> get ($id);

						$orders = $this -> orders -> get_all ($id);

						if (!is_null($user)) {

							$order_data = array ();
							$user_data = array ();

							foreach ($orders as $order) {

								$order_data[] = array (
									'order_id' => $order -> order_id,
									'product' => $order -> product_name,
									'qty' => $order -> quantity,
									'subtotal' => $order -> total_price,
									'user_ip' => $order -> user_ip,
									'order_no' => $order -> order_no,
									'completed' => $order -> is_completed,
									'product_price' => $order -> product_price,
									'purchase_date' => $order -> purchase_date,
									'product_url' => $this -> site_url . $order -> product_url,
									'product_thumbnail' => $this -> site_url . $order -> product_image
								);

							}

							$user_data = array (
								'name' => $user -> user_name,
								'email' => $user -> user_email,
								'register_date' => $user -> user_register_date,
								'order_details' => $order_data
							);

							$this -> output
								  -> set_status_header (200)
								  -> set_output (json_encode($user_data))
								  -> _display ();

							exit ;

						} else {

							$this -> output
								-> set_status_header (400)
								-> set_output (json_encode(array(
									'status' => 'error',
									'message' => 'User Not Found!'
								)))
								-> _display ();

							exit ;

						}

					} else {

						$this -> output
							-> set_status_header (401)
							-> set_output (json_encode(array (
								'status' => 'error',
								'message' => 'Authorization Error'
							)))
							-> _display ();

						exit ;

					}

				} else {

					$this -> output
						  -> set_status_header (405)
						  -> set_output (json_encode(array (
							  'status' => 'error',
							  'message' => 'Method Not Allowed'
						  )))
						 -> _display ();

					exit ;

				}

			} else {

				$this -> output
					  -> set_status_header (400)
					  -> set_output (json_encode(array(
						  'status' => 'error',
						  'message' => 'Bad Request'
					  )))
					  -> _display ();

				exit ;

			}

		}

	}

?>
