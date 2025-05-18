<?php

namespace PocketGate\form;

use EasyUI\element\Button;
use EasyUI\variant\SimpleForm;
use PocketGate\converter\BlockConverter;
use PocketGate\form\blockConfig\BlockConfigForm;
use PocketGate\form\blockMap\BlockMapperForm;
use PocketGate\session\SessionFactory;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class MainForm extends SimpleForm {

    public function __construct() {
        parent::__construct("PocketGate");
    }

    protected function onCreation(): void {
        $this->addButton(new Button("Block Conversion Map", null, function(Player $player): void {
            $player->sendForm(new BlockMapperForm());
        }));

        $this->addButton(new Button("Hytopia Block Configuration", null, function(Player $player): void {
            $player->sendForm(new BlockConfigForm());
        }));

        $this->addButton(new Button("Set first position", null, function(Player $player): void {
            SessionFactory::getSessionOrThrow($player)->setFirstPosition($player->getPosition());
            $player->sendMessage(TextFormat::GREEN . "You have set first position.");
        }));

        $this->addButton(new Button("Set second position", null, function(Player $player): void {
            SessionFactory::getSessionOrThrow($player)->setSecondPosition($player->getPosition());
            $player->sendMessage(TextFormat::GREEN . "You have set second position.");
        }));

        $this->addButton(new Button("Convert selection to Hytopia's format", null, function(Player $player): void {
            $converter = new BlockConverter();
            $session = SessionFactory::getSessionOrThrow($player);

            $converter->setSession($session);
            $converter->setFirstPos($session->getFirstPosition());
            $converter->setSecondPos($session->getSecondPosition());
            $converter->setWorld($session->getFirstPosition()?->getWorld());

            if(!$converter->attemptToConvert()) {
                $player->sendMessage(TextFormat::RED . "Couldn't convert the world");
            }
        }));
    }

}