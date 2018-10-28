<?php 

class Booking {
	
	static public $months = [
		1 => 'Январь',
		2 => 'Февраль',
		3 => 'Март',
		4 => 'Апрель',
		5 => 'Май',
		6 => 'Июнь',
		7 => 'Июль',
		8 => 'Август',
		9 => 'Сентябрь',
		10 => 'Октябрь',
		11 => 'Ноябрь',
		12 => 'Декабрь',
	];
	static public $table = 'booking';
	const PATTERN_PHONE = '/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){7,14}(\s*)?$/';

	static public function getDates() {

		$date_ = new DateTime;
		$today = $date_->format("j-m-Y");
		$current_year = strval($date_->format("Y")); 
		$start_date = $date_->modify("first day of January")->format("j-m-Y");
		$booking_dates = self::getBookingDates();

		$array_days = [];
		$array_days[strval($start_date)]['date'] = strval($start_date);
		$array_days[strval($start_date)]['day_week'] = $date_->format("N");
		$array_days[strval($start_date)]['month'] = $date_->format("n");
		$array_days[strval($start_date)]['booking'] = false;
		if (strtotime($start_date) < strtotime($today)) {
			$array_days[strval($start_date)]['past'] = true;
		} else {
			$array_days[strval($start_date)]['past'] = false;
		}

		$count_days = 365;
		for ($i=1;$i<=$count_days;$i++) {
				$start_date = $date_->modify("+1 day")->format("j-m-Y");
			if ($date_->format("Y") == $current_year) {
				$date__ = strval($start_date);
				$array_days[$date__]['date'] = $date__;
				$array_days[$date__]['day_week'] = $date_->format("N");
				$array_days[$date__]['month'] = $date_->format("n");
				$array_days[$date__]['booking'] = false;
				if (strtotime($start_date) < strtotime($today)) {
					$array_days[$date__]['past'] = true;
				} else {
					$array_days[$date__]['past'] = false;
				}
				if (array_key_exists($date__, $booking_dates) !== false) {
					$array_days[$date__]['booking'] = true;
				}
			}
		}

		$array_by_month = [];

		foreach ($array_days as $k => $v) {
			if (array_key_exists($v['month'], self::$months) !== false) {
				$array_by_month[$v['month']][$v['date']] = $v;
			}
		}

		return $array_by_month;

	}

	static public function getBookingDates() {
		$db = DB::connectDB();
		if (!$db) {
			exit("Не установлено соединение с ДБ");
		}

		$query = "SELECT * FROM ".self::$table."";
		$result = mysqli_query($db, $query);
		if (!$result) {
			exit("Ошибка при выборке данных");
		}

		$result_array = [];
		while ($row = mysqli_fetch_assoc($result)) {
			$result_array[$row['date_booking']] = $row;
		}
		return $result_array;

	}

	static public function addBooking($date_, $phone) {
		$booking_dates = self::getBookingDates();
		if (array_key_exists($date_, $booking_dates) === false && 
			(strtotime($date_) >= strtotime(date("j-m-Y"))) &&
			(preg_match(self::PATTERN_PHONE, $phone) !== false)) {
			$query_insert = "INSERT INTO ".self::$table." (`date_booking`, `phone`) VALUES ('".$date_."', '".$phone."')";
			$result_insert = mysqli_query(DB::$connect, $query_insert);
			if ($result_insert) {
				return true;
			}
		} 
		return false;

	}

}

?>