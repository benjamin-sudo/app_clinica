<br>
<?php
echo "<br>";
if (extension_loaded('oci8')) {
    echo "La extensión oci8 está instalada.";
} else {
    echo "La extensión oci8 no está instalada.";
}
echo "<br>";
if (extension_loaded('json')) {
    echo "La extensión json está instalada.";
} else {
    echo "La extensión json no está instalada.";
}
echo "<br>";
if (extension_loaded('PDO_OCI')) {
    echo "La extensión PDO_OCI está instalada.";
} else {
    echo "La extensión PDO_OCI no está instalada.";
}
//echo "<br>";
//phpinfo();
?>