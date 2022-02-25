<?php

namespace hcf\manager;

use pocketmine\utils\SingletonTrait;
use pocketmine\Server;

use hcf\Loader;
use hcf\PlayerHCF;
use hcf\provider\SQLite3Provider;

class FactionManager 
{
  use SingletonTrait;
  
  public const OWNER = "owner";
  public const MEMBER = "member";
  
  public const DTR_MAX = Loader::getInstance()->getConfig("faction")["maxPlayers"] . .5;
  public const DTR_REGENERATE_TIME = 3600;
  
  public array $factions; 
  
  public function getFactions(): array
  {
    return $this->factions;
  }
  
  public function isFaction(string $name): bool
  {
    $sqlite = new SQLite3Provider();
    $query = $sqlite->getDatabase()->query("SELECT factionName FROM players WHERE username = '$name'");
    $result = $query->fetchArray(SQLITE3_ASSOC);
    return $result ? true : false;
  }
  
  public function getFaction(string $name): Faction
  {
    return ($this->factions[$name] instanceof Faction) ? $this->factions[$name] : null;
  }
  
  public function createFaction(string $name, PlayerHCF $owner): void
  {
    if ($this->isFaction($name)) {
      return;
    }
    // code.. (SQLite3)
    $username = $owner->getName();
    /** @var Faction(factionName, positionHome, membersArray, balanceInt, dtrFloat) **/
    $this->factions[$name] = new Faction($name, null, [$username], 0, self::DTR_MAX);
    $owner->setFaction($this->factions[$name]);
    /** @funciton Set the player role for the faction **/
    $owner->setFactionRank(self::OWNER);
  }
  
  public function joinFaction(Player $owner, string $username, string $factionName): void
  {
    if ($this->isFaction($username)) {
      return;
    }
    $sql = new SQLite3Provider();
    $query = $sql->prepare("INSERT INTO players(username, factionName, factionRank) VALUES (:username, :factionName, :factionRank);");
    $query->bindParam(":username", $username, SQLITE3_TEXT);
    $query->bindParam(":factionName", $factionName, SQLITE3_TEXT);
    $query->bindParam(":factionRank", self::MEMBER, SQLITE3_TEXT);
    $query->execute();
    $player->sendMessage();
    foreach($player->getFaction()->getMembers() as $member) {
      $memberPrefix = Loader::getInstance()->getServer()->getPlayerByPrefix($member);
      if ($memberPrefix instanceof PlayerHCF) {
        $memberPrefix->sendMessage();
      }
    } 
  }
  
  public function deleteFaction(string $name): void
  {
    if (!$this->isFaction($name)) {
      return;
    }
    $faction = $this->factions[$name];
    foreach($faction->getMembers() as $player) {
      $player->setFaction(null);
      $player->setFactionRank(null);
    }
    // code.. SQLite3
    unset($faction);
  }
  
}