<?php

namespace hcf\provider;

use hcf\Loader;
use mysqli;

class MySQLProvider 
{
  
  protected $database;

  public static function connect(): void 
  {
    $loader = Loader::getInstance();
    $sql = new mysqli($loader->getConfig()->get("mysql")["host"], $loader->getConfig()->get("mysql")["user"], $loader->getConfig()->get("mysql")["password"], $loader->getConfig()->get("mysql")["name"], $loader->getConfig()->get("mysql")["port"]);
    if (!$sql) {
      $loader->getLogger()->error("SyntaxError: " . $sql->connect_error);
      $loader->getLogger()->error("Line Error: " . $sql->connect_errno);
      return;
    }
    //$sql->query("");
    $this->database = $sql;
  }
  
  public static function get(): mysqli {
    return $this->database;
  }
  
}