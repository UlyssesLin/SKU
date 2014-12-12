<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//Ulysses Lin 12/10/14
class Products_process extends CI_Controller {
	public function index(){
		$this->load->view('products_view',$this->session->userdata);
	}
	public function editView(){
		$this->load->view('edit_view',$this->session->userdata);
	}
	public function get_products(){
		$this->load->model('Product');
		$all_products_array=[];
		$all_products=$this->Product->getAllProducts();
		$pointer=0;
		for($i=0;$i<ceil(count($all_products)/10);$i++){
			$products_page_array=[];
			if($i+1==ceil(count($all_products)/10)){
				for($j=$pointer;$j<count($all_products);$j++){
					array_push($products_page_array,$all_products[$j]);
				}
			}else{
				for($j=$pointer;$j<$pointer+10;$j++){
					array_push($products_page_array,$all_products[$j]);
				}
				$pointer+=10;
			}
			array_push($all_products_array,$products_page_array);
		}
		$this->session->set_userdata('all_products',$all_products_array);
		$this->index();
	}
	public function get_page($page){
		if($this->session->userdata('all_products'))
		echo json_encode($this->session->userdata('all_products')[$page-1]);
	}
	public function prep_page($id){
		$this->load->model('Product');
		$this->session->set_userdata('product_info',$this->Product->findProduct($id));
		$this->session->set_userdata('categories',$this->Product->getCategories());
		// var_dump($this->session->userdata('categories'));
		$all_srcs=$this->Product->getSrcs($id);
		$src_count=0;
		$srcs_array=[];
		foreach($all_srcs as $src_num=>$src){
			if($src && $src!='NONE'){
				$src_count++;
				array_push($srcs_array,$src);
			}
		}
		$this->session->set_userdata('srcs_array',$srcs_array);
		$this->session->set_userdata('type','Update');
		$this->session->set_userdata('to_update_categories',array());
		$this->session->set_userdata('to_update_images',array());
		$this->editView();
	}
	public function update($id){
		$category='';
		$a=$this->session->userdata('to_update_categories');
		$category=$a['PRODUCT CATEGORY'];
		unset($a['PRODUCT CATEGORY']);
		$this->load->model('Product');
		//Updates categories that have been changed
		foreach($a as $cat_id=>$cat_text){
			if($cat_text=='TO DELETE'){
				$this->Product->deleteCategory($cat_id);
				unset($a[$cat_id]);
			}else{
				$this->Product->updateCategory($cat_id,$cat_text);
			}
		}
		//If no new category is inputted
		if(!empty($this->input->post('category_new'))){
			echo 'new cat entered';
			$this->load->library('form_validation');
			$this->form_validation->set_rules('category_new','new category','trim|unique');
			//New category inputted has errors | FORM VALIDATION FAILS!
			if($this->form_validation->run()===FALSE){
				$this->session->set_flashdata('errors',validation_errors());
				$this->editView();
			//New category inputted validates
			}else{
				$category=$this->input->post('category_new');
				$this->Product->newCategory($category);
			}
		}
		if($id=='NEW'){
			$this->Product->newProduct($this->input->post('item'),$this->input->post('description'),$category);
		}else{
			$this->Product->updateProduct($id,$this->input->post('item'),$this->input->post('description'),$category);
		}
		if(!empty($this->session->userdata('to_update_images'))){
			$img=$this->session->userdata('to_update_images');
			$order=$img['IMAGE ORDER'];
			unset($img['IMAGE ORDER']);
			foreach($img as $delete=>$src_number){
				$row=$this->Product->updateImage($id,$src_number,'NONE');
			}
			$all_srcs=$this->Product->getSrcs($id);
			//$i is the location in the $order string; $i+1 is the original src# (1,2,3,4), $all_srcs[$order[$i]-1] is the src value
			for($i=0;$i<strlen($order);$i++){
				//If the order is off for that src slot, make the change
				if($i+1!=$order[$i]){
					$row=$this->Product->updateImage($id,$i+1,$all_srcs['src'.$order[$i]]);
				}
			}
		}
		$data['success']=true;
		echo json_encode($data);
	}
	//Saves the src of the image to delete into session
	public function deleteImage($id,$src_number){
		$a=$this->session->userdata('to_update_images');
		$a['TO DELETE']=$src_number;
		$this->session->set_userdata('to_update_images',$a);
		echo json_encode($this->session->userdata('to_update_images'));
	}
	//Saves the new order of src ids into session
	public function organizeImages($order){
		$a=$this->session->userdata('to_update_images');
		$a['IMAGE ORDER']=$order;
		$this->session->set_userdata('to_update_images',$a);
	}
	public function delete($page){

	}
	//Saves actual category id into session
	public function setCategory($category_id){
		$a=$this->session->userdata('to_update_categories');
		$a['PRODUCT CATEGORY']=$category_id;
		$this->session->set_userdata('to_update_categories',$a);
		echo json_encode($this->session->userdata('to_update_categories'));
	}
	//Saves text updates to categories into session
	public function updateCategory($category_id,$updated_cat){
		$a=$this->session->userdata('to_update_categories');
		$a[$category_id]=$updated_cat;
		$this->session->set_userdata('to_update_categories',$a);
		echo json_encode($this->session->userdata('to_update_categories'));
	}
	//Saves information on categories to delete into session
	public function deleteCategory($category_id){
		$a=$this->session->userdata('to_update_categories');
		$a[$category_id]='TO DELETE';
		$this->session->set_userdata('to_update_categories',$a);
		echo json_encode($this->session->userdata('to_update_categories'));
	}
	public function add(){
		$this->session->set_userdata('type','Add');
		$this->session->set_userdata('product_info',array('id'=>'NEW','item'=>'','description'=>''));
		$this->load->model('Product');
		$this->session->set_userdata('categories',$this->Product->getCategories());
		$this->editView();
	}
}
?>