<?php

namespace hcf\fight;

use pocketmine\entity\{EntityDataHelper,EntityFactory};

use hcf\fight\logger\LogoutZombie;

class FightRegister 
{
  
  public function __construct()
  {
    $factory = EntityFactory::getInstance();
    $factory->register(LogoutZombie::class, function(World $world, CompoundTag $tag) {
      return new LogoutZombie(EntityDataHelper::parseLocation($tag, $world), $tag);
    }, ["Zombie", "minecraft:zombie"]);
  }
  
}
