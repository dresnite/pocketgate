<?php

namespace PocketGate\block\blockMap;

use PocketGate\PocketGate;

class BlockMapManager {

    private bool $loaded = false;

    /** @var BlockMap[] */
    private array $blockMaps = [];

    private const MINECRAFT_BLOCK_NAME = "minecraft_block_name";
    private const HYTOPIA_BLOCK_NAME = "hytopia_block_name";

    /**
     * @return BlockMap[]
     */
    public function getBlockMaps(): array {
        return $this->blockMaps;
    }

    public function getBlockMapByMinecraftBlockName(string $minecraftBlockName): ?BlockMap {
        return $this->blockMaps[$minecraftBlockName] ?? null;
    }

    public function removeBlockMap(BlockMap $blockMap): void {
        unset($this->blockMaps[$blockMap->getMinecraftBlockName()]);
    }

    public function addBlockMap(BlockMap $blockMap): void {
        $this->blockMaps[$blockMap->getMinecraftBlockName()] = $blockMap;
    }

    public function loadBlockMaps(): void {
        $blocksUnparsed = json_decode(file_get_contents($this->getBlocksFilePath()), true);

        foreach ($blocksUnparsed as $blockUnparsed) {
            $this->addBlockMap(new BlockMap(
                $blockUnparsed[self::MINECRAFT_BLOCK_NAME],
                $blockUnparsed[self::HYTOPIA_BLOCK_NAME],
            ));
        }

        $this->loaded = true;
    }

    public function saveBlockMaps(): void {
        if(!$this->loaded) {
            return;
        }

        $data = [];

        foreach ($this->blockMaps as $blockMap) {
            $data[] = [
                self::MINECRAFT_BLOCK_NAME => $blockMap->getMinecraftBlockName(),
                self::HYTOPIA_BLOCK_NAME => $blockMap->getHytopiaBlockName(),
            ];
        }

        file_put_contents($this->getBlocksFilePath(), json_encode($data));
    }

    private function getBlocksFilePath(): string {
        return PocketGate::getInstance()->getDataFolder() . "/blocks.json";
    }

}