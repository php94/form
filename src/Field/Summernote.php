<?php

declare(strict_types=1);

namespace PHP94\Form\Field;

use PHP94\Form\ItemInterface;
use Stringable;

class Summernote implements ItemInterface
{

    private $label;
    private $name;
    private $value = '';

    private $upload_url = '';

    private $help = '';

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

    public function setUploadUrl(string $upload_url): self
    {
        $this->upload_url = $upload_url;
        return $this;
    }

    public function __toString(): string
    {
        $str = '';
        $str .= '<label class="form-label">' . htmlspecialchars($this->label) . '</label>';

        $str .= <<<str
<link href="https://cdn.bootcdn.net/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.bootcdn.net/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>
<script src="https://cdn.bootcdn.net/ajax/libs/summernote/0.8.20/lang/summernote-zh-CN.min.js"></script>
<style>
.note-editable {
    background-color: #fff;
}

.note-editing-area > .CodeMirror{
    padding: 0;
    border: 0;
}

.note-btn-group .dropdown-toggle::after {
    content: none;
    border: none;
    margin: 0;
}

.note-btn-group {
    margin-right: 0px;
}

.note-editor .note-toolbar .note-color-all .note-dropdown-menu {
    min-width: 348px;
}

.note-editor .note-toolbar .note-para .note-dropdown-menu {
    min-width: 232px !important;
}
</style>
<div style="max-width:900px;">
str;
        $str .= '<textarea class="form-control" name="' . htmlspecialchars($this->name) . '" >';
        $str .= htmlspecialchars($this->value);
        $str .= '</textarea>';

        $str .= <<<str
<script>
(function() {
    var textarea = document.currentScript.previousElementSibling;
    var upload_url = "{$this->upload_url}";
    var upload_by_form = function(url, file, callback) {
        var form = new FormData();
        form.append("file", file);

        var xmlhttp;
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.open("POST", url, true);
        xmlhttp.setRequestHeader("Accept", "application/json");
        xmlhttp.responseType = "json";
        xmlhttp.onerror = function(e) {};
        xmlhttp.ontimeout = function(e) {
            alert("Timeout!!");
        };
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4) {
                if (xmlhttp.status == 200) {
                    callback(xmlhttp.response);
                } else {
                    alert("[" + xmlhttp.status + "] " + xmlhttp.statusText);
                }
            }
        }
        xmlhttp.send(form);
    }
    window.addEventListener('load', function() {
        $(textarea).summernote({
            lang: "zh-CN",
            height: "250px",
            width: "auto",
            callbacks: {
                onImageUpload: function(files) {
                    for (const key in files) {
                        if (Object.hasOwnProperty.call(files, key)) {
                            const ele = files[key];
                            if(upload_url){
                                upload_by_form(upload_url, ele, function(response) {
                                    if (response !== null && response.hasOwnProperty('message') && response.hasOwnProperty('data') && response.hasOwnProperty('error')) {
                                        if (response.error) {
                                            alert(response.message);
                                        } else {
                                            var data = response.data;
                                            if (data !== null && data.hasOwnProperty('src') && data.hasOwnProperty('size') && data.hasOwnProperty('filename')) {
                                                $(textarea).summernote('insertImage', data.src);
                                            } else {
                                                alert('接口错误:' + JSON.stringify(response));
                                            }
                                        }
                                    } else {
                                        alert('接口错误:' + JSON.stringify(response));
                                    }
                                });
                            } else {
                                const reader = new FileReader(); // 创建FileReader对象
                                reader.onload = function(e) {
                                    const base64 = e.target.result;
                                    $(textarea).summernote('insertImage', base64);
                                };
                                reader.readAsDataURL(ele);
                            }
                        }
                    }
                }
            }
        });
    });
})()
</script>
</div>
str;

        if (strlen($this->help)) {
            $str .= '<div class="form-text">' . htmlspecialchars($this->help) . '</div>';
        }
        return $str;
    }
}
