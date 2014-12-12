<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//Sara Wong 12/9/14
class Orders extends CI_Controller {

    //Send the orders to the view
    public function index() {
        $this->getAllOrders();
        $this->orderView();
    }

    //main orders view page
    public function orderView(){
        $this->load->view('order_view');
    }

    //retrieve order info with purchases and send to new view
    public function orderInfo($id){
        $this->load->model('order');
        $send['billing']=$this->order->getBilling($id);
        $send['shipping']=$this->order->getShipping($id); 
        $send['purchases']=$this->order->getPurchases($id);
        $this->load->view('show_view', $send);         
    }

    //Depending on the orderPage clicked, send in that id
    public function orderPage($id){
        $id = $id-1;
        $orders = $this->session->userdata('orders');
        $orders[$id]['pages'] = $this->session->userdata('orderPages');
        echo json_encode($orders[$id]);
    }

    //if radio buttons of status changed, then update the DB
    public function status_change($id, $status){
        $values = array($status, $id);
        $this->load->model('order');
        echo json_encode($this->order->statusChange($values));
    }

    //take all products and paginate
    public function getAllOrders(){
        $this->load->model('order');
        $all_products=$this->order->getAllOrders();
        $paginated = $this->paginate($all_products);
        return TRUE;
    }

    //paginate any array passed into function
	function paginate($results){
        $paginated = array();
        $pages = intval(ceil(count($results)/5));
		$pointer = 0;
		for ($page=1; $page <= $pages; $page++) { 
			$lilpage = array();
			if($page==$pages){
				for($i=$pointer; $i<count($results); $i++){
					$lilpage[] = $results[$i];
				}	
			}
			else{
				for($i=$pointer; $i<$pointer+5; $i++){ 
					$lilpage[] = $results[$i];
			}
        	}
        	$pointer += 5;
			$paginated[] = $lilpage;
        }
        $this->session->set_userdata('orderPages', $pages);
        $this->session->set_userdata('orders', $paginated);
		return $paginated;  
	}

    //when anything is entered in search bar, query the entry from DB and return the results
    function search($entry)
    {
        $this->load->model('order');
        if($entry=='all'){
            $all_products=$this->order->getAllOrders();           
        }
        else {
            $all_products = $this->order->search($entry);
        }
            $paginated = $this->paginate($all_products);
            $this->orderPage(1);
    }
    
}
/* End of file logins.php */
/* Location: ./application/controllers/logins.php */