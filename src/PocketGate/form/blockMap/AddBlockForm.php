<?php

namespace PocketGate\form\blockMap;

use EasyUI\element\Input;
use EasyUI\utils\FormResponse;
use EasyUI\variant\CustomForm;
use PocketGate\block\blockMap\BlockMap;
use PocketGate\PocketGate;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class AddBlockForm extends CustomForm {

    private const MINECRAFT_BLOCK_INPUT = "minecraft_block";
    private const HYTOPIA_BLOCK_INPUT = "hytopia_block";

    public function __construct() {
        parent::__construct("Add new block");
    }

    protected function onCreation(): void {
        $this->addElement(self::MINECRAFT_BLOCK_INPUT, new Input("Enter the ID of the block you want to port:"));
        $this->addElement(self::HYTOPIA_BLOCK_INPUT, new Input("Enter the name of the block in Hytopia:"));
    }

    protected function onSubmit(Player $player, FormResponse $response): void
    {
        $minecraftBlockName = $response->getInputSubmittedText(self::MINECRAFT_BLOCK_INPUT);
        $hytopiaBlockName = $response->getInputSubmittedText(self::HYTOPIA_BLOCK_INPUT);

        PocketGate::getInstance()->getBlockMapManager()->addBlockMap(new BlockMap(
            $minecraftBlockName,
            $hytopiaBlockName
        ));

        $player->sendMessage(TextFormat::GREEN . "Block " . TextFormat::WHITE . $minecraftBlockName . TextFormat::GREEN .  " added successfully!");
    }

}