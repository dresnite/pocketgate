<?php

namespace PocketGate\block\blockMap;

class BlockMap {

    private string $minecraftBlockName;
    private string $hytopiaBlockName;

    public function __construct(string $minecraftBlockName, string $hytopiaBlockName) {
        $this->minecraftBlockName = $minecraftBlockName;
        $this->hytopiaBlockName = $hytopiaBlockName;
    }

    public function getMinecraftBlockName(): string {
        return $this->minecraftBlockName;
    }

    public function getHytopiaBlockName(): string {
        return $this->hytopiaBlockName;
    }

}