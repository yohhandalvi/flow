<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Email_model');
    }

    public function home()
    {
        $data['tab'] = 'home';
        $data['title'] = 'Home';
        $data['_view'] = 'front/page/home';
        $this->load->view('front/layout/basetemplate', $data);
    }
}