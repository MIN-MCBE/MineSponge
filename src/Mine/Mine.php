<?php

declare(strict_types=1);

namespace Mine;

use pocketmine\block\Block;
use pocketmine\block\BlockTypeIds;
use pocketmine\block\Sponge;
use pocketmine\block\VanillaBlocks;
use pocketmine\event\block\{BlockBreakEvent, BlockPlaceEvent};
use pocketmine\event\EventPriority;
use pocketmine\item\Item;
use pocketmine\item\VanillaItems;
use pocketmine\plugin\PluginBase;
use function mt_rand;

final class Mine extends PluginBase
{
	protected function onEnable(): void
	{
		$pluginmanager = $this->getServer()->getPluginManager();
		$pluginmanager->registerEvent(BlockBreakEvent::class, function(BlockBreakEvent $event): void {
			$block = $event->getBlock();
			$pos = $block->getPosition();
			$world = $pos->world;
			if($world->getBlockAt($pos->x, $pos->y - 1, $pos->z) instanceof Sponge) {
				$event->cancel();
				$world->setBlock($pos, $this->randBlock());
				$event->getPlayer()->getInventory()->addItem($this->getItem($block->getTypeId()));
			}
		}, EventPriority::NORMAL, $this, true);
		$pluginmanager->registerEvent(BlockPlaceEvent::class, function(BlockPlaceEvent $event): void {
			$block = $event->getBlock();
			if($block instanceof Sponge) {
				$pos = $block->getPosition();
				$pos->y += 1;
				$pos->world->setBlock($pos, $this->randBlock());
			}
		}, EventPriority::NORMAL, $this);
	}

	public function randBlock(): Block
	{
		$rand = mt_rand(1, 100);
		if($rand === 100) return VanillaBlocks::EMERALD_ORE();
		if($rand === 99) return VanillaBlocks::DIAMOND_ORE();
		if($rand <= 50) return VanillaBlocks::STONE();
		if($rand <= 70) return VanillaBlocks::COAL_ORE();
		if($rand <= 80) return VanillaBlocks::IRON_ORE();
		if($rand <= 88) return VanillaBlocks::GOLD_ORE();
		if($rand <= 93) return VanillaBlocks::LAPIS_LAZULI_ORE();
		if($rand <= 98) return VanillaBlocks::REDSTONE_ORE();
		return VanillaBlocks::STONE();
	}

	public function getItem(int $id): Item
	{
		return match ($id) {
			BlockTypeIds::GOLD_ORE => VanillaItems::GOLD_INGOT(),
			BlockTypeIds::IRON_ORE => VanillaItems::IRON_INGOT(),
			BlockTypeIds::COAL_ORE => VanillaItems::COAL(),
			BlockTypeIds::DIAMOND_ORE => VanillaItems::DIAMOND(),
			BlockTypeIds::EMERALD_ORE => VanillaItems::EMERALD(),
			BlockTypeIds::LAPIS_LAZULI_ORE => VanillaItems::LAPIS_LAZULI()->setCount(mt_rand(1, 4)),
			BlockTypeIds::REDSTONE_ORE => VanillaItems::REDSTONE_DUST()->setCount(mt_rand(1, 4)),
			BlockTypeIds::STONE => VanillaBlocks::COBBLESTONE()->asItem(),
		};
	}

}
