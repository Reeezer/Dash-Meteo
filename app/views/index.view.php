<?php
$title = "Dash Meteo";
$page_class = "home";

require_once "partials/header.php";

?>

<div class="content">
	<h1>Home</h1>
	<form class="home_form" action="search" method="get">
		<input class="locality_input" type="text" name="search_input" placeholder="Search a locality..." required>
		<input class="submit_input" type="submit" value="Submit">
	</form>
</div>

<?php if ($logged_in) {?>

    <div class="content">
        <section id="week-days">
            <?php
                foreach ($meteo_data as $locality_data)
                {
                    $locality_name = $locality_data['locality_name'];
                    $weather_icon = $locality_data['icon_url'];
                    $flag_emoji = $locality_data['flag_emoji'];
                    $temp_min = $locality_data['temp_min'];
                    $temp_max = $locality_data['temp_max'];

                    ?>
                    <a href="search?search_input=<?php echo htmlentities($locality_name); ?>" class="day-column basic-info">
                        <div class="day"><?php echo htmlentities($locality_name) . " " . htmlentities($flag_emoji); ?></div>
                        <div class="day-weather-icon"><img src="<?="http://openweathermap.org/img/wn/" . htmlentities($locality_data['current']['weather'][0]['icon']) . "@4x.png";?>" /></div>
                        <div class="day-weather-info"><h2><?php echo round(htmlentities($locality_data['current']['temp']) - 273.15, 1); ?>&deg;C</h2></div>
                        <div class="day-weather-minmax">
                            <p><?php echo round(htmlentities($temp_min) - 273.15, 1); ?>&deg;C</p>
                            <p><?php echo round(htmlentities($temp_max) - 273.15, 1); ?>&deg;C</p>
                        </div>
                    </a>
                    <?php
                }
            ?>
        </section>
    </div>
<?php } ?>

<?php require_once "partials/footer.php" ?>