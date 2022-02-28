<?php

namespace hcf\faction\command\subcommand;

use pocketmine\command\{
  CommandSender
};
use pocketmine\Server;

use hcf\commands\SubCommand;

use hcf\Loader;
use hcf\manager\FactionManager;
use hcf\PlayerHCF;
use hcf\translation\Translation;

class AcceptCommand extends SubCommand
{
  
  public function __construct()
  {
    parent::__construct("accept");
    $this->setDescription("null");
    $this->setUsage("/f accept");
    $this->setAliases(["ac"]);
  }
  
  public function execute(CommandSender $sender, string $label, array $args): void
  {
    if (!$sender instanceof PlayerHCF) return;
    $factionName = $sender->getFactionName();
    $player = Server::getInstance()->getPlayerByPrefix($sender->getFactionOwner());
    $factionManager = FactionManager::getInstance();
    if (!$sender->wasFactionInvite()) {
      return;
    }
    if ($factionManager->isFaction($sender->getName())) {
      return;
    }
    //code.. if faction is full
    $sender->setInviteFaction(false);
    $player->sendMessage(Translation::addMessage("accept-invite-owner-faction", ["name" => $sender->getName()]));
    $sender->sendMessage(Translation::addMessage("accept-invite-faction", ["faction_name"  => $player->getFaction()->getName()]));
    $factionManager->joinFaction($player, $sender->getName(), $factionName);
  }
  
}
