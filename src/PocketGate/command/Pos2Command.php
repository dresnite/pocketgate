<?php

namespace PocketGate\command;

use PocketGate\session\Session;
use pocketmine\world\Position;

class Pos2Command extends PosCommand {

    public function __construct() {
        parent::__construct("pg1", "Sets PocketGate second position", "/pg2", ["pg2"]);
        $this->setPermission("pocketgate.command.pg2");
    }

    public function handlePositionSet(Position $position, Session $session): void {
        $session->setSecondPosition($position);
    }

}