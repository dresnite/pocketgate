<?php

namespace PocketGate\command;

use PocketGate\converter\BlockConverter;
use PocketGate\session\Session;
use pocketmine\world\Position;

class ConvertCommand extends SessionCommand {

    public function __construct() {
        parent::__construct("pgc", "Converts PocketGate positions", "/pgc", ["pgc"]);
        $this->setPermission("pocketgate.command.pgc");
    }

    public function onCommand(Position $position, Session $session): void {
        BlockConverter::convertFor($session);
    }

}