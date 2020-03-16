<?php

namespace MythicRelics\relics;

use MythicRelics\EventLoader;

use pocketmine\Server;
use pocketmine\item\Item;
use pocketmine\event\Listener;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\utils\TextFormat as TF;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\block\Block;
use pocketmine\Player;
use pocketmine\utils\Random;

class Common implements Listener
{
    private $plugin;

    public function __construct(EventLoader $plugin)
    {
        $this->setPlugin($plugin);
        $plugin->getServer()->getPluginManager()->registerEvents($this, $plugin);
    }

    public function setPlugin($plugin)
    {
        return $this->plugin;
    }

    public function onBlockBreak(BlockBreakEvent $event){
        $player = $event->getPlayer();
        $item = $event->getItem();
        $name = $player->getName();
        $block = $event->getBlock();
        $chance = mt_rand(1,100);

        if($block->getId() === 1){
            if($chance === 25){

                $relic = Item::get(54, 101, 1);
                $relic->setCustomName(TF::RESET . TF::AQUA . "Common" . TF::BLUE . " relic");
                $player->getInventory()->addItem($relic);
                $player->getServer()->broadcastMessage(TF::BOLD . TF::DARK_GRAY . "(" . TF::DARK_PURPLE . "!" . TF::DARK_GRAY . ")" . TF::RESET . TF::GRAY . TF::RESET . TF::GRAY . " $name Found an Ancient Relic!");
            }
        }
    }

    public function onTap(BlockPlaceEvent $event){
        $player = $event->getPlayer();
        $item = $event->getItem();

        $damage = $event->getItem()->getDamage();

        $prot = Enchantment::getEnchantment(0);
        $unb = Enchantment::getEnchantment(1);
        $sharp = Enchantment::getEnchantment(1);
        $eff = Enchantment::getEnchantment(1);
        $kb = Enchantment::getEnchantment(1);
        $loot = Enchantment::getEnchantment(1);
        $fire = Enchantment::getEnchantment(1);
        $resp = Enchantment::getEnchantment(1);

        switch($damage) {
            case "101":
            $relic = Item::get(54, 101, 1);
            $item1 = Item::get(310, 0, 1);
            $item1->setCustomName(TF::AQUA . "Common" . TF::GRAY . "Helmet");
            $item1->addEnchantment(new EnchantmentInstance($prot, 1));
            $item1->addEnchantment(new EnchantmentInstance($unb, 1));

            $item2 = Item::get(311, 0, 1);
            $item2->setCustomName(TF::AQUA . "Common" . TF::GRAY . "Chestplate");
            $item2->addEnchantment(new EnchantmentInstance($prot, 1));
            $item2->addEnchantment(new EnchantmentInstance($unb, 1));
            
            $item3 = Item::get(312, 0, 1);
            $item3->setCustomName(TF::AQUA . "Common" . TF::GRAY . "Leggings");
            $item3->addEnchantment(new EnchantmentInstance($prot, 1));
            $item3->addEnchantment(new EnchantmentInstance($unb, 1));

            $item4 = Item::get(313, 0, 1);
            $item4->setCustomName(TF::AQUA . "Common" . TF::GRAY . "Boots");
            $item4->addEnchantment(new EnchantmentInstance($prot, 1));
            $item4->addEnchantment(new EnchantmentInstance($unb, 1));

            $sword = Item::get(276, 0, 1);
            $sword->setCustomName(TF::AQUA . "Common" . TF::GRAY . "Sword");
            $sword->addEnchantment(new EnchantmentInstance($sharp, 1));
            $sword->addEnchantment(new EnchantmentInstance($unb, 1));

            $pickaxe = Item::get(278, 0, 1);
            $pickaxe->setCustomName(TF::AQUA . "Common" . TF::GRAY . "Pickaxe");
            $pickaxe->addEnchantment(new EnchantmentInstance($eff, 1));
            $pickaxe->addEnchantment(new EnchantmentInstance($unb, 1));

            $axe = Item::get(279, 0, 1);
            $axe->setCustomName(TF::AQUA . "Common" . TF::GRAY . "Axe");
            $axe->addEnchantment(new EnchantmentInstance($eff, 1));
            $axe->addEnchantment(new EnchantmentInstance($unb, 1));

            $diamond = Item::get(264, 0, 10);
            $iron = Item::get(265, 0, 33);
            $gold = Item::get(266, 0, 32);

            $tobegiven1 = [$item1, $item2, $item3, $item4, $sword, $pickaxe, $axe]; //array1
            $rand1 = mt_rand(0, 1);

            $player->getInventory()->addItem($tobegiven1[$rand1]);
            $player->sendMessage(TF::LIGHT_PURPLE . "Opening Relic..");
            $event->setCancelled();
            $player->getInventory()->removeItem($relic);
            break;
        }
    }
}
