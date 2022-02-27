<?php

namespace hcf\faction\command;

use pocketmine\command\{
  Command,
  CommandSender
};

use hcf\PlayerHCF;
use hcf\faction\command\subcommand\{
  CreateCommand,
  InviteCommand,
  AcceptCommand,
  TopCommand
};
use hcf\commands\SubCommand;

class FactionCommand extends Command
{
  
  protected $commands;
  
  public function __construct() 
  {
    parent::__construct("faction", "Faction Commands", "/faction help", ["f", "fac"]);
    $this->addCommand(new CreateCommand());
    $this->addCommand(new InviteCommand());
    $this->addCommand(new AcceptCommand());
    /*$this->addCommand(new TopCommand());*/
  }

  public function execute(CommandSender $sender, string $label, array $args): void
  {
    if (isset($args[0])) { 
      $command = $this->commands[$args[0]];
      $command->execute($sender, $label, $args);
    }
  }
  
  public function addCommand(SubCommand $command): void
  {
    $this->commands[$command->getName()] = $command;
    foreach($command->getAliases() as $alias) {
      $this->commands[$alias] = $command;
    }
  }
}
