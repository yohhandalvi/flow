<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Flow extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Flow_model');
    }

    private function _validate_submission()
    {
        $id = $this->session->userdata('submission');

        if(!empty($id))
        {
            $user_submission = $this->Flow_model->get_submission_by_id($id);

            if(!empty($user_submission))
            {
                return $user_submission;
            }
        }

        redirect('flow/error');
        exit;
    }

    private function _validate_flow($hash)
    {
        if(!empty($hash))
        {
            $flow = $this->Flow_model->get_flow_by_params(['hash' => $hash, 'inactive' => 0]);

            if(!empty($flow) && !empty($flow['steps']))
            {
                if($flow['flow_date'] == null || $flow['flow_date'] == "0000-00-00" || $flow['flow_date'] == date('Y-m-d'))
                {
                    return $flow;
                }
            }
        }

        redirect('flow/error');
        exit;
    }

    public function index($hash = null)
    {
        $data['flow'] = $this->_validate_flow($hash);
        $data['tab'] = 'flow';
        $data['title'] = 'Flow';
        $data['_view'] = 'front/flow/index';
        $this->load->view('front/layout/basetemplate', $data);
    }

    public function start($hash = null)
    {
        $flow = $this->_validate_flow($hash);

        $data = array(
            'flow_id' => $flow['id'],
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'start_time' => date('H:i:s'),
            'hash' => strtolower(random_string('alnum', 16))
        );

        $result = $this->Flow_model->start_user_flow($data);
        $this->session->set_userdata('submission', $result);
        redirect('flow/'.$hash.'/'.$flow['steps'][0]['id']);
        exit;
    }

    public function step($hash = null, $current_step = 0)
    {
        $data['flow'] = $this->_validate_flow($hash);
        $data['user_submission'] = $this->_validate_submission();
        $data['step'] = [];
        $next_step = 0;

        foreach ($data['flow']['steps'] as $key => $step)
        {
            if($step['id'] == $current_step)
            {
                $data['step'] = $step;
                $next_step = isset($data['flow']['steps'][$key + 1]) ? $data['flow']['steps'][$key + 1]['id'] : 0;
                break;
            }
        }

        if(empty($data['step']))
        {
            redirect('flow/error');
            exit;
        }

        if(empty($data['step']['questions']))
        {
            if($next_step)
            {
                redirect('flow/'.$hash.'/'.$next_step);
                exit;
            }
            else
            {
                redirect('flow/end/'.$hash);
                exit;
            }
        }

        if($_POST)
        {
            if(!empty($_POST))
            {
                foreach ($_POST as $question_id => $answer)
                {
                    $submission_data = array(
                        'submission_id' => $data['user_submission']['id'],
                        'flow_question_id' => $question_id,
                        'answer' => $answer
                    );

                    $this->Flow_model->publish_user_flow_answer($submission_data);
                }

                if($next_step)
                {
                    redirect('flow/'.$hash.'/'.$next_step);
                    exit;
                }
                else
                {
                    redirect('flow/end/'.$hash);
                    exit;
                }
            }
        }

        $data['tab'] = 'flow';
        $data['title'] = 'Flow / '.$data['flow']['name'].' / '.$data['step']['step'];
        $data['_view'] = 'front/flow/step';
        $this->load->view('front/layout/basetemplate', $data);
    }

    public function end($hash = null)
    {
        $user_submission = $this->_validate_submission();
        $flow = $this->_validate_flow($hash);

        $data = array(
            'end_time' => date('H:i:s'),
            'completed' => 1
        );

        $this->Flow_model->update_user_flow($user_submission['id'], $data);

        redirect('flow/result/'.$user_submission['hash']);
        exit;
    }

    public function result($hash = null)
    {
        $data['user_submission'] = $this->Flow_model->get_submission_by_params(['hash' => $hash, 'completed' => 1]);
        $data['flow'] = $this->Flow_model->get_flow_by_id($data['user_submission']['flow_id']);

        $data['tab'] = 'flow';
        $data['title'] = 'Flow / Result';
        $data['_view'] = 'front/flow/result';
        $this->load->view('front/layout/basetemplate', $data);
    }

    public function error()
    {
        $data['tab'] = 'flow';
        $data['title'] = 'Flow / Error';
        $data['_view'] = 'front/flow/error';
        $this->load->view('front/layout/basetemplate', $data);
    }

}