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
}
