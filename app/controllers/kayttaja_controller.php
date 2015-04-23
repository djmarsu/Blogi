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
 
      if (!Kayttaja::onko_kayttajaa()) {
        if (count($errors) == 0) {
          if (Kayttaja::find($kayttaja->nimi)) {
            Redirect::to('/', array('errors' => array("saman niminen ($kayttaja->nimi) käyttäjä on jo luotu mitä tehdä?")));
          } else {
            $nimi = Kayttaja::create($attributes);
            $_SESSION['nimi'] = $attributes['nimi'];
            Redirect::to('/', array('message' => "olet nyt rekisteröitynyt (kirjaudutin sisään)!"));
          }
        } else {
          View::make('kayttaja/signup.html', array('errors' => $errors));
        }
      } else {
//         Redirect::to('/login', array('errors' => array("käyttäjä on jo tehty, ota yhteys sql tukihenkilöön/vastaavaan")));
        View::make('kayttaja/login.html', array('errors' => array("käyttäjä on jo tehty, ota yhteys sql tukihenkilöön/vastaavaan")));
      }
    }

    public static function login() {
      View::make('login.html');
    }

    public static function handle_login() {
      $params = $_POST;
      $kayttaja = Kayttaja::authenticate($params['nimi'], $params['salasana']);
      if(!$kayttaja) {
          View::make('/kayttaja/login.html', array('errors' => array('Väärä käyttäjätunnus tai salasana.')));
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
