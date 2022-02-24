<?php

namespace hcf\tasks;

use pocketmine\scheduler\Task;
use pocketmine\utils\TextFormat;

use hcf\Loader;

class ScoreboardTask extends Task
{
  
  public ?Scoreboard $scoreboard;
  
  public function __construct(Scoreboard $scoreboard) 
  {
    $this->scoreboard = $scoreboard;
    if (!$scoreboard->getPlayer()->isOnline()) {
      $this->cancelTask();
    }
  }
  
  public function getScoreboard(): ?Scoreboard
  {
    return $this->scoreboard ?? null;
  }
  
  public function onRun(): void
  {
    $lines = [];
    //code..
    //$this->getScoreboard()->setLine(($line + 1), $text);
    
  }
  
  public function cancelTask(): void
  {
    Loader::getInstance()->getScheduler()->cancelTask($this->getTaskId());
  }
}
