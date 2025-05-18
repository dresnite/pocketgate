<?php

namespace PocketGate\listener;

use PocketGate\session\SessionFactory;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;

class SessionListener implements Listener {

    public function onPlayerJoin(PlayerJoinEvent $event): void {
        SessionFactory::openSession($event->getPlayer());
    }

    public function onPlayerLeave(PlayerQuitEvent $event): void {
        SessionFactory::closeSession($event->getPlayer());
    }

}