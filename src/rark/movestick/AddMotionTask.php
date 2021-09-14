<?php
declare(strict_types = 1);

namespace rark\movestick;

use pocketmine\player\GameMode;
use pocketmine\player\Player;
use pocketmine\scheduler\Task;
use pocketmine\world\particle\RedstoneParticle;
use pocketmine\world\sound\NoteInstrument;
use pocketmine\world\sound\NoteSound;

class AddMotionTask extends Task{
	/** @var Player[string] */
	protected static array $targets = [];
	protected static array $player_gamemodes = [];

	public static function join(Player $player):void{
		self::$targets[$player->getName()] = $player;
		self::$player_gamemodes[$player->getName()] = $player->getGamemode();
		$player->setGamemode(GameMode::SPECTATOR());
		$player->getWorld()->addSound($player->getPosition(), new NoteSound(NoteInstrument::PIANO(), 7));
	}

	public static function quit(Player $player):void{
		$player->setGamemode(
			isset(self::$player_gamemodes[$player->getName()])?
				self::$player_gamemodes[$player->getName()]:
				GameMode::CREATIVE()
		);
		unset(self::$targets[$player->getName()]);
		unset(self::$player_gamemodes[$player->getName()]);
		$player->getWorld()->addSound($player->getPosition(), new NoteSound(NoteInstrument::PIANO(), 2));
	}

	public static function isJoined(Player $player):bool{
		return isset(self::$targets[$player->getName()]);
	}

	final public function onRun():void{
		/** @var Player $player */
		foreach(self::$targets as $player){
			if(!$player instanceof Player) return; //リフレクション対策
			$player->setMotion($player->getDirectionVector()->multiply(2.3));
			$player->getWorld()->addParticle($player->getPosition()->add(0.5, 1, 0.5), new RedstoneParticle(10));
		}
	}
}