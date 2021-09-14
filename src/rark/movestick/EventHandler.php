<?php
declare(strict_types = 1);

namespace rark\movestick;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerQuitEvent;

class EventHandler implements Listener{

	public function onInteract(PlayerInteractEvent $ev):void{
		$player = $ev->getPlayer();

		if(!$player->isOp()) return;
		if(!$ev->getItem()->equals(Main::getMoveStick())) return;
		AddMotionTack::isJoined($player)? AddMotionTack::quit($player): AddMotionTack::join($player);
	}

	public function onQuit(PlayerQuitEvent $ev):void{
		$player = $ev->getPlayer();
		
		if(AddMotionTack::isJoined($player)) AddMotionTack::quit($player);
	}
}