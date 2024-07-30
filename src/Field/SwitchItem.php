<?php

declare(strict_types=1);

namespace PHP94\Form\Field;

use PHP94\Form\ItemInterface;
use PHP94\Form\Layout\Flex;
use Stringable;

class SwitchItem
{
    private $label;
    private $value;

    private $flex;

    public function __construct(string $label, string|int|float|bool|null|Stringable $value)
    {
        $this->label = $label;
        $this->value = (string)$value;
        $this->flex = new Flex;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getFlex(): Flex
    {
        return $this->flex;
    }

    public function addItem(ItemInterface ...$items): self
    {
        $this->flex->addItem(...$items);
        return $this;
    }

    public function addCustomItem(ItemInterface $item, string $class = '', string $style = ''): self
    {
        $this->flex->addCustomItem($item, $class, $style);
        return $this;
    }

    public function getBody(): Flex
    {
        return $this->flex;
    }
}
