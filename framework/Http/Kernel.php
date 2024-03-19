<?php

namespace Framework\Http;
use Framework\Router\Router;

use Framework\Http\Exceptions\RouteNotFoundException;
use Framework\Http\Exceptions\HttpException;

class Kernel
{
  public function __construct(private Router $router){}

  public function handle(Request $request): Response{

    try{
      [$routeHandler, $vars] = $this->router->dispatch($request);
    
      $response = call_user_func_array($routeHandler, $vars);
    }catch(HttpException $exception){
      $response = new Response($exception->getMessage(), $exception->getStatusCode());
    }catch(\Throwable $exception){
      $response = new Response($exception->getMessage(), 500);
    }
    

    return $response;
  }
}