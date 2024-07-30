<?php

declare(strict_types=1);

namespace PHP94\Form\Help;

use PHP94\Form\ItemInterface;
use PHP94\Form\Layout\Flex;

class Summary implements ItemInterface
{
    private $label;
    private $open = false;
    private $flex;

    public function __construct(string $label)
    {
        $this->label = $label;
        $this->flex = new Flex;
    }

    public function setOpen(bool $open): self
    {
        $this->open = $open;
        return $this;
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

    public function __toString(): string
    {
        $open = $this->open ? 'open' : '';
        $label = htmlspecialchars($this->label);
        return <<<str
<details {$open}>
<summary>{$label}</summary>
{$this->flex}
</details>
str;
    }
}
