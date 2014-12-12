<?php 
	
	class ProductsModel extends CI_Model {

		public function get_All() {
			return $this->db->query("SELECT * FROM products JOIN srcs ON src_id=srcs.id ")->result_array();
		}
		
		
		public function get_Category($id) {
			$value= array($id);
			return $this->db->query("SELECT * , products.id FROM products JOIN srcs ON src_id=srcs.id JOIN categories ON products.category_id=categories.id WHERE categories.id = ?", $value)->result_array();
		}

		public function get_One($id) {
			$value= array($id);
			return $this->db->query("SELECT * FROM products JOIN srcs ON src_id=srcs.id WHERE products.id = ?", $value)->row_array();
		}

		public function buy_Item($id) {
			$value= array($id);
			return $this->db->query("SELECT * FROM products WHERE products.id = ?" , $value)->result_array();
		}

		public function get_Cart($id) {
			$value= array($id);
			return $this->db->query("SELECT * FROM products WHERE products.id = ?" , $value)->row_array();
		}

		public function findItems($str){
		    $query = "SELECT * FROM products JOIN srcs ON srcs.id=products.src_id WHERE products.item like '%{$str}%'";
		    return $this->db->query($query)->result_array();
		}

		public function get_Similar($category_id,$id) {
		   return $this->db->query("SELECT * , products.id FROM products JOIN srcs ON src_id=srcs.id JOIN categories ON products.category_id=categories.id WHERE categories.id = ? AND products.id != ? LIMIT 5", array($category_id,$id))->result_array();
		}
	}
?>