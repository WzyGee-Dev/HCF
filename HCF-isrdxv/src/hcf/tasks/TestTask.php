<?php

namespace hcf\tasks;

use pocketmine\scheduler\Task;

use hcf\Loader;
use hcf\PlayerHCF;

class TestTask extends Task 
{
  private PlayerHCF $player;
  
  private string $username;
  
  private string $item;
  
  private int $time;
  
  public function __construct(PlayerHCF $player, string $item, int $time = time()) 
  {
    $this->player = $player;
    $this->username = $player->getName();
    $this->item = $item;
    $this->time = $time + time();
  }
  
  public function onRun(): void
  {
    if (isset($this->player) & !$this->player->isOnline()) {
      Loader::getInstance()->getScheduler()->cancelTask($this->getTaskId());
      return;
    }
    if ($this->time === 0) {
      switch($this->item) {
        case "EnderPearl":
          $this->player->setAntiTrapper(false);
        break;
        case "AntiTrapper":
          $this->player->setAntiTrapper(false);
        break;
      }
      Loader::getInstance()->getScheduler()->cancelTask($this->getTaskId());
      return;
    }
   switch($this->item) {
     case "EnderPearl":
       $this->player->setEnderPearl(true);
     break;
     case "AntiTrapper":
       $this->player->setAntiTrapper(true);
     break;
   }
   $this->time--;
  }
  
}