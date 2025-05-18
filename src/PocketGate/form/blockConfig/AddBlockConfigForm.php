<?php

namespace PocketGate\form\blockConfig;

use Closure;
use EasyUI\element\Input;
use EasyUI\utils\FormResponse;
use EasyUI\variant\CustomForm;
use PocketGate\block\blockConfig\BlockConfig;
use PocketGate\PocketGate;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class AddBlockConfigForm extends CustomForm {

    private const BLOCK_NAME = "block_name";
    private const TEXTURE_URI_INPUT = "texture_uri";

    public function __construct() {
        parent::__construct("Add block config");
    }

    protected function onCreation(): void {
        $this->addElement(self::BLOCK_NAME, new Input("Enter the block name:"));
        $this->addElement(self::TEXTURE_URI_INPUT, new Input("Enter the texture URI:"));
    }

    protected function onSubmit(Player $player, FormResponse $response): void {
        $blockName = $response->getInputSubmittedText(self::BLOCK_NAME);
        $textureUri = $response->getInputSubmittedText(self::TEXTURE_URI_INPUT);

        PocketGate::getInstance()->getBlockConfigManager()->addBlockConfig(
            new BlockConfig($blockName, $textureUri)
        );

        $player->sendMessage(TextFormat::GREEN . "Block configuration added!");
    }

}