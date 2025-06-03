<?php

namespace PocketGate\form\blockConfig;

use EasyUI\element\Input;
use EasyUI\element\Toggle;
use EasyUI\utils\FormResponse;
use EasyUI\variant\CustomForm;
use PocketGate\block\blockConfig\BlockConfig;
use PocketGate\PocketGate;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class AddBlockConfigForm extends CustomForm {

    private const BLOCK_NAME = "block_name";
    private const TEXTURE_URI_INPUT = "texture_uri";
    private const IS_MULTI_TEXTURE_INPUT = "is_multi_txture";
    private const IS_CUSTOM_INPUT = "is_custom";

    public function __construct() {
        parent::__construct("Add block config");
    }

    protected function onCreation(): void {
        $this->addElement(self::BLOCK_NAME, new Input("Enter the block name:"));
        $this->addElement(self::TEXTURE_URI_INPUT, new Input("Enter the texture URI:"));
        $this->addElement(self::IS_MULTI_TEXTURE_INPUT, new Toggle("Mark as multi-texture:"));
        $this->addElement(self::IS_CUSTOM_INPUT, new Toggle("Mark as custom block:"));
    }

    protected function onSubmit(Player $player, FormResponse $response): void {
        $blockName = $response->getInputSubmittedText(self::BLOCK_NAME);
        $textureUri = $response->getInputSubmittedText(self::TEXTURE_URI_INPUT);
        $isMultiTexture = $response->getInputSubmittedText(self::IS_MULTI_TEXTURE_INPUT);
        $isCustom = $response->getInputSubmittedText(self::IS_CUSTOM_INPUT);

        PocketGate::getInstance()->getBlockConfigManager()->addBlockConfig(
            new BlockConfig($blockName, $textureUri, $isMultiTexture, $isCustom)
        );

        $player->sendMessage(TextFormat::GREEN . "Block configuration added!");
    }

}