<?php

class Flow_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function add_flow($data)
    {
        $this->db->insert('flows', $data);
        return $this->db->insert_id();
    }

    public function update_flow($id, $data)
    {
        return $this->db->update('flows', $data, array('id' => $id));
    }

    public function add_flow_step($data)
    {
        $this->db->insert('flow_steps', $data);
        return $this->db->insert_id();
    }

    public function update_flow_step($id, $data)
    {
        return $this->db->update('flow_steps', $data, array('id' => $id));
    }

    public function add_question($data)
    {
        $this->db->insert('flow_questions', $data);
        return $this->db->insert_id();
    }

    public function update_question($id, $data)
    {
        return $this->db->update('flow_questions', $data, array('id' => $id));
    }

    public function add_answer($data)
    {
        $this->db->insert('flow_options', $data);
        return $this->db->insert_id();
    }

    public function update_answer($id, $data)
    {
        return $this->db->update('flow_options', $data, array('id' => $id));
    }

    public function delete_flow($id)
    {
        $this->db->where('id', $id)->update('flows', array('deleted' => 1));
    }

    public function delete_question($id)
    {
        $this->db->where('id', $id)->update('flow_questions', array('deleted' => 1));
    }

    public function delete_answer($id)
    {
        $this->db->where('id', $id)->update('flow_options', array('deleted' => 1));
    }

    public function count_all_flows($params = null)
    {
        if(!empty($params['search']))
            $this->db->like('flows.name', $params['search']);

        if(!empty($params['organization_id']))
            $this->db->where('flows.organization_id', $params['organization_id']);

        $this->db->where('flows.deleted', 0);
        return $this->db->count_all_results('flows');
    }

    public function get_all_flows($limit, $page, $params = null)
    {
        if(!empty($params['search']))
            $this->db->like('f.name', $params['search']);

        if(!empty($params['organization_id']))
            $this->db->where('f.organization_id', $params['organization_id']);

        if($limit)
            $this->db->limit($limit, $offset);

        $this->db->select('f.*, ft.type, COUNT(DISTINCT fs.id) as total_steps, COUNT(DISTINCT s.id) as total_submissions');
        $this->db->where('f.deleted', 0);
        $this->db->group_by('f.id');
        $this->db->order_by('f.id', 'desc');
        $this->db->join('flow_types ft', 'ft.id = f.flow_type_id');
        $this->db->join('flow_steps fs', 'f.id = fs.flow_id', 'left');
        $this->db->join('submissions s', 'f.id = s.flow_id AND s.completed = 1', 'left');
        return $this->db->get('flows f')->result_array();
    }

    public function get_flow_by_id($id)
    {
        $this->db->select('f.*, ft.type, COUNT(DISTINCT fs.id) as total_steps, COUNT(DISTINCT s.id) as total_submissions');
        $this->db->where('f.deleted', 0);
        $this->db->where('f.id', $id);
        $this->db->join('flow_types ft', 'ft.id = f.flow_type_id');
        $this->db->join('flow_steps fs', 'f.id = fs.flow_id', 'left');
        $this->db->join('submissions s', 'f.id = s.flow_id AND s.completed = 1', 'left');
        $flow = $this->db->get('flows f')->row_array();
        
        if (!empty($flow))
        {
            $flow['steps'] = $this->db->where('flow_id', $flow['id'])->where('deleted', 0)->get('flow_steps')->result_array();

            if(!empty($flow['steps']))
            {
                foreach ($flow['steps'] as $skey => $step)
                {
                    $questions = $this->db->where('flow_step_id', $step['id'])->where('deleted', 0)->get('flow_questions')->result_array();

                    if(!empty($questions))
                    {
                        foreach ($questions as $qkey => $question)
                        {
                            $questions[$qkey]['answers'] = $this->db->where('flow_question_id', $question['id'])->where('deleted', 0)->get('flow_options')->result_array();
                        }
                    }

                    $flow['steps'][$skey]['questions'] = $questions;
                }
            }

            return $flow;
        }
        else
        {
            return false;
        }
    }

    public function get_flow_by_params($params)
    {
        if(!empty($params['hash']))
            $this->db->where('hash', $params['hash']);

        if(!empty($params['inactive']))
            $this->db->where('inactive', $params['inactive']);

        $this->db->where('deleted', 0);
        $flow = $this->db->get('flows')->row_array();
        
        if (!empty($flow))
        {
            $flow['steps'] = $this->db->where('flow_id', $flow['id'])->where('deleted', 0)->get('flow_steps')->result_array();

            if(!empty($flow['steps']))
            {
                foreach ($flow['steps'] as $skey => $step)
                {
                    $questions = $this->db->where('flow_step_id', $step['id'])->where('deleted', 0)->get('flow_questions')->result_array();

                    if(!empty($questions))
                    {
                        foreach ($questions as $qkey => $question)
                        {
                            $questions[$qkey]['answers'] = $this->db->where('flow_question_id', $question['id'])->where('deleted', 0)->get('flow_options')->result_array();
                        }
                    }

                    $flow['steps'][$skey]['questions'] = $questions;
                }
            }

            return $flow;
        }
        else
        {
            return false;
        }
    }

    public function get_all_flow_steps($limit, $page, $params = null)
    {
        if(!empty($params['search']))
            $this->db->like('fs.name', $params['search']);

        if(!empty($params['organization_id']))
            $this->db->where('f.organization_id', $params['organization_id']);

        if(!empty($params['flow_id']))
            $this->db->where('fs.flow_id', $params['flow_id']);

        if($limit)
            $this->db->limit($limit, $offset);

        $this->db->select('fs.*, COUNT(fq.id) as total_questions');
        $this->db->where('fs.deleted', 0);
        $this->db->group_by('fs.id');
        $this->db->order_by('fs.id', 'asc');
        $this->db->join('flows f', 'f.id = fs.flow_id');
        $this->db->join('flow_questions fq', 'fs.id = fq.flow_step_id', 'left');
        return $this->db->get('flow_steps fs')->result_array();
    }

    public function get_flow_step_by_id($id)
    {
        $this->db->select('fs.*, COUNT(fq.id) as total_questions');
        $this->db->where('fs.id', $id);
        $this->db->where('fs.deleted', 0);
        $this->db->group_by('fs.id');
        $this->db->order_by('fs.id', 'asc');
        $this->db->join('flows f', 'f.id = fs.flow_id');
        $this->db->join('flow_questions fq', 'fs.id = fq.flow_step_id', 'left');
        return $this->db->get('flow_steps fs')->row_array();
    }

    public function get_all_flow_types()
    {
        return $this->db->get('flow_types')->result_array();
    }

    public function count_all_submissions($params = null)
    {
        if(!empty($params['search'])) {
            $this->db->group_start();
            $this->db->like('f.name', $params['search']);
            $this->db->or_like('s.name', $params['search']);
            $this->db->or_like('s.email', $params['search']);
            $this->db->group_end();
        }

        if(!empty($params['organization_id']))
            $this->db->where('f.organization_id', $params['organization_id']);

        if(!empty($params['flow_id']))
            $this->db->where('s.flow_id', $params['flow_id']);

        $this->db->join('flows f', 'f.id = s.flow_id', 'left');
        $this->db->where('s.completed', 1);
        return $this->db->count_all_results('submissions s');
    }

    public function get_all_submissions($limit, $page, $params = null)
    {
        if(!empty($params['search'])) {
            $this->db->group_start();
            $this->db->like('f.name', $params['search']);
            $this->db->or_like('s.name', $params['search']);
            $this->db->or_like('s.email', $params['search']);
            $this->db->group_end();
        }

        if(!empty($params['organization_id']))
            $this->db->where('f.organization_id', $params['organization_id']);

        if(!empty($params['flow_id']))
            $this->db->where('s.flow_id', $params['flow_id']);

        if($limit)
            $this->db->limit($limit, $page);

        $this->db->join('flows f', 'f.id = s.flow_id', 'left');
        $this->db->where('s.completed', 1);
        $this->db->order_by('s.created_on', 'desc');
        return $this->db->select('s.*, f.name as flow')->get('submissions s')->result_array();
    }

    public function start_user_flow($data)
    {
        $this->db->insert('submissions', $data);
        return $this->db->insert_id();
    }

    public function update_user_flow($id, $data)
    {
        return $this->db->update('submissions', $data, ['id' => $id]);
    }

    public function publish_user_flow_answer($data)
    {
        $answer = $this->db->get_where('submission_answers', $data)->row_array();

        if(!empty($answer))
        {
            return $this->db->update('submission_answers', $data, array('id' => $answer['id']));
        }
        else
        {
            return $this->db->insert('submission_answers', $data);
        }
    }

    public function get_submission_by_id($id)
    {
        $this->db->where('s.id', $id);
        $this->db->select('s.*');
        $this->db->join('flows f', 'f.id = s.flow_id', 'left');
        $submission = $this->db->get('submissions s')->row_array();

        if (!empty($submission))
        {
            $this->db->select('sa.*, fo.answer as option');
            $this->db->join('flow_questions fq', 'fq.id = sa.flow_question_id', 'left');
            $this->db->join('flow_options fo', 'fo.id = sa.answer', 'left');
            $submission['answers'] = $this->db->where('submission_id', $submission['id'])->get('submission_answers sa')->result_array();
            return $submission;
        }
        else
        {
            return false;
        }
    }

    public function get_submission_by_params($params = null)
    {
        if(!empty($params['flow_id']))
            $this->db->where('s.flow_id', $params['flow_id']);

        if(!empty($params['email']))
            $this->db->where('s.email', $params['email']);

        if(!empty($params['hash']))
            $this->db->where('s.hash', $params['hash']);

        if(!empty($params['completed']))
            $this->db->where('s.completed', $params['completed']);

        $this->db->select('s.*');
        $this->db->join('flows f', 'f.id = s.flow_id', 'left');
        $submission = $this->db->get('submissions s')->row_array();

        if (!empty($submission))
        {
            $this->db->select('sa.*, fo.answer as option');
            $this->db->join('flow_questions fq', 'fq.id = sa.flow_question_id', 'left');
            $this->db->join('flow_options fo', 'fo.id = sa.answer', 'left');
            $submission['answers'] = $this->db->where('submission_id', $submission['id'])->get('submission_answers sa')->result_array();
            return $submission;
        }
        else
        {
            return false;
        }
    }

}
