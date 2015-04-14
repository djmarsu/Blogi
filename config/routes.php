<?php

  $routes->get('/', function() {
//    PostausController::index();
    BlogiController::index();
  });

  $routes->get('/postaus/:id/muokkaa', function($id) {
	  PostausController::edit($id);
  });

  $routes->post('/postaus/:id/muokkaa', function($id) {
    PostausController::update($id);
  });

  $routes->post('/postaus/:id/poista', function($id) {
    PostausController::destroy($id);
  });

  $routes->post('/postaus/uusi', function() {
    PostausController::store();
  });

  $routes->get('/postaus/uusi', function() {
    PostausController::create();
  });

  $routes->get('/listaus', function() {
	  BlogiController::listaus();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/login', function() {
    KayttajaController::login();
  });

  $routes->post('/login', function() {
    KayttajaController::handle_login();
  });

  $routes->get('/prujulistaus', function() {
    HelloWorldController::prujulistaus();
  });

  $routes->get('/edit', function() {
    HelloWorldController::edit();
  });

  $routes->post('/signup', function() {
    KayttajaController::register();
  });

  $routes->get('/signup', function() {
    KayttajaController::signup();
  });

  $routes->post('/logout', function() {
    KayttajaController::logout();
  });

  $routes->get('/kokeilu', function() {
		BlogiController::showkokeilu();
	});

  $routes->get('/blogi/:nimi', function($nimi) {
    BlogiController::show($nimi);
  });

  $routes->get('/postaus/:id', function($id) { // pitääkö tän olla perimmäisenäää????????
    PostausController::show($id);
  });

  $routes->get('/kategoriat', function() {
    KategoriaController::listaa();
  });

  $routes->get('/kategoria/:nimi', function($nimi) {
    KategoriaController::show($nimi);
  });

 
