<?php

declare(strict_types=1);

namespace PHP94\Form\Field;

use Stringable;

class Radio implements Stringable
{
    private $label = '';
    private $name = '';
    private $value = '';
    private $checked = false;

    private $title = '';
    private $style = '';

    private $readonly = false;
    private $required = false;
    private $disabled = false;

    private $autofocus = false;
    private $autocomplete = false;

    public function __construct(string $label, string|int|float|bool|null|Stringable $value = null)
    {
        $this->label = $label;
        $this->value = (string)$value;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setChecked(bool $checked): self
    {
        $this->checked = $checked;
        return $this;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function setStyle(string $style): self
    {
        $this->style = $style;
        return $this;
    }

    public function setReadonly(bool $readonly = true): self
    {
        $this->readonly = $readonly;
        return $this;
    }

    public function setRequired(bool $required = true): self
    {
        $this->required = $required;
        return $this;
    }

    public function setDisabled(bool $disabled = true): self
    {
        $this->disabled = $disabled;
        return $this;
    }

    public function setAutocomplete(bool $autocomplete = true): self
    {
        $this->autocomplete = $autocomplete;
        return $this;
    }

    public function setAutofocus(bool $autofocus = true): self
    {
        $this->autofocus = $autofocus;
        return $this;
    }

    public function __toString()
    {
        $res = '';
        $res .= '<div class="form-check">';
        $res .= '<label class="form-check-label">';
        $res .= '<input type="radio" class="form-check-input"';

        if (strlen($this->name)) {
            $res .= ' name="' . htmlspecialchars($this->name) . '"';
        }
        if (strlen($this->value)) {
            $res .= ' value="' . htmlspecialchars($this->value) . '"';
        }
        if ($this->checked) {
            $res .= ' checked';
        }

        if (strlen($this->title)) {
            $res .= ' title="' . htmlspecialchars($this->title) . '"';
        }
        if (strlen($this->style)) {
            $res .= ' style="' . htmlspecialchars($this->style) . '"';
        }

        if ($this->required) {
            $res .= ' required';
        }
        if ($this->disabled) {
            $res .= ' disabled';
        }
        if ($this->readonly) {
            $res .= ' readonly';
        }

        if ($this->autofocus) {
            $res .= ' autofocus';
        }
        if ($this->autocomplete) {
            $res .= ' autocomplete="on"';
        }
        $res .= ' >';

        $res .= '<span>' . htmlspecialchars($this->label) . '</span>';
        $res .= '</label>';
        $res .= '</div>';

        return $res;
    }
}
