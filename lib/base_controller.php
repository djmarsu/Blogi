<?php

  class BaseController{
    public static function get_user_logged_in() {
      if (isset($_SESSION['nimi'])){
        $nimi = $_SESSION['nimi'];
        $kayttaja = Kayttaja::find($nimi);
        return $kayttaja;
      } 
      return null;
    }

    public static function check_logged_in() {
        if (!isset($_SESSION['nimi'])) {
            Redirect::to('/login', array('message' => 'Kirjaudu sisään'));
        }
    }
  }
