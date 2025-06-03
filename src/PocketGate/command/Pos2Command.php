<?php

namespace PocketGate\command;

use PocketGate\session\Session;
use pocketmine\utils\TextFormat;
use pocketmine\world\Position;

class Pos2Command extends SessionCommand {

    public function __construct() {
        parent::__construct("pg1", "Sets PocketGate second position", "/pg2", ["pg2"]);
        $this->setPermission("pocketgate.command.pg2");
    }

    public function onCommand(Position $position, Session $session): void {
        $session->setSecondPosition($position);
        $session->sendMessage(TextFormat::GREEN . "Second position has been set.");
    }

}