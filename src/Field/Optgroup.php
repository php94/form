<?php

declare(strict_types=1);

namespace PHP94\Form\Field;

use Stringable;

class Optgroup implements Stringable
{
    private $label = '';
    private $disabled = false;
    private $options = [];

    public function __construct(string $label, bool $disabled = false)
    {
        $this->label = $label;
        $this->disabled = $disabled;
    }

    public function addOption(Option ...$options): self
    {
        array_push($this->options, ...$options);
        return $this;
    }

    /**
     * @return \PHP94\Form\Field\Option[]
     */
    public function getOptions()
    {
        return $this->options;
    }

    public function __toString()
    {
        $res = '<optgroup';
        $res .= ' label="' . htmlspecialchars($this->label) . '"';
        if ($this->disabled) {
            $res .= ' disabled';
        }
        $res .= '>';
        $res .= implode('', $this->options);
        $res .= '</optgroup>';

        return $res;
    }
}
