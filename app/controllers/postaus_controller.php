<?php

class PostausController extends BaseController {
  public static function index() {
    $postaukset = Postaus::all();
    View::make('postaus/listaus.html', array('postaukset' => $postaukset));
  }

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

    $blii = 'n';

    if (isset($_POST['julkaistu']) && $_POST['julkaistu'] == 'jees') {
      $blii = 'y';
    }

    $attributes = array(
      'blogi' => 'koolo',
      'otsikko' => $params['otsikko'],
      'leipateksti' => $params['leipateksti'],
      'julkaistu' => $blii
    );

    $postaus = new Postaus($attributes);

    $errors = $postaus->errors();

    Kint::dump($errors);
    foreach($errors as $error) {
      Kint::dump($error);
    }
    if (count($errors) == 0) {
      $id = $postaus->save();

      $kategoriat = $params['kategoriat'];
      KategoriaController::kategorizoi($kategoriat, $id);

      Redirect::to('/postaus/' . $id, array('message' => 'Postaus lisätty onnistuneesti!'));
    } else{
      View::make('postaus/uusi.html', array('errors' => $errors, 'attributes' => $attributes));
    }
  }

  public static function edit($id) {
    $postaus = Postaus::find($id);
    View::make('postaus/edit.html', array('attributes' => $postaus));
  }

  public static function update($id) {
    $params = $_POST;
    
    $blii = 'n';
    if (isset($_POST['julkaistu'])) {
      $blii = 'y';
    }

    $attributes = array(
      'blogi' => 'koolo',
      'id' => $id,
      'otsikko' => $params['otsikko'],
      'leipateksti' => $params['leipateksti'],
      'julkaistu' => $blii
    );

    $postaus = new Postaus($attributes);
    $errors = $postaus->errors();
//    Kint::dump($postaus);
    $postaus->update($id);

    if (count($errors) > 0) {
      View::make('postaus/edit.html', array('errors' => $errors, 'attributes' => $attributes));
    } else {
      $postaus->update($id);
      Redirect::to('/postaus/' . $id, array('message' => 'muokattu'));
    }
  }

  public static function destroy($id){
    $postaus = Postaus::find($id);
    $kategoriaz = Kategoria::postauksen_kategoriat($id);

    foreach ($kategoriaz as $kategoria) {
      Kategoria::poista_postaus($id);
    }
    $postaus->diztroy($postaus->id);
//    $postaus = new Postaus(array('id' => $id));
//    $postaus->destroy();
    Redirect::to('/', array('message' => 'postaus poistettu'));
  }
}
