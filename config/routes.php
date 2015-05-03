<?php

  function check_logged_in(){
    BaseController::check_logged_in();
  }

  $routes->get('/', function() {
    BlogiController::index();
  });

  $routes->get('/kategoria/:nimi/muokkaa', 'check_logged_in', function($nimi) {
    KategoriaController::edit($nimi);
  });

  $routes->post('/kategoria/:nimi/muokkaa', 'check_logged_in', function($nimi) {
    KategoriaController::update($nimi);
  });

  $routes->post('/kategoria/:nimi/poista', 'check_logged_in', function($nimi) {
    KategoriaController::destroy($nimi);
  });

  $routes->get('/postaus/:id/muokkaa', 'check_logged_in', function($id) {
	  PostausController::edit($id);
  });

  $routes->post('/postaus/:id/muokkaa', 'check_logged_in', function($id) {
    PostausController::update($id);
  });

  $routes->post('/postaus/:id/poista', 'check_logged_in', function($id) {
    PostausController::destroy($id);
  });

  $routes->post('/postaus/uusi', 'check_logged_in', function() {
    PostausController::store();
  });

  $routes->get('/postaus/uusi', 'check_logged_in', function() {
    PostausController::create();
  });

  $routes->get('/listaus', function() {
	  BlogiController::listaus();
  });

  $routes->get('/login', function() {
    KayttajaController::login();
  });

  $routes->post('/login', function() {
    KayttajaController::handle_login();
  });

  $routes->post('/signup', function() {
    KayttajaController::register();
  });

  $routes->get('/signup', function() {
    KayttajaController::signup();
  });

  $routes->post('/logout', 'check_logged_in', function() {
    KayttajaController::logout();
  });

  $routes->get('/postaus/:id', function($id) {
    PostausController::show($id);
  });

  $routes->get('/kategoriat', function() {
    KategoriaController::listaa();
  });

  $routes->get('/kategoria/:nimi', function($nimi) {
    KategoriaController::show($nimi);
  });

