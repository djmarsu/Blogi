<?php

class Kayttaja extends BaseModel {
  public $nimi, $salasana;

  public function __construct($attributes) {
    parent::__construct($attributes);
    $this->validators = array('validate_nimi', 'validate_salasana');
  }

  public function validate_nimi() {
    $errors = array();

    if ($this->nimi == '' || $this->nimi == null) {
        $errors[] = "anna nimi(merkki)";
    }

    if (strlen($this->nimi) > 50) {
      $errors[] = "nimi(merkin) pituus liian pitkä (yli 50 merkkiä)";
    }

    return $errors;
  }

  public function validate_salasana() {
    $errors = array();

    if ($this->salasana == '' || $this->salasana == null) {
        $errors[] = "salasana ei saa olla tyhjä!";
    }
 
    if (strlen($this->salasana) > 50) {
      $errors[] = "salasanan pituus liian pitkä (yli 50 merkkiä)";
    }

   return $errors;

  }

  public static function authenticate($nimi, $salasana) {
    $kayttaja = Kayttaja::find($nimi);

    if ($kayttaja && $salasana == $kayttaja->salasana) {
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

  // TODO turhaa toistoa? täähän on melkeen ku find..
  public static function onko_kayttajaa() {
    // huippu jättää limit tohon niin ei tarvi sitten rivejä käydä läpi..emt
    $query = DB::connection()->prepare('SELECT * FROM Kayttaja LIMIT 1');
    $query->execute();
    $row = $query->fetch();

    if ($row) {
      return true;
    }

    return false;
  }

  public static function create($attributes) {
    $query = DB::connection()->prepare('INSERT INTO Kayttaja (nimi, salasana) VALUES (:nimi, :salasana) RETURNING nimi');
    $query->execute($attributes);
    $row = $query->fetch();
    if ($row) {
      return $row['nimi'];
    }
    return null;
  }
}
