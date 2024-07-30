<?php

declare(strict_types=1);

namespace PHP94\Form\Help;

use PHP94\Form\ItemInterface;
use PHP94\Form\Layout\Flex;

class Fieldset implements ItemInterface
{
    private $legend;
    private $flex;

    private $name = '';
    private $disabled = false;

    public function __construct(string $legend)
    {
        $this->legend = $legend;
        $this->flex = new Flex;
    }

    public function setDisabeld(bool $disabled): self
    {
        $this->disabled = $disabled;
        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
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
        $str = '<fieldset';
        if (strlen($this->name)) {
            $str .= ' name="' . htmlspecialchars($this->name) . '"';
        }
        if ($this->disabled) {
            $str .= ' disabled';
        }
        $str .= ' >';
        $str .= '<legend>' . htmlspecialchars($this->legend) . '</legend>';
        $str .= $this->flex;
        $str .= '</fieldset>';
        return $str;
    }
}
