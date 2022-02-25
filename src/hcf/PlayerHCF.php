<?php

namespace hcf;

use pocketmine\player\Player;

class PlayerHCF extends Player
{
  public const PUBLIC_CHAT = "public"; public const STAFF_CHAT = "staff_chat"; public const FACTION_CHAT = "faction_chat"; 

  private $enderPearl = 0 ;
  
  private $goldenApple = 0;
  
  private Faction $faction;
  
  private string $factionRank;
  
  private bool $factionInvite;
  
  private string $factionInviteName;
  
  private PlayerHCF $factionInviteOwner;
  
  public function setFaction(Faction $faction): void
  {
    $this->faction = $faction;
    $sql = SQLite3Provider::getDatabase()->prepare("INSERT INTO players(username, factionName) VALUES (:username, :factionName);");
    $sql->bindParam(":username", $this->getName());
    $sql->bindParam(":factionName", $faction->getName());
    $sql->execute();
  }
  
  public function setFactionRank(string $rank): void
  {
    $this->factionRank = $rank;
    $sql = SQLite3Provider::getDatabase()->prepare("UPDATE players SET factionRank = :factionRank WHERE username = :username;");
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
  
}
