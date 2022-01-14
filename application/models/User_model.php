<?php

	class User_model extends CI_Model
	{

		private $table_name = 'users';

		public function __construct()
		{

			parent::__construct ();

		}

		public function get ($id)
		{

			return $this -> db
				-> get_where ($this -> table_name, array ('user_id' => $id))
				-> row ();

		}

	}

?>
