<?php

namespace MythicRelics;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\Server;

use MythicRelics\relics\Ancient;
use MythicRelics\relics\Rare;
use MythicRelics\relics\Legendary;
use MythicRelics\relics\Mythic;

class EventLoader extends PluginBase {
  
  public static $instance;

    public function onEnable()
  {
    self::$instance = $this;
    $this->getLogger()->info("has been enabled!");
    $this->setRelics();
  }

  public static function getInstance() : self
  {
    return self::$instance;
  }

  public function setRelics()
  {
    new Ancient($this);
    new Legendary($this);
    new Mythic($this);
    new Rare($this);
  }
}