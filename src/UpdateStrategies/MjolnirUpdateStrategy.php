<?php

declare(strict_types=1);

namespace Shop\UpdateStrategies;

use Shop\Item;
use Shop\UpdateStrategies\IUpdateStrategy;

final class MjolnirUpdateStrategy implements IUpdateStrategy
{
    const QUALITY = 80;

    public function updateQuality(Item $item): void
    {
        $item->quality = self::QUALITY;
    }
}
