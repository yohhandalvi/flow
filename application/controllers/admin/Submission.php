<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Submission extends AdminController {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Flow_model');
    }

    public function index()
    {
        $this->authenticate(current_url());

        $filters = $this->input->get();
        $filters['organization_id'] = $this->user['organization_id'];
        $data['submissions'] = $this->Flow_model->get_all_submissions(null, null, $filters);

        $data['title'] = 'Submissions';
        $data['tab'] = 'submissions';
        $data['_view'] = 'admin/submission/index';
        $this->load->view('admin/layout/basetemplate', $data);
    }

    public function view($id = 0)
    {
        $this->authenticate(current_url());

        $data['user_submission'] = $this->Flow_model->get_submission_by_id($id);

        if(empty($data['user_submission']))
        {
            $this->session->set_flashdata('error_message', 'Submission not found');
            redirect('admin/submissions');
            exit;
        }

        $data['flow'] = $this->Flow_model->get_flow_by_id($data['user_submission']['flow_id']);

        if(!$data['flow']['organization_id'] == $this->user['organization_id'])
        {
            $this->session->set_flashdata('error_message', 'Submission not found');
            redirect('admin/submissions');
            exit;
        }

        $data['title'] = 'Submission - View';
        $data['tab'] = 'submissions';
        $data['_view'] = 'admin/submission/view';
        $this->load->view('admin/layout/basetemplate', $data);
    }
}
