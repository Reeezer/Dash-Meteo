<?php
$title = "Dash Meteo - Search";
$page_class = "search";

require_once "partials/header.php";

// All icons found on icons8.com

?>

<div class="current">
	<div class="content">
		<div class="title">
			<div class="locality">
				<div id="favourite_star" class="detail" ></div>
				<div id="locality_name" class="detail"><?= htmlentities($locality_name) ?></div>
				<div id="country_flag" class="detail"><?= htmlentities($flag_emoji) ?></div>
			</div>
			<div class="date"><?= date("D j M H:i", htmlentities($current_data['dt'])) ?></div>
			<div class="temp"><?php echo round(htmlentities($current_data['temp']) - 273.15, 1);?>&deg;C</div>
			<div class="description"><?= htmlentities($current_data['weather'][0]['description']) ?></div>
		</div>
		<div class="informations">
			<div class="feels_like weather">
				<div class="icon"><img src="https://img.icons8.com/android/48/000000/thermometer.png"/></div>
				<div class="info"><?= htmlentities($current_data['feels_like']) - 273.15 ?>&deg;C</div>
				<div class="description">Feels like</div>
			</div>
			<div class="humidity weather">
				<div class="icon"><img src="https://img.icons8.com/material-outlined/48/000000/water.png"/></div>
				<div class="info"><?= htmlentities($current_data['humidity']) ?>%</div>
				<div class="description">Humidity</div>
			</div>
			<div class="pressure weather">
				<div class="icon"><img src="https://img.icons8.com/material-outlined/48/000000/pressure.png"/></div>
				<div class="info"><?= htmlentities($current_data['pressure']) ?>hPa</div>
				<div class="description">Pressure</div>
			</div>
			<div class="UV weather">
				<div class="icon"><img src="https://img.icons8.com/material-outlined/48/000000/do-not-expose-to-sunlight.png"/></div>
				<div class="info"><?= htmlentities($current_data['uvi']) ?></div>
				<div class="description">UV</div>
			</div>
			<div class="cloud weather">
				<div class="icon"><img src="https://img.icons8.com/metro/52/000000/cloud.png"/></div>
				<div class="info"><?= htmlentities($current_data['clouds']) ?>%</div>
				<div class="description">Cloud</div>
			</div>
			<div class="wind weather">
				<div class="icon"><img src="https://img.icons8.com/pastel-glyph/64/000000/paper-plane--v1.png"/></div>
				<div class="info"><?= htmlentities($current_data['wind_speed']) ?>m/s</div>
				<div class="description">Wind speed</div>
			</div>
		</div>
		<p class="next_days_temperature">The temperature for the next days</p>
		<div class="plot">
			<canvas id="plot"></canvas>
		</div>
	</div>
</div>
<div class="content">
	<h1 class="overview" >Week overview</h1>
	<section id="week-days">
		<?php
			foreach($daily_data as $key => $day)
			{
				?>
				<!-- base -->
				<div class="day-column basic-info <?php echo "day" . htmlentities($key); ?>">
					<div class="day"><?php echo date("D j", htmlentities($day['dt'])); ?></div>
					<div class="day-weather-icon"><img src="<?="http://openweathermap.org/img/wn/" . htmlentities($day['weather'][0]['icon']) . "@4x.png";?>" /></div>
					<div class="day-weather-info"><h2><?php echo round(htmlentities($day['temp']['day']) - 273.15, 1); ?>&deg;C</h2></div>
					<div class="day-weather-minmax">
						<p><?php echo round(htmlentities($day['temp']['min']) - 273.15, 1); ?>&deg;C</p>
						<p><?php echo round(htmlentities($day['temp']['max']) - 273.15, 1); ?>&deg;C</p>
					</div>
				</div>

				<!-- details -->
				<div class="day-column details-info <?php echo "day" . htmlentities($key); ?>" hidden>
					<div class="day info"><?php echo date("D j", htmlentities($day['dt'])); ?></div>
					<div class="details">
						<div class="humidity weather">
							<div class="icon detail"><img src="https://img.icons8.com/material-outlined/48/000000/water.png"/> </div>
							<div class="info detail"><?= htmlentities($day['humidity']) ?>%</div>
						</div>
						<div class="cloud weather">
							<div class="icon detail"><img src="https://img.icons8.com/metro/52/000000/cloud.png"/> </div>
							<div class="info detail"><?= htmlentities($day['clouds']) ?>%</div>
						</div>
						<div class="wind weather">
							<div class="icon detail"><img src="https://img.icons8.com/pastel-glyph/64/000000/paper-plane--v1.png"/> </div>
							<div class="info detail"><?= htmlentities($day['wind_speed']) ?>m/s</div>
						</div>
						<div class="sunrise weather">
							<div class="icon detail"><img src="https://img.icons8.com/fluent-systems-regular/48/000000/sunrise.png"/> </div>
							<div class="info detail"><?= date("H:i", htmlentities($day['sunrise'])) ?></div>
						</div>
						<div class="sunrise weather">
							<div class="icon detail"><img src="https://img.icons8.com/fluent-systems-regular/48/000000/sunset.png"/> </div>
							<div class="info detail"><?= date("H:i", htmlentities($day['sunset'])) ?></div>
						</div>
					</div>
				</div>
				<?php
			}
		?>
	</section>
</div>

<script>
	let is_favourited = false;
	<?php if ($is_favourited) { ?>
		is_favourited = true;
	<?php } ?>

	function setFavouriteStar(state)
	{
		if (state)
			$('#favourite_star').html("<img src=\"app/assets/star_filled.png\">");
		else
			$('#favourite_star').html("<img src=\"app/assets/star.png\">");
	}

	$('#favourite_star').on('click', function () {

		let user_id = "<?= urlencode($user_id) ?>";
		let lat = "<?= urlencode($latitude) ?>";
		let lon = "<?= urlencode($longitude) ?>";
		let name = "<?= urlencode($locality_name) ?>";
		let country = "<?= urlencode($country) ?>";

		if (!is_favourited)
		{
			$.get("add_favourite", {
				'user_id': user_id,
				'lat': lat,
				'lon': lon,
				'name': name,
				'country': country
			}, function (data, status, jqXHR) {
				setFavouriteStar(true);
				is_favourited = true;
			});
		}
		else
		{
			$.get("remove_favourite", {
				'user_id': user_id,
				'name': name
			}, function (data, status, jqXHR) {
				setFavouriteStar(false);
				is_favourited = false;
			});
		}
	});

	<?php if ($logged_in) { ?>
		setFavouriteStar(is_favourited);
	<?php } ?>
	

	// flipping cards
	const animation_duration = 250;
	$('.day-column.basic-info').each(function (index) {
		let id_name = $(this).attr('class');
		let id_numeric = id_name.replace( /^\D+/g, '');
		$(this).on('click', function (event) {
			$(this).fadeOut(animation_duration, function() {$(".day-column.details-info.day" + id_numeric).fadeIn(animation_duration);});
		});
	});

	$('.day-column.details-info').each(function (index) {
		let id_name = $(this).attr('class');
		let id_numeric = id_name.replace( /^\D+/g, '');
		$(this).on('click', function (event) {
			$(this).fadeOut(animation_duration, function() {$(".day-column.basic-info.day" + id_numeric).fadeIn(animation_duration);});
		});
	});

</script>

<script>
	let plot_data = [];
	let min_y = 200;
	let max_y = -273.15;
	let x;
	let y;

	<?php
	foreach($daily_data as $key => $day) {
	?>
		x = <?php echo json_encode(date("D j", htmlentities($day['dt']))); ?>;
		y = <?php echo json_encode(round(htmlentities($day['temp']['day']) - 273.15, 1)); ?>;

		min_y = Math.min(min_y, y);
		max_y = Math.max(max_y, y);

		plot_data.push({
			x: x,
			y: y
		});
	<?php
	}
	?>

	let ctx = $('#plot')[0].getContext('2d');

	let gradient = ctx.createLinearGradient(0,0,0,300);
	gradient.addColorStop(0, '#ff4444');
	gradient.addColorStop(1, '#0077ff');

	let chart = new Chart(ctx, {
		type: 'line',
		data: {
			datasets: [{
				label: 'Temperature',
				data: plot_data,
				tension: 0.4,
				backgroundColor: gradient,
				borderColor: gradient,
				pointBackgroundColor: '#ffffff',
				pointBorderColor: 'transparent'
			}]
		},
		options: {
			elements: {
				point: {
					radius: 0,
					hitRadius: 5,
					hoverRadius: 5
				}
			},
			responsive: true,
			maintainAspectRatio: false,
			scales: {
				y: {
					suggestedMax: Math.ceil(max_y + 0.5),
					suggestedMin: Math.floor(min_y - 0.5),
					ticks: {
						count: 5
					},
					title: {
						display: true,
						text: "Temperature [°C]"
					}
				}
			},
			plugins: {
				legend: {
					display: false
				}
			}
		}
	});
</script>




<?php require_once "partials/footer.php" ?>