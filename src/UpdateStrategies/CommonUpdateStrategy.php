<?php

declare(strict_types=1);

namespace Shop\UpdateStrategies;

use Shop\Item;
use Shop\UpdateStrategies\IUpdateStrategy;

final class CommonUpdateStrategy implements IUpdateStrategy
{
    const QUALITY_DICREMENTOR = 1;
    const MIN_QUALITY = 0;

    public function updateQuality(Item $item): void
    {
        --$item->sell_in;

        if ($item->sell_in < 0) {
            $item->quality -= self::QUALITY_DICREMENTOR * 2;
        } else {
            $item->quality -= self::QUALITY_DICREMENTOR;
        }

        if ($item->quality < self::MIN_QUALITY) {
            $item->quality = self::MIN_QUALITY;
        }
    }
}