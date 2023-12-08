


<?php
echo "<br>";
if (extension_loaded('imagick')) {
    echo "La extensión imagick está instalada.";
} else {
    echo "La extensión imagick no está instalada.";
}
echo "<br>";
if (extension_loaded('gd')) {
    echo "La extensión gd está instalada.";
} else {
    echo "La extensión gd no está instalada.";
}
echo "<br>";
if (extension_loaded('mbstring')) {
    echo "La extensión simplexml está instalada.";
} else {
    echo "La extensión simplexml no está instalada.";
}
phpinfo();
//echo "<br>";
//phpinfo();
?>