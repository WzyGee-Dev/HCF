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
    return (isset($result)) ? true : false;
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
    //code... (SQLite3)
    $sqlBalance = (new SQLite3Provider())->getDatabase()->prepare("INSERT OR REPLACE INTO balances(factionName, money) VALUES (:factionName, :money);");
    $sqlBalance->bindParam(":factionName", $name, SQLITE3_TEXT);
    $sqlBalance->bindParam(":money", 0, SQLITE3_INTEGER);
    $sqlBalance->execute();
    $sqlDTR = (new SQLite3Provider())->getDatabase()->prepare("INSERT INTO strength(factionName, dtr) VALUES (:factionName, :dtr);");
    $sqlDTR->bindParam(":factionName", $name, SQLITE3_TEXT);
    $sqlDTR->bindParam(":dtr", self::DTR_MAX, SQLITE3_FLOAT);
    $sqlDTR->execute();
    $sqlTop = (new SQLite3Provider())->getDatabase()->prepare("INSERT INTO tops(factionName, points) VALUES (:factionName, :points);");
    $sqlTop->bindParam(":factionName", $name, SQLITE3_TEXT);
    $sqlTop->bindParam(":points", 0, SQLITE3_INTEGER);
    $sqlTop->execute();
    $sqlMembers = (new SQLite3Provider())->getDatabase()->prepare("INSERT INTO members(factionName, members) VALUES (:factionName, :members);");
    $sqlMembers->bindParam(":factionName", $name, SQLITE3_TEXT);
    $sqlMembers->bindParam(":members", $owner->getName(), SQLITE3_TEXT);
    $sqlMembers->execute();
    /** @var Faction(factionName, positionHome, membersArray, balanceInt, dtrFloat) **/
    $this->factions[$name] = new Faction($name, null, [$owner->getName()], 0, self::DTR_MAX);
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
    $user = Loader::getInstance()->getServer()->getPlayerByPrefix($username);
    $name = $user instanceof PlayerHCF ? $user->getName() : null;
    $owner->setMembers($name);
    $owner->sendMessage();
    foreach($owner->getFaction()->getMembers() as $member) {
      $player = Loader::getInstance()->getServer()->getPlayerByPrefix($member);
      if ($player instanceof PlayerHCF) {
        $player->sendMessage();
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
