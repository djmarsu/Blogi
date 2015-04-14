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

      $kayttaja = new Kayttaja($attributes);
      $errors = $kayttaja->errors();  
//      Kint::dump($errors);
//      Kint::dump("eipä siinä,,");
 
      if (!Kayttaja::onko_kayttajaa()) {
        if (count($errors) == 0) {
          $nimi = Kayttaja::create($attributes);
          $_SESSION['nimi'] = $attributes['nimi'];
          Redirect::to('/login', array('message' => "olet nyt rekisteröitynyt!"));
        } else {
        View::make('kayttaja/signup.html', array('errors' => $errors));
        }
      } else {
//         Redirect::to('/login', array('errors' => array("käyttäjä on jo tehty, ota yhteys sql tukihenkilöön/vastaavaan")));
        View::make('kayttaja/login.html', array('errors' => array("käyttäjä on jo tehty, ota yhteys sql tukihenkilöön/vastaavaan")));
      }
      
      //Redirect::to('/', array('message' => 'onnistuiii'));
      //self::Redirect::to('/login');
    }

    public static function login() {
      View::make('login.html');
    }

    public static function handle_login() {
      $params = $_POST;
      $kayttaja = Kayttaja::authenticate($params['nimi'], $params['salasana']);

      if (!$kayttaja) {
          Redirect::to('/login', array('errors' => 'Väärä käyttäjätunnus tai salasana.'));
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
