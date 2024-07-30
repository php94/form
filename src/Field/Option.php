<?php

declare(strict_types=1);

namespace PHP94\Form\Field;

use Stringable;

class Option implements Stringable
{
    private $label = '';
    private $value = '';
    private $disabled = false;
    private $selected = false;

    public function __construct(string $label, string|int|float|bool|null|Stringable $value)
    {
        $this->label = $label;
        $this->value = (string)$value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setSelected(bool $selected): self
    {
        $this->selected = $selected;
        return $this;
    }

    public function setDisabled(bool $disabled): self
    {
        $this->disabled = $disabled;
        return $this;
    }

    public function __toString()
    {

        $res = '<option';
        $res .= ' value="' . htmlspecialchars($this->value) . '"';
        if ($this->selected) {
            $res .= ' selected';
        }
        if ($this->disabled) {
            $res .= ' disabled';
        }
        $res .= '>';
        $res .= htmlspecialchars($this->label);
        $res .= '</option>';

        return $res;
    }
}
