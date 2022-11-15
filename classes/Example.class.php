<?php
	class Example {
		//muutujad, klassis omadused ehk properties
		//privaatsed ja avalikud
		private $secret_value;
		public $known_value = 7;
		private $received_value;
		
		//funktsioonid, klassis meetodid ehk methods
		
		//eriline funktsioon/meetod on konstruktor, mis käivitub klassi kasutuselvõtul kohe, üks kord
		function __construct($value){
			echo "Klass käivitus!<br>";
			$this->secret_value = mt_rand(1,10);
			echo "Salajane väärtus on: " .$this->secret_value ."<br>";
			$this->received_value = $value;
			$this->multiply();
		}
		//destruktor, mis käivitub, kui objekt tühistatakse
		function __destruct(){
			echo "Klass lõpetas, ongi kõik!<br>";
		}
		
		private function multiply(){
			echo "Privaatsete väärtuste korrutis on: " .$this->secret_value * $this->received_value ."<br>";
		}
		
		public function add(){
			echo "Privaatsete väärtuste summa on: " .$this->secret_value + $this->received_value ."<br>";
		}
	}//class lõppeb