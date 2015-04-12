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

    public static function login() {
      View::make('login.html');
    }

    public static function handle_login() {
      $params = $_POST;
      $kayttaja = Kayttaja::authenticate($params['nimi'], $params['salasana']);

      if (!$kayttaja) {
          Redirect::to('/login', array('error' => 'Väärä käyttäjätunnus tai salasana.'));
      } else {
          $_SESSION['nimi'] = $kayttaja->nimi;
          Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $kayttaja->nimi . '.'));
      }
    }

    public static function logout() {
        $_SESSION['nimi'] = null;
        Redirect::to('/', array('message' => 'Olet nyt kirjautunut ulos.'));
    }
  }
