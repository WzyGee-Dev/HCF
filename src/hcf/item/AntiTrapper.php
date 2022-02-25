<?php

namespace hcf\item;

use pocketmine\item\{
  ItemIds,
  ItemIdentifier
};
use pocketmine\nbt\tag\CompoundTag;

class AntiTrapper extends Item
{
  
  public function __construct()
  {
    parent::__construct(new ItemIdentifier(ItemIds::BONE, 0), "Bone"); 
  }
}