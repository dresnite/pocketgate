<?php

namespace PocketGate\block\blockConfig;

class BlockConfig {

    private string $uniqueId;
    private string $blockName;
    private string $textureUri;

    public function __construct(string $blockName, string $textureUri) {
        $this->uniqueId = uniqid();
        $this->blockName = $blockName;
        $this->textureUri = $textureUri;
    }

    public function getUniqueId(): string {
        return $this->uniqueId;
    }

    public function getBlockName(): string {
        return $this->blockName;
    }

    public function getTextureUri(): string {
        return $this->textureUri;
    }

}