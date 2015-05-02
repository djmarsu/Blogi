<?php

class PostausController extends BaseController {
  public static function show($id) {
    $postaus = Postaus::find($id);
    $kategoriat = Kategoria::postauksen_kategoriat($id);
    View::make('postaus/esittely.html', array('postaus' => $postaus, 'kategoriat' => $kategoriat));
  }

  public static function create() {
    View::make('postaus/uusi.html');
  }

  public static function store() {
    $params = $_POST;

    $julkaistu = 'n';

    if (isset($params['julkaistu']) && $params['julkaistu'] == 'jees') {
      $julkaistu = 'y';
    }

    $attributes = array(
      'blogi' => 'koolo',
      'otsikko' => $params['otsikko'],
      'leipateksti' => $params['leipateksti'],
      'julkaistu' => $julkaistu
    );

    $postaus = new Postaus($attributes);

    $errors = $postaus->errors();
    if (count($errors) == 0) {
      $id = $postaus->save();

      $kategoriat = $params['kategoriat'];
      KategoriaController::kategorizoi($kategoriat, $id, $attributes);

      Redirect::to('/postaus/' . $id, array('message' => 'Postaus lisätty onnistuneesti!'));
    } else{
      View::make('postaus/uusi.html', array('errors' => $errors, 'attributes' => $attributes));
    }
  }

  public static function edit($id) {
    $postaus = Postaus::find($id);
    // TODO korjaa tää joskus aiva kauheen näkönen...
    // mutta ei jaksa käyttää javascriptiä????
    $kategoriatruma = Kategoria::postauksen_kategoriat($id);
    $kategoriat = "";
    foreach ($kategoriatruma as $kategoria) {
      $kategoriat .= $kategoria->nimi;
      $kategoriat .= ",";
    }
    if (!empty($kategoriat)) {
      $kategoriat = substr($kategoriat, 0, -1);
    }
    View::make('postaus/edit.html', array('attributes' => $postaus, 'kategoriat' => $kategoriat));
  }

  public static function update($id) {
    $params = $_POST;
    
    $juklaistu = 'n';
    if (isset($params['julkaistu'])) {
      $julkaistu = 'y';
    }

    $attributes = array(
      'blogi' => 'koolo',
      'id' => $id,
      'otsikko' => $params['otsikko'],
      'leipateksti' => $params['leipateksti'],
      'julkaistu' => $julkaistu
    );

    $postaus = new Postaus($attributes);
    $errors = $postaus->errors();

    if (count($errors) > 0) {
      View::make('postaus/edit.html', array('errors' => $errors, 'attributes' => $attributes));
    } else {
      $postaus->update($id);
      Kategoria::poista_postaus($id);
      $kategoriat = $params['kategoriat'];
      $kategoriat = trim($kategoriat);
      if (!empty($kategoriat)) {
        KategoriaController::kategorizoi($kategoriat, $id, $attributes);
      }
      
      Redirect::to('/postaus/' . $id, array('message' => 'muokattu'));
    }
  }

  public static function destroy($id){
    $postaus = Postaus::find($id);
    $kategoriaz = Kategoria::postauksen_kategoriat($id);

    foreach ($kategoriaz as $kategoria) {
      Kategoria::poista_postaus($id);
    }
    $postaus->destroy($postaus->id);
    Redirect::to('/', array('message' => 'postaus ' . $postaus->otsikko .' poistettu'));
  }
}
