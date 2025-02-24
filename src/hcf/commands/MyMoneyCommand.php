<?php

namespace Taco\HCF\commands\economy;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use hcf\Loader;

class MyMoneyCommand extends Command {

	public function __construct() {
		parent::__construct("money", Loader::getInstance());
		$this->setDescription("Check your balance.");
		$this->setAliases(["bal", "balance"]);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) : void {
		if (!$sender instanceof Player) return;
		$money = Loader::getInstance()->players[$sender->getName()]["money"];
		$sender->sendMessage("§r§l§7(§c!§7) §r§7You have §a".$money."§7.");
	}

}
