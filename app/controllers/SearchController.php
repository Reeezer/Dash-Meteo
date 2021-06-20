<?php

require_once "app/controllers/Controller.php";
require_once "app/controllers/LocalityController.php";
require_once "app/models/User.php";


/**
 * Handles the API calls and searches on the OpenWeatherMap API
 */
class SearchController extends Controller
{

	/**
	 * Searches the OWM geocoding API for a city or locality with a matching name, returning the longitute and latitude of all the matching localities
	 * @param string $name City or Locality name
	 * @return mixed The decoded JSON response from the OWM API
	 */
	public static function searchByName($name)
	{
		$api_key = App::get('config')['api_key'];	
		$ch = curl_init();
		// curl_setopt($ch, CURLOPT_URL, "https://api.openweathermap.org/data/2.5/onecall?q=" . $search_input . "&appid=$api_key");
		curl_setopt($ch, CURLOPT_URL, "http://api.openweathermap.org/geo/1.0/direct?q=$name&limit=1&appid=$api_key");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);

		// vérifier si il y a un résultat 
		if ($response === false)
			Request::redirect_notify("home", "error", "There has been an unknown error with the service provider. Please try later.");
			
		curl_close($ch);

		return json_decode($response, true);
	}

	/**
	 * Calls the OWM OneCall API which returns the wheather data for a given latitude and longitude
	 * 
	 * @param float $lon Longitude
	 * @param float $lat Latitude
	 * @return mixed The decoded JSON response from the OWM API
	 */
	public static function searchByLonLat($lon, $lat)
	{
		$api_key = App::get('config')['api_key'];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.openweathermap.org/data/2.5/onecall?lat=$lat&lon=$lon&appid=$api_key");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);

		// vérifier si il y a un résultat 
		if ($response === false)
			Request::redirect_notify("home", "error", "There has been an unknown error with the service provider. Please try later.");
		
		curl_close($ch);

		return json_decode($response, true);
	}

	/**
	 * Displays the results page from a search on the website. Does all API calls on OWM for a given locality name
	 * @return void
	 */
	public function showResults()
	{
		// somehow the only place to include this and have it work is in a function ¯\_(ツ)_/¯
		include "app/views/utils/emoji_flags.php"; 

		if (!isset($_GET['search_input']))
		{
			Request::redirect_notify("home", "error", "Don't mess with the GET. Thanks :)");
		}

		$search_input = $_GET['search_input'];

		// Récupérer la longitude et latitude de la ville recherchée
		// lancer la recherche sur l'api
		$response_array = SearchController::searchByName($search_input);

		// vérifier sur l'API a retourné une erreur
		if (count($response_array) == 0)
			Request::redirect_notify("home", "error", "There are no results to this search");

		// parfois ça retourne quand même ça si il n'y a pas de résultats ¯\_(ツ)_/¯
		if (isset($response_array['cod']) && $response_array['cod'] == 404)
			Request::redirect_notify("home", "error", "There are no results to this search");

		$lat = $response_array[0]['lat'];
		$lon = $response_array[0]['lon'];
		$locality_name =  $response_array[0]['name'];
		$country = $response_array[0]['country'];

		// Récupérer les infos de la ville 
		$response_array = SearchController::searchByLonLat($lon, $lat);

		// Déterminer si la localité est déjà dans les favoris de l'utilisateur
		$is_favourited = false;
		if (isset($_SESSION['user']))
		{	
			$user = unserialize($_SESSION['user']);

			$is_favourited = LocalityController::checkFavouriteByName($user->getID(), $locality_name);
		}

		$icon_url = SearchController::iconUrlFromCode($response_array['current']['weather'][0]['icon']);        
		$flag_emoji = $emoji_flags[$country];

		// passer les résultats à la page direct
		return $this->view("search", [
			'locality_name' => $locality_name,  
			'country' => $country,
			'latitude' => $lat,
			'longitude' => $lon,
			'icon_url' => $icon_url,
			'flag_emoji' => $flag_emoji,

			'current_data' => $response_array['current'],
			'hourly_data' => $response_array['hourly'],
			'daily_data' => $response_array['daily'],

			'is_favourited' => $is_favourited
			]
		);

	}

	/**
	 * Returns the URL to the image corresponding to a certain OWM weather condition code
	 * 
	 * @param string $code The OWM code for a certain weather condition
	 * 
	 * @return string
	 */
	public static function iconUrlFromCode($code)
	{
		return "http://openweathermap.org/img/wn/" . $code . ".png";
	}
}
