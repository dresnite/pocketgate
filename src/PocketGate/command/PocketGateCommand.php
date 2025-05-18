<?php

namespace PocketGate\command;

use PocketGate\form\MainForm;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class PocketGateCommand extends Command {

    public function __construct() {
        parent::__construct("pocketgate", "World converter command", "/pocketgate", ["pg"]);
        $this->setPermission("pocketgate.command");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): void {
        $sender->sendForm(new MainForm());
    }

}