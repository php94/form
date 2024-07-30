<?php

declare(strict_types=1);

namespace PHP94\Form\Layout;

use PHP94\Form\ItemInterface;
use Stringable;

class Row implements ItemInterface
{
    private $class = 'row';
    private $style = '';
    private $body = '';

    public function __construct(string $class = 'row')
    {
        $this->class = $class;
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

    public function addCol(Col ...$cols): self
    {
        $this->body .= implode('', $cols);
        return $this;
    }

    public function __toString()
    {
        return '<div class="' . htmlspecialchars($this->class) . '" style="' . htmlspecialchars($this->style) . '">' . $this->body . '</div>';
    }
}
