<?php

namespace Framework\Container;

use Framework\Container\Exceptions\ContainerException;

class Container implements \Psr\Container\ContainerInterface
{
  private array $services = [];

  public function add(string $id, string|object $concrete = null){

    if(is_null($concrete)){

      if(!class_exists($id)){
        throw new ContainerException();
      }

      $concrete = $id; 
    }

    $this->services[$id] = $concrete;
  }

  public function get(string $id){

    if(!$this->has($id)){
      if(!class_exists($id)){

        throw new ContainerException("Services $id not found");
      }

      $this->add($id);
    }

    $instance = $this->resolve($this->services[$id]);

    return $instance;
  }

  public function has(string $id): bool{
    return array_key_exists($id, $this->services);
  }

  private function resolve($class){
    $reflectionClass = new \ReflectionClass($class);
    
    if(is_null($reflectionClass->getConstructor())){
      return $reflectionClass->newInstance();
    }

    $constructorParams = $reflectionClass->getConstructor()->getParameters();
    $classDependencies = $this->resolveClassDependencies($constructorParams);
    
    return $reflectionClass->newInstanceArgs($classDependencies);
  }

  private function resolveClassDependencies(array $constructorParams): array{
    $classDependencies = [];

    foreach($constructorParams as $param){
      $classDependencies[] = $this->get($param->getType()->getName()); 
    }

    return $classDependencies;
  }
}