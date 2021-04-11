<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Flow extends AdminController {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Flow_model');
    }

    public function index()
    {
        $this->authenticate(current_url());

        $filters = [];
        $filters['organization_id'] = $this->user['organization_id'];
        $data['flows'] = $this->Flow_model->get_all_flows(null, null, $filters);

        $data['title'] = 'Flows';
        $data['tab'] = 'flow';
        $data['_view'] = 'admin/flow/index';
        $this->load->view('admin/layout/basetemplate', $data);
    }

    public function add()
    {
        $this->authenticate(current_url());

        $this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
        $this->form_validation->set_rules('summary', 'Summary', 'required');
        $this->form_validation->set_rules('flow_type_id', 'Type', 'required|xss_clean');
        $this->form_validation->set_rules('flow_date', 'Date', 'xss_clean');
        $this->form_validation->set_rules('start_time', 'Start time', 'xss_clean');
        $this->form_validation->set_rules('end_time', 'End time', 'xss_clean');

        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run())
        {
            $flow_data = array(
                'name' => $_POST['name'],
                'flow_type_id' => $_POST['flow_type_id'],
                'summary' => $_POST['summary'],
                'flow_date' => $_POST['flow_date'],
                'start_time' => $_POST['start_time'],
                'end_time' => $_POST['end_time'],
                'organization_id' => $this->user['organization_id'],
                'hash' => strtolower(random_string('alnum', 16))
            );

            $response = $this->Flow_model->add_flow($flow_data);
        
            if($response)
            {
                $this->session->set_flashdata('success_message', 'Flow created successfully');
                redirect('admin/flows');
                exit;
            }
            else
            {
                $this->session->set_flashdata('error_message', 'Error occured while creating the flow');
                redirect('admin/flow/add');
                exit;
            }
        }
        else
        {
            $data['flow_types'] = $this->Flow_model->get_all_flow_types();

            $data['title'] = 'Create Flow';
            $data['tab'] = 'flow';
            $data['_view'] = 'admin/flow/add';
            $this->load->view('admin/layout/basetemplate', $data);
        }
    }

    public function edit($id = 0)
    {
        $this->authenticate(current_url());

        $data['flow'] = $this->Flow_model->get_flow_by_id($id);

        if(empty($data['flow']) || $data['flow']['organization_id'] !== $this->user['organization_id'])
        {
            $this->session->set_flashdata('error_message', 'Flow not found');
            redirect('admin/flows');
            exit;
        }

        $this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
        $this->form_validation->set_rules('summary', 'Summary', 'required');
        $this->form_validation->set_rules('flow_type_id', 'Type', 'required|xss_clean');
        $this->form_validation->set_rules('flow_date', 'Date', 'xss_clean');
        $this->form_validation->set_rules('start_time', 'Start time', 'xss_clean');
        $this->form_validation->set_rules('end_time', 'End time', 'xss_clean');

        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run())
        {
            $flow_data = array(
                'name' => $_POST['name'],
                'flow_type_id' => $_POST['flow_type_id'],
                'summary' => $_POST['summary'],
                'flow_date' => $_POST['flow_date'],
                'start_time' => $_POST['start_time'],
                'end_time' => $_POST['end_time'],
            );

            $response = $this->Flow_model->update_flow($id, $flow_data);
        
            if($response)
            {
                $this->session->set_flashdata('success_message', 'Flow updated successfully');
                redirect('admin/flows');
                exit;
            }
            else
            {
                $this->session->set_flashdata('error_message', 'Error occured while updating the flow');
                redirect('admin/flow/edit/'.$id);
                exit;
            }
        }
        else
        {
            $data['flow_types'] = $this->Flow_model->get_all_flow_types();

            $data['title'] = 'Update Flow';
            $data['tab'] = 'flow';
            $data['_view'] = 'admin/flow/edit';
            $this->load->view('admin/layout/basetemplate', $data);
        }
    }

    public function delete($id = 0)
    {
        $this->authenticate(current_url());

        $data['flow'] = $this->Flow_model->get_flow_by_id($id);

        if(empty($data['flow']) || $data['flow']['organization_id'] !== $this->user['organization_id'])
        {
            $this->session->set_flashdata('error_message', 'Flow not found');
            redirect('admin/flows');
            exit;
        }

        $response = $this->Flow_model->update_flow($id, array('deleted' => 1));

        if($response)
        {
            $this->session->set_flashdata('success_message', 'Flow deleted successfully');
            redirect('admin/flows');
            exit;
        }
        else
        {
            $this->session->set_flashdata('error_message', 'Some error occured while deleting the flow');
            redirect('admin/flows');
            exit;
        }
    }

    public function steps($id = 0)
    {
        $this->authenticate(current_url());

        $data['flow'] = $this->Flow_model->get_flow_by_id($id);

        if(empty($data['flow']) || $data['flow']['organization_id'] !== $this->user['organization_id'])
        {
            $this->session->set_flashdata('error_message', 'Flow not found');
            redirect('admin/flows');
            exit;
        }

        $filters = [];
        $filters['organization_id'] = $this->user['organization_id'];
        $filters['flow_id'] = $id;
        $data['steps'] = $this->Flow_model->get_all_flow_steps(null, null, $filters);

        $data['title'] = 'Flow Steps';
        $data['tab'] = 'flow';
        $data['_view'] = 'admin/flow/steps';
        $this->load->view('admin/layout/basetemplate', $data);
    }

    public function add_step($id = 0)
    {
        $this->authenticate(current_url());

        $data['flow'] = $this->Flow_model->get_flow_by_id($id);

        if(empty($data['flow']) || $data['flow']['organization_id'] !== $this->user['organization_id'])
        {
            $this->session->set_flashdata('error_message', 'Flow not found');
            redirect('admin/flows');
            exit;
        }

        $this->form_validation->set_rules('step', 'Name', 'required|xss_clean');

        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run())
        {
            $flow_step_data = array(
                'flow_id' => $id,
                'step' => $_POST['step'],
            );

            $response = $this->Flow_model->add_flow_step($flow_step_data);
        
            if($response)
            {
                $this->session->set_flashdata('success_message', 'Flow step added successfully');
                redirect('admin/flow/steps/'.$id);
                exit;
            }
            else
            {
                $this->session->set_flashdata('error_message', 'Error occured while adding the flow step');
                redirect('admin/flow/step/add/'.$id);
                exit;
            }
        }
        else
        {
            $data['title'] = 'Add Flow Step';
            $data['tab'] = 'flow';
            $data['_view'] = 'admin/flow/add_step';
            $this->load->view('admin/layout/basetemplate', $data);
        }
    }

    public function edit_step($id = 0)
    {
        $this->authenticate(current_url());

        $data['step'] = $this->Flow_model->get_flow_step_by_id($id);

        if(empty($data['step']))
        {
            $this->session->set_flashdata('error_message', 'Step not found');
            redirect('admin/flows');
            exit;
        }

        $data['flow'] = $this->Flow_model->get_flow_by_id($data['step']['flow_id']);

        if(empty($data['flow']) || $data['flow']['organization_id'] !== $this->user['organization_id'])
        {
            $this->session->set_flashdata('error_message', 'Flow not found');
            redirect('admin/flows');
            exit;
        }

        $this->form_validation->set_rules('step', 'Name', 'required|xss_clean');

        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run())
        {
            $flow_step_data = array(
                'step' => $_POST['step'],
            );

            $response = $this->Flow_model->update_flow_step($id, $flow_step_data);
        
            if($response)
            {
                $this->session->set_flashdata('success_message', 'Flow step updated successfully');
                redirect('admin/flow/steps/'.$data['step']['flow_id']);
                exit;
            }
            else
            {
                $this->session->set_flashdata('error_message', 'Error occured while updating the flow step');
                redirect('admin/flow/step/edit/'.$id);
                exit;
            }
        }
        else
        {
            $data['title'] = 'Update Flow Step';
            $data['tab'] = 'flow';
            $data['_view'] = 'admin/flow/edit_step';
            $this->load->view('admin/layout/basetemplate', $data);
        }
    }

    public function delete_step($id = 0)
    {
        $this->authenticate(current_url());

        $data['step'] = $this->Flow_model->get_flow_step_by_id($id);

        if(empty($data['step']))
        {
            $this->session->set_flashdata('error_message', 'Step not found');
            redirect('admin/flows');
            exit;
        }

        $data['flow'] = $this->Flow_model->get_flow_by_id($data['step']['flow_id']);

        if(empty($data['flow']) || $data['flow']['organization_id'] !== $this->user['organization_id'])
        {
            $this->session->set_flashdata('error_message', 'Flow not found');
            redirect('admin/flows');
            exit;
        }

        $response = $this->Flow_model->update_flow_step($id, array('deleted' => 1));

        if($response)
        {
            $this->session->set_flashdata('success_message', 'Flow step deleted successfully');
            redirect('admin/flow/steps/'.$data['ste']['flow_id']);
            exit;
        }
        else
        {
            $this->session->set_flashdata('error_message', 'Error occured while deleting the flow step');
            redirect('admin/flow/steps/'.$data['ste']['flow_id']);
            exit;
        }
    }

    public function publish($id = 0)
    {
        $this->authenticate(current_url());

        $data['flow'] = $this->Flow_model->get_flow_by_id($id);

        if(empty($data['flow']) || $data['flow']['organization_id'] !== $this->user['organization_id'])
        {
            $this->session->set_flashdata('error_message', 'Flow not found');
            redirect('admin/flows');
            exit;
        }

        $this->form_validation->set_rules('input', '', 'required');

        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run())
        {
            $types = [];

            if(!empty($data['flow']['steps']))
            {
                foreach ($data['flow']['steps'] as $step)
                {
                    $type = $types[] = $step['id'];

                    if(!empty($data['flow']['steps']))
                    {
                        foreach ($step['questions'] as $question)
                        {
                            if(!empty($_POST[$type]['i_'.$question['id']]) && !empty($_POST[$type]['i_'.$question['id']]['type']))
                            {
                                $question_data = array(
                                    'type' => $_POST[$type]['i_'.$question['id']]['type'],
                                    'has_options' => isset($_POST[$type]['i_'.$question['id']]['has_options']) ? 1 : 0
                                );

                                if($_POST[$type]['i_'.$question['id']]['type'] == 'image')
                                {
                                    $text = $this->upload('questions', $type, 'i_'.$question['id'].'-question');

                                    if($text)
                                    {
                                        $question_data['question'] = $text;
                                    }
                                }
                                else
                                {
                                    $question_data['question'] = $_POST[$type]['i_'.$question['id']]['question'];
                                }

                                $this->Flow_model->update_question($question['id'], $question_data);

                                if(!empty($question['answers']) && isset($_POST[$type]['i_'.$question['id']]['has_options']))
                                {
                                    foreach ($question['answers'] as $answer)
                                    {
                                        if(!empty($_POST[$type]['i_'.$question['id']]['answers']['i_'.$answer['id']]) && !empty($_POST[$type]['i_'.$question['id']]['answers']['i_'.$answer['id']]['type']))
                                        {
                                            $right_answer = (isset($_POST[$type]['i_'.$question['id']]['right_answer']) && $_POST[$type]['i_'.$question['id']]['right_answer'] == 'i_'.$answer['id']) ? 1 : 0;

                                            $answer_data = array(
                                                'type' => $_POST[$type]['i_'.$question['id']]['answers']['i_'.$answer['id']]['type'],
                                                'right_answer' => $right_answer
                                            );

                                            if($_POST[$type]['i_'.$question['id']]['answers']['i_'.$answer['id']]['type'] == 'image')
                                            {
                                                $text = $this->upload('answers', $type, 'i_'.$question['id'].'-answers-'.'i_'.$answer['id'].'-answer');

                                                if($text)
                                                {
                                                    $answer_data['answer'] = $text;
                                                }
                                            }
                                            else
                                            {
                                                $answer_data['answer'] = $_POST[$type]['i_'.$question['id']]['answers']['i_'.$answer['id']]['answer'];
                                            }

                                            $this->Flow_model->update_answer($answer['id'], $answer_data);
                                        }
                                        else
                                        {
                                            $this->Flow_model->delete_answer($answer['id']);
                                        }
                                    }
                                }

                                if(!empty($_POST[$type]['i_'.$question['id']]['answers']) && isset($_POST[$type]['i_'.$question['id']]['has_options']))
                                {
                                    foreach ($_POST[$type]['i_'.$question['id']]['answers'] as $akey => $answer)
                                    {
                                        if(is_numeric($akey))
                                        {
                                            if(!empty($_POST[$type]['i_'.$question['id']]['answers'][$akey]) && !empty($_POST[$type]['i_'.$question['id']]['answers'][$akey]['type']))
                                            {
                                                $right_answer = (isset($_POST[$type]['i_'.$question['id']]['right_answer']) && $_POST[$type]['i_'.$question['id']]['right_answer'] == $akey) ? 1 : 0;

                                                $answer_data = array(
                                                    'flow_question_id' => $question['id'],
                                                    'type' => $_POST[$type]['i_'.$question['id']]['answers'][$akey]['type'],
                                                    'right_answer' => $right_answer
                                                );

                                                if($_POST[$type]['i_'.$question['id']]['answers'][$akey]['type'] == 'image')
                                                {
                                                    $text = $this->upload('answers', $type, 'i_'.$question['id'].'-answers-'.$akey.'-answer');

                                                    if($text)
                                                    {
                                                        $answer_data['answer'] = $text;
                                                    }
                                                }
                                                else
                                                {
                                                    $answer_data['answer'] = $_POST[$type]['i_'.$question['id']]['answers'][$akey]['answer'];
                                                }

                                                $this->Flow_model->add_answer($answer_data);
                                            }
                                        }
                                    }
                                }
                            }
                            else
                            {
                                $this->Activity_model->delete_question($question['id']);
                            }
                        }
                    }
                }
            }

            if(!empty($types))
            {
                foreach ($types as $key => $type)
                {
                    if(!empty($_POST[$type]) && isset($_POST[$type]))
                    {
                        foreach ($_POST[$type] as $key => $question)
                        {   
                            if(is_numeric($key))
                            {
                                if(!empty($question) && !empty($question['type']))
                                {
                                    $question_data = array(
                                        'flow_step_id' => $type,
                                        'type' => $question['type'],
                                        'has_options' => isset($question['has_options']) ? 1 : 0,
                                    );

                                    if($question['type'] == 'image')
                                    {
                                        $text = $this->upload('questions', $type, $key.'-question');

                                        if($text)
                                        {
                                            $question_data['question'] = $text;
                                        }
                                    }
                                    else
                                    {
                                        $question_data['question'] = $question['question'];
                                    }

                                    $question_id = $this->Flow_model->add_question($question_data);

                                    if(!empty($question['answers']) && isset($question['has_options']))
                                    {
                                        foreach ($question['answers'] as $akey => $answer)
                                        {
                                            if(!empty($answer) && !empty($answer['type']))
                                            {
                                                $right_answer = (isset($answer['right_answer']) && $answer['right_answer'] == $akey) ? 1 : 0;

                                                $answer_data = array(
                                                    'flow_question_id' => $question_id,
                                                    'type' => $answer['type'],
                                                    'right_answer' => $right_answer
                                                );

                                                if($answer['type'] == 'image')
                                                {
                                                    $text = $this->upload('answers', $type, $key.'-answers-'.$akey.'-answer');

                                                    if($text)
                                                    {
                                                        $answer_data['answer'] = $text;
                                                    }
                                                }
                                                else
                                                {
                                                    $answer_data['answer'] = $answer['answer'];
                                                }

                                                $this->Flow_model->add_answer($answer_data);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $this->session->set_flashdata('success_message', 'Flow steps published successfully');
            redirect('admin/flow/steps/'.$id);
            exit;
        }
        else
        {
            $data['title'] = 'Publish Flow';
            $data['tab'] = 'flow';
            $data['_view'] = 'admin/flow/publish';
            $this->load->view('admin/layout/basetemplate', $data);
        }
    }

    public function submissions()
    {
        $this->authenticate(current_url());

        $filters = $this->input->get();

        $offset = ($this->input->get('page')) ? $this->input->get('page') : 0;
        $data['submissions'] = $this->Activity_model->get_all_activity_submissions(ROWS_PER_LISTING, $offset, $filters);
        $data['count'] = $this->Activity_model->count_all_activity_submissions($filters);
        $data['pagination'] = pagination(site_url('admin/activity/submissions'), $data['count'], ROWS_PER_LISTING);
        $data['title'] = 'Activity Submissions';
        $data['tab'] = 'submissions';
        $data['_view'] = 'admin/activity/submissions';
        $this->load->view('admin/layout/basetemplate', $data);
    }

    public function submission($id = 0)
    {
        $this->authenticate(current_url());

        $data['user_submission'] = $this->Activity_model->get_user_activity_by_id($id);

        if(empty($data['user_submission']))
        {
            $this->session->set_flashdata('error_message', 'Submission not found');
            redirect('activity/submissions');
            exit;
        }

        $data['activity'] = $this->Activity_model->get_activity_by_id($data['user_submission']['activity_id']);

        $data['title'] = 'Activity Submissions';
        $data['tab'] = 'submissions';
        $data['_view'] = 'admin/activity/submission';
        $this->load->view('admin/layout/basetemplate', $data);
    }

    private function upload($folder, $type, $path = null)
    {
        $keys = array('name', 'type', 'tmp_name', 'error', 'size');
        $path_arr = explode("-", $path);
        foreach ($keys as $key)
        {
            $file = $_FILES[$type][$key];

            foreach ($path_arr as $value)
            {
                $file = $file[$value];
            }

            $_FILES['image'][$key] = $file;
        }

        if($_FILES["image"]['size'] > 0)
        {
            $config['upload_path']          = FCPATH.'/uploads/'.$folder.'/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['encrypt_name']         = TRUE;
            $config['file_ext_tolower']     = TRUE;

            if(!is_dir($config['upload_path']))
            {
                mkdir($config['upload_path'], 0777, true);
            }

            $this->upload->initialize($config);

            if(!$this->upload->do_upload('image'))
            {
                return null;
            }
            else
            {
                $data = $this->upload->data();
                return $data['file_name'];
            }
        }
        else
        {
            return null;
        }
    }
}
