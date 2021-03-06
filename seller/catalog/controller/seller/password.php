<?php
class ControllerSellerPassword extends Controller {
	private $error = array();
  	public function index() {	
    	if (!$this->seller->isLogged()) {
      		$this->session->data['redirect'] = $this->url->link('seller/password', '', 'SSL');
      		$this->response->redirect($this->url->link('seller/login', '', 'SSL'));
    	}
		$this->language->load('seller/password');
    	$this->document->setTitle($this->language->get('heading_title'));
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->load->model('seller/seller');
			$this->model_seller_seller->editPassword($this->seller->getEmail(), $this->request->post['password']);
      		$this->session->data['success'] = $this->language->get('text_success');
	  		$this->response->redirect($this->url->link('seller/account', '', 'SSL'));
    	}
      	$data['breadcrumbs'] = array();
      	$data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),       	
        	'separator' => false
      	); 
      	$data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('seller/account', '', 'SSL')
      	);
      	$data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('seller/password', '', 'SSL')
      	);
    	$data['heading_title'] = $this->language->get('heading_title');
    	$data['text_password'] = $this->language->get('text_password');
    	$data['entry_password'] = $this->language->get('entry_password');
    	$data['entry_confirm'] = $this->language->get('entry_confirm');
    	$data['button_continue'] = $this->language->get('button_continue');
    	$data['button_back'] = $this->language->get('button_back');
		if (isset($this->error['password'])) { 
			$data['error_password'] = $this->error['password'];
		} else {
			$data['error_password'] = '';
		}
		if (isset($this->error['confirm'])) { 
			$data['error_confirm'] = $this->error['confirm'];
		} else {
			$data['error_confirm'] = '';
		}
    	$data['action'] = $this->url->link('seller/password', '', 'SSL');
		if (isset($this->request->post['password'])) {
    		$data['password'] = $this->request->post['password'];
		} else {
			$data['password'] = '';
		}
		if (isset($this->request->post['confirm'])) {
    		$data['confirm'] = $this->request->post['confirm'];
		} else {
			$data['confirm'] = '';
		}
    	$data['back'] = $this->url->link('seller/account', '', 'SSL');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = 
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/seller/password.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/seller/password.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/seller/password.tpl', $data));
		}		
  	}
  	private function validate() {
    	if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
      		$this->error['password'] = $this->language->get('error_password');
    	}
    	if ($this->request->post['confirm'] != $this->request->post['password']) {
      		$this->error['confirm'] = $this->language->get('error_confirm');
    	}  
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}
}
?>
