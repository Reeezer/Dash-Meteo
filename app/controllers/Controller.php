<?php

require_once "app/models/User.php";

class Controller
{
	public function view($name, $data = [])
	{
		$data['logged_in'] = isset($_SESSION['user']);

		if ($data['logged_in'])
		{
			$user = unserialize($_SESSION['user']);
			$data['email'] =  $user->getEmail();
			$data['user_id'] = $user->getID();
		}

		extract($data);
		return require "app/views/{$name}.view.php";
	}
}