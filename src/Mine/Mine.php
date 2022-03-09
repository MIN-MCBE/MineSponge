<?php

declare(strict_types=1);

namespace Mine;

use pocketmine\event\EventPriority;
use pocketmine\event\block\{BlockBreakEvent, BlockPlaceEvent};

use pocketmine\world\Position;

use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\block\Sponge;

use pocketmine\item\Item;
use pocketmine\item\ItemFactory;

use pocketmine\plugin\PluginBase;

use function mt_rand;

final class Mine extends PluginBase
{
    protected function onEnable(): void
    {
        $pluginmanager = $this->getServer()->getPluginManager();
        $pluginmanager->registerEvent(BlockBreakEvent::class, function(BlockBreakEvent $event) : void
        {
            $block = $event->getBlock();
            $pos = $block->getPosition();
            $world = $pos->world;
            if ($world->getBlockAt($pos->x, $pos->y - 1, $pos->z) instanceof Sponge) {
                $event->cancel();
                $world->setBlock($pos, $this->randBlock());
                $event->getPlayer()->getInventory()->addItem($this->getItem($block->getId()));
            }
        }, EventPriority::NORMAL, $this, true);
        $pluginmanager->registerEvent(BlockPlaceEvent::class, function(BlockPlaceEvent $event) : void
        {
            $block = $event->getBlock();
            if ($block instanceof Sponge) {
                $pos = $block->getPosition();
                $pos->y += 1;
                $pos->world->setBlock($pos, $this->randBlock(), true);
            }
        }, EventPriority::NORMAL, $this);
    }

    public function randBlock(): Block
    {
        $block = BlockFactory::getInstance();
        $rand = mt_rand(1, 100);
        if ($rand === 100) return $block->get(129, 0);
        if ($rand === 99) return $block->get(56, 0);
        if ($rand <= 50) return $block->get(1, 0);
        if ($rand <= 70) return $block->get(16, 0);
        if ($rand <= 80) return $block->get(15, 0);
        if ($rand <= 88) return $block->get(14, 0);
        if ($rand <= 93) return $block->get(21, 0);
        if ($rand <= 98) return $block->get(74, 0);
        return $block->get(1,0);
    }

    public function getItem(int $id): Item
    {
        $item = ItemFactory::getInstance();
        return match ($id)
        {
            14 => $item->get(266, 0),
            15 => $item->get(265, 0),
            16 => $item->get(263, 0),
            56 => $item->get(264, 0),
            129 => $item->get(388, 0),
            21 => $item->get(351, 4, mt_rand(1, 4)),
            73, 74 => $item->get(331, 0, mt_rand(1, 4)),
            1 => $item->get(4, 0)
        };
    }

}
