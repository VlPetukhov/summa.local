<?php
/**
 * @var app\View $this
 */
use app\App;

?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title><?= (isset($this->title) ? $this->title : App::instance()->appName)?></title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/site.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
</head>
<body>
    <?=$this->content;?>
    <script type="text/javascript" src="/js/site.js"></script>
</body>
</html>