<?php

declare(strict_types=1);

namespace PHP94\Form\Field;

use PHP94\Form\ItemInterface;
use Stringable;

class Color implements ItemInterface
{

    private $label = '';
    private $name = '';
    private $value = '';

    private $help = '';

    private $class = 'form-control';
    private $style = 'max-width: 150px;';
    private $title = '';

    private $readonly = false;
    private $required = false;
    private $disabled = false;

    private $autocomplete = false;
    private $autofocus = false;

    public function __construct(string $label, string $name, string|null|Stringable $value = '')
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = (string)$value;
    }

    public function setHelp(string $help): self
    {
        $this->help = $help;
        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }
    public function setClass(string $class): self
    {
        $this->class = $class;
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
        $str = '';
        $str .= '<label class="form-label">' . htmlspecialchars($this->label) . '</label>';

        $str .= '<input';
        $str .= ' type="color"';
        $str .= ' name="' . htmlspecialchars($this->name) . '"';
        $str .= ' value="' . htmlspecialchars($this->value) . '"';

        if (strlen($this->title)) {
            $str .= ' title="' . htmlspecialchars($this->title) . '"';
        }
        if (strlen($this->class)) {
            $str .= ' class="' . htmlspecialchars($this->class) . '"';
        }
        if (strlen($this->style)) {
            $str .= ' style="' . htmlspecialchars($this->style) . '"';
        }

        if ($this->required) {
            $str .= ' required';
        }
        if ($this->disabled) {
            $str .= ' disabled';
        }
        if ($this->readonly) {
            $str .= ' readonly';
        }

        if ($this->autofocus) {
            $str .= ' autofocus="on"';
        }
        if ($this->autocomplete) {
            $str .= ' autocomplete="on"';
        }
        $str .= ' >';

        if (strlen($this->help)) {
            $str .= '<div class="form-text">' . htmlspecialchars($this->help) . '</div>';
        }
        return $str;
    }
}
