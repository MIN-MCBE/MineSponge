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
        else if ($rand === 99) return BlockFactory::getInstance()->get(56, 0);
        else if ($rand <= 50) return BlockFactory::getInstance()->get(1, 0);
        else if ($rand <= 70) return BlockFactory::getInstance()->get(16, 0);
        else if ($rand <= 80) return BlockFactory::getInstance()->get(15, 0);
        else if ($rand <= 88) return BlockFactory::getInstance()->get(14, 0);
        else if ($rand <= 93) return BlockFactory::getInstance()->get(21, 0);
        else if ($rand <= 98) return BlockFactory::getInstance()->get(74, 0);
        else return BlockFactory::getInstance()->get(1,0);
    }

    public function getItem(int $id): Item
    {
        return match ($id)
        {
            14 => ItemFactory::getInstance()->get(266, 0),
            15 => ItemFactory::getInstance()->get(265, 0),
            16 => ItemFactory::getInstance()->get(263, 0),
            56 => ItemFactory::getInstance()->get(264, 0),
            129 => ItemFactory::getInstance()->get(388, 0),
            21 => ItemFactory::getInstance()->get(351, 4, mt_rand(1, 4)),
            73, 74 => ItemFactory::getInstance()->get(331, 0, mt_rand(1, 4)),
            1 => ItemFactory::getInstance()->get(4, 0)
        };
    }

}
