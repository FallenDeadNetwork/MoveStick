<?php
declare(strict_types = 1);

namespace rark\movestick;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\InventoryTransactionPacket;
use pocketmine\network\mcpe\protocol\types\inventory\UseItemTransactionData;
use pocketmine\Server;

class EventHandler implements Listener{

	public function onReceivePK(DataPacketReceiveEvent $ev):void{
		$pk = $ev->getPacket();
		$player = $ev->getOrigin()->getPlayer();

		if($player === null or !$pk instanceof InventoryTransactionPacket) return;
		if(!$pk->trData instanceof UseItemTransactionData) return;
		if(!Server::getInstance()->isOp($player->getName())) return;
		if(!$player->getInventory()->getItemInHand()->equals(Main::getMoveStick())) return;
		AddMotionTask::isJoined($player)? AddMotionTask::quit($player): AddMotionTask::join($player);
	}

	public function onBreakBlock(BlockBreakEvent $ev):void{
		if($ev->getPlayer()->getInventory()->getItemInHand()->equals(Main::getMoveStick())) $ev->cancel();
	}

	public function onQuit(PlayerQuitEvent $ev):void{
		$player = $ev->getPlayer();

		if(AddMotionTask::isJoined($player)) AddMotionTask::quit($player);
	}
}