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
            $update_strategy = $this->getUpdateStrategy($item->name);
            $update_strategy->updateQuality($item);
        }
    }

    private function getUpdateStrategy(string $name): IUpdateStrategy
    {
        $array_names = explode(' ', $name);

        foreach ($array_names as &$word) {
            $word = ucfirst(strtolower($word));
        }
        unset($word);

        $namespace = 'Shop\UpdateStrategies\\';

        $class_name = $namespace . implode('', $array_names) . 'UpdateStrategy';

        if (class_exists($class_name)) {
            return new $class_name();
        }

        $class_name = $namespace . 'CommonUpdateStrategy';

        return new  $class_name();
    }
}
