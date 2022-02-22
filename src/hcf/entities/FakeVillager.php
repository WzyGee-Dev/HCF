<?php

namespace hcf\entities;

use pocketmine\entity\animation\DeathAnimation;

use pocketmine\entity\{Villager, EntityDamageEvent, Location, EntitySizeInfo};
use pocketmine\event\entity\{EntityDamageByEntityEvent, EntityDamageEvent};

use pocketmine\item\Item;

use pocketmine\nbt\{NBT, TreeRoot};

use pocketmine\nbt\tag\{CompoundTag, DoubleTag, FloatTag, IntTag, ListTag, StringTag};

use pocketmine\player\Player;

use pocketmine\world\generator\populator\Tree;

use hcf\Loader;
use function var_dump;

class FakeVillager extends Villager {

    private string $playerName = "";

    private int $time = 0;

    private int $tickk = 0;

    private array $items = [];

    public function __construct(Location $level, ?CompoundTag $nbt, string $playerName = "", array $items = []) {
        if ($playerName == "") return;
        parent::__construct($level, $nbt);
        $this->items = $items;
        $this->setMaxHealth(200);
        $this->setHealth(200);
        $this->playerName = $playerName;
        $this->time = 120;
        $this->setNameTagAlwaysVisible(true);
        $this->setNameTagVisible(true);
    }
private bool $isDed = false;
	public function attack(EntityDamageEvent $source) : void {
		if ($source instanceof EntityDamageByEntityEvent) {
			$dmg = $source->getDamager();
			if ($dmg instanceof Player) {
				if ($this->getHealth() - $source->getFinalDamage() > 0.1) {
					parent::attack($source);
					return;
				}
				$this->broadcastAnimation(new DeathAnimation($this));
				$player = Loader::getInstance()->getServer()->getOfflinePlayerData($this->playerName);
				$items = $this->items;
				$drops = [];
				foreach ($items as $i) {
					$drops[] = $i;
				}
				Loader::getInstance()->players[$dmg->getName()]["kills"] += 1;
				$player->setTag("Inventory", new ListTag([], NBT::TAG_Compound));
				Loader::getInstance()->players[$this->playerName]["didDie"] = true;
				Loader::getInstance()->getServer()->saveOfflinePlayerData($this->playerName, $player);
				Loader::getInstance()->getServer()->broadcastMessage("§c" . $this->playerName . "§4[" . Loader::getInstance()->players[$this->playerName]["kills"] . "] §r§7(Logger) §r§ewas killed by §c" . $dmg->getName()."§4[".Loader::getInstance()->players[$dmg->getName()]["kills"]."] §r§eusing §r".($dmg->getInventory()->getItemInHand()->getCustomName() == "" ? $dmg->getInventory()->getItemInHand()->getName() : $dmg->getInventory()->getItemInHand()->getCustomName()));
				foreach ($drops as $drop) {
					if (count($drops) < 1) break;
					$this->getPosition()->getWorld()->dropItem($this->getPosition(), $drop);
				}
				$this->isDed = true;
			}
		} else {
			$source->cancel();
		}
	}
    public function entityBaseTick(int $tickDiff = 1) : bool {
        $this->tickk++;
        if (($this->tickk % 20) == 0) {
            if ($this->isDed) {
            	$this->setInvisible(true);
				$this->setScale(0.001);
            	$this->flagForDespawn();
            	return true;
			}
            if (Loader::getInstance()->getServer()->getPlayerByPrefix($this->playerName) !== null) {
				$this->setInvisible(true);
				$this->setScale(0.001);
                $this->flagForDespawn();
                return true;
            }
            $this->time--;
            $this->setNameTag("§f" . $this->playerName . " §e[§c" . Loader::getUtils()->secondsToEnderpearlCD($this->time) . "§r§e] §c" . floor($this->getHealth()) . "§f/§c" . floor($this->getMaxHealth()));
        }
		if ($this->isClosed() or $this->closed or !$this->isAlive() or $this->isDed) {
			$this->flagForDespawn();
		}
        return parent::entityBaseTick($tickDiff);
    }

    public function tryChangeMovement(): void
	{
		parent::tryChangeMovement();
	}

	protected function getInitialSizeInfo() : EntitySizeInfo {
		return new EntitySizeInfo(1.5, 1.5);
	}

	protected function onDispose() : void{}

	public function saveNBT(): CompoundTag
	{
		return CompoundTag::create()->setByte("", 1);
	}

	public function onRandomUpdate(): void
	{

	}
}
