<?php

declare(strict_types=1);

namespace PHP94\Form\Field;

use PHP94\Form\ItemInterface;
use Stringable;

class Pictures implements ItemInterface
{
    private $label = '';
    private $name = '';
    private $pics = [];
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

    public function addPic(string $src, string|int|float|bool|null|Stringable $size = '', string|int|float|bool|null|Stringable $title = ''): self
    {
        $this->pics[] = [
            'src' => $src,
            'title' => (string)$title,
            'size' => (string)$size,
        ];
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
        $pics = json_encode($this->pics, JSON_UNESCAPED_SLASHES);
        $str .= <<<str
<div style="display: flex;flex-direction: row;gap: 5px;flex-wrap: wrap;"></div>
<div style="margin-top: 5px;">
    <input type="button" value="上传" />
</div>
<script>
(function() {
    var container = document.currentScript.previousElementSibling.previousElementSibling;
    var handler = document.currentScript.previousElementSibling.children[0];
    var upload_url = "{$this->upload_url}";
    var fieldname = "{$name}";
    var pics = JSON.parse('{$pics}');

    function renderValue() {
        container.innerHTML = "";
        for (const index in pics) {
            if (Object.hasOwnProperty.call(pics, index)) {
                const obj = pics[index];

                var div = document.createElement("div");
                div.style.display = "flex";
                div.style.flexDirection = "column";
                div.style.gap = "5px";
                div.style.flexWrap = "wrap";
                container.appendChild(div);

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

                var imgdiv = document.createElement("div");
                imgdiv.style.width = "190px";
                imgdiv.style.height = "100px";
                imgdiv.style.display = "flex"
                imgdiv.style.flexDirection = "row"
                imgdiv.style.justifyContent = "center"
                imgdiv.style.alignItems = "center"
                imgdiv.style.background = "#eee"
                imgdiv.style.padding = "5px"
                div.appendChild(imgdiv)

                var img = document.createElement("img");
                img.style.maxHeight = "100%"
                img.style.maxWidth = "100%"
                img.alt = obj.src
                img.title = obj.src
                img.src = obj.src
                imgdiv.appendChild(img)

                var inputtitle = document.createElement("input");
                inputtitle.type = "text";
                inputtitle.name = fieldname + "[" + index + "][title]";
                inputtitle.value = obj.title;
                // inputtitle.className = "form-control";
                inputtitle.placeholder = "请输入图片标题";
                inputtitle.onchange = function() {
                    pics[index]['title'] = event.target.value;
                }
                div.appendChild(inputtitle);

                var actiondiv = document.createElement("div")
                actiondiv.style.display = "flex"
                actiondiv.style.gap = "5px"
                div.appendChild(actiondiv);

                var delbtn = document.createElement("input");
                delbtn.type = "button";
                delbtn.value = "删除";
                delbtn.onclick = function() {
                    if (confirm('确定删除吗?')) {
                        pics.splice(index, 1);
                        renderValue();
                    }
                }
                actiondiv.appendChild(delbtn);

                if (index != 0) {
                    var upbtn = document.createElement("input");
                    upbtn.type = "button";
                    upbtn.value = "左移";
                    upbtn.onclick = function() {
                        pics[index] = pics.splice(parseInt(index) - 1, 1, pics[index])[0];
                        renderValue();
                    }
                    actiondiv.appendChild(upbtn);
                } else {
                    var upbtn = document.createElement("input");
                    upbtn.type = "button";
                    upbtn.disabled = "disabled";
                    upbtn.value = "左移";
                    actiondiv.appendChild(upbtn);
                }

                if (index < pics.length - 1) {
                    var downbtn = document.createElement("input");
                    downbtn.type = "button";
                    downbtn.value = "右移";
                    downbtn.onclick = function() {
                        pics[index] = pics.splice(parseInt(index) + 1, 1, pics[index])[0];
                        renderValue();
                    }
                    actiondiv.appendChild(downbtn);
                } else {
                    var downbtn = document.createElement("input");
                    downbtn.type = "button";
                    downbtn.disabled = "disabled";
                    downbtn.value = "右移";
                    actiondiv.appendChild(downbtn);
                }
            }
        }
    }

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
        fileinput.accept = "image/*";
        fileinput.onchange = function() {
            var items = event.target.files;
            for (const indexInArray in items) {
                if (Object.hasOwnProperty.call(items, indexInArray)) {
                    const ve = items[indexInArray];
                    upload_by_form(upload_url, ve, function(response) {
                        if (response !== null && response.hasOwnProperty('message') && response.hasOwnProperty('data') && response.hasOwnProperty('error')) {
                            if (response.error) {
                                alert(response.message);
                            } else {
                                var data = response.data;
                                if (data !== null && data.hasOwnProperty('src') && data.hasOwnProperty('size') && data.hasOwnProperty('filename')) {
                                    pics.push({
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

    setTimeout(function() {
        renderValue();
    }, 100);
})()
</script>
str;
        if (strlen($this->help)) {
            $str .= '<div class="form-text">' . htmlspecialchars($this->help) . '</div>';
        }
        return $str;
    }
}
