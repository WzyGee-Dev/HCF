<?php

namespace hcf\manager;

use hcf\Loader;
use hcf\commands\{
  GKitCommand
};
use hcf\faction\command\FactionCommand;

use pocketmine\utils\TextFormat as TE;

class CommandsManager 
{
  
  /**
  * @return void
  */
  public static function init() : void 
  {
    //Loader::getInstance()->getServer()->getCommandMap()->register("/lff", new LFFCommand());
    Loader::getInstance()->getServer()->getCommandMap()->register("/gkit", new GKitCommand());
    Loader::getInstance()->getServer()->getCommandMap()->register("/faction", new FactionCommand());
  }
    
}
