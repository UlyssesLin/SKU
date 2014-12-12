<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$this->load->model('productsmodel');
		$product_array = $this->productsmodel->get_All();

		$send['items']=$product_array;

		$this->load->view('view1', $send);
	}

	public function loadCategory($id)
	{
		$this->load->model('productsmodel');
		$item_array = $this->productsmodel->get_Category($id);
		$send['items']=$item_array;
		
		$this->load->view('view1', $send);
	}

	public function loadDetail($id)
    {
        $this->load->model('productsmodel');
        $item_array = $this->productsmodel->get_One($id);
        $similars = $this->productsmodel->get_Similar($item_array['category_id'],$id);
        $send['item']=$item_array;
        $send['similars']=$similars;
        $this->load->view('view2', $send);
    }

	public function findItems(){

        $entry = $this->input->post('searchPhrase');
        $this->load->model('productsmodel');
        $found_items=$this->productsmodel->findItems($entry);
        echo json_encode($found_items);
	}

	public function AddtoCart($id)
	{
		$this->load->model('productsmodel');
		$item_array = $this->productsmodel->buy_Item($id);
		$temp = $this->session->userdata('cart');
		$temp[] = $item_array[0];
		$temp[count($temp)-1]['quantity']=$this->input->post('quantity');
		$this->session->set_userdata('cart', $temp);
		$this->loadDetail($id);
	}

	public function loadCart()
	{
		$this->load->view('view3');

	}
	public function deleteItem($n){
		$temp = $this->session->userdata('cart');
		unset($temp[$n]);
		$temp = array_values($temp);
		$this->session->set_userdata('cart', $temp);
		redirect('checkout');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */