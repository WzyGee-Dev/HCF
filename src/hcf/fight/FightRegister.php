<?php

namespace hcf\fight;

use pocketmine\entity\{EntityDataHelper,EntityFactory};
use pocketmine\world\World;
use pocketmine\nbt\tag\CompoundTag;

use hcf\fight\logger\LogoutZombie;

class FightRegister 
{
  
  public function __construct()
  {
    $factory = EntityFactory::getInstance();
    $factory->register(LogoutZombie::class, function(World $world, CompoundTag $tag): LogoutZombie {
      return new LogoutZombie(EntityDataHelper::parseLocation($tag, $world), $tag);
    }, ["Zombie", "minecraft:zombie"]);
  }
  
}
