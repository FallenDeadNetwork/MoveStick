<?php
declare(strict_types = 1);

namespace rark\movestick;

use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase{

	protected static Item $movestick;

	protected function onEnable():void{
		$this->getServer()->getPluginManager()->registerEvents(new EventHandler, $this);
		self::$movestick = ItemFactory::getInstance()->get(166, 102);
		self::$movestick->setCustomName('§cMoveStick');
		$this->getScheduler()->scheduleRepeatingTask(new AddMotionTask, 1);
		$this->getServer()->getCommandMap()->register($this->getName(), new MoveStickCommand);
	}

	public static function getMoveStick():Item{
		return clone self::$movestick;
	}
}