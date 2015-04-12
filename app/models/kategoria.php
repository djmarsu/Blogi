<?php
class Kategoria extends BaseModel {
  public $nimi;

  public function __construct($attributes) {
    parent::__construct($attributes);
  }

  public function luo() {
    $query = DB::connection()->prepare("INSERT INTO Kategoria (nimi) VALUES (:nimi) RETURNING nimi");
    $query->execute(array('nimi' => $this->nimi));
    $row = $query->fetch();
    /* tässä piti jotakin tehä */
  }

  public function liita_postaukseen($postausid) {
    $query = DB::connection()->prepare("INSERT INTO PostauksenKategoria (postausID, kategoriannimi) VALUES (:postausid, :kategoriannimi)");
    $query->execute(array('postausid' => $postausid, 'kategoriannimi' => $this->nimi));
  }
}

