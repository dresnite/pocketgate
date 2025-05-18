<?php

namespace PocketGate\session;

use pocketmine\player\Player;
use pocketmine\world\Position;

class Session {

    private Player $player;

    private ?Position $firstPosition = null;
    private ?Position $secondPosition = null;

    public function __construct(Player $player) {
        $this->player = $player;
    }

    public function getPlayer(): Player {
        return $this->player;
    }

    public function getFirstPosition(): ?Position {
        return $this->firstPosition;
    }

    public function setFirstPosition(?Position $firstPosition): void {
        $this->firstPosition = $firstPosition;
    }

    public function getSecondPosition(): ?Position {
        return $this->secondPosition;
    }

    public function setSecondPosition(?Position $secondPosition): void {
        $this->secondPosition = $secondPosition;
    }

}