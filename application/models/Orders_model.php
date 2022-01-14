<?php

	class Orders_model extends CI_Model
	{

		private $table_name = 'orders';

		public function __construct()
		{

			parent::__construct ();

		}

		public function get_all ($user_id)
		{

			return $this -> db
				-> join ('products', 'products.product_id = orders.product_id', 'left')
				-> get_where ($this -> table_name, array ('user_id' => $user_id))
				-> result ();

		}

	}

?>
