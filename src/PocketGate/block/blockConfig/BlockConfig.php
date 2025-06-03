<?php

namespace PocketGate\block\blockConfig;

class BlockConfig {

    private string $uniqueId;
    private string $blockName;
    private string $textureUri;
    private bool $isMultiTexture;

    public function __construct(string $blockName, string $textureUri, bool $isMultiTexture) {
        $this->uniqueId = uniqid();
        $this->blockName = $blockName;
        $this->textureUri = $textureUri;
        $this->isMultiTexture = $isMultiTexture;
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

    public function isMultiTexture(): bool {
        return $this->isMultiTexture;
    }

}