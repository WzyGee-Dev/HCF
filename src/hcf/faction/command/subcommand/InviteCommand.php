<?php

namespace hcf\faction\command\subcommand;

use pocketmine\command\{
  Command,
  CommandSender
};
use pocketmine\Server;

use hcf\Loader;
use hcf\PlayerHCF;
use hcf\manager\FactionManager;
use hcf\translation\Translation;

class InviteCommand extends Command
{
  
  public function __construct()
  {
    parent::__construct("invite");
    $this->setDescription();
    $this->setUsage("/faction invite <username>");
    $this->setAliases(["i", "inv"]);
  }
  
  public function execute(CommandSender $sender, string $label, array $args)
  {
    if (!$sender instanceof PlayerHCF) return;
    
    $username = (isset($args[1])) ? (string)$args[1] : null;
    $player = Server::getInstance()->getPlayerByPrefix($username);
    $factionManager = FactionManager::getInstance();
    if (!($factionManager->isFaction($player->getName()) & $factionManager->isFaction($sender->getName()))) {
      return;
    }
    if ($player->getName() === $sender->getName()) {
      return;
    }
    /** if the player is already invited **/
    if ($player->wasFactionInvite()) {
      return;
    } 
    if (!$sender->getName() === $factionManager->getFactionOwner($sender->getName())) {
      return;
    }
    $player->setInviteFaction(true);
    $player->setFactionName($sender->getFaction()->getName());
    $player->setFactionOwner($sender->getName());
    $player->sendMessage(Translation::addMessage("invite-player-faction", ["faction_name" => $sender->getFaction()->getName()]));
    $sender->sendMessage(Translation::addMessage("invite-owner-faction", ["name" => $player->getName()]));
  }
  
}
