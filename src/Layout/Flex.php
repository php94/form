<?php

declare(strict_types=1);

namespace PHP94\Form\Layout;

use PHP94\Form\ItemInterface;
use Stringable;

class Flex implements ItemInterface
{
    private $class = '';
    private $style = '';
    private $body = '';

    public function __construct(Stringable|string $class = 'd-flex flex-column gap-3')
    {
        $this->class = (string)$class;
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

    public function addItem(ItemInterface ...$items): self
    {
        $this->body .= '<div>' . implode('</div><div>', $items) . '</div>';
        return $this;
    }

    public function addCustomItem(ItemInterface $item, string $class = '', string $style = ''): self
    {
        $this->body .= '<div class="' . htmlspecialchars($class) . '" class="' . htmlspecialchars($style) . '">' . $item . '</div>';
        return $this;
    }

    public function __toString()
    {
        return '<div class="' . htmlspecialchars($this->class) . '" style="' . htmlspecialchars($this->style) . '">' . $this->body . '</div>';
    }
}
