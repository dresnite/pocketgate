<?php

namespace PocketGate;

use PocketGate\block\blockConfig\BlockConfigManager;
use PocketGate\block\blockMap\BlockMapManager;
use PocketGate\command\ConvertCommand;
use PocketGate\command\PocketGateCommand;
use PocketGate\command\Pos1Command;
use PocketGate\command\Pos2Command;
use PocketGate\listener\SessionListener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

class PocketGate extends PluginBase {
    use SingletonTrait;

    private BlockMapManager $blockMapManager;
    private BlockConfigManager $blockConfigManager;

    protected function onLoad(): void {
        self::setInstance($this);
    }

    protected function onEnable(): void {
        $this->createWorldsFolder();

        $this->saveResources();
        $this->registerCommands();

        $this->blockMapManager = new BlockMapManager();
        $this->blockMapManager->loadBlockMaps();

        $this->blockConfigManager = new BlockConfigManager();
        $this->blockConfigManager->loadBlockConfiguration();

        $this->registerListeners();
    }

    protected function onDisable(): void {
        $this->blockMapManager->saveBlockMaps();
        $this->blockConfigManager->saveBlockConfiguration();
    }

    public function getBlockMapManager(): BlockMapManager {
        return $this->blockMapManager;
    }

    public function getBlockConfigManager(): BlockConfigManager {
        return $this->blockConfigManager;
    }

    public function getHytopiaWorldsFolder(): string {
        return $this->getDataFolder() . "hytopia-worlds/";
    }

    private function saveResources(): void {
        $this->saveResource("blocks.json");
        $this->saveResource("block-config.json");
    }

    private function registerCommands(): void {
        $commandMap = $this->getServer()->getCommandMap();
        $fallbackPrefix = "pocketgate";

        $commandMap->register($fallbackPrefix, new PocketGateCommand());
        $commandMap->register($fallbackPrefix, new Pos1Command());
        $commandMap->register($fallbackPrefix, new Pos2Command());
        $commandMap->register($fallbackPrefix, new ConvertCommand());
    }

    private function registerListeners(): void {
        $pluginManager = $this->getServer()->getPluginManager();
        $pluginManager->registerEvents(new SessionListener(), $this);
    }

    private function createWorldsFolder(): void {
        $path = $this->getHytopiaWorldsFolder();

        if (!is_dir($path)) {
            mkdir($path);
        }
    }

}