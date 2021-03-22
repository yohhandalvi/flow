<?php

class User_model extends CI_Model {

	public function login($domain, $email, $password)
	{
		$this->db->select('u.id, u.email, u.organization_id');
		$this->db->where('o.domain', $domain);
		$this->db->where('u.email', $email);
		$this->db->where('u.password', $password);
		$this->db->join('organizations o', 'o.id = u.organization_id');
		$admin = $this->db->get('users u')->row_array();

		if(!empty($admin))
		{
			$this->set_user_session(['user_id' => $admin['id'], 'user_email' => $admin['email'], 'user_organization' => $admin['organization_id']]);
			return true;
		}
		else
		{
			return false;
		}
	}

	public function get_temp($email)
	{
		return $this->db->get_where('temp_users', ['email' => $email])->row_array();
	}

	public function temp_update($email, $data)
	{
		$user = $this->get_temp($email);

		$user_data = json_decode($user['data'], true);

		if(!empty($data))
		{
			foreach ($data as $key => $value)
			{
				$user_data[$key] = $value;
			}
		}

		return $this->db->update('temp_users', ['data' => json_encode($user_data)], ['id' => $user['id']]);
	}

	public function temp($email, $otp)
	{
		$user = $this->get_temp($email);

		if(empty($user))
		{
			$data = [
				'email' => $email,
				'confirmation_code' => $otp,
				'data' => json_encode([])
			];

			$this->db->insert('temp_users', $data);
			$user_id = $this->db->insert_id();
		}
		else
		{
			$data = [
				'confirmation_code' => $otp
			];

			$this->db->update('temp_users', $data, ['id' => $user['id']]);
			$user_id = $user['id'];
		}

		return $user_id;
	}

	public function set_user_session($user_data)
	{
		if(!empty($user_data))
		{
			foreach ($user_data as $key => $value)
			{
				$this->session->set_userdata($key, $value);
			}
		}
	}

	public function add($data)
    {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

	public function update($id, $data)
	{
		return $this->db->update('users', $data, array('id' => $id));
	}

	public function get_user_by_params($params)
	{
		if(isset($params['forgot_password_key']))
			$this->db->where('u.forgot_password_key', $params['forgot_password_key']);

		if(isset($params['email']))
			$this->db->where('u.email', $params['email']);

		if(isset($params['username']))
			$this->db->where('u.username', $params['username']);

		if(isset($params['domain']))
			$this->db->where('o.domain', $params['domain']);

		$this->db->select('u.*, CONCAT_WS(" ", u.first_name, u.last_name) as full_name');
		$this->db->from('users u');
		$this->db->join('organizations o', 'o.id = u.organization_id');
		return $this->db->get()->row_array();
	}
}