<?php

class Kayttaja extends BaseModel {
  public $nimi, $salasana;

  public static function authenticate($nimi, $salasana) {
    $kayttaja = Kayttaja::find($nimi);
    if ($salasana == $kayttaja->salasana) {
      return $kayttaja;
    }
    return null;
  }
  
  public static function find($nimi) {
    $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE nimi = :nimi LIMIT 1');
    $query->execute(array('nimi' => $nimi));
    $row = $query->fetch();

    if ($row) {
      $kayttaja = new Kayttaja(array(
        'nimi' => $row['nimi'],
        'salasana' => $row['salasana']
      ));
      return $kayttaja;
    }
  
    return null;
  }


