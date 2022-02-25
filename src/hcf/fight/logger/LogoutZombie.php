<?php

namespace hcf\fight\logger;

use hcf\Loader;
use hcf\PlayerHCF;
use hcf\translation\Translation;

use pocketmine\entity\{Entity,Zombie};

use pocketmine\utils\TextFormat as Text;

use pocketmine\item\Item;

use pocketmine\event\entity\{EntityDamageEvent, EntityDamageByEntityEvent};

use pocketmine\nbt\tag\{CompoundTag, StringTag, ListTag};

use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;

use pocketmine\math\Vector3;

class LogoutZombie extends Zombie 
{
  public PlayerHCF $player;
  
  public string $name;
  
  public int $timeLeft; 
    
  public array $items;
  
  public array $armorItems;
  
  public function __construct(Location $location, ?CompoundTag $nbt = null, PlayerHCF $player = null, int $time = 0)
  {
    parent::__construct($location, $nbt);
    $this->player = $player;
    $this->name = $player->getName();
    $this->timeLeft = $time;
    foreach($player->getInventory()->getContents() as $item) {
    $this->items = $item;
    }
    foreach($player->getArmorInventory()->getContents() as $armor) {
      $this->armorItems = $armor;
      $this->getArmorInventory()->setHelmet($armor[0]);
      $this->getArmorInventory()->setChestPlate($armor[1]);
      $this->getArmorInventory()->setLeggings($armor[2]);
      $this->getArmorInventory()->setBoots($armor[3]);
    }
    $this->setMaxHealth(100);
  }
  
  public function onUpdate(int $currentTick): bool
  {
    if (count(Loader::getInstance()->getServer()->getOnlinePlayers()) === 0) {
      $this->close();
      return false;
    }
    if ($this->timeLeft === 0) {
      $this->close();
      return;
    }
    if ($this->player === null & $this->name === null) {
      $this->close();
      return false;
    }
    if ($this->player !== Loader::getInstance()->getServer()->getPlayerByPrefix($this->name) & $this->name !== $this->player->getName()) {
      $this->close();
      return false;
    }
    $this->timeLeft--;
    $this->setNameTag(
      Translation::addMessage("fight-logger-logout", ["&" => "§", "name" => $this->name])
    );
    $this->setScoreTag(
      Translation::addMessage("fight-logger-logout-time", ["&" => "§", "time" => $this->timeLeft])
    );
    return parent::onUpdate($currentTick);
  }
  
  public function getDrops(): array
  {
    $items = array_merge(
      $this->items === null ? [] : array_values($this->items)
    );
    return $items;
  }
  
  public function attack(EntityDamageEvent $event): void
  {
    parent::attack($event);
    if ($event instanceof EntityDamageByEntityEvent) {
      $player = $event->getDamager();
      $zombie = $event->getEntitiy();
      if ($player instanceof PlayerHCF) {
         if ($zombie->getHealth() <= $event->getFinalDamage()) {
           foreach($this->getDrops() as $item) {
             if ($player->getInventory()->canAddItem($item)) {
           $player->getInventory()->addItem($item);
               foreach($this->armorItems as $slot => $item) {
                 if ($player->getArmorInventory()->canAddItem($item)) {
                 $player->getArmorInventory()->setItem($slot, $item);
                 return;
                 }
               }
             }
           }
           $pos = $player->getPosition();
           foreach($this->getDrops() as $item) {
               $this->getWorld()->dropItem(new Vector3($pos->x, $pos->y, $pos->z), $item);
             }
             foreach(array_values($this->armorItems) as $item) {
               $this->getWorld()->dropItem(new Vector3($pos->x, $pos->y, $pos->z), $item);
             }
         }
      }
    }
  }
  
}
