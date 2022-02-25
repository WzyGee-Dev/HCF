<?php

namespace hcf\implement\announcements;

use pocketmine\Server;

use pocketmine\utils\{Config,TextFormat};

class AnnouncementsManager 
{
  public Loader $hcf;

  public function __construct(Loader $loader)
  {
    $this->hcf = $loader;
  }
  
  public function getRecentAnnouncement();
  
  public function addAnnouncement();
  
  public function setAnnouncement();
  
  public function deleteAnnouncement();
  
  public function isInAnnouncement();
  
}