<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends CI_Model {

	function getAllOrders(){
	    return $this->db->query("SELECT orders.id, first_name, last_name, address_1, city, state, zip, purchase_date, CASE ship_status WHEN 0 THEN 'Cancelled' WHEN 1 THEN 'Order in Progress' WHEN 2 THEN 'Shipped' ELSE ship_status END as ship_status, quantity, price, SUM(quantity*price) AS TOTAL FROM ecommerce.orders JOIN addresses ON billing_id = addresses.id JOIN purchases ON orders.id = order_id JOIN products ON product_id = products.id GROUP BY orders.id;")->result_array();  
	}
	function getBilling($id){
	    return $this->db->query("SELECT * FROM orders JOIN addresses ON billing_id = addresses.id ORDER BY orders.id ASC;")->row_array();  
	}
	function getShipping($id){
	    return $this->db->query("SELECT * FROM orders JOIN addresses ON shipping_id = addresses.id ORDER BY orders.id ASC;")->row_array();  
	}
	function getPurchases($id){
		$value = array($id);
		return $this->db->query("SELECT purchases.id AS PurchaseID, orders.id AS OrdersID, products.id AS ProductID, item, price, quantity, shipping_cost, CASE ship_status WHEN 0 THEN 'Cancelled' WHEN 1 THEN 'Order in Progress' WHEN 2 THEN 'Shipped' ELSE ship_status END as SHIPPING FROM ecommerce.purchases JOIN orders ON order_id = orders.id JOIN products ON product_id = products.id WHERE orders.id = ?", $value)->result_array();
	}
	function statusChange($values){
		return $this->db->query("UPDATE orders SET ship_status=? WHERE id=?", $values);
	}
  	function search($entry){
        $query = "SELECT orders.id, first_name, last_name, address_1, city, state, zip, purchase_date, CASE ship_status WHEN 0 THEN 'Cancelled' WHEN 1 THEN 'Order in Progress' WHEN 2 THEN 'Shipped' ELSE ship_status END as ship_status, quantity, price, SUM(quantity*price) AS TOTAL FROM ecommerce.orders JOIN addresses ON billing_id = addresses.id JOIN purchases ON orders.id = order_id JOIN products ON product_id = products.id WHERE orders.id IS NOT NULL AND (first_name LIKE '{$entry}%' OR last_name LIKE '{$entry}%' OR purchase_date LIKE '%{$entry}%' OR orders.id LIKE '{$entry}' OR ship_status LIKE '{$entry}%') GROUP BY orders.id";
 		return $this->db->query($query)->result_array();
 	}
}
