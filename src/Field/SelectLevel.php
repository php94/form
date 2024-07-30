<?php

declare(strict_types=1);

namespace PHP94\Form\Field;

use PHP94\Form\ItemInterface;
use Stringable;

class SelectLevel implements ItemInterface
{
    private $label = '';
    private $name = '';
    private $value = '';

    private $help = '';

    private $items = [];

    public function __construct(string $label, string $name, string|int|float|bool|null|Stringable $value = '')
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

    public function addItem(string $title, string|int|float|bool|null|Stringable $value, string|int|float|bool|null|Stringable $parent = '', string $group = '', bool $disabled = false): self
    {
        array_push($this->items, [
            'title' => $title,
            'value' => (string)$value,
            'parent' => (string)$parent,
            'group' => $group,
            'disabled' => $disabled,
        ]);
        return $this;
    }

    public function __toString(): string
    {
        $str = '';
        $str .= '<label class="form-label">' . htmlspecialchars($this->label) . '</label>';

        $name = htmlspecialchars($this->name);
        $value = htmlspecialchars($this->value);
        $items = json_encode($this->items, JSON_UNESCAPED_UNICODE);
        $str .= <<<str
<input type="hidden" name="{$name}" value="{$value}">
<div style="display: flex;flex-direction: row;gap: 5px;flex-wrap: wrap;">
</div>
<script>
    (function() {
        var items = JSON.parse('{$items}');
        var container = document.currentScript.previousElementSibling;
        var input = document.currentScript.previousElementSibling.previousElementSibling;

        function buildSelect(parent, selectvalue) {
            var groups = {};
            var select = document.createElement('select');
            select.className = "form-select";
            select.onchange = function() {
                container.innerHTML = '';
                input.value = event.target.value;
                buildSelect(event.target.value);
            };
            var node = document.createElement("option");
            node.innerText = "不限";
            node.value = parent;
            select.appendChild(node);

            items.forEach(element => {
                if (element.parent == parent) {
                    if (element.group) {
                        if (!groups[element.group]) {
                            groups[element.group] = element.group;
                            var optgroup = document.createElement("optgroup");
                            optgroup.label = element.group;

                            items.forEach(subele => {
                                if (subele.parent == parent) {
                                    if (subele.group == element.group) {
                                        var node = document.createElement("option");
                                        node.value = subele.value;
                                        node.innerText = subele.title;
                                        if (node.value == selectvalue) {
                                            node.selected = "selected";
                                        }
                                        if (subele.disabled) {
                                            node.disabled = "disabled";
                                        }
                                        optgroup.appendChild(node);
                                    }
                                }
                            })

                            select.appendChild(optgroup);
                        }
                    } else {
                        var node = document.createElement("option");
                        node.value = element.value;
                        node.innerText = element.title;
                        if (node.value == selectvalue) {
                            node.selected = 'selected';
                        }
                        if (element.disabled) {
                            node.disabled = "disabled";
                        }
                        select.appendChild(node);
                    }
                }
            });
            items.forEach(element => {
                if (element.value == parent) {
                    buildSelect(element.parent, element.value);
                }
            })
            if (select.children.length > 1) {
                var div = document.createElement("div");
                div.appendChild(select);
                container.appendChild(div);
            }
        }

        buildSelect(input.value);
    })()
</script>
str;
        if (strlen($this->help)) {
            $str .= '<div class="form-text">' . htmlspecialchars($this->help) . '</div>';
        }
        return $str;
    }
}
