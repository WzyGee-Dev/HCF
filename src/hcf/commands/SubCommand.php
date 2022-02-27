<?php

namespace hcf\commands;

use pocketmine\command\CommandSender;

abstract class SubCommand 
{
  
  /** @var String **/
  protected $name;
  
  /** @var String **/
  protected $description = "";
  
  protected $usageMessage;
  
  /** @var Array **/
  protected $aliases;
  
  public function __construct(string $name, string $description = "", string $usage = null, array $aliases = []) 
  {
    $this->name = $name;
    $this->description = $description;
    $this->usageMessage = $usage ?? ("/" . $name);
    $this->aliases = $aliases;
  }
  
  public function getName(): ?string
  {
    return $this->name ?? null;
  }
  
  public function getUsage(): string
  {
    return $this->usageMessage;
  }
  
  public function setDescription(string $desc): void
  {
    $this->description = $desc;
  }
  
  public function setUsage(string $usage): void
  {
    $this->usageMessage = $usage;
  }
  
  public function setAliases(array $aliases): void
  {
    $this->aliases = $aliases;
  }

  abstract public function execute(CommandSender $sender, string $label, array $args): void;
  
}
