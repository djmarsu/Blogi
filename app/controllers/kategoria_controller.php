<?php

class KategoriaController extends BaseController {
  public static function listaa() {
    $kategoriat = Kategoria::all();
    View::make('kategoria/listaus.html', array('kategoriat' => $kategoriat));
  }

  public static function show($nimi) {
    $kategoria = Kategoria::find($nimi);
    $postaukset = Postaus::kategorioittain($nimi);
    View::make('kategoria/esittely.html', array('kategoria' => $kategoria, 'postaukset' => $postaukset));
  }

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

  public static function edit($nimi) {
    $kategoria = Kategoria::find($nimi);
    View::make('kategoria/edit.html', array('attributes' => $kategoria));
  }

  public static function update($nimi) {
    $params = $_POST;
    
    $attributes = array(
      'nimi' => $params['nimi'],
      'kuvaus' => $params['kuvaus'],
    );
    
    $kategoria = new Kategoria($attributes);
    $errors = $kategoria->errors();

    if (count($errors) > 0) {
      View::make('kategoria/edit.html', array('errors' => $errors, 'attributes' => $attributes));
    } else {
      $kategoria->update($nimi);
      Redirect::to('/kategoria/' . $nimi, array('message' => 'muokattu'));
    }
  }
}

