<?php

namespace hcf\listeners;

use pocketmine\utils\TextFormat;
use pocketmine\event\{
  Listener,
  player\PlayerJoinEvent,
  player\PlayerLoginEvent,
  player\PlayerQuitEvent,
  player\PlayerInteracgEvent,
  player\PlayerCreationEvent
};

use pocketmine\Server;

use hcf\{
  PlayerHCF,
  Loader,
  tasks\async\DataLoad,
  tasks\async\DataSave,
  translation\Translation
};

use libs\scoreboard\Scoreboard;

class PlayerListener implements Listener 
{
  
  public function joinEvent(PlayerJoinEvent $event): void
  {
    $player = $event->getPlayer();
    if (!$player instanceof PlayerHCF) return;
    if (!$player->hasPlayedBefore()) {
    Loader::getInstance()->getServer()->getAsyncPool()->submitTask(new DataLoad($player));
    }
    $event->setJoinMessage(TextFormat::colorize(Translation::addMessage("message-welcome", ["name" => $player->getName()])));
    //$scoreboard = Scoreboard::create($player, TextFormat::colorize(Loader::getInstance()->getConfig()->get("server-name") . "&r | " . Loader::getInstance()->getConfig()->get("server-color") . "Map: #" . Loader::getInstance()->getConfig()->get("server-map")));
    //Loader::getInstance()->getScheduler()->scheduleRepeatingTask(new ScoreboardTask($scoreboard), 30);
 }
  
  /**public function preLogin(PlayerLoginEvent $event): void
  {
    $player = $event->getPlayer();
    if (!$player instanceof PlayerHCF) return;
  }**/
  
  public function quitEvent(PlayerQuitEvent $event): void
  {
    $player = $event->getPlayer();
    
    $event->setQuitMessage(TextFormat::colorize(Translation::addMessage("message-leave", ["name" => $player->getName()])));
  }
  
  public function creation(PlayerCreationEvent $event): void 
  {
    if ($event->getPlayerClass() !== PlayerHCF::class) {
      $event->setPlayerClass(PlayerHCF::class);
      return;
    }
  }
  
}
