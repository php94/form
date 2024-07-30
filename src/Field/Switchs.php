<?php

declare(strict_types=1);

namespace PHP94\Form\Field;

use PHP94\Form\ItemInterface;
use Stringable;

/**
 * @property \PHP94\Form\Field\SwitchItem[] $switchs
 */
class Switchs implements ItemInterface
{
    private $label = null;
    private $name = null;
    private $value = null;

    private $help = '';

    private $switchs = [];

    public function __construct(string $label, string $name, string|int|float|bool|null|Stringable $value = null)
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = (string)$value;
        $this->switchs = [];
    }

    public function setHelp(string $help): self
    {
        $this->help = $help;
        return $this;
    }

    public function addSwitchItem(SwitchItem ...$switchitems): self
    {
        array_push($this->switchs, ...$switchitems);
        return $this;
    }

    public function __toString(): string
    {
        $str = '';
        $str .= '<label class="form-label">' . htmlspecialchars($this->label) . '</label>';

        $str .= '<div style="display: flex;flex-direction: row;gap: 10px;">';
        foreach ($this->switchs as $vo) {
            $str .= '<div class="form-check">';
            $str .= '<label class="form-check-label">';
            if ($vo->getValue() == $this->value) {
                $str .= '<input type="radio" class="form-check-input" name="' . htmlspecialchars($this->name) . '" value="' . htmlspecialchars($vo->getValue()) . '" checked>';
            } else {
                $str .= '<input type="radio" class="form-check-input" name="' . htmlspecialchars($this->name) . '" value="' . htmlspecialchars($vo->getValue()) . '">';
            }
            $str .= '<span>' . htmlspecialchars($vo->getLabel()) . '</span>';
            $str .= '</label>';
            $str .= '</div>';
        }
        $str .= '</div>';
        $str .= '<div style="margin-top: 10px;">';
        foreach ($this->switchs as $vo) {
            if ($vo->getValue() == $this->value) {
                $str .= ' <fieldset>' . $vo->getBody() . '</fieldset>';
            } else {
                $str .= ' <fieldset disabled style="display: none;">' . $vo->getBody() . '</fieldset>';
            }
        }
        $str .= '</div>';
        $str .= <<<str
<script>
(function() {
    var tabts = document.currentScript.previousElementSibling.previousElementSibling.children;
    var tabcs = document.currentScript.previousElementSibling.children;
    for (const key in tabts) {
        if (Object.hasOwnProperty.call(tabts, key)) {
            const elet = tabts[key];
            elet.children[0].children[0].onchange = function(e) {
                for (const index in tabcs) {
                    if (Object.hasOwnProperty.call(tabcs, index)) {
                        const elec = tabcs[index];
                        if (index == key) {
                            elec.removeAttribute('disabled');
                            elec.style.display = 'block';
                        } else {
                            elec.setAttribute('disabled', true);
                            elec.style.display = 'none';
                        }
                    }
                }
            }
        }
    }
})()
</script>
str;

        if (strlen($this->help)) {
            $str .= '<div class="form-text">' . htmlspecialchars($this->help) . '</div>';
        }
        return $str;
    }
}
