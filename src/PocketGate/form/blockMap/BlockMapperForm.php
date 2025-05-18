<?php

namespace PocketGate\form\blockMap;

use EasyUI\element\Button;
use EasyUI\variant\SimpleForm;
use PocketGate\PocketGate;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class BlockMapperForm extends SimpleForm {

    public function __construct() {
        parent::__construct("Block Conversion Map", "Choose which blocks your Minecraft blocks will be converted into in your Hytopia game.");
    }

    protected function onCreation(): void {
        $this->addButton(new Button(TextFormat::RED . "Add block", null, function (Player $player): void {
            $player->sendForm(new AddBlockForm());
        }));

        $this->loadBlockMapButtons();
    }

    private function loadBlockMapButtons(): void {
        foreach (PocketGate::getInstance()->getBlockMapManager()->getBlockMaps() as $blockMap) {
            $this->addButton(new Button(
                $blockMap->getMinecraftBlockName(),
                null,
                function (Player $player) use ($blockMap): void {
                    $player->sendForm(new ManageBlockMapForm($blockMap));
                }));
        }
    }

}