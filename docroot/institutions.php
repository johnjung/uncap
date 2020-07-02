<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>UNCAP : About the Institutions</title>
<?php include "includes/headstatic.php"; ?>
</head>
<body id="institutions">
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

<h2>About the Institutions</h2>

<div class="quicklinks">
<h2>Quicklinks</h2>
<ul>
<li><a href="#chicagodefender">Chicago Defender</a></li>
<li><a href="#dusable">DuSable Museum of African American History</a></li>
<li><a href="#chicagopubliclibrary">Chicago Public Library, Carter G. Woodson
Regional Library, Vivian G. Harsh Research Collection of Afro-American History
and Literature</a></li>
<li><a href="#northwesternuniversitylibrary">Northwestern University
Library</a></li>
<li><a href="#sscac">South Side Community Art Center</a></li>
<li><a href="#universityofchicago">University of Chicago Library</a></li>
</ul>
</div>

<?php
$xml = new DOMDocument();
$xml->load('xml/institutions.xml');

foreach ($xml->getElementsByTagName('institution') as $institution) {
    $html = $xml->saveHTML($institution);
    $html = str_replace("<institution>", "", $html);
    $html = str_replace("</institution>", "", $html);
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
