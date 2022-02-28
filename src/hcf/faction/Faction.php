<?php

namespace hcf\faction;

use hcf\Loader;
use hcf\PlayerHCF;
use hcf\translation\Translation;

class Faction 
{
  /** @var String **/
  public $name;
  
  /** @var Position **/
  public $home;
  
  /** @var Player::getName()[] **/
  public $members;
  
  /** @var Int **/
  public $balance;
  
  /** @var Float **/
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
 
  public function setHome(Position $position): void
  {
    $this->home = $position;
  }
  
  public function setMembers(string $username): void
  {
    $this->members[] = $username;
  }
  
  public function setBalance(int $money): void
  {
    $this->balance = $money;
  }
  
  public function setDTR(float $dtr): void
  {
    $this->dtr = $dtr;
  }
  
}
