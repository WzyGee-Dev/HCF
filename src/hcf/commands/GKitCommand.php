<?php

namespace hcf\commands;

use pocketmine\command\{
  Command,
  CommandSender
};

use libs\invmenu\{
  InvMenu,
  type\InvMenuTypeIds
};

use hcf\Loader;
use hcf\PlayerHCF;

class GKitCommand extends Command
{
  
  public function __construct()
  {
    parent::__construct("gkit", "Kits for PvP", "/kit");
  }
  
  public function execute(CommandSender $sender, string $label, array $args): void
  {
    if (!$sender instanceof PlayerHCF) return;
    
    if (empty($args[0])) {
      $menu = InvMenu::create(InvMenuTypeIds::TYPE_CHEST);
      $menu->setName("KitsGUI");
      $menu->setListener(InvMenu::readonly(function(DeterministicInvMenuTransaction $transaction): DeterministicInvMenuTransaction {
        $player = $transaction->getPlayer();
        $itemClicked = $transaction->getItemClicked();
        
      }));
      $menu->send($sender);
    } else {
      switch($args[0]) {
      }
    }
    
  }
  
}
