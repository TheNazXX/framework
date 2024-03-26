<?php 

namespace Tests;

use PHPUnit\Framework\TestCase;
use Framework\Container\Exceptions\ContainerException;

class ContainerTest extends TestCase
{
  public function test_get(){
    $container = new \Framework\Container\Container();
    
    $container->add($id = 'some-class-1', SomeClassOne::class);
    $this->assertInstanceOf(SomeClassOne::class, $container->get($id));
  }

  public function test_exception(){
    $container = new \Framework\Container\Container();

    $this->expectException(ContainerException::class);
    $container->add('foo');
  }

  public function test_has(){
    $container = new \Framework\Container\Container();
    
    $container->add($id = 'some-class-1', SomeClassOne::class);
    $this->assertTrue($container->has($id));
    $this->assertFalse($container->has('no-class'));
  }

  public function test_recursively_autowiterd(){
    $container = new \Framework\Container\Container();

    $container->add($id = 'second-class', SomeClassSecond::class);
    $class = $container->get($id);
    $this->assertInstanceOf(SomeClassOne::class, $class->getDependency());
  }
}

class SomeClassOne{
  public function __construct(){}
};

class SomeClassSecond{
  public function __construct(private SomeClassOne $someDependency){}

  public function getDependency(){
    return $this->someDependency;
  }
};