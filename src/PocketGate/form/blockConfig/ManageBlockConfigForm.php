<?php

namespace PocketGate\form\blockConfig;

use EasyUI\element\Button;
use EasyUI\variant\SimpleForm;
use PocketGate\block\blockConfig\BlockConfig;
use PocketGate\PocketGate;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class ManageBlockConfigForm extends SimpleForm {

    private BlockConfig $blockConfig;

    public function __construct(BlockConfig $blockConfig) {
        $this->blockConfig = $blockConfig;

        $hytopiaBlockName = $blockConfig->getBlockName();
        $hytopiaTextureUri = $blockConfig->getTextureUri();
        $isMultiTexture = $blockConfig->isMultiTexture() ? "Yes" : "No";

        parent::__construct(
            "Manage Block Configuration",
            "Hytopia block name:\n$hytopiaBlockName\n\nHytopia block texture uri:\n$hytopiaTextureUri\n\nMarked as multitexture:\n$isMultiTexture",
        );
    }

    protected function onCreation(): void {
        $this->addButton(new Button(
            "Remove block configuration",
            null,
            function (Player $player): void {
                PocketGate::getInstance()->getBlockConfigManager()->removeBlockConfig($this->blockConfig);
                $player->sendMessage(TextFormat::GREEN . "Block configuration removed.");
            }
        ));
    }

}