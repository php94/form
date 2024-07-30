<?php

declare(strict_types=1);

namespace PHP94\Form\Layout;

use PHP94\Form\ItemInterface;
use Stringable;

class Col implements Stringable
{
    private $class = 'col';
    private $style = '';

    private $flex;

    public function __construct($class = 'col')
    {
        $this->class = $class;
        $this->flex = new Flex();
    }

    public function setClass(Stringable|string $class = ''): self
    {
        $this->class = (string)$class;
        return $this;
    }

    public function setStyle(Stringable|string $style = ''): self
    {
        $this->style = (string)$style;
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

    public function __toString()
    {
        return '<div class="' . htmlspecialchars($this->class) . '" style="' . htmlspecialchars($this->style) . '">' . $this->flex . '</div>';
    }
}
