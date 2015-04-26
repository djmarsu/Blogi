<?php
class Postaus extends BaseModel {
  public $id, $blogi, $pvm, $otsikko, $leipateksti, $julkaistu;

  public function __construct($attributes) {
    parent::__construct($attributes);
    $this->validators = array('validate_otsikko', 'validate_leipateksti');
  }

  public function validate_leipateksti() {
    $errors = array();
    if ($this->leipateksti == '' || $this->leipateksti == null) {
        $errors[] = "Tyhjä postaus ei ole järkevä..";
    }
    return $errors;
  }

  public function validate_otsikko() {
    $errors = array();
    if ($this->otsikko == '' || $this->otsikko == null) {
      $errors[] = "ei saa olla tyhjä otsikko";
    }
    return $errors;
  }

  public static function all() {
    $query = DB::connection()->prepare('SELECT * FROM Postaus ORDER BY id DESC');
    $query->execute();
    $rows = $query->fetchAll();
    $postaukset = array();

    foreach ($rows as $row) {
      $postaukset[] = new Postaus(array(
        'id' => $row['id'],
        'blogi' => $row['blogi'],
        'pvm' => $row['pvm'],
        'otsikko' => $row['otsikko'],
        'leipateksti' => $row['leipateksti'],
        'julkaistu' => $row['julkaistu']
      ));
    }

    return $postaukset;
  }

  public static function find($id) {
    $query = DB::connection()->prepare('SELECT * FROM Postaus WHERE id = :id LIMIT 1');
    $query->execute(array('id' => $id));
    $row = $query->fetch();

    if ($row) {
      $postaus = new Postaus(array(
        'id' => $row['id'],
        'blogi' => $row['blogi'],
        'pvm' => $row['pvm'],
        'otsikko' => $row['otsikko'],
        'leipateksti' => $row['leipateksti'],
        'julkaistu' => $row['julkaistu']
      ));
      return $postaus;
    }

    return null;
  }

  public function save() {
    // HOX KÄYTÄ TÄTÄ $kayttaja = BaseController::get_user_logged_in();
    //                $kayttaja->nimi
    $query = DB::connection()->prepare("INSERT INTO Postaus (blogi, pvm, otsikko, leipateksti, julkaistu) VALUES ('koolo', current_date, :otsikko, :leipateksti, :julkaistu) RETURNING id");
    $query->execute(array('otsikko' => $this->otsikko, 'leipateksti' => $this->leipateksti, 'julkaistu' => $this->julkaistu));
    $row = $query->fetch();
    return $row['id'];
  }

  public function update($id) {
//    $query = DB::connection()->prepare('UPDATE Postaus SET otsikko = :otsikko, leipateksti = :leipateksti, julkaistu = :julkaistu WHERE id = :id');
    $query = DB::connection()->prepare('UPDATE Postaus SET otsikko = :otsikko, leipateksti = :leipateksti, julkaistu = :julkaistu WHERE id = :id');
//    $query->execute(array('otsikko' => $this->otsikko, 'leipateksti' => $this->leipateksti, 'julkaistu' => $this->julkaistu, 'id' => $this->id));
//    $query->execute(array('otsikko' => $this->otsikko, 'leipateksti' => $this->leipateksti, 'id' => $id));
    $query->execute(array('otsikko' => $this->otsikko, 'leipateksti' => $this->leipateksti, 'julkaistu' => $this->julkaistu, 'id' => $id));



//    $query = DB::connection()->prepare("UPDATE Postaus SET otsikko = 'morjes', leipateksti = 'morjes2' WHERE id = :id");
//    $query->execute(array('id' => $this->id));
//    $row = $query->fetch();
  }

  public function diztroy($iid) {
    $query = DB::connection()->prepare("DELETE FROM Postaus WHERE id = :id");
    $query->execute(array('id' => $iid));
    //Kint::dump($query);
  }

  public static function kategorioittain($nimi) {
    $query = DB::connection()->prepare('SELECT * FROM PostauksenKategoria WHERE kategoriannimi = :nimi');
    $query->execute(array('nimi' => $nimi));
    $rows = $query->fetchAll();
    $postaukset = array();

    foreach ($rows as $row) {
      $postaukset[] = Postaus::find($row['postausid']);
    }

    return $postaukset;
  }
}
