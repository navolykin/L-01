<?php

declare(strict_types=1);

namespace Shop;

use Shop\UpdateStrategies\IUpdateStrategy;

final class Shop
{
    /**
     * @var Item[]
     */
    private $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            $updateStrategy = $this->getUpdateStrategy($item->name);
            $updateStrategy->updateQuality($item);
        }
    }

    public function getUpdateStrategy(string $name): IUpdateStrategy
    {
        $namespace = 'Shop\UpdateStrategies\\';
        $name_array = explode(' ', $name);
        foreach ($name_array as &$word) {
            $word = ucfirst(strtolower($word));
        }
        unset($word);

        $className = $namespace . implode('', $name_array) . 'UpdateStrategy';

        if (class_exists($className)) {
            return new $className();
        }

        $className = $namespace . 'CommonUpdateStrategy';

        return new  $className();
    }
}
