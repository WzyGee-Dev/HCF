<?php

namespace hcf\listeners;

use pocketmine\utils\TextFormat;
use pocketmine\event\{
  Listener,
  player\PlayerJoinEvent,
  player\PlayerQuitEvent,
  player\PlayerInteracgEvent,
  player\PlayerCreationEvent
};

use pocketmine\Server;

use hcf\{
  PlayerHCF,
  Loader
};

use libs\scoreboard\Scoreboard;

class PlayerListener implements Listener 
{
  
  public function joinEvent(PlayerJoinEvent $event): void
  {
    $player = $event->getPlayer();
    
    //$event->setJoinMessage(TE::GRAY."[".TE::GREEN."+".TE::GRAY."] ".TE::GREEN.$player->getName().TE::GRAY." entered the server.");
    $scoreboard = Scoreboard::create($player, TextFormat::colorize(Loader::getInstance()->getConfig()->get("server-name") . "&r | " . Loader::getInstance()->getConfig()->get("server-color") . "Map: #" . Loader::getInstance()->getConfig()->get("server-map")));
    Loader::getInstance()->getScheduler()->scheduleRepeatingTask(new ScoreboardTask($scoreboard), 30);
 }
  
  public function quitEvent(PlayerQuitEvent $event): void
  {
    $player = $event->getPlayer();
    
    //$event->setQuitMessage(TE::GRAY."[".TE::RED."-".TE::GRAY."]".TE::RED.$player->getName().TE::GRAY." left the server.");
  }
  
  public function creation(PlayerCreationEvent $event): void 
  {
    if ($event->getPlayerClass() !== PlayerHCF::class) {
      return;
    }
    $event->setPlayerClass(PlayerHCF::class);
  }
  
}
