<?php

namespace hcf\commands;

use pocketmine\command\CommandSender;

class SubCommand 
{
  
  /** @var String **/
  protected $name;
  
  /** @var String **/
  protected $description;
  
  /** @var Array **/
  protected $aliases;
  
  public function __construct(string $name, string $description = "", array $aliases = []) 
  {
    $this->name = $name;
    $this->description = $description;
    $this->aliases = $aliases;
  }
  
  public function getName(): ?string
  {
    return $this->name ?? null;
  }
  
  public function setDescription(string $desc): void
  {
    $this->description = $desc;
  }
  
  public function setAliases(array $aliases): void
  {
    $this->aliases = $aliases;
  }

  abstract public function execute(CommandSender $sender, string $label, array $args): void;
  
}