<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package         Flow
 * @subpackage      Site
 * @category        SiteController
 * @author          Yohhan Dalvi
 */
class SiteController extends BaseController {

	public $customer;

	public function __construct()
	{
		// main constructor
		parent::__construct();

		if($this->session->userdata('customer_id'))
			$this->customer['id'] = $this->session->userdata('customer_id');

		if($this->session->userdata('customer_email'))
			$this->customer['email'] = $this->session->userdata('customer_email');

		$this->set_vars();
	}

	public function set_vars()
	{
		$vars = [];
		$this->load->vars($vars);
	}

	public function authenticate($redirect_to = null, $check_permission = true)
	{
		if($this->customer['id']) {
			return TRUE;
		} else {
			if(is_null($redirect_to)) {
				$url = site_url();
			} else {
				$url = site_url('account?redirect_to='.urlencode($redirect_to));
			}
			redirect($url);
		}
	}

}