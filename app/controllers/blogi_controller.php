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

	public static function show($bloginnimi) {
		$blogi = Blogi::find($bloginnimi);
	//  Render::view('blogietusivu.html', array('blogi', => $blogi));
 // 		View::make('blogietusivu.html' /*, array('blogi', => $blogi)*/);
	   Redirect::to('/', array('message' => 'onnistuiii'));
	}

	public static function etusivu() {
		View::make('etusivu.html');
	}

	public static function postaus() {
		View::make('postaus.html');
	}

	public static function postaus_muokkaus() {
		View::make('postaus_muokkaus.html');
	}

	public static function listaus() {
		View::make('listaus.html');
	}

/*  public static function showkokeilu() {
    $kokeiluvaan = Blogi::find("tes");
		View::make('blogietusivu.html');
	}*/
}
