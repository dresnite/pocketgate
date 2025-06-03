<?php

namespace PocketGate\command;

use PocketGate\form\MainForm;
use PocketGate\session\Session;
use PocketGate\session\SessionFactory;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use pocketmine\world\Position;

abstract class SessionCommand extends Command {

    public function execute(CommandSender $sender, string $commandLabel, array $args): void {
        if (!$sender instanceof Player) {
            $sender->sendMessage(TextFormat::RED . "Please run this command in-game.");
            return;
        }

        $session = SessionFactory::getSession($sender);

        if ($session === null) {
            $sender->sendMessage(TextFormat::RED . "Session not found.");
            return;
        }

        $this->onCommand($sender->getPosition(), $session);
    }

    abstract function onCommand(Position $position, Session $session): void;

}