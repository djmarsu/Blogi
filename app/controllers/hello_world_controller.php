<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
 	// View::make('home.html');
	//echo 'etusivuuu';
	View::make('login.html');
    }

    public static function sandbox(){
      // Testaa koodiasi täällä
      echo 'Hello World!';
    }

    public static function login() {
      View::make('login.html');
    }

    public static function prujulistaus() {
      View::make('prujulistaus.html');
    }

    public static function edit() {
      View::make('edit.html');
    }

    public static function signup() {
      View::make('signup.html');
    }
  }
