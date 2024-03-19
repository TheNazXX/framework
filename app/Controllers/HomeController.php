<?php

namespace App\Controllers;

use Framework\Http\Response;

class HomeController
{
  public function index()
  {
    $content = 'home';

    return new Response($content);
  } 
}