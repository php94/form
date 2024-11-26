<?php

declare(strict_types=1);

namespace PHP94\Form\Field;

use PHP94\Form\ItemInterface;

class Selects implements ItemInterface
{
    private $label = null;
    private $name = null;
    private $checked = [];

    private $help = '';

    private $items = [];

    private $title = '';
    private $style = 'width: auto;';
    private $class = 'form-select';

    private $required = false;
    private $disabled = false;

    private $autofocus = false;

    private $size = null;

    public function __construct(string $label, string $name, array $checked = [])
    {
        $this->label = $label;
        $this->name = $name;
        $this->checked = $checked;
    }

    public function setHelp(string $help): self
    {
        $this->help = $help;
        return $this;
    }

    public function addItem(Option|Optgroup ...$items): self
    {
        foreach ($items as $vo) {
            if (is_a($vo, Optgroup::class)) {
                foreach ($vo->getOptions() as $sb) {
                    $sb->setSelected(in_array($sb->getValue(), $this->checked));
                }
            } else {
                $vo->setSelected(in_array($vo->getValue(), $this->checked));
            }
            array_push($this->items, $vo);
        }
        return $this;
    }

    public function setAutofocus(bool $autofocus = true): self
    {
        $this->autofocus = $autofocus;
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

    public function setSize(int $size): self
    {
        $this->size = $size;
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
    public function setClass(string $class): self
    {
        $this->class = $class;
        return $this;
    }

    public function __toString(): string
    {
        $res = '';
        $res .= '<label class="form-label">' . htmlspecialchars($this->label) . '</label>';

        $res .= '<select';
        $res .= ' multiple';
        $res .= ' name="' . htmlspecialchars($this->name) . '"';
        if (strlen($this->title)) {
            $res .= ' title="' . htmlspecialchars($this->title) . '"';
        }
        if (strlen($this->class)) {
            $res .= ' class="' . htmlspecialchars($this->class) . '"';
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
        if ($this->autofocus) {
            $res .= ' autofocus';
        }
        if (!is_null($this->size)) {
            $res .= ' size="' . $this->size . '"';
        }
        $res .= ' >';
        $res .= implode('', $this->items);
        $res .= '</select>';

        if (strlen($this->help)) {
            $res .= '<div class="form-text">' . htmlspecialchars($this->help) . '</div>';
        }

        return $res;
    }
}
