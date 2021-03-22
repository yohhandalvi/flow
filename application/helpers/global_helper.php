<?php

function pr($array)
{
	echo '<pre>';
	print_r($array);
	echo '</pre>';
}

function lq()
{
	$ci =& get_instance();
	echo $ci->db->last_query();
	exit;
}

function convert_db_time($datetime, $format = "d/m/Y")
{
	return date($format, strtotime($datetime));
}

function check_field($value, $data)
{
	$ci =& get_instance();
	$params = explode(",", $data);

	if(!empty($params[2]))
	{
		$filters = explode("&", $params[2]);

		if(!empty($filters))
		{
			foreach ($filters as $key => $filter)
			{
				$f = explode("|", $filter);
				$ci->db->where($f[0], $f[1]);
			}
		}
	}

	$ci->db->where($params[1], $value);
	$row = $ci->db->get($params[0])->row_array();

	if(empty($row))
	{
		return TRUE;
	}
	else
	{
		$ci->form_validation->set_message('check_field', '%s is already used');
		return FALSE;
	}
}

function otp()
{
    $otp = random_string('numeric', 6);
    if(substr($otp, 0, 1) == 0)
        $otp = rand(1, 9).substr($otp, 1);
    return $otp;
}

function slug($string)
{
    return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
}

function show_image($image, $params = null)
{
	if(isset($params['thumbnail']))
	{
		$image_data = explode(".", $image);
		$extension = end($image_data);
		$folders = explode("/", $image);
		$url = str_replace(end($folders), "", $image)."thumb/".str_replace(".".$extension, "", end($folders))."_".$params['thumbnail'].".".$extension;
	}
	else
	{
		$url = $image;
	}

	return $url;
}

function get_original_image_url($image)
{
	$image_data = explode(".", $image);
	$extension = end($image_data);
	$image = preg_replace( '/_[^_]*$/', '', $image);
	$image = preg_replace( '/_[^_]*$/', '', $image);
	$image = $image.".".$extension;
	$image_data = explode("/", $image);
	$allowed_data = array_diff($image_data, ['thumb']);
	return implode("/", $allowed_data);
}

function base64_to_image($base64_string, $output_file)
{
    $ifp = fopen($output_file, 'wb'); 
    $data = explode(',', $base64_string);
    fwrite($ifp, base64_decode($data[1]));
    fclose($ifp); 
    return $output_file; 
}

function get_allowed_formats($type)
{
	$allowed_types = [
		'image' => ['image/gif', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png']
	];

	return isset($allowed_types[$type]) ? $allowed_types[$type] : [];
}

function show_price($amount)
{
	return CURRENCY_SYMBOL . " " . number_format($amount, 2);
}