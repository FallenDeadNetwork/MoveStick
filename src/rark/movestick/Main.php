<?php
declare(strict_types = 1);

namespace rark\movestick;

use pocketmine\item\Item;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase{

	protected static Item $movestick;

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents(new EventHandler, $this);
		self::$movestick = Item::get(166, mt_rand(0x00f, 0xfff));
		self::$movestick->setCustomName('§cMoveStick');
		Item::addCreativeItem(self::$movestick);
		$this->getScheduler()->scheduleRepeatingTask(new AddMotionTask, 10);
	}
	
	public function onDisable(){
		Item::removeCreativeItem(self::$movestick);
	}

	public static function getMoveStick():Item{
		return clone self::$movestick;
	}
}