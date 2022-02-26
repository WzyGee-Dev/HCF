<?php

namespace hcf\faction\command\subcommand;

use pocketmine\command\{
  Command,
  CommandSender
};
use pocketmine\utils\TextFormat;

use hcf\Loader;
use hcf\PlayerHCF;
use hcf\manager\FactionManager;
use hcf\trabslation\Translation;

class CreateCommand extends Command
{
  
  public function __construct()
  {
    parent::__construct("create");
    $this->setDescription("null");
    $this->setUsage("/faction create <factionName>");
    $this->setAliases(["c","cre"]);
  }
  
  public function execute(CommandSender $sender, string $label, array $args): void
  {
    if (!$sender instanceof PlayerHCF) return;
    
    if (!isset($args[1])) {
      $sender->sendMessage($this->getUsage());
      return;
    }
    $factionName = (string)$args[1];
    $factionManager = FactionManager::getInstance();
    if ($factionManager->isFaction($factionName)) {
      $sender->sendMessage();
      return;
    }
    $factionManager->createFaction($factionName, $sender);
    $sender->sendMessage();
  }
  
}
