<?php

namespace PocketGate\converter;

use PocketGate\PocketGate;
use PocketGate\session\Session;
use pocketmine\block\Air;
use pocketmine\item\StringToItemParser;
use pocketmine\math\Vector3;
use pocketmine\utils\TextFormat;
use pocketmine\world\World;

class BlockConverter {

    private Session $session;

    private ?World $world = null;

    private ?Vector3 $firstPos = null;
    private ?Vector3 $secondPos = null;

    static public function convertFor(Session $session): void {
        $converter = new BlockConverter($session);

        $converter->setFirstPos($session->getFirstPosition());
        $converter->setSecondPos($session->getSecondPosition());
        $converter->setWorld($session->getFirstPosition()?->getWorld());

        if(!$converter->attemptToConvert()) {
            $session->sendMessage(TextFormat::RED . "Couldn't convert the world");
        }
    }

    public function __construct(Session $session) {
        $this->session = $session;
    }

    public function setWorld(?World $world): void {
        $this->world = $world;
    }

    public function setFirstPos(?Vector3 $firstPos): void {
        $this->firstPos = $firstPos;
    }

    public function setSecondPos(?Vector3 $secondPos): void {
        $this->secondPos = $secondPos;
    }

    public function attemptToConvert(): bool {
        $player = $this->session->getPlayer();

        if ($this->firstPos === null) {
            $player->sendMessage(TextFormat::RED . "You didn't have a valid first position set");
            return false;
        }

        if ($this->secondPos === null) {
            $player->sendMessage(TextFormat::RED . "You didn't have a valid second position set");
            return false;
        }

        if ($this->world === null) {
            $player->sendMessage(TextFormat::RED . "You didn't have a valid world set");
            return false;
        }

        $player->sendMessage(TextFormat::YELLOW . "The conversion is starting...");
        $player->sendMessage(TextFormat::YELLOW . "This might take a while, prepare your popcorn.");

        $blocksConverted = $this->convert($this->firstPos, $this->secondPos, $this->world);

        $player->sendMessage(TextFormat::GREEN . "Successfully converted $blocksConverted blocks");

        return true;
    }

    private function convert(Vector3 $firstPos, Vector3 $secondPos, World $world): int {
        $timestamp = time(); // get current Unix timestamp
        $currentDateAsText = date("Y-m-d H:i:s", $timestamp);
        $tempFile = PocketGate::getInstance()->getHytopiaWorldsFolder() . $currentDateAsText . ".tmp";
        $finalFile = PocketGate::getInstance()->getHytopiaWorldsFolder() . $currentDateAsText . ".json";

        // Start writing the file with block types
        $blockTypes = [];
        $uniqueId = 1;
        $hytopiaBlockNameToUniqueIdMap = [];
        foreach (PocketGate::getInstance()->getBlockConfigManager()->getBlockConfigurations() as $blockConfig) {
            $blockTypes[] = [
                "id" => $uniqueId,
                "name" => $blockConfig->getBlockName(),
                "textureUri" => $blockConfig->getTextureUri(),
                "isMultiTexture" => $blockConfig->isMultiTexture(),
                "isCustom" => $blockConfig->isCustom()
            ];

            $hytopiaBlockNameToUniqueIdMap[$blockConfig->getBlockName()] = $uniqueId;
            $uniqueId++;
        }

        // Write initial structure with block types
        $initialData = [
            "blockTypes" => $blockTypes,
            "blocks" => []
        ];
        file_put_contents($tempFile, json_encode($initialData));

        $minX = min($firstPos->getFloorX(), $secondPos->getFloorX());
        $maxX = max($firstPos->getFloorX(), $secondPos->getFloorX());
        $minY = min($firstPos->getFloorY(), $secondPos->getFloorY());
        $maxY = max($firstPos->getFloorY(), $secondPos->getFloorY());
        $minZ = min($firstPos->getFloorZ(), $secondPos->getFloorZ());
        $maxZ = max($firstPos->getFloorZ(), $secondPos->getFloorZ());

        $blocksConverted = 0;
        $currentChunk = [];
        $chunkSize = 100;

        $blockMapManager = PocketGate::getInstance()->getBlockMapManager();

        for ($x = $minX; $x <= $maxX; $x++) {
            for ($y = $minY; $y <= $maxY; $y++) {
                for ($z = $minZ; $z <= $maxZ; $z++) {
                    $block = $world->getBlockAt($x, $y, $z);

                    if ($block instanceof Air) {
                        continue;
                    }

                    $relativeX = $x - $minX;
                    $relativeY = $y - $minY;
                    $relativeZ = $z - $minZ;

                    $blockAliases = StringToItemParser::getInstance()->lookupBlockAliases($block);

                    $found = null;
                    foreach ($blockAliases as $blockAlias) {
                        $blockMap = $blockMapManager->getBlockMapByMinecraftBlockName($blockAlias);

                        if ($blockMap !== null) {
                            $found = $blockMap;
                            break;
                        }
                    }

                    $currentChunk["$relativeX,$relativeY,$relativeZ"] = $hytopiaBlockNameToUniqueIdMap[$found?->getHytopiaBlockName()] ?? 1;
                    $blocksConverted++;

                    // When we reach chunk size, append to file
                    if (count($currentChunk) >= $chunkSize) {
                        $this->appendBlocksToFile($tempFile, $currentChunk);
                        $currentChunk = [];
                    }
                }
            }
        }

        // Write any remaining blocks
        if (!empty($currentChunk)) {
            $this->appendBlocksToFile($tempFile, $currentChunk);
        }

        // Rename temp file to final file
        rename($tempFile, $finalFile);

        return $blocksConverted;
    }

    private function appendBlocksToFile(string $file, array $blocks): void {
        // Read the current content
        $content = json_decode(file_get_contents($file), true);
        
        // Merge new blocks
        $content["blocks"] = array_merge($content["blocks"], $blocks);
        
        // Write back to file
        file_put_contents($file, json_encode($content));
    }

}