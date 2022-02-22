<?php

namespace hcf\fight;

use pocketmine\entity\EntityFactory;

use hcf\fight\logger\LogoutZombie;

class FightRegister 
{
  
  public function __construct()
  {
    $factory = new EntityFactory();
    $factory->register(LogoutZombie::class, function(World $world, CompoundTag $tag) {
      
    }, ["Zombie", "minecraft:zombie"]);
  }
  
}
