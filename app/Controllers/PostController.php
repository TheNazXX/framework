<?php

namespace App\Controllers;

use Framework\Http\Response;

class PostController
{
  public function show(int $id)
  {
    $content = "post - {$id}";

    return new Response($content);
  } 
}