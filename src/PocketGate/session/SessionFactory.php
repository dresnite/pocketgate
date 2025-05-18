<?php

namespace PocketGate\session;

use pocketmine\player\Player;

class SessionFactory {

    /** @var Session[] */
    private static array $sessions = [];

    public static function getSession(Player $player): ?Session {
        return self::$sessions[$player->getName()] ?? null;
    }

    public static function getSessionOrThrow(Player $player): Session {
        $session = self::getSession($player);

        if ($session === null) {
            throw new \Error("Couldn't find the session of the player {$player->getName()}");
        }

        return $session;
    }

    public static function openSession(Player $player): void {
        self::$sessions[$player->getName()] = new Session($player);
    }

    public static function closeSession(Player $player): void {
        unset(self::$sessions[$player->getName()]);
    }

}