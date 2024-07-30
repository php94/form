<?php

declare(strict_types=1);

namespace PHP94\Form\Field;

use PHP94\Form\Help\Html;
use PHP94\Form\ItemInterface;
use PHP94\Form\Layout\Flex;

class Checkboxs implements ItemInterface
{
    private $label = '';
    private $name = '';
    private $checked = [];
    private $help = '';

    private $flex;

    public function __construct(string $label, string $name, array $checked = [])
    {
        $this->label = $label;
        $this->name = $name;
        $this->checked = $checked;
        $this->flex = new Flex('d-flex flex-row gap-2 flex-wrap');
    }

    public function getFlex(): Flex
    {
        return $this->flex;
    }

    public function setHelp(string $help): self
    {
        $this->help = $help;
        return $this;
    }

    public function addCheckbox(Checkbox ...$checkboxs): self
    {
        foreach ($checkboxs as $vo) {
            $vo->setName($this->name);
            $vo->setChecked(in_array($vo->getValue() . '', $this->checked));
            $this->flex->addItem(new Html($vo));
        }
        return $this;
    }

    public function __toString(): string
    {
        $str = '';
        $str .= '<label class="form-label">' . htmlspecialchars($this->label) . '</label>';
        $str .= $this->flex;
        if (strlen($this->help)) {
            $str .= '<div class="form-text">' . htmlspecialchars($this->help) . '</div>';
        }
        return $str;
    }
}
