<?php

namespace PocketGate\command;

use PocketGate\session\Session;
use pocketmine\utils\TextFormat;
use pocketmine\world\Position;

class Pos1Command extends SessionCommand {

    public function __construct() {
        parent::__construct("pg1", "Sets PocketGate first position", "/pg1", ["pg1"]);
        $this->setPermission("pocketgate.command.pg1");
    }

    public function onCommand(Position $position, Session $session): void {
        $session->setFirstPosition($position);
        $session->sendMessage(TextFormat::GREEN . "First position has been set.");
    }

}