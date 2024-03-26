<?php 

namespace Framework\Router;

use Framework\Http\Request;
use Framework\Router\RouterInterface;
use function FastRoute\simpleDispatcher;
use FastRoute\RouteCollector;
use FastRoute\Dispatcher;
use Framework\Http\Exceptions\MethodNotAllowedException;
use Framework\Http\Exceptions\RouteNotFoundException;

class Router implements RouterInterface
{
  public function dispatch(Request $request){

    [$handler, $vars] = $this->extractRouteInfo($request);


    if(is_array($handler)){
      [$controller, $method] = $handler;
      $handler = [new $controller, $method];
    }



    return [$handler, $vars];
  }

  public function extractRouteInfo(Request $request): array
  {
    $dispatcher = simpleDispatcher(function(RouteCollector $collector){
      $routes = include ROOT . '/routes/web.php';

      foreach($routes as $route){
        $collector->addRoute(...$route);
      };
    });

    $routeInfo = $dispatcher->dispatch(
      $request->getMethod(),
      $request->getUri()
    );



    switch ($routeInfo[0]){
      case Dispatcher::FOUND: {
        return [$routeInfo[1], $routeInfo[2]];
      }
      case Dispatcher::METHOD_NOT_ALLOWED: {
        $allowedMethods = implode(', ', $routeInfo[1]);
        $exception = new MethodNotAllowedException("Supported HTTP Methods: $allowedMethods");
        $exception->setStatusCode(405);
        throw $exception;
      }
      default: {
        $exception = new RouteNotFoundException("Route not found");
        $exception->setStatusCode(404);
        throw $exception;
      }
    }
  }
}