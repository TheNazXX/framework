<?php 

namespace Framework\Router;
use Framework\Http\Request;

interface RouterInterface {
  public function dispatch(Request $request);
}