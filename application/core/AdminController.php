<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package         Flow
 * @subpackage      Admin
 * @category        AdminController
 * @author          Yohhan Dalvi
 */
class AdminController extends BaseController {

	public $user;

	public function __construct()
	{
		// main constructor
		parent::__construct();

		if($this->session->userdata('user_id'))
			$this->user['id'] = $this->session->userdata('user_id');

		if($this->session->userdata('user_email'))
			$this->user['email'] = $this->session->userdata('user_email');

		if($this->session->userdata('user_organization'))
			$this->user['organization_id'] = $this->session->userdata('user_organization');
	}

	public function authenticate($redirect_to = null, $check_permission = true)
	{
		if($this->user['id']) {
			return TRUE;
		} else {
			if(is_null($redirect_to)) {
				$url = site_url();
			} else {
				$url = site_url('admin?redirect_to='.urlencode($redirect_to));
			}
			redirect($url);
		}
	}

}