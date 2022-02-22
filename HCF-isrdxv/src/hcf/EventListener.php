<?php

namespace hcf;

use hcf\Loader;

use hcf\listeners\{
  PlayerListener
};

class EventListener 
{
  
  public function init(): void
  {
  $loader = Loader::getInstance();
  $loader->getServer()->getPluginManager()->registerEvents(new PlayerListener(), $loader);
  }
  
}
