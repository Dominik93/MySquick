<?php
    $element_table=["header1", "link1", "link2", "link3", "link4", "content", "sidebar2", "footer"];
?>
<link href="<?php echo dirname($_SERVER['PHP_SELF'])."/style.css"; ?>" rel="stylesheet" type="text/css"/>
<header id="header1"></header>
<nav>
    <div id="link1" class="link"></div>
    <div id="link2" class="link"></div>
    <div id="link3" class="link"></div>
    <div id="link4" class="link"></div>
</nav>
<article id="content"></article>
<div id="sidebar2"></div>
<footer id="footer"></footer>
