<?php

namespace hcf\item;

use pocketmine\item\ProyectileItem;
use pocketmine\entity\proyectile\Throwable;
use pocketmine\entity\Location;
use pocketmine\player\Player;

use hcf\item\entity\SnowballBASS;

class SnowballBass extends ProyectileItem
{
  
  public function getMaxStackSize(): int
  {
    return 16;
  }
  
  public function getThrowForce(): float
  {
    return 1.6;
  }
  
  public function createEntity(Vector3 $location, Player $player): Throwable
  {
    return new SnowballBASS($location, $player);
  }
  
}
