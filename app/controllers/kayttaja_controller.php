<?php

  class KayttajaController extends BaseController {
    public static function signup() {
      View::make('kayttaja/signup.html');
    }

    public static function register() {
      $params = $_POST;

      $attributes = array(
	'nimi' => $params['nimi'],
	'salasana' => $params['salasana']
      );

      Redirect::to('/', array('message' => 'onnistuiii'));
      //self::Redirect::to('/login');
    }
  }
