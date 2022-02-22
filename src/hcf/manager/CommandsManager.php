<?php

namespace hcf\manager;

use hcf\Loader;

use pocketmine\player\Player;

use pocketmine\utils\TextFormat as TE;

class CommandsManager {

    /**
    * @return void
    */
    public static function init() : void {
        Loader::getInstance()->getServer()->getCommandMap()->register("/lff", new LFFCommand());
    }
}
