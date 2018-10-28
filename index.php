<?php 
require_once 'classes/DB.php';
require_once 'classes/Booking.php';

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	if (isset($_POST['phone']) && isset($_POST['date_booking'])) {
		echo json_encode(Booking::addBooking($_POST['date_booking'], $_POST['phone']));
		die;
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Start-test</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" type="text/css" href="/css/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
	<body>
		<!--romand1z9 27b99af73fb755bed4961ee219f4ad26 http://s135707.smrtp.ru/-->
		<div class="container-fluid container-extra">
			<?php 
			$array_by_month = Booking::getDates();
			?>
			<h1 class="main_title">Бронирование даты</h1>
			<div class="row">
			<?php foreach ($array_by_month as $month => $month_days):?>
				<div class="month">
					<p class="month_title"><?=Booking::$months[$month];?></p>
					<table>
						<thead>
							<tr>
								<th>Пн</th>
								<th>Вт</th>
								<th>Ср</th>
								<th>Чт</th>
								<th>Пт</th>
								<th class="holiday">Сб</th>
								<th class="holiday">Вс</th>
							</tr>
						</thead>
						<?php if(!empty($month_days)):?>
							<tbody>
								<tr class="extra_tr">
									<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
								</tr>
								<?php $i = 1;?>
								<?php foreach ($month_days as $day):?>
									<?php if ($i == 1):?>
										<tr>
										<?php if ($day['day_week'] != $i):?>
											<?php for($j=0;$j<$day['day_week']-1;$j++):?>
												<td></td>
											<?php endfor;?>
											<?php $i = intval($day['day_week']);?>
										<?php endif;?>
									<?php endif;?>
									<?php if ($day['past']) {
										$class_cell = 'past_cell';
									} elseif ($day['booking']) {
										$class_cell = 'booking_cell';
									} else {
										$class_cell = 'free_cell';
									}?>
									<td class="<?=$class_cell;?> date_cell" data-date_booking="<?=$day['date']?>"><p align="center"><?=substr($day['date'], 0, -8);?></p></td>
									<?php if ($i % 7 == 0):?>
										</tr>
									<?php endif;?>
									<?php $i++;?>
								<?php endforeach;?>
							</tbody>
						<?php endif;?>
					</table>
				</div><br><br>
				<!--<?php if ($month == 6):?>
					</div>
					<div class="row">
				<?php endif;?>-->
			<?php endforeach;?>
			</div>
		
		<br>
		<label><b>Укажите телефон:</b></label>
		<div class="row contacts">
			<div class="col-lg-2 col-md-3 col-sm-6 col-xs-6">
				<input type="text" name="phone" class="form-control" placeholder="Моб. телефон...">
			</div><br><br>
			<div class="col-lg-2 col-md-3 col-sm-6 col-xs-6">
				<button class="btn btn-success" id="booking_submit">Забронировать</button>
			</div>
		</div><br><br><br>
		</div>

		<?php //echo "<pre>".print_r(Booking::getDates(), true)."</pre>";?>
		<!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->
		<script type="text/javascript" src="/js/jquery.js"></script>
		<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>-->
		<script type="text/javascript" src="/js/bootstrap/bootstrap.min.js"></script>
		<script type="text/javascript" src="/js/jquery.maskedinput.min.js"></script>
		<script type="text/javascript" src="/js/main.js"></script>
	</body>
</html>