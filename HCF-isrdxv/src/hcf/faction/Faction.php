<?php

namespace hcf\faction;

use hcf\Loader;
use hcf\PlayerHCF;
use hcf\translation\Translation;

class Faction 
{
  
  public $name;
  
  public $home;
  
  public $members;
  
  public $balance;
  
  public $dtr;
  
  public function __construct(string $name, Position $home, array $members, int $balance, float $dtr)
  {
    $this->name = $name;
    $this->home = $home;
    $this->members = $members;
    $this->balance = $balance;
    $this->dtr = $dtr;
  }
  
  public function getName(): string 
  {
    return $this->name;
  }
  
  public function getHome(): Position
  {
    return $this->home;
  }
  
  public function getMembers(): array
  {
    return $this->members;
  }
  
  public function getBalance(): int 
  {
    return $this->balance;
  }
  
  public function getDTR(): float
  {
    return $this->dtr;
  }
 
}
