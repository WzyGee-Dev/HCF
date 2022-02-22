<?php

namespace hcf\commands;

use hcf\loader;

use pocketmine\command\{PluginCommand, CommandSender};
use pocketmine\utils\{Config, TextFormat as TE};

class RankCommand extends PluginCommand {
  
  public $rank = [
  	"Guest",
  	"Silver",
  	"Iron",
  	"Diamond",
  	"Esmerald",
  	"Ruby",
  	"Trainee",
  	"Mod",
  	"Sr-Mod",
  	"Jr-Admin",
  	"Admin",
  	"Sr-Admin",
  	"Coordinator",
  	"Developer",
  	"Co-Owner",
  	"Owner",
  	"Partner",
  	"Youtuber"
  	
  	];
  public function __construct(){
    parent::__construct("Rank", Loader::getInstance());
  }
  public function execute(CommandSender $sender, String $label, Array $args){
    if(!$this->getServer()->operators->exits($name)){
      $sender->sendMessage(TE::RED."You don't have permissions");
      return;
    }
    if(count($args) === 0){
      $sender->sendMessage(TE::RED."Use: ".TE::GRAY."/rank help");
      return;
    }
    switch($args[0]){
      case 'set':
        $player = Loader::getInstance()->getServer()->getPlayer($args[1]);
        if($player === null){
        	$this->addProfile($args[1]);
        	if(count($args) === 2){
          $sender->sendMessage(TE::RED."Use: ".TE::GRAY."/rank set <string:playerName> <string:group>");
          return;
        }
        if(!in_array($args[2], $this->rank)){
        	$sender->sendMessage(TE::RED."The range ".TE::YELLOW.$args[2].TE::RED." does not exist!");
        	return;
        }
        $data["rank"] = $args[2];
        $this->savePlayerData($args[1], $data);
        $sender->sendMessage(TE::GREEN."You have given the rank ".TE::YELLOW.$args[2].TE::GREEN." to ".TE::YELLOW.$args[1]);
        return;
        }
        if(count($args) === 2){
          $sender->sendMessage(TE::RED."Use: ".TE::GRAY."/rank set <string:playerName> <string:group>");
          return;
        }
        if(!in_array($args[2], $this->rank)){
        	$sender->sendMessage(TE::RED."The range ".TE::YELLOW.$args[2].TE::RED." does not exist!");
        	return;
        }
        $data["rank"] = $args[2];
        $this->savePlayerData($player->getName(), $data);
        $player->sendMessage(TE::GREEN."Your rank has been successfully updated!");
        $sender->sendMessage(TE::GREEN."You have given the rank ".TE::YELLOW.$args[2].TE::GREEN." to ".TE::YELLOW.$player->getName());
        break;
    }
  }
  public function savePlayerData(String $name, array $config){
		$data = new Config(Loader::getInstance()->getDataFolder() . "players/$name.yml", Config::YAML);
		$data->setAll($config);
		$data->save();
	}
	public function addProfile(String $name){
    new Config(Loader::getInstance()->getDataFolder()."players/{$name}.yml", Config::YAML, array(
      "rank" => "Guest"
  ));
  }
}
