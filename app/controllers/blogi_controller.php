<?php

class BlogiController extends BaseController {
  public static function index() {
    if (!Kayttaja::onko_kayttajaa()) {
      View::make('kayttaja/signup.html');
    } else {
      $postaukset = Postaus::all();
      View::make('postaus/listaus.html', array('postaukset' => $postaukset));
    }
  }
}
