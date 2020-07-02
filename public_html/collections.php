<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>UNCAP Collections</title>
<?php include "includes/headstatic.php"; ?>
</head>
<body id="collections">
<div id="wrapper1">
<div id="wrapper2">
<!--HEADER-->
<div id="header"><?php include "includes/header.php"; ?></div>

<!--SIDEBAR -->
<div id="sidebar">
<?php include "includes/sidebar.php"; ?>
</div>

<!--TEXT-->
<div id="textwrapper">

<h2>About the Collections</h2>

<div class="quicklinks">
<h2>Quicklinks</h2>

<ul>
<li><a href="#chicagojazzarchive">Chicago Jazz Archive</a></li>
<li><a href="#contemporarypoetry">Contemporary Poetry</a></li>
<li><a href="#mappingthestacks">Mapping The Stacks</a></li>
</ul>
</div>

<?php
$xml = new DOMDocument();
$xml->load('xml/collections.xml');

foreach ($xml->getElementsByTagName('collection') as $collection) {
    $html = $xml->saveHTML($collection);
    $html = str_replace("<collection>", "", $html);
    $html = str_replace("</collection>", "", $html);
    echo $html;
}
?>

<?php include "includes/footer.php"; ?>
</div>
<!--/TEXT-->

</div>
<!-- /WRAPPER 2 -->
</div>
<!-- /WRAPPER 1 -->

</body>
</html>
