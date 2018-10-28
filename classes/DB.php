<?php 

class DB {
	
	static public $params = [
		'host' => 'localhost',
		'user' => 'root',
		'password' => '',
		'db' => 'starta_test'
	];

	static public $connect = false;

	static public function connectDB() {
		if (!self::$connect) {
			self::$connect = mysqli_connect(
				self::$params['host'],
				self::$params['user'],
				self::$params['password'],
				self::$params['db']
			);
			mysqli_set_charset(self::$connect, "utf-8");
		}
		return self::$connect;
	}

}

?>