<?php

	class Api_model extends CI_Model
	{

		private $table_name = 'api_keys';

		public function __construct()
		{

			parent::__construct ();

		}

		public function get ($key)
		{

			return $this -> db
					     -> get_where ($this -> table_name, array ('key_value' => $key))
						 -> row ();

		}

		public function update ($id, $data)
		{

			return $this -> db
						 -> where ('key_id', $id)
						 -> update ($this -> table_name, $data);

		}

	}

?>
