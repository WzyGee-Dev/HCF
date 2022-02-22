<?php

namespace hcf\kit;

abstract class Kit 
{
  
  protected string $name;
  
  protected string $permission;
  
  protected int $cooldown;
  
  protected string $custom_name;
  
  protected array $items;
  
  protected array $itemsArmor;
  
  protected Item $kitItem;
  
  public function __construct(string $name, string $permission, int $cooldown, string $custom_name, array $items, array $itemsArmor, ?Item $kitItem)
  {
    $this->name = $name;
    $this->permission = $permission;
    $this->cooldown = $cooldown;
    $this->custom_name = $custom_name;
    $this->items = $items;
    $this->itemsArmor = $itemsArmor;
    $this->kitItem = $kitItem;
  }
  
  public function getName(): string
  {
    return $this->name;
  }
  
  public function getPermission(): string
  {
    return $this->permission;
  }
  
  public function getCooldown(): int
  {
    return $this->cooldown;
  }
  
  public function getItems(): array
  {
    return $this->items;
  }
  
  public function getArmorItems(): array
  {
    return $this->itemsArmor;
  }
  
}
