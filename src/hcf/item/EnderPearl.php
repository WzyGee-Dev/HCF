<?php

namespace hcf\item;

use pocketmine\item\{
  ItemIds,
  ItemIdentifier,
  ProyectileItem
};
use pocketmine\entity\Location;
use pocketmine\player\Player;

class EnderPearl extends ProyectileItem
{
  
  public function __construct()
  {
    parent::__construct(new ItemIdentifier(ItemIds::ENDER_PEARL, 0), "Ender Pearl");
  }
  
  public function getMaxStackSize(): int
  {
    return 16;
  }
  
  public function getThrowForce(): float
  {
    return 2.5;
  }
  
  public function getCooldownTicks(): int
  {
    return 15;
  }
  
}
