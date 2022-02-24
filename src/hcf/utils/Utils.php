<?php

namespace hcf\Utils;

use pocketmine\math\Vector3;
use pocketmine\entity\Location;

use hcf\Loader;
use hcf\entities\FakeVillager;

class Utils {
  
  public function spawnFakeVillager(Vector3 $pos, string $name, array $items) : void {
		$entity = new FakeVillager(Location::fromObject($pos, Loader::getInstance()->getServer()->getWorldManager()->getDefaultWorld()), null, $name, $items);
		$entity->spawnToAll();
  }
    
    /** 
    * @use Utils::spawnZombie($player, $position, $yaw, $pitch, 580);
    **/
    public function spawnZombie(PlayerHCF $player, Vector3 $position, float $yaw, float $pitch, int $time = 580): void
    {
      $entity = new LogoutZombie(Location::fromObject($position, Loader::getInstance()->getServer()->getWorldManager()->getDefaultWorld(), $yaw, $pitch), null, $player, $time);
      $entity->setImmobile(true);
      $entity->spawnToAll();
    }
    
  }
