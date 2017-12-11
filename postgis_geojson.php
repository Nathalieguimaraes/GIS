<?php
# Connect to PostgreSQL database
$conn = pg_connect("dbname='gisdata' user='user' password='pass' host='localhost'");
if (!$conn) {
    echo "Not connected : " . pg_error();
    exit;
};
?>