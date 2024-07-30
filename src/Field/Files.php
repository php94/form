<?php

declare(strict_types=1);

namespace PHP94\Form\Field;

use PHP94\Form\ItemInterface;
use Stringable;

class Files implements ItemInterface
{
    private $label = '';
    private $name = '';
    private $files = [];
    private $upload_url = '';

    private $help = '';

    public function __construct(string $label, string $name)
    {
        $this->label = $label;
        $this->name = $name;
    }

    public function setUploadUrl(string $upload_url): self
    {
        $this->upload_url = $upload_url;
        return $this;
    }

    public function addFile(string $src, string|int|float|bool|null|Stringable $size = '', string|int|float|bool|null|Stringable $title = ''): self
    {
        $this->files[] = [
            'src' => $src,
            'title' => (string)$title,
            'size' => (string)$size,
        ];
        return $this;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    public function setHelp(string $help): self
    {
        $this->help = $help;
        return $this;
    }

    public function __toString(): string
    {
        $files = json_encode($this->files, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $str = '';
        $str .= '<label class="form-label">' . htmlspecialchars($this->label) . '</label>';
        $str .= <<<str
<div style="display: flex;flex-direction: column;gap: 5px;"></div>
<div style="margin-top: 5px;">
    <input type="button" value="上传" />
</div>
<script>
    (function() {
        var container = document.currentScript.previousElementSibling.previousElementSibling;
        var handler = document.currentScript.previousElementSibling.children[0];
        var fieldname = "{$this->name}";
        var upload_url = "{$this->upload_url}";
        var files = JSON.parse('{$files}');

        function sizex(limit) {
            var size = "";
            if (limit < 0.1 * 1024) {
                size = limit.toFixed(2) + "B"
            } else if (limit < 0.1 * 1024 * 1024) {
                size = (limit / 1024).toFixed(2) + "KB"
            } else if (limit < 0.1 * 1024 * 1024 * 1024) {
                size = (limit / (1024 * 1024)).toFixed(2) + "MB"
            } else {
                size = (limit / (1024 * 1024 * 1024)).toFixed(2) + "GB"
            }

            var sizeStr = size + "";
            var index = sizeStr.indexOf(".");
            var dou = sizeStr.substr(index + 1, 2)
            if (dou == "00") {
                return sizeStr.substring(0, index) + sizeStr.substr(index + 3, 2)
            }
            return size;
        }

        function renderValue() {
            container.innerHTML = "";
            for (const index in files) {
                if (Object.hasOwnProperty.call(files, index)) {
                    const obj = files[index];

                    var div = document.createElement("div");
                    div.style.display = "flex";
                    div.style.flexDirection = "row";
                    div.style.gap = "5px";
                    div.style.flexWrap = "wrap"

                    var inputsrc = document.createElement("input");
                    inputsrc.type = "hidden";
                    inputsrc.name = fieldname + "[" + index + "][src]";
                    inputsrc.value = obj.src;
                    div.appendChild(inputsrc);

                    var inputsize = document.createElement("input");
                    inputsize.type = "hidden";
                    inputsize.name = fieldname + "[" + index + "][size]";
                    inputsize.value = obj.size;
                    div.appendChild(inputsize);

                    var delbtn = document.createElement("input");
                    delbtn.type = "button";
                    delbtn.value = "删除";
                    delbtn.onclick = function() {
                        if (confirm('确定删除吗?')) {
                            files.splice(index, 1);
                            renderValue();
                        }
                    }
                    div.appendChild(delbtn);

                    if (index != 0) {
                        var upbtn = document.createElement("input");
                        upbtn.type = "button";
                        upbtn.value = "上移";
                        upbtn.onclick = function() {
                            files[index] = files.splice(parseInt(index) - 1, 1, files[index])[0];
                            renderValue();
                        }
                        div.appendChild(upbtn);
                    } else {
                        var upbtn = document.createElement("input");
                        upbtn.type = "button";
                        upbtn.disabled = "disabled";
                        upbtn.value = "上移";
                        div.appendChild(upbtn);
                    }

                    if (index < files.length - 1) {
                        var downbtn = document.createElement("input");
                        downbtn.type = "button";
                        downbtn.value = "下移";
                        downbtn.onclick = function() {
                            files[index] = files.splice(parseInt(index) + 1, 1, files[index])[0];
                            renderValue();
                        }
                        div.appendChild(downbtn);
                    } else {
                        var downbtn = document.createElement("input");
                        downbtn.type = "button";
                        downbtn.disabled = "disabled";
                        downbtn.value = "下移";
                        div.appendChild(downbtn);
                    }

                    var inputtitle = document.createElement("input");
                    inputtitle.type = "text";
                    inputtitle.name = fieldname + "[" + index + "][title]";
                    inputtitle.value = obj.title;
                    inputtitle.placeholder = "请输入图片标题";
                    inputtitle.onchange = function() {
                        files[index]['title'] = event.target.value;
                    }
                    div.appendChild(inputtitle);

                    var span = document.createElement("span");
                    span.innerText = sizex(obj.size);
                    div.appendChild(span);

                    var a = document.createElement("a");
                    a.href = obj.src;
                    a.target = "_blank";
                    a.innerText = "查看";
                    div.appendChild(a);

                    container.appendChild(div);
                }
            }
        }

        setTimeout(function() {
            renderValue();
        }, 100);

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
            fileinput.multiple = "multiple";
            fileinput.onchange = function() {
                var items = event.target.files;
                for (const indexInArray in items) {
                    if (Object.hasOwnProperty.call(items, indexInArray)) {
                        const valueOfElement = items[indexInArray];
                        upload_by_form(upload_url, valueOfElement, function(response) {
                            if (response !== null && response.hasOwnProperty('message') && response.hasOwnProperty('data') && response.hasOwnProperty('error')) {
                                if (response.error) {
                                    alert(response.message);
                                } else {
                                    var data = response.data;
                                    if (data !== null && data.hasOwnProperty('src') && data.hasOwnProperty('size') && data.hasOwnProperty('filename')) {
                                        files.push({
                                            src: data.src,
                                            size: data.size,
                                            title: data.filename,
                                        });
                                        renderValue();
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
    })()
</script>
str;
        if (strlen($this->help)) {
            $str .= '<div class="form-text">' . htmlspecialchars($this->help) . '</div>';
        }
        return $str;
    }
}
