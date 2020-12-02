<?php

namespace Check;

use onebone\economyapi\EconomyAPI;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;

class CheckListener implements Listener
{

	public function playerInterctEvent(PlayerInteractEvent $e)
	{
		$player = $e->getPlayer();
		$item = $e->getItem();
		if ($item->getId() == 339) {
			if ($item->getDamage() == 5) {
				$lore = $item->getLore();
				$para = $lore[1];
				$eco = EconomyAPI::getInstance();
				$name = $player->getName();
				$eco->addMoney($name, $para);
				$player->getInventory()->removeItem($item);
				$player->sendMessage("§8»§fHesabına §6$para TL §fpara eklendi");
			}
		}
		$item = $e->getItem();
		$damage = $item->getDamage();
		$id = $item->getId();
		if ($id == 339 && $damage == 5) {
			$e->setCancelled(true);
		}
	}
}