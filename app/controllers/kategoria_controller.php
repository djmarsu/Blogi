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

  public static function kategorizoi($kategoriat, $postausid, $attributes) {
    $kategoriapalaset = explode(",", $kategoriat);
    foreach ($kategoriapalaset as $kategoria) {
      $kategoria = trim($kategoria);
      if (!empty($kategoria)) {
        $kategoria = new Kategoria(array(
          'nimi' => $kategoria
        ));

        $errors = $kategoria->errors();
        if (count($errors) == 0) {
          $kategoria->luo();
          $kategoria->liita_postaukseen($postausid);
        } else {
          View::make('postaus/uusi.html', array('errors' => $errors, 'attributes' => $attributes));
        }
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

      if (strcmp($nimi, $kategoria->nimi) != 0) {
        // hae alkuperäne kategoria
        $kategoria_alku = Kategoria::find($nimi);
        $postaukset = Postaus::kategorioittain($nimi);

        foreach ($postaukset as $postaus) {
          Kategoria::poista_postauksen_kategoriat($postaus->id);
          $kategoria->luo();
          $kategoria->liita_postaukseen($postaus->id);
          $kategoria->update($nimi);
        }
        Redirect::to('/kategoria/' . $kategoria->nimi, array('message' => 'muokattu'));     
      }

      Redirect::to('/kategoria/' . $nimi, array('message' => 'muokattu'));
    }
  }

  public static function destroy($nimi) {
    Kategoria::destroy($nimi);
    Redirect::to('/', array('message' => 'Kategoria ' . $nimi . ' poistettu'));
  }
}

