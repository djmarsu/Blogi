<?php

class PostausController extends BaseController {
  public static function create() {
    View::make('postaus/uusi.html');
  }

  public static function store() {
    $params = $_POST;

    print_r($params);
  }
}
