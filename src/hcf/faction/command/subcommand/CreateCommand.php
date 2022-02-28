<?php

namespace hcf\faction\command\subcommand;

use pocketmine\command\{
  CommandSender
};
use pocketmine\utils\TextFormat;

use hcf\commands\SubCommand;

use hcf\Loader;
use hcf\PlayerHCF;
use hcf\manager\FactionManager;
use hcf\translation\Translation;

class CreateCommand extends SubCommand
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
    if ($factionManager->isFaction($sender->getName())) {
     // $sender->sendMessage();
      return;
    }
    $factionManager->createFaction($factionName, $sender);
    //$sender->sendMessage();
  }
  
}
