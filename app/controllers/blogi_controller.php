<?php

  class BlogiController extends BaseController{
	public static function show($bloginnimi) {
		$blogi = Blogi::find($bloginnimi);
		self::render_view('blogietusivu.html', array('blogi', => $blogi));
	}
  }
