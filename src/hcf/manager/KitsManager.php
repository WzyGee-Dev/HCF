<?php

namespace hcf\manager;

use hcf\Loader;
use hcf\PlayerHCF;
use hcf\kit\{
  Kit,
  KitException
};

use pocketmine\item\Item;
use pocketmine\utils\Config;

class KitsManager 
{
  
  protected array $kits;
  
  /** Receive the items, to add them later to the GUI **/
  public static function init(): void
  {
    $kits = new Config(Loader::getInstance()->getDataFolder() . "backups" . DIRECTORY_SEPARATOR . "kits.yml", Config::YAML);
    $kitData = $kits->getAll();
    foreach($kitData as $name => $data) {
      $dataObject = $kits->getAll()[$name];
      $kit = [];
      $kit["name"] = $dataObject["name"];
      $kit["customName"] = "";
      if ((empty($dataObject["items"]) && empty($dataObject["armor"]))) {
        throw new KitException("Kit data is not defined: {$name}");
      }
      foreach($dataObject["items"] as $slot => $value) { 
        $kit["items"][$slot] = Item::jsonDeserialize($value);
      }
      foreach($dataObject["armor"] as $slot => $value) {
        $kit["armor"][$slot] = Item::jsonDeserialize($value);
      }
      $kit["itemPresent"] = ($dataObject["itemPresent"] === null) ? [] : Item::jsonDeserialize($dataObject["itemPresent"]);
      $this->createKit($kit["name"], $kit);
    }
  }
  
  public function createKit(string $kitName, array $kitData): void
  {
    if (empty($kitName)) {
      throw new KitException("Kit name is null or not defined");
    }
    $this->kits[$kitName] = new Kit($kitName, $kitData["customName"], $kitData["items"], $kitData["armor"], $kitData["itemPresent"]);
  }
  
  public function deleteKit(string $name): void
  {
    if (isset($this->kits[$name])) unset($this->kits[$name]);
    $kit = new Config(Loader::getInstance()->getDataFolder() . "backups" . DIRECTORY_SEPARATOR . "kits.yml", Config::YAML);
    if ($kit->exists($name)) {
    $kit->remove($name);
    $kit->save();
    }
  }
  
  public function isKit(string $name): bool 
  {
    return ($this->kits[$name] !== null) ? true : false;
  }
  
  public function getKit(string $name): ?Kit 
  {
    return $this->kits[$name] ?? null; 
  }
  
}
?>