<?php

namespace hcf\commands;

use pocketmine\command\{CommandSender, Command};

use pocketmine\player\Player;

use pocketmine\utils\TextFormat as TE;

use hcf\Loader;
use hcf\manager\FactionManager;

class LFFCommand extends Command{

    public function __construct()
    {
        parent::__construct("lff");
        $this->setDescription("Send the message: Looking for Faction.");   
    }

    public function execute(CommandSender $sender, String $label, Array $args) : void {
        if(FactionManager::getInstance()->isFaction($sender->getName())) {
            $sender->sendMessage(TE::RED . "You cannot run this command if you are already in a faction.");
            return;
        }
        Loader::getInstance()->getServer()->broadcastMessage("§8--------------------------------------------------");
        Loader::getInstance()->getServer()->broadcastMessage("§l§4".$sender->getName()." §l§8Is now Looking For Faction.");
        Loader::getInstance()->getServer()->broadcastMessage("§8--------------------------------------------------");
    }
}
