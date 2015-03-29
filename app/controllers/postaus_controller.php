<?php

class PostausController extends BaseController {
  public static function index() {
    $postaukset = Postaus::all();
    View::make('postaus/listaus.html', array('postaukset' => $postaukset));
  }

  public static function show($id) {
    $postaus = Postaus::find($id);
    View::make('postaus/esittely.html', array('postaus' => $postaus));
  }

  public static function create() {
    View::make('postaus/uusi.html');
  }

  public static function store() {
    $params = $_POST;

    $postaus = new Postaus(array(
      'id' => '7777777',
      'blogi' => 'koolo',
      'pvm' => 'i90dasi90asdi90',
      'otsikko' => $params['otsikko'],
      'leipateksti' => $params['leipateksti'],
      'published' => 'y'
    ));

    $postaus->save();
    Redirect::to('/');
    //print_r($params); /* TODO joo tee tää joskus loppuun */ 
  }
}
