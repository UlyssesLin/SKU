<?php
//Ulysses Lin 12/10/14
class Product extends CI_Model{
	function getAllProducts(){
		return $this->db->query('SELECT products.id,products.item,SUM(purchases.quantity) AS quantity_sold,products.inventory,srcs.src1 FROM srcs LEFT JOIN products ON products.src_id=srcs.id LEFT JOIN purchases ON purchases.product_id=products.id GROUP BY products.id ORDER BY products.id ASC')->result_array();
	}
	function findProduct($page){
		return $this->db->query('SELECT products.id,products.item,products.description,products.category_id,srcs.src1,srcs.src2,srcs.src3,srcs.src4 FROM products LEFT JOIN srcs ON srcs.id=products.src_id WHERE products.id=?',$page)->row_array();
	}
	function updateImage($id,$to_replace,$value){
		if($to_replace==1){
			return $this->db->query("UPDATE srcs SET srcs.src1=? WHERE srcs.id=?",array($value,$id));
		}else if($to_replace==2){
			return $this->db->query("UPDATE srcs SET srcs.src2=? WHERE srcs.id=?",array($value,$id));
		}else if($to_replace==3){
			return $this->db->query("UPDATE srcs SET srcs.src3=? WHERE srcs.id=?",array($value,$id));
		}else{
			return $this->db->query("UPDATE srcs SET srcs.src4=? WHERE srcs.id=?",array($value,$id));
		}
	}
	function getCategories(){
		return $this->db->query('SELECT * FROM categories ORDER BY id ASC')->result_array();
	}
	function getSrcs($id){
		return $this->db->query('SELECT srcs.src1,srcs.src2,srcs.src3,srcs.src4 FROM srcs WHERE srcs.id=?',$id)->row_array();
	}
	function updateProduct($id,$item,$description,$category){
		return $this->db->query('UPDATE products SET products.item=?,products.description=?,products.category_id=? WHERE products.id=?',array($item,$description,$category,$id));
	}
	function newCategory($category){
		return $this->db->query('INSERT INTO categories (category) VALUES (?)',$category);
	}
	function updateCategory($category_id,$category){
		return $this->db->query('UPDATE categories SET categories.category=? WHERE categories.id=?',array($category,$category_id));
	}
	function deleteCategory($category_id){
		return $this->db->query('DELETE FROM categories WHERE categories.id=?',$category_id);
	}
	function newProduct($item,$description,$category_id){
		return $this->db->query('INSERT INTO products (item,description,category_id,src_id) VALUES (?,?,?,?)',array($item,$description,$category_id,50));
	}
}
?>