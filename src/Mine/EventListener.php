<?php

declare(strict_types=1);

namespace Mine;

use Mine\Mine;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\Listener;

use pocketmine\world\Position;

class EventListener implements Listener
{
    public function __construct(private Mine $plugin){}

    public function onBreak(BlockBreakEvent $event): void
    {
        $player = $event->getPlayer();
        $block = $event->getBlock();
        $pos = $block->getPosition();
        $pos2 = new Position($pos->getX(), $pos->getY() - 1, $pos->getZ(), $pos->getWorld());
        if ($pos->getWorld()->getBlock($pos2)->getId() == 19) {
            $event->cancel();
            $pos->getWorld()->setBlock($pos, $this->plugin->randBlock());
            $player->getInventory()->addItem($this->plugin->getItem($block->getId()));
        }
    }

    public function onPlace(BlockPlaceEvent $event): void
    {
        $block = $event->getBlock();
        $pos1 = $block->getPosition();
        $pos2 = new Position($pos1->getX(), $pos1->getY() + 1, $pos1->getZ(), $pos1->getWorld());
        if ($block->getId() == 19) {
            $pos1->getWorld()->setBlock($pos2, $this->plugin->randBlock(), true);
        }
    }
}
