<?php

namespace hcf\tasks\async;

use pocketmine\scheduler\AsyncTask;

use hcf\PlayerHCF;
use hcf\provider\SQLite3Provider;

class DataLoad extends AsyncTask
{
  
  private $player;

  public function __construct(PlayerHCF $player)
  {
    $this->player = $player;
  }
  
  public function onRun(): void
  {
    $provider = new SQLite3Provider();
    $sqlite = $provider->getDatabase();
    $players = $sqlite->prepare("INSERT INTO players(username, factionName, factionRank) VALUES (:username, :factionName, :factionRank);");
    $players->bindParam(":username", $this->player->getName());
    $players->bindParam(":factionName", null);
    $players->bindParam(":factionRank", null);
    $players->execute();
  }
  
}
