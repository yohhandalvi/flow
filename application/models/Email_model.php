<?php

class Email_model extends CI_Model {

	public function send_otp($email, $otp)
	{
        $data['data'] = array(
			'otp' => $otp
		);
		$data['_view'] = 'otp';
        $data['title'] = PROJECT_NAME.' Verification Code';
        $html = $this->load->view('email/layout', $data, true);
        return $this->send_mail->send_to([$email => $name], PROJECT_NAME." Verification Code", $html);
	}

	public function send_forgot_password_link($name, $email, $forgot_password_key)
	{
        $data['data'] = array(
			'name' => $name,
			'forgot_password_key' => $forgot_password_key
		);
		$data['_view'] = 'reset-password-link';
        $data['title'] = PROJECT_NAME.' Reset Password Mail';
        $html = $this->load->view('email/layout', $data, true);
        return $this->send_mail->send_to([$email => $name], PROJECT_NAME." Reset Password Mail", $html);
	}

	public function send_contact_mail($first_name, $last_name, $email, $subject, $message)
	{
        $data['data'] = array(
			'first_name' => $first_name,
			'last_name' => $last_name,
			'email' => $email,
			'subject' => $subject,
			'message' => $message
		);
		$data['_view'] = 'contact';
        $data['title'] = PROJECT_NAME.' Contact Mail';
        $html = $this->load->view('email/layout', $data, true);
        return $this->send_mail->send_to(EMAIL_ADMIN, PROJECT_NAME." Contact Mail", $html);
	}
}
