<?php

declare(strict_types=1);

namespace PHP94\Form\Field;

use PHP94\Form\ItemInterface;
use Stringable;

class Email implements ItemInterface
{

    private $label = '';
    private $name = '';
    private $value = '';

    private $help = '';

    private $title = '';
    private $class = 'form-control';
    private $style = 'max-width: 500px;';

    private $readonly = false;
    private $required = false;
    private $disabled = false;
    private $autocomplete = false;
    private $autofocus = false;

    private $maxlength = null;
    private $pattern = '';
    private $placeholder = '';

    private $datalist = [];
    private $datalist_url = '';

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

    public function setMaxLength(int $maxlength): self
    {
        $this->maxlength = $maxlength;
        return $this;
    }

    public function setPattern(string $pattern): self
    {
        $this->pattern = $pattern;
        return $this;
    }

    public function setPlaceholder(string $placeholder): self
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    public function setDataList(array $datalist = []): self
    {
        $this->datalist = $datalist;
        return $this;
    }

    public function setDataListUrl(string $url): self
    {
        $this->datalist_url = $url;
        return $this;
    }

    public function __toString()
    {
        $res = '';
        $res .= '<label class="form-label">' . htmlspecialchars($this->label) . '</label>';

        $res .= '<input';
        $res .= ' type="email"';
        $res .= ' name="' . htmlspecialchars($this->name) . '"';
        $res .= ' value="' . htmlspecialchars($this->value) . '"';
        if (strlen($this->title)) {
            $res .= ' title="' . htmlspecialchars($this->title) . '"';
        }
        if (strlen($this->class)) {
            $res .= ' class="' . htmlspecialchars($this->class) . '"';
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
            $res .= ' autofocus="on"';
        }
        if ($this->autocomplete) {
            $res .= ' autocomplete="on"';
        }

        $listid = 'list_' . uniqid();
        if ($this->datalist || $this->datalist_url) {
            $res .= ' list="' . $listid . '"';
        }

        $res .= ' >';

        if ($this->datalist || $this->datalist_url) {
            $res .= '<datalist id="' . $listid . '">';
            foreach ($this->datalist as $vo) {
                $res .= '<option value="' . htmlspecialchars($vo) . '">';
            }
            $res .= '</datalist>';
        }

        if ($this->datalist_url) {
            $res .= <<<str
<script>
    (function() {
        var input = document.currentScript.previousElementSibling.previousElementSibling;
        var datalist = document.currentScript.previousElementSibling;
        var query = function(q) {
            var xmlhttp;
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.open("post", "{$this->datalist_url}", true);
            xmlhttp.setRequestHeader("Accept", "application/json");
            xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xmlhttp.responseType = "json";
            xmlhttp.onerror = function(e) {
                alert("错误");
            };
            xmlhttp.ontimeout = function(e) {
                alert("超时");
            };
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4) {
                    if (xmlhttp.status == 200) {
                        if(Array.isArray(xmlhttp.response)){
                            datalist.innerHTML='';
                            xmlhttp.response.data.forEach(function(el) {
                                var opt = document.createElement("option");
                                opt.value=el;
                                datalist.appendChild(opt);
                            });
                        }else{
                            alert('接口错误:' + JSON.stringify(xmlhttp.response));
                        }
                    } else {
                        alert("[" + xmlhttp.status + "] " + xmlhttp.statusText);
                    }
                }
            }
            xmlhttp.send("q="+q);
        };
        input.oninput = function(){
            query(event.target.value);
        }
        query(input.value);
    })()
</script>
str;
        }

        if (strlen($this->help)) {
            $res .= '<div class="form-text">' . htmlspecialchars($this->help) . '</div>';
        }
        return $res;
    }
}
