<?php

declare(strict_types=1);

namespace Shop\UpdateStrategies;

use Shop\Item;
use Shop\UpdateStrategies\IUpdateStrategy;

final class BlueCheeseUpdateStrategy implements IUpdateStrategy
{
    const QUALITY_INCREMENTOR = 1;
    const MAX_QUALITY = 50;

    public function updateQuality(Item $item): void
    {
        --$item->sell_in;

        if ($item->sell_in < 0) {
            $item->quality += self::QUALITY_INCREMENTOR * 2;
        } else {
            $item->quality += self::QUALITY_INCREMENTOR;
        }

        if ($item->quality > self::MAX_QUALITY) {
            $item->quality = self::MAX_QUALITY;
        }
    }
}
