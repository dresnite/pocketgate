<?php

namespace PocketGate\block\blockConfig;

use PocketGate\PocketGate;

class BlockConfigManager {

    private bool $loaded = false;

    /** @var BlockConfig[] */
    private array $blockConfigurations = [];

    private const BLOCK_NAME = "blockName";
    private const TEXTURE_URI = "textureUri";
    private const IS_MULTI_TEXTURE = "isMultiTexture";

    /**
     * @return BlockConfig[]
     */
    public function getBlockConfigurations(): array {
        return $this->blockConfigurations;
    }

    public function removeBlockConfig(BlockConfig $blockConfig): void {
        unset($this->blockConfigurations[$blockConfig->getUniqueId()]);
    }

    public function addBlockConfig(BlockConfig $blockConfig): void {
        $this->blockConfigurations[$blockConfig->getUniqueId()] = $blockConfig;
    }

    public function loadBlockConfiguration(): void {
        $blocksUnparsed = json_decode(file_get_contents($this->getBlockConfigFilePath()), true);

        foreach ($blocksUnparsed as $blockUnparsed) {
            $this->addBlockConfig(new BlockConfig(
                $blockUnparsed[self::BLOCK_NAME],
                $blockUnparsed[self::TEXTURE_URI],
                $blockUnparsed[self::IS_MULTI_TEXTURE] ?? false
            ));
        }

        $this->loaded = true;
    }

    public function saveBlockConfiguration(): void {
        if (!$this->loaded) return;

        $data = [];

        foreach ($this->blockConfigurations as $blockConfig) {
            $data[] = [
                self::BLOCK_NAME => $blockConfig->getBlockName(),
                self::TEXTURE_URI => $blockConfig->getTextureUri(),
                self::IS_MULTI_TEXTURE => $blockConfig->isMultiTexture()
            ];
        }

        file_put_contents($this->getBlockConfigFilePath(), json_encode($data));
    }

    private function getBlockConfigFilePath(): string {
        return PocketGate::getInstance()->getDataFolder() . "/block-config.json";
    }
}