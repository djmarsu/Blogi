<?php
  class Blogi extends BaseModel {
		public $nimi, $kenen, $osoite;

    public static function find($bloginnimi) {
      $query = DB::connection()->prepare('SELECT * FROM Blogi WHERE nimi = :bloginnimi LIMIT 1');
      $query->execute(array('nimi' => $bloginnimi));
      $row = $query->fetch();

      if ($row) {
        $blogi = new Blogi(array(
					'nimi' => $row[̈́'nimi'];
					'kenen' => $row['kenen'];
					'osoite' => $row['osoite'];
				));
				return $blogi;
			}
			return null;
		}
  }
