<?php

namespace Kingbobs\relics;

use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\item\Item;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\Listener;
use pocketmine\item\ItemFactory;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use function mt_rand;
use function strtolower;

class Main extends PluginBase implements Listener{
	public $config;
	public static $instance;
	public $opening = [];
	public function onLogin(PlayerLoginEvent $event){
		$this->opening[$event->getPlayer()->getName()] = false;
	}
	public function onBreak(BlockBreakEvent $event){
	    $player = $event->getPlayer();
	    $block = $event->getBlock();
        $item = $event->getItem();
        $name = $player->getName();
      
	    
	    if($block->getId() == 1){
		if (mt_rand(0, 500) >= 20){
		    
			$chance = mt_rand(0, 500);
			/**
			 * Common 50%
			 * epic 30%
			 * rare 25%
			 * legendary 20%
			 * mythical 10%
			 */
			if ($chance > 50 & $chance <= 50){
				$event->getPlayer()->sendMessage($this->config["Common"]["Message"]["Receive"]);
				$this->giveRelic($event->getPlayer(), "common");
			}
			if ($chance > 30 & $chance <= 40){
				$event->getPlayer()->sendMessage($this->config["Epic"]["Message"]["Receive"]);
				$this->giveRelic($event->getPlayer(), "epic");
			}
			if ($chance > 25 & $chance <= 30){
				$this->giveRelic($event->getPlayer(), "rare");
			}
			if ($chance > 20 & $chance <= 25){
				$this->giveRelic($event->getPlayer(), "legendary");
			}
			if ($chance > 10 & $chance <= 20){
				$this->giveRelic($event->getPlayer(), "mythical");
			}
		}
	}
	}
	public function onEnable(){
		$this->saveResource("config.yml");
		$this->config = (new Config($this->getDataFolder() . "config.yml", Config::YAML))->getAll();
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		self::$instance = $this;
	}
	/**
	 * @param $player
	 * @param $type
	 */
	public function giveRelic(Player $player  $type){

		switch ($type){
			case "common":
				$item = ItemFactory::get(Item::CHEST, 0, 1);
				$item->setNamedTagEntry(new ByteTag("common"));
				$item->setCustomName(TextFormat::colorize($this->config["Common"]["Name"]));
				$item->setLore([TextFormat::colorize($this->config["Common"]["Lore"])]);
				$player->sendMessage($this->config["Common"]["Message"]["Receive"]);
				$player->getInventory()->addItem($item);
			break;
			case "epic":
				$item = ItemFactory::get(Item::CHEST, 0, 1);
				$item->setCustomName(TextFormat::colorize($this->config["Epic"]["Name"]));
				$item->setNamedTagEntry(new ByteTag("epic"));
				$item->setLore([TextFormat::colorize($this->config["Epic"]["Lore"])]);
				$player->sendMessage($this->config["Epic"]["Message"]["Receive"]);
				$player->getInventory()->addItem($item);
			break;
			case "rare":
				$item = ItemFactory::get(Item::CHEST, 0, 1);
				$item->setCustomName(TextFormat::colorize($this->config["Rare"]["Name"]));
				$item->setLore([TextFormat::colorize($this->config["Rare"]["Lore"])]);
				$item->setNamedTagEntry(new ByteTag("rare"));
				$player->sendMessage($this->config["Rare"]["Message"]["Receive"]);
				$player->getInventory()->addItem($item);
			break;
			case "legendary":
				$item = ItemFactory::get(Item::CHEST, 0, 1);
				$item->setCustomName(TextFormat::colorize($this->config["Legendary"]["Name"]));
				$item->setLore([TextFormat::colorize($this->config["Legendary"]["Lore"])]);
				$item->setNamedTagEntry(new ByteTag("legendary"));
				$player->getInventory()->addItem($item);
				$player->sendMessage($this->config["Legendary"]["Message"]["Receive"]);
			break;
			case "mythical":
				$item = ItemFactory::get(Item::CHEST, 0, 1);
				$item->setCustomName(TextFormat::colorize($this->config["Mythical"]["Name"]));
				$item->setLore([TextFormat::colorize($this->config["Mythical"]["Lore"])]);
				$item->setNamedTagEntry(new ByteTag("mythical"));
				$player->sendMessage($this->config["Mythical"]["Message"]["Receive"]);
				$player->getInventory()->addItem($item);
			break;
		}
	}
	public function onPlace(BlockPlaceEvent $event){
		$item = $event->getItem();
		$id = $item->getId();
		if($item->getNamedTagEntry("common") !== null){
			$x = $event->getBlock()->getX();
			$y = $event->getBlock()->getY();
			$z = $event->getBlock()->getZ();
			$event->setCancelled(true);
			$this->openRelic($event->getPlayer(), "Common", $x, $y, $z, $id);
		}
		if($item->getNamedTagEntry("epic") !== null){
			$x = $event->getBlock()->getX();
			$y = $event->getBlock()->getY();
			$z = $event->getBlock()->getZ();
			$event->setCancelled(true);
			$this->openRelic($event->getPlayer(), "Epic", $x, $y, $z, $id);
		}
		if($item->getNamedTagEntry("rare") !== null){
			$x = $event->getBlock()->getX();
			$y = $event->getBlock()->getY();
			$z = $event->getBlock()->getZ();
			$event->setCancelled(true);
			$this->openRelic($event->getPlayer(), "Epic", $x, $y, $z, $event->getItem());
		}
		if($item->getNamedTagEntry("legendary") !== null){
			$x = $event->getBlock()->getX();
			$y = $event->getBlock()->getY();
			$z = $event->getBlock()->getZ();
			$event->setCancelled(true);
			$this->openRelic($event->getPlayer(), "Legendary", $x, $y, $z, $id);
		}
		if($item->getNamedTagEntry("mythical") !== null){
			$x = $event->getBlock()->getX();
			$y = $event->getBlock()->getY();
			$z = $event->getBlock()->getZ();
			$event->setCancelled(true);
			$this->openRelic($event->getPlayer(), "Mythical", $x, $y, $z, $id);
		}
	}
	public function openRelic(Player $player, String $type, $x, $y, $z ,$id){
		if ($this->opening[$player->getName()] === true){
			return;
		}
		$this->opening[$player->getName()] = true;
		$player->sendMessage($this->config[$type]["Message"]["Opening"]);
		foreach($player->getInventory()->getContents() as $slot => $items){
			if ($items->getNamedTagEntry(strtolower($type))){
				$player->getInventory()->removeItem(Item::get($id, 0, 1));
			}
		}
		$this->getScheduler()->scheduleDelayedTask(new task\openRelicTask($x, $y, $z, $player, $type, $this), 40);
	}
}
