<?php

namespace PocketGate\form\blockConfig;

use EasyUI\element\Button;
use EasyUI\variant\SimpleForm;
use PocketGate\PocketGate;
use pocketmine\player\Player;

class BlockConfigForm extends SimpleForm {

    public function __construct() {
        parent::__construct("Hytopia Block Configuration");
    }

    protected function onCreation(): void {
        $this->addButton(new Button("Add block config", null, function(Player $player): void {
            $player->sendForm(new AddBlockConfigForm());
        }));

        $this->loadBlockConfigButtons();
    }

    private function loadBlockConfigButtons(): void {
        foreach (PocketGate::getInstance()->getBlockConfigManager()->getBlockConfigurations() as $blockConfig) {
            $this->addButton(new Button(
                $blockConfig->getBlockName(),
                null,
                function (Player $player) use ($blockConfig) {
                    $player->sendForm(new ManageBlockConfigForm($blockConfig));
                }
            ));
        }
    }

}