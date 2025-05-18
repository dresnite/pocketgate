<?php

namespace PocketGate\form\blockMap;

use EasyUI\element\Button;
use EasyUI\variant\SimpleForm;
use PocketGate\block\blockMap\BlockMap;
use PocketGate\PocketGate;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class ManageBlockMapForm extends SimpleForm {

    private BlockMap $blockMap;

    public function __construct(BlockMap $blockMap) {
        $this->blockMap = $blockMap;

        $minecraftBlockName = $blockMap->getMinecraftBlockName();
        $hytopiaBlockName = $blockMap->getHytopiaBlockName();

        parent::__construct(
            $minecraftBlockName,
            "Minecraft block:\n$minecraftBlockName\n\nHytopia block:\n$hytopiaBlockName"
        );
    }

    protected function onCreation(): void {
        $this->addButton(new Button("Remove block", null, function(Player $player): void {
            PocketGate::getInstance()->getBlockMapManager()->removeBlockMap($this->blockMap);
            $player->sendMessage(TextFormat::GREEN . "Block map removed!");
        }));
    }

}