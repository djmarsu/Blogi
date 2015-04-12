<?php

class KategoriaController extends BaseController {
  public static function luokategoria($nimi) {
  }

  public static function kategorizoi($kategoriat, $postausid) {
    $kategoriapalaset = explode(",", $kategoriat);
    foreach ($kategoriapalaset as $kategoria) {
      if (!empty($kategoria)) {
        $kategoria = new Kategoria(array(
          'nimi' => $kategoria
        ));

        $kategoria->luo();
        $kategoria->liita_postaukseen($postausid);
      }
    }

  }
}

