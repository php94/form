<?php

declare(strict_types=1);

namespace PHP94\Form;

use PHP94\Form\Layout\Flex;
use Stringable;

class Form implements Stringable
{
    protected $title = '';
    protected $action = '';
    protected $method = '';
    protected $flex;

    public function __construct(string $title, string $action = '', string $method = 'POST')
    {
        $this->title = $title;
        $this->action = $action;
        $this->method = $method;
        $this->flex = new Flex;
    }

    public function getFlex(): Flex
    {
        return $this->flex;
    }

    public function addItem(ItemInterface ...$items): self
    {
        $this->flex->addItem(...$items);
        return $this;
    }

    public function addCustomItem(ItemInterface $item, string $class = '', string $style = ''): self
    {
        $this->flex->addCustomItem($item, $class, $style);
        return $this;
    }

    public function __toString(): string
    {
        $str = '';
        $title = htmlspecialchars($this->title);
        $method = htmlspecialchars($this->method);
        $str .= <<<str
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title}</title>
    <link href="https://static.php94.com/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://static.php94.com/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://static.php94.com/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <div class="container-fluid py-3">
        <form action="{$this->action}" method="{$method}" enctype="application/x-www-form-urlencoded">
            <h1>{$title}</h1>
            <div class="mt-3">{$this->flex}</div>
            <div style="margin-top: 20px;">
                <input type="submit" class="btn btn-primary" value="提交">
            </div>
            <script>
                (function() {
                    var form = document.currentScript.parentNode;
                    form.onsubmit = function() {
                        event.preventDefault();
                        var xmlhttp;
                        if (window.XMLHttpRequest) {
                            xmlhttp = new XMLHttpRequest();
                        } else {
                            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                        }
                        xmlhttp.open(event.target.method, event.target.action, true);
                        xmlhttp.setRequestHeader("Accept", "application/json");
                        xmlhttp.responseType = "json";
                        xmlhttp.onerror = function(e) {
                            alert("错误：" + JSON.stringify(e));
                        };
                        xmlhttp.ontimeout = function(e) {
                            alert("超时：" + JSON.stringify(e));
                        };
                        xmlhttp.onreadystatechange = function() {
                            if (xmlhttp.readyState == 4) {
                                if (xmlhttp.status == 200) {
                                    if (typeof(xmlhttp.response) != 'object' || xmlhttp.response === null) {
                                        alert("接口错误：" + JSON.stringify(xmlhttp.response));
                                    } else if (!xmlhttp.response.hasOwnProperty('message')) {
                                        alert("接口错误：" + JSON.stringify(xmlhttp.response));
                                    }
                                    if (xmlhttp.response.message) {
                                        alert(xmlhttp.response.message);
                                    }
                                    if (!xmlhttp.response.error) {
                                        window.history.go(-1);
                                    }
                                } else {
                                    alert("接口错误：[" + xmlhttp.status + "] " + xmlhttp.statusText);
                                }
                            }
                        }
                        xmlhttp.send(new FormData(form));
                    }
                })()
            </script>
        </form>
    </div>
</body>

</html>
str;
        return $str;
    }
}
