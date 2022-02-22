<?php

namespace hcf\listeners;

use pocketmine\utils\TextFormat as TE;
use pocketmine\event\{
  Listener,
  player\PlayerJoinEvent,
  player\PlayerQuitEvent,
  player\PlayerInteracgEvent,
  player\PlayerCreationEvent
};

use pocketmine\Server;

use hcf\PlayerHCF;

class PlayerListener implements Listener 
{
  
  public function joinEvent(PlayerJoinEvent $event): void
  {
    $player = $event->getPlayer();
    
    $event->setJoinMessage(TE::GRAY."[".TE::GREEN."+".TE::GRAY."] ".TE::GREEN.$player->getName().TE::GRAY." entered the server.");
 }
  
  public function quitEvent(PlayerQuitEvent $event): void
  {
    $player = $event->getPlayer();
    
    $event->setQuitMessage(TE::GRAY."[".TE::RED."-".TE::GRAY."]".TE::RED.$player->getName().TE::GRAY." left the server.");
  }
  
  public function creation(PlayerCreationEvent $event): void 
  {
    if ($event->getPlayerClass() === PlayerHCF::class) {
      return;
    }
    $event->setPlayerClass(PlayerHCF::class);
  }
  
}