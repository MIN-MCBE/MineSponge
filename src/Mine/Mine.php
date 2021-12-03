<?php

declare(strict_types=1);

namespace Mine;

use Mine\EventListener;

use pocketmine\block\Block;
use pocketmine\block\BlockFactory;

use pocketmine\item\Item;
use pocketmine\item\ItemFactory;

use pocketmine\plugin\PluginBase;

class Mine extends PluginBase
{
    public function onEnable(): void
    {
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
    }

    public function randBlock(): Block
    {
        $rand = mt_rand(1, 100);
        if ($rand === 100) return BlockFactory::getInstance()->get(129, 0);
        if ($rand === 99) return BlockFactory::getInstance()->get(56, 0);
        if ($rand <= 50) return BlockFactory::getInstance()->get(1, 0);
        if ($rand <= 70) return BlockFactory::getInstance()->get(16, 0);
        if ($rand <= 80) return BlockFactory::getInstance()->get(15, 0);
        if ($rand <= 88) return BlockFactory::getInstance()->get(14, 0);
        if ($rand <= 93) return BlockFactory::getInstance()->get(21, 0);
        if ($rand <= 98) return BlockFactory::getInstance()->get(74, 0);
        else return BlockFactory::getInstance()->get(1,0);
    }

    public function getItem(int $id): Item
    {
        if ($id == 14) return ItemFactory::getInstance()->get(266, 0);
        if ($id == 15) return ItemFactory::getInstance()->get(265, 0);
        if ($id == 16) return ItemFactory::getInstance()->get(263, 0);
        if ($id == 56) return ItemFactory::getInstance()->get(264, 0);
        if ($id == 129) return ItemFactory::getInstance()->get(388, 0);
        if ($id == 21) return ItemFactory::getInstance()->get(351, 4, mt_rand(1, 4));
        if ($id == 73 or $id == 74) return ItemFactory::getInstance()->get(331, 0, mt_rand(1, 4));
        if ($id == 1) return ItemFactory::getInstance()->get(4, 0);
        return ItemFactory::getInstance()->get($id);
    }

}
