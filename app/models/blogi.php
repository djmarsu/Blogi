<?php
  class Blogi extends BaseModel {
		public $nimi, $kenen, $osoite;

/*		public function __construct($nimi, $kenen, $osoite) {
			$this->nimi = $nimi;
			$this->kenen = $kenen;
			$this->osoite = $osoite;
		}
*/
		public function __construct($attributes) {
			parent::__construct($attributes);
		}

    public static function find($nimi) {
//      $query = DB::connection()->prepare('SELECT * FROM Blogi WHERE nimi = 'tes' LIMIT 1');
//			$query->execute();
//      $query->execute(array('nimi' => $nimi));
//      $row = $query->fetch();

/*			$rows = DB::query('SELECT * FROM Blogi WHERE NIMI = 'tes' LIMIT 1');
			if(count($rows) > 0) {
				$row = $rows[0];
				
*/
//      if ($row) {
/*        $blogi = new Blogi(array(
					'nimi' => $row[̈́'nimi'];
					'kenen' => $row['kenen'];
					'osoite' => $row['osoite'];
				));
				return $blogi;
			}
			return $blogi;
*/		
			//$query = DB::connection()->prepare('SELECT * FROM Blogi WHERE nimi = :nimi LIMIT 1', array('nimi' => $nimi));
			$query = DB::connection()->prepare('SELECT * FROM Blogi WHERE nimi = 'tes' LIMIT 1');
			$query->execute();
			$row = $query->fetch();
			if($row){
				$huoh = new Blogi(array(
					'nimi' => row['nimi'],
					'kenen' => row['kenen'],
					'osoite' => row['osoite']
				));
				return $huoh;
  // Käyttäjä löytyi, palautetaan löytynyt käyttäjä oliona
			}else{
  // Käyttäjää ei löytynyt, palautetaan null
				return null;
}




		}
  }
