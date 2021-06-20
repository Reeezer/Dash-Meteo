<?php

require_once "core/DatabaseManager.php";

require_once "app/controllers/Controller.php";
require_once "app/controllers/SearchController.php";
require_once "app/models/User.php";
require_once "app/models/Locality.php";

class IndexController extends Controller
{
	public function index()
	{
		$data = array();

		// est-ce que l'utilisateur est connecté
		if (isset($_SESSION['user']))
		{
			// somehow the only place to include this and have it work is in a function ¯\_(ツ)_/¯
			include "app/views/utils/emoji_flags.php"; 

			$user = unserialize($_SESSION['user']);
			$localities = Locality::fetchLocalities(DatabaseManager::$dbh, $user->getID());
			
			$meteo_data = array();

			foreach ($localities as $locality)
			{
				$lon = $locality->getLon();
				$lat = $locality->getLat();
				$locality_name = $locality->getName();	
				$country = $locality->getCountry();
				$response_array = SearchController::searchByLonLat($lon, $lat);

				$icon_url = SearchController::iconUrlFromCode($response_array['current']['weather'][0]['icon']);        
				$flag_emoji = $emoji_flags[$country];

				array_push($meteo_data, [
					'locality_name' => $locality_name,  
					'country' => $country,
					'icon_url' => $icon_url,
					'flag_emoji' => $flag_emoji,
					'temp_min' => $response_array['daily'][0]['temp']['min'],
					'temp_max' => $response_array['daily'][0]['temp']['max'],
		
					'current' => $response_array['current']
				]);
			}

			$data['meteo_data'] = $meteo_data;
		}

		return $this->view("index", $data);
	}

	public function testNotification()
	{
		Request::redirect_notify("index", "success", "Just testing notifications");
	}
}
