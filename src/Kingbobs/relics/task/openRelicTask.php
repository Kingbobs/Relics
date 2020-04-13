<?php

namespace Kingbobs/relics/task;

use pocketmine\command\ConsoleCommandSender;
use pocketmine\level\particle\ExplodeParticle;
use pocketmine\level\particle\CriticalParticle;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use function mt_rand;
use function str_replace;

class openRelicTask extends Task{

	public $x;
	public $y;
	public $z;
	public $player;
	public $type;
	public $plugin;

	public function __construct($x, $y, $z, Player $player, $type, $plugin){
		$this->x = $x;
		$this->y = $y;
		$this->z = $z;
		$this->player = $player;
		$this->type = $type;
		$this->plugin = $plugin;
	}

	/**
	 * @inheritDoc
	 */
	public function onRun(int $currentTick){
		$pos = new Vector3($this->x, $this->y, $this->z);
		$this->player->getLevel()->addParticle(new CriticalParticle($pos));
		$input = $this->plugin->config[$this->type]["Commands"];
		$command =  $input[mt_rand(0, count($input) - 1)];
		$cmd = str_replace("{PLAYER}", $this->player->getName(), $command);
		Server::getInstance()->dispatchCommand(new ConsoleCommandSender, $cmd);
		$this->plugin->opening[$this->player->getName()] = false;
	}
}
