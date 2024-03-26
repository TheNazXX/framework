<?php

namespace Framework\Http\Exceptions;

class HttpException extends \Exception{
  private int $statusCode = 400;
  
  public function setStatusCode(int $statusCode){
    $this->statusCode = $statusCode;
  }

  public function getStatusCode(): int{
    return $this->statusCode;
  }
}