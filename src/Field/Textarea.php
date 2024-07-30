<?php

declare(strict_types=1);

namespace PHP94\Form\Field;

use PHP94\Form\ItemInterface;
use Stringable;

class Textarea implements ItemInterface
{
    private $label = '';
    private $name = '';
    private $value = '';

    private $title = '';
    private $style = 'max-width: 500px;';
    private $class = 'form-control';

    private $help = '';

    private $wrap = 'soft';
    private $pattern = '';

    private $placeholder = '';
    private $maxlength = null;
    private $rows = null;
    private $cols = null;

    private $autofocus = null;
    private $readonly = null;
    private $required = null;
    private $disabled = null;

    public function __construct(string $label, string $name, string|int|float|bool|null|Stringable $value = null)
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

    public function setWrap(string $wrap): self
    {
        if (!in_array($wrap, ['soft', 'hard'])) {
            trigger_error('错误，只支持hard和soft');
        }
        $this->wrap = $wrap;
        return $this;
    }

    public function setPlaceholder(string $placeholder): self
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    public function setMaxlength(int $maxlength): self
    {
        $this->maxlength = $maxlength;
        return $this;
    }

    public function setRows(int $rows): self
    {
        $this->rows = $rows;
        return $this;
    }

    public function setCols(int $cols): self
    {
        $this->cols = $cols;
        return $this;
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

    public function __toString()
    {
        $res = '';
        $res .= '<label class="form-label">' . htmlspecialchars($this->label) . '</label>';

        $res .= '<textarea';
        $res .= ' name="' . htmlspecialchars($this->name) . '"';
        if (strlen($this->title)) {
            $res .= ' title="' . htmlspecialchars($this->title) . '"';
        }
        if (strlen($this->class)) {
            $res .= ' class="' . htmlspecialchars($this->class) . '"';
        }
        if (strlen($this->wrap)) {
            $res .= ' wrap="' . htmlspecialchars($this->wrap) . '"';
        }
        if (strlen($this->style)) {
            $res .= ' style="' . htmlspecialchars($this->style) . '"';
        }
        if (!is_null($this->maxlength)) {
            $res .= ' maxlength="' . $this->maxlength . '"';
        }
        if (strlen($this->pattern)) {
            $res .= ' pattern="' . htmlspecialchars($this->pattern) . '"';
        }
        if (strlen($this->placeholder)) {
            $res .= ' placeholder="' . htmlspecialchars($this->placeholder) . '"';
        }

        if ($this->rows) {
            $res .= ' rows="' . $this->rows . '"';
        }
        if ($this->cols) {
            $res .= ' cols="' . $this->cols . '"';
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
        $res .= ' >';
        $res .= htmlspecialchars($this->value);
        $res .= '</textarea>';

        if (strlen($this->help)) {
            $res .= '<div class="form-text">' . htmlspecialchars($this->help) . '</div>';
        }
        return $res;
    }
}
