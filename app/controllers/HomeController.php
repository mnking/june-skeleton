<?php

class HomeController extends BaseController
{
    public function hello()
    {
        return View::make('hello');
    }
}