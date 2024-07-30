<?php

declare(strict_types=1);

namespace PHP94\Form\Field;

use Stringable;

class Checkbox implements Stringable
{
    private $label;
    private $name;
    private $value;

    private $checked = false;

    private $title = '';
    private $style = '';

    private $readonly = false;
    private $required = false;
    private $disabled = false;

    private $autofocus = false;

    public function __construct(string $label, string|int|float|bool|null|Stringable $value)
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

    public function setAutofocus(bool $autofocus = true): self
    {
        $this->autofocus = $autofocus;
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

    public function __toString(): string
    {
        $html = '';
        $html .= '<div class="form-check">';
        $html .= '<label class="form-check-label">';
        $html .= '<input class="form-check-input" type="checkbox"';
        if (strlen($this->name)) {
            $html .= ' name="' . htmlspecialchars($this->name) . '[]"';
        }
        if (strlen($this->value)) {
            $html .= ' value="' . htmlspecialchars($this->value) . '"';
        }
        if (strlen($this->title)) {
            $html .= ' title="' . htmlspecialchars($this->title) . '"';
        }
        if (strlen($this->style)) {
            $html .= ' style="' . htmlspecialchars($this->style) . '"';
        }
        if ($this->required) {
            $html .= ' required';
        }
        if ($this->disabled) {
            $html .= ' disabled';
        }
        if ($this->readonly) {
            $html .= ' readonly';
        }
        if ($this->autofocus) {
            $html .= ' autofocus';
        }
        if ($this->checked) {
            $html .= ' checked';
        }
        $html .= '>';
        $html .= ' <span>' . htmlspecialchars($this->label) . '</span>';
        $html .= '</label>';
        $html .= '</div>';
        return $html;
    }
}
