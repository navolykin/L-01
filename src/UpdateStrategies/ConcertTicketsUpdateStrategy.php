<?php

declare(strict_types=1);

namespace Shop\UpdateStrategies;

use Shop\Item;
use Shop\UpdateStrategies\IUpdateStrategy;

final class ConcertTicketsUpdateStrategy implements IUpdateStrategy
{
    const MAX_QUALITY = 50;

    public function updateQuality(Item $item): void
    {
        --$item->sell_in;

        if ($item->sell_in >= 10) {
            $item->quality += 1;
        } elseif ($item->sell_in < 10 && $item->sell_in >= 5) {
            $item->quality += 2;
        } elseif ($item->sell_in < 5 && $item->sell_in >= 0) {
            $item->quality += 3;
        } elseif ($item->sell_in < 0) {
            $item->quality = 0;
        }

        if ($item->quality > self::MAX_QUALITY) {
            $item->quality = self::MAX_QUALITY;
        }
    }
}
