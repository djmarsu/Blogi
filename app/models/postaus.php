<?php
class Postaus extends BaseModel {
  public $id, $blogi, $pvm, $otsikko, $leipateksti, $julkaistu;

  public function __construct($attributes) {
    parent::__construct($attributes);
    $this->validators = array('validate_leipateksti');
  }

  public function validate_leipateksti() {
    $errors = array();
//    if ($this->leipateksti == '' || $this->leipateksti == null || strlen($this->leipateksti) < 3) {
        $errors[] = "Tyhjä postaus ei ole järkevä..";
 //   }
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
    $query = DB::connection()->prepare("INSERT INTO Postaus (blogi, pvm, otsikko, leipateksti, julkaistu) VALUES ('koolo', current_date, :otsikko, :leipateksti, :julkaistu) RETURNING id");
    $query->execute(array('otsikko' => $this->otsikko, 'leipateksti' => $this->leipateksti, 'julkaistu' => $this->julkaistu));
    $row = $query->fetch();
    return $row['id'];
  }

  public function update() {
    $query = DB::connection()->prepare('UPDATE Postaus SET otsikko = :otsikko, leipateksti = :leipateksti, julkaistu = :julkaistu WHERE id = :id');
    $query->execute(array('otsikko' => $this->otsikko, 'leipateksti' => $this->leipateksti, 'julkaistu' => $this->julkaistu, 'id' => $this->id));
  }

  public function destroy() {
    $query = DB::connection()->prepare("DELETE FROM Postaus WHERE id = :id");
    $query->execute(array('id' => $this->id));
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
