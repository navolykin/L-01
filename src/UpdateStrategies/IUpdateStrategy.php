<?php

declare(strict_types=1);

namespace Shop\UpdateStrategies;

use Shop\Item;

interface IUpdateStrategy
{
    public function updateQuality(Item $item): void;
}
