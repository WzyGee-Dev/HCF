<?php

namespace hcf;

use pocketmine\player\Player;

class PlayerHCF extends Player
{
  public const PUBLIC_CHAT = "public"; public const STAFF_CHAT = "staff_chat"; public const FACTION_CHAT = "faction_chat"; 

  private bool $enderPearl = false;
  
  private int $enderPearlTime = 0;
  
  //private $goldenApple = false;
  
  private ?Faction $faction;
  
  private string $factionRank;
  
  private bool $factionInvite;
  
  private string $factionInviteName;
  
  private string $factionInviteOwner;
  
  public function getEnderPearl(): bool
  {
    return $this->enderPearl;
  }
  
  /*
  public function getGoldenApple(): bool
  {
    return $this->goldenApple;
  }*/
  
  public function setEnderPearlTime(int $time): void
  {
    return $this->enderPearlTime = $time;
  }
  
  /*public function setGoldebAppleTime(int $time): void
  {
    $this->goldenAppleTime = $time;
  }*/
  
  public function setFaction(Faction $faction): void
  {
    $this->faction = $faction;
    $sql = (new SQLite3Provider())->getDatabase()->prepare("REPLACE INTO players(factionName) VALUES (:factionName) WHERE username = '$this->getName()';");
    $sql->bindParam(":factionName", $faction->getName());
    $sql->execute();
  }
  
  public function setFactionRank(string $rank): void
  {
    $this->factionRank = $rank;
    $sql = (new SQLite3Provider())->getDatabase()->prepare("UPDATE players SET factionRank = :factionRank WHERE username = :username;");
    $sql->bindParam(":username", $this->getName());
    $sql->bindParam(":factionRank", $rank);
    $sql->execute();
  }
  
  public function setInviteFaction(bool $invite): void
  {
    $this->factionInvite = $invite;
  }
  
  /** @note Invitation faction name **/
  public function setFactionName(string $factionName): void
  {
    $this->factionInviteName = $factionName;
  }
  
  public function setFactionOwner(string $factionOwner): void
  {
    $this->factionInviteOwner = $factionOwner;
  }
  
  public function getFaction(): Faction
  {
    return $this->faction;
  }
  
  public function getFactionRank(): string
  {
    return $this->factionRank;
  }
  
  public function wasFactionInvite(): bool
  {
    return $this->factionInvite;
  }
  
  public function getFactionName(): string
  {
    return $this->factionInviteName;
  }

  public function getFactionOwner(): string
  {
    return $this->factionInviteOwner;
  }
  
}
