<?php

namespace PocketGate\command;

use PocketGate\session\Session;
use pocketmine\world\Position;

class Pos1Command extends PosCommand {

    public function __construct() {
        parent::__construct("pg1", "Sets PocketGate first position", "/pg1", ["pg1"]);
        $this->setPermission("pocketgate.command.pg1");
    }

    public function handlePositionSet(Position $position, Session $session): void {
        $session->setFirstPosition($position);
    }

}