<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends AdminController {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
		$this->load->model('Email_model');
        $this->load->model('Organization_model');
	}

	public function index()
	{
		if(isset($this->user['id']))
		{
			redirect('admin/dashboard');
			exit;
		}

        $this->form_validation->set_rules('domain', 'domain', 'required|xss_clean');
		$this->form_validation->set_rules('email', 'email', 'required|valid_email|xss_clean');
		$this->form_validation->set_rules('password', 'password', 'required|md5');

		$this->form_validation->set_error_delimiters('<div class="text-danger p-2">', '</div>');

		if($this->form_validation->run())
		{
			$result = $this->User_model->login($this->input->post('domain'), $this->input->post('email'), $this->input->post('password'));

			if($result)
			{
				$this->session->set_flashdata('success_message', 'Logged in successfully');

				if($this->input->get('redirect_to'))
					redirect($this->input->get('redirect_to'));
				else
					redirect('admin/dashboard');

				exit;
			}
			else
			{
				$this->session->set_flashdata('error_message', 'Invalid credentials');
				redirect('admin');
				exit;
			}
		}
		else
		{
			$data['title'] = 'Login';
			$this->load->view('admin/user/login', $data);
		}
	}

	public function dashboard()
	{
		$this->authenticate(current_url());

		$data['tab'] = 'dashboard';
		$data['title'] = 'Dashboard';
		$data['_view'] = 'admin/user/dashboard';
		$this->load->view('admin/layout/basetemplate', $data);
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('admin');
		exit;
	}

	public function forgot_password()
    {
        if(isset($this->user['id']))
		{
			redirect('admin/dashboard');
			exit;
		}

        $this->form_validation->set_rules('domain', 'domain', 'required|xss_clean');
        $this->form_validation->set_rules('email', 'email', 'required|valid_email|xss_clean');

        $this->form_validation->set_error_delimiters('<div class="text-danger p-2">', '</div>');

        if($this->form_validation->run())
        {
            $user = $this->User_model->get_user_by_params(['domain' => $this->input->post('domain'), 'email' => $this->input->post('email')]);

            if(!empty($user))
            {
                $forgot_password_key = random_string('alnum', 16);
                $this->Email_model->send_forgot_password_link($user['full_name'], $user['email'], $forgot_password_key);

                $data = [
                    'forgot_password_key' => $forgot_password_key
                ];

                $result = $this->User_model->update($user['id'], $data);

                if($result)
                {
                    $this->session->set_flashdata('success_message', 'Reset password mail has been sent to your email');
                    redirect('admin/forgot-password');
                    exit;
                }
                else
                {
                    $this->session->set_flashdata('error_message', 'Some error occured while sending the reset password mail');
                    redirect('admin/forgot-password');
                    exit;
                }
            }
            else
            {
                $this->session->set_flashdata('error_message', 'This account is not registered with us');
                redirect('admin/forgot-password');
                exit;
            }
        }
        else
        {
            $data['title'] = 'Forgot Password';
			$this->load->view('admin/user/forgot-password', $data);
        }
    }

    public function reset_password()
    {
        if(isset($this->user['id']))
		{
			redirect('admin/dashboard');
			exit;
		}

        $user = $this->User_model->get_user_by_params(['forgot_password_key' => $this->input->post('key')]);

        if(!empty($user))
        {
            $this->form_validation->set_rules('password', 'password', 'required|min_length[6]');
            $this->form_validation->set_rules('retype_password', 'confirm password', 'required|min_length[6]|matches[password]');

            $this->form_validation->set_error_delimiters('<div class="text-danger p-2">', '</div>');

            if($this->form_validation->run())
            {
                $data = [
                    'forgot_password_key' => null,
                    'password' => md5($this->input->post('password'))
                ];

                $result = $this->User_model->update($customer['id'], $data);

                if($result)
                {
                    $this->session->set_flashdata('success_message', 'Password has been updated successfully');
                    redirect('admin');
                    exit;
                }
                else
                {
                    $this->session->set_flashdata('error_message', 'Some error occured while resetting the password');
                    redirect('admin/forgot-password');
                    exit;
                }
            }
            else
            {
                $data['title'] = 'Reset Password';
                $this->load->view('admin/user/reset-password', $data);
            }
        }
        else
        {
            redirect('admin');
            exit;
        }
    }

    public function register()
    {
        if(isset($this->user['id']))
        {
            redirect('admin/dashboard');
            exit;
        }

        $this->form_validation->set_rules('email', 'email', 'required|valid_email|xss_clean');

        $this->form_validation->set_error_delimiters('<div class="text-danger p-2">', '</div>');

        if($this->form_validation->run())
        {
            $otp = otp();
            $result = $this->User_model->temp($this->input->post('email'), $otp);

            if($result)
            {
                $this->session->set_userdata('temp_email', $this->input->post('email'));
                $this->Email_model->send_otp($this->input->post('email'), $otp);
                $this->session->set_flashdata('success_message', 'OTP has been sent to your email address');
                redirect('confirmation');
                exit;
            }
            else
            {
                $this->session->set_flashdata('error_message', 'Some error occured');
                redirect('register');
                exit;
            }
        }
        else
        {
            $data['title'] = 'Registration';
            $this->load->view('admin/user/register', $data);
        }
    }

    public function confirmation()
    {
        if(isset($this->user['id']))
        {
            redirect('admin/dashboard');
            exit;
        }

        $registration = $this->_validate_registration();

        $this->form_validation->set_rules('otp', 'otp', 'required|xss_clean');

        $this->form_validation->set_error_delimiters('<div class="text-danger p-2">', '</div>');

        if($this->form_validation->run())
        {
            if($registration['confirmation_code'] == $this->input->post('otp'))
            {
                redirect('personal');
                exit;
            }
            else
            {
                $this->session->set_flashdata('error_message', 'Invalid OTP');
                redirect('confirmation');
                exit;
            }
        }
        else
        {
            $data['title'] = 'Registration / Verify OTP';
            $this->load->view('admin/user/confirmation', $data);
        }
    }

    public function personal()
    {
        if(isset($this->user['id']))
        {
            redirect('admin/dashboard');
            exit;
        }

        $registration = $this->_validate_registration();

        $this->form_validation->set_rules('first_name', 'first name', 'required|xss_clean');
        $this->form_validation->set_rules('last_name', 'last name', 'required|xss_clean');
        $this->form_validation->set_rules('username', 'username', 'xss_clean');
        $this->form_validation->set_rules('password', 'password', 'required|min_length[6]');
        $this->form_validation->set_rules('retype_password', 'confirm password', 'required|min_length[6]|matches[password]');

        $this->form_validation->set_error_delimiters('<div class="text-danger p-2">', '</div>');

        if($this->form_validation->run())
        {
            $data = $this->input->post();
            $data['password'] = md5($data['password']);
            unset($data['retype_password']);
            $result = $this->User_model->temp_update($registration['email'], $data);

            if($result)
            {
                redirect('organization');
                exit;
            }
            else
            {
                $this->session->set_flashdata('error_message', 'Some error occured');
                redirect('personal');
                exit;
            }
        }
        else
        {
            $data['title'] = 'Registration / Personal Details';
            $this->load->view('admin/user/personal', $data);
        }
    }

    public function organization()
    {
        if(isset($this->user['id']))
        {
            redirect('admin/dashboard');
            exit;
        }

        $registration = $this->_validate_registration();

        $this->form_validation->set_rules('organization_size_id', 'orgnization size', 'required|xss_clean');
        $this->form_validation->set_rules('organization_type_id', 'orgnization type', 'required|xss_clean');
        $this->form_validation->set_rules('organization_name', 'name', 'required|xss_clean');

        $this->form_validation->set_error_delimiters('<div class="text-danger p-2">', '</div>');

        if($this->form_validation->run())
        {
            $data = $this->input->post();
            $result = $this->User_model->temp_update($registration['email'], $data);

            if($result)
            {
                redirect('domain');
                exit;
            }
            else
            {
                $this->session->set_flashdata('error_message', 'Some error occured');
                redirect('organization');
                exit;
            }
        }
        else
        {
            $data['organization_sizes'] = $this->Organization_model->get_all_organization_sizes();
            $data['organization_types'] = $this->Organization_model->get_all_organization_types();

            $data['title'] = 'Registration / Organization Details';
            $this->load->view('admin/user/organization', $data);
        }
    }

    public function domain()
    {
        if(isset($this->user['id']))
        {
            redirect('admin/dashboard');
            exit;
        }

        $registration = $this->_validate_registration();

        $this->form_validation->set_rules('domain', 'domain', 'required|is_unique[organizations.domain]|xss_clean');

        $this->form_validation->set_error_delimiters('<div class="text-danger p-2">', '</div>');
        $this->form_validation->set_message('is_unique', 'This %s is already registered with us');

        if($this->form_validation->run())
        {
            $data = $this->input->post();
            $result = $this->User_model->temp_update($registration['email'], $data);

            if($result)
            {
                redirect('terms');
                exit;
            }
            else
            {
                $this->session->set_flashdata('error_message', 'Some error occured');
                redirect('domain');
                exit;
            }
        }
        else
        {
            $user_data = json_decode($registration['data'], true);
            $data['domain'] = slug($user_data['organization_name']);
            $data['title'] = 'Registration / Domain Setup';
            $this->load->view('admin/user/domain', $data);
        }
    }

    public function terms()
    {
        if(isset($this->user['id']))
        {
            redirect('admin/dashboard');
            exit;
        }

        $registration = $this->_validate_registration();

        $this->form_validation->set_rules('terms', 'terms', 'required|xss_clean');

        $this->form_validation->set_error_delimiters('<div class="text-danger p-2">', '</div>');

        if($this->form_validation->run())
        {
            $user_data = json_decode($registration['data'], true);

            $organization = [
                'name' => $user_data['organization_name'],
                'domain' => $user_data['domain'],
                'organization_type_id' => $user_data['organization_type_id'],
                'organization_size_id' => $user_data['organization_size_id'],
            ];

            $result = $this->Organization_model->add($organization);

            if($result)
            {
                $user = [
                    'first_name' => $user_data['first_name'],
                    'last_name' => $user_data['last_name'],
                    'organization_id' => $result,
                    'email' => $registration['email'],
                    'password' => $user_data['password'],
                    'username' => $user_data['username'],
                    'superadmin' => 1
                ];

                $result = $this->User_model->add($user);

                if($result)
                {
                    $this->session->unset_userdata('temp_email');
                    $this->session->set_flashdata('success_message', 'Registered successfully');
                    redirect('admin');
                    exit;
                }
                else
                {
                   $this->session->set_flashdata('error_message', 'Some error occured');
                    redirect('terms');
                    exit; 
                }
            }
            else
            {
                $this->session->set_flashdata('error_message', 'Some error occured');
                redirect('terms');
                exit;
            }
        }
        else
        {
            $data['title'] = 'Registration / Accept terms & conditions';
            $this->load->view('admin/user/terms', $data);
        }
    }

    private function _validate_registration()
    {
        if($this->session->userdata('temp_email'))
        {
            $email = $this->session->userdata('temp_email');
            return $this->User_model->get_temp($email);
        }
        else
        {
            return [];
        }
    }
}
