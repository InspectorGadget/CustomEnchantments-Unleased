<?php

namespace RTG\CE;

use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\item\Item;
use pocketmine\entity\Effect;
use pocketmine\event\Listener;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;

/**
	* All rights reserved (c) RTGNetworkkk
	* @GitHub: https://github.com/RTGNetworkkk
	* @link: https://rtgnetwork.tk
	* Never clone or duplicate this project!
	* Credit goes to : IG <InspectorGadget>
*/


class CustomEnchants extends PluginBase implements Listener {
	
	public function onEnable() {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
	
	public function onCommand(CommandSender $sender, Command $cmd, $label, array $args) {
		switch(strtolower($cmd->getName())) {
		
			case "ce":
				$api = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
				$money = $api->myMoney($sender);
				
				if(isset($args[0])) {
					switch(strtolower($args[0])) {
					
						case "list":
						
							if(isset($args[1])) {
								switch(strtolower($args[1])) {
								
								case "swords":
								
									$sender->sendMessage("-> §czaroc§f - has Sharpness II and Fire Aspect III. This sets your oponent to fire! This costs §e2500");
									$sender->sendMessage("");
									$sender->sendMessage("-> §brager§f - has Haste II, Blindness II and Fire Aspect II. This lets you RAGE. This costs §e4500");
									
									return true;
								break;
								
								case "armors":
									
									$sender->sendMessage("-> §adefender§f - has Thorns II and Fire Protection III. This comes in a set. This costs §c5500");
									
									return true;
								break;
								
								}
							
							
							
							}
						
						
							return true;
						break;
						
						case "buy":
						
							if(isset($args[0])) {
								switch(strtolower($args[0])) {
								
								case "zaroc":
									$player = $sender;
									
									if($money < 2500) {
										$sender->sendMessage("[CE] You need 2500 to buy this sword!");
									}
									else {
										$api->reduceMoney($sender->getName(), 2500);
										$this->onZaroc($player);
									}
									return true;
								break;
								
								case "rager":
									$player = $sender;
									
									if($money < 4500) {
										$sender->sendMessage("[CE] You need 4500 to buy this sword!");
									}
									else {
										$api->reduceMoney($sender->getName(), 4500);
										$this->onRage($player);
									}
									return true;
								break;
								
								case "defender":
									$player = $sender;
									
									if($money < 5500) {
										$sender->sendMessage("[CE] You need 5500 to buy this Kit!");
									}
									else {
										$this->onDefender($player);
									}
									return true;
								break;
								
								}
							
							
							
							}
							
							
							
							
							
							
						
							return true;
						break;
					
					
					}
				
				
				
				}
			
			
			
			
			
				return true;
			break;
		
		}
	
	
	}
	
	public function onZaroc($player) {
		$item = Item::getItem(276, 0, 1);
		$sh = Enchantment::getEnchantment(9); // Sharpness
		$sh->setLevel(2);
		$h = Enchantment::getEnchantment(13); // Fire Aspect
		$h->setLevel(3);
		
		$item->addEnchantment($sh);
		$item->addEnchantment($h);
		$item->setCustomName("§bZaRoc\n§eFire Aspect III\n§cSharpness II\n§f50% chance of fire");
		
		$player->getInventory()->addItem($item);
		
		$player->sendMessage("§b§e[CE]§r You have successfully purchased ZaRoc. Please check your inventory for the Enchanted Item!");
	}
	
	public function onRage($player) {
		$item = Item::getItem(276, 0, 1);
		$f = Enchantment::getEnchantment(13);
		$f->setLevel(2);
		$item->addEnchantment($f);
		$item->setCustomName("§cRager\n§bHaste II\n§bFire Aspect II\n§eBlindness II");
		
		$player->getInventory()->addItem($item);
		
		$player->sendMessage("§b§e[CE]§r You have successfully purchased Rager. Please check your inventory for the Enchanted Item!");
	}
	
	public function onDefender($player) {
		$item = Item::getItem(310, 0, 1);
		$itemm = Item::getItem(311, 0, 1);
		$itemmm = Item::getItem(312, 0, 1);
		$i = Item::getItem(313, 0, 1);
		// Enchantments
		// Thorns
		$item->addEnchantment(Enchantment::getEnchantment(5)->setLevel(2);
		$itemm->addEnchantment(Enchantment::getEnchantment(5)->setLevel(2);
		$itemmm->addEnchantment(Enchantment::getEnchantment(5)->setLevel(2);
		$i->addEnchantment(Enchantment::getEnchantment(5)->setLevel(2);
		// Fire Protection
		$f = Enchantment::getEnchantment(5);
		$item->addEnchantment($f)->setLevel(3);
		$itemm->addEnchantment($f)->setLevel(3);
		$itemmm->addEnchantment($f)->setLevel(3);
		$i->addEnchantment($f)->setLevel(3);
		// Finish Enchantment
		$player->getInventory()->addItem($item);
		$player->getInventory()->addItem($itemm);
		$player->getInventory()->addItem($itemmm);
		$player->getInventory()->addItem($i);
		
		$player->sendMessage("[CE] You have successfully purchased Defender! Please check your inventory for the Enchanted Item!");
	}
	
	public function onDamage(EntityDamageEvent $e) {
		$p = $e->getEntity();
		if($e instanceof EntityDamageByEntityEvent) {
			
			$d = $e->getDamager();
			$hand = $d->getItemInHand();
		
			if($hand->getName() === "§bZaRoc\n§eFire Aspect III\n§cSharpness II\n§f50% chance of fire") {
					switch(mt_rand(1,2)) {
						case "1":
						break;
						case "2":
							$p->isOnFire(15);
							$p->sendMessage("[CE] You have been hit. Take cover! You're on Fire! Find WATER.");
						break;
					}
			}
			
			if($hand->getName() === "§cRager\n§bHaste II\n§bFire Aspect II\n§eBlindness II") {
				$p->isOnFire(15);
				$d->sendMessage("Fire Aspect Enabled!");
				$h = Effect::getEffect(3);
				$p->addEffect($h)->setDuration(13 * 20)->setAmplifier(1));
				$d->sendMessage("Haste Enabled!"):
				$b = Effect::getEffect(15);
				$p->addEffect($b)->setDuration(13 * 20)->setAmplifier(1));
				$d->sendMessage("Blindness Enabled!");
				$p->sendMessage("[CE] You have been effected by Rager! You better run!");
			}
		}
	}
	
	public function onDisable() {
	}

}
