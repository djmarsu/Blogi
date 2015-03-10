<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/login', function() {
    HelloWorldController::login();
  });

  $routes->get('/prujulistaus', function() {
    HelloWorldController::prujulistaus();
  });

  $routes->get('/edit', function() {
    HelloWorldController::edit();
  });

  $routes->get('/signup', function() {
    HelloWorldController::signup();
  });
