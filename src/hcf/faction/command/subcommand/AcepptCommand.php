<?php

namespace hcf\faction\command\subcommand;

use pocketmine\command\{
  Command,
  CommandSender
};
use pocketmine\Server;

use hcf\Loader;
use hcf\manager\FactionManager;
use hcf\PlayerHCF;
use hcf\translation\Translation;

class AcceptCommand extends Command
{
  
  public function __construct()
  {
    parent::__construct("accept");
    $this->setDescription("");
    $this->setUsage("/f accept");
    $this->setAliases(["ac"]);
  }
  
  public function execute(CommandSender $sender, string $label, array $args)
  {
    if (!$sender instanceof PlayerHCF) return;
    $factionName = $sender->getFactionName();
    $player = Server::getInstance()->getPlayerByPrefix($sender->getFactionOwner());
    $factionManager = FactionManager::getInstance();
    if (!$sender->wasFactionInvite()) {
      return;
    }
    if ($factionManager->isFaction($factionName)) {
      return;
    }
    //code.. if faction is full
    $sender->setInviteFaction(false);
    $player->sendMessage(Translation::addMessage("accept-invite-owner-faction", ["name" => $sender->getName()]));
    $sender->sendMessage(Translation::addMessage("accept-invite-faction", ["faction_name"  => $player->getFaction()->getName()]));
    $factionManager->joinFaction($player, $sender->getName(), $factionName);
  }
  
}