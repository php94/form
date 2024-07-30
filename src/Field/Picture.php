<?php

declare(strict_types=1);

namespace PHP94\Form\Field;

use PHP94\Form\ItemInterface;
use Stringable;

class Picture implements ItemInterface
{
    private $label = '';
    private $name = '';
    private $value = '';
    private $upload_url = '';
    private $help = '';

    public function __construct(string $label, string $name, string|int|float|bool|null|Stringable $value = '')
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = (string)$value;
    }

    public function setUploadUrl(string $upload_url): self
    {
        $this->upload_url = $upload_url;
        return $this;
    }

    public function setHelp(string $help): self
    {
        $this->help = $help;
        return $this;
    }

    public function __toString(): string
    {
        $str = '';
        $str .= '<label class="form-label">' . htmlspecialchars($this->label) . '</label>';

        $name = htmlspecialchars($this->name);
        $value = htmlspecialchars($this->value);
        $str .= <<<str
<input type="text" style="display: none;" name="{$name}" value="{$value}">
<div style="width: 145px;height: 100px;display: flex;flex-direction: row;justify-content: center;align-items: center;background: #eee;padding: 5px;">
    <img style="max-height:100%;max-width:100%;" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNTgwIiBoZWlnaHQ9IjQwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KIDwhLS0gQ3JlYXRlZCB3aXRoIE1ldGhvZCBEcmF3IC0gaHR0cDovL2dpdGh1Yi5jb20vZHVvcGl4ZWwvTWV0aG9kLURyYXcvIC0tPgogPGc+CiAgPHRpdGxlPmJhY2tncm91bmQ8L3RpdGxlPgogIDxyZWN0IGZpbGw9IiNmZmYiIGlkPSJjYW52YXNfYmFja2dyb3VuZCIgaGVpZ2h0PSI0MDIiIHdpZHRoPSI1ODIiIHk9Ii0xIiB4PSItMSIvPgogIDxnIGRpc3BsYXk9Im5vbmUiIG92ZXJmbG93PSJ2aXNpYmxlIiB5PSIwIiB4PSIwIiBoZWlnaHQ9IjEwMCUiIHdpZHRoPSIxMDAlIiBpZD0iY2FudmFzR3JpZCI+CiAgIDxyZWN0IGZpbGw9InVybCgjZ3JpZHBhdHRlcm4pIiBzdHJva2Utd2lkdGg9IjAiIHk9IjAiIHg9IjAiIGhlaWdodD0iMTAwJSIgd2lkdGg9IjEwMCUiLz4KICA8L2c+CiA8L2c+CiA8Zz4KICA8dGl0bGU+TGF5ZXIgMTwvdGl0bGU+CiAgPHRleHQgc3R5bGU9ImN1cnNvcjogbW92ZTsiIHN0cm9rZT0iIzAwMCIgdHJhbnNmb3JtPSJtYXRyaXgoNi44NjU2MTI1ODA2MjkyNjEsMCwwLDcuMjg3ODQyMzcwMDgyMjE3LC04NTQuNDIwODE1MTkxNTQ3OCwtOTg2LjEyNjIyMTA2NTUxNTgpICIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgdGV4dC1hbmNob3I9InN0YXJ0IiBmb250LWZhbWlseT0iSGVsdmV0aWNhLCBBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIyNCIgaWQ9InN2Z18xIiB5PSIxNjkuMTUyNjkiIHg9IjE0Mi4xMDY5OCIgc3Ryb2tlLXdpZHRoPSIwIiBmaWxsPSIjOTk5OTk5Ij7ml6Dlm748L3RleHQ+CiA8L2c+Cjwvc3ZnPg==">
</div>
<div style="margin-top: 5px;">
    <input type="button" value="上传图片" />
    <input type="button" value="清空图片" />
</div>
<script>
    (function() {
        var input = document.currentScript.previousElementSibling.previousElementSibling.previousElementSibling;
        var preview = document.currentScript.previousElementSibling.previousElementSibling.children[0];
        var handler = document.currentScript.previousElementSibling.children[0];
        var clearbtn = document.currentScript.previousElementSibling.children[1];
        var upload_url = "{$this->upload_url}";
        var noimg = preview.src;

        handler.onclick = function() {
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
            var fileinput = document.createElement("input");
            fileinput.type = "file";
            fileinput.accept = "image/*";
            fileinput.onchange = function() {
                var files = event.target.files;
                for (const key in files) {
                    if (Object.hasOwnProperty.call(files, key)) {
                        const ele = files[key];
                        upload_by_form(upload_url, ele, function(response) {
                            if (response !== null && response.hasOwnProperty('message') && response.hasOwnProperty('data') && response.hasOwnProperty('error')) {
                                if (response.error) {
                                    alert(response.message);
                                } else {
                                    var data = response.data;
                                    if (data !== null && data.hasOwnProperty('src') && data.hasOwnProperty('size') && data.hasOwnProperty('filename')) {
                                        preview.src = data.src;
                                        input.value = data.src;
                                    } else {
                                        alert('接口错误:' + JSON.stringify(response));
                                    }
                                }
                            } else {
                                alert('接口错误:' + JSON.stringify(response));
                            }
                        });
                    }
                }
            }
            fileinput.click();
        }
        clearbtn.onclick = function() {
            preview.src = noimg;
            input.value = "";
        }

        setTimeout(function() {
            if (input.value) {
                preview.src = input.value;
            }
        }, 10);
    })()
</script>
str;
        if (strlen($this->help)) {
            $str .= '<div class="form-text">' . htmlspecialchars($this->help) . '</div>';
        }
        return $str;
    }
}
