<?php
ini_set('display_errors', 1);

# Connect to PostgreSQL database
$conn = pg_connect("dbname='gisdata' user='username' password='pass' host='localhost'") 
    or die ("Could not connect to server\n");

    $result = pg_fetch_all(pg_query($conn, "SELECT row_to_json(fc)
    FROM ( SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
    FROM (SELECT 'Feature' As type
    , ST_AsGeoJSON(lg.geom, 4)::json As geometry
    , row_to_json((SELECT l FROM (SELECT id, designacao) As l
      )) As properties
    FROM hidrog As lg ) As f ) As fc;"));
    
if (!$result) {
    echo "An error occurred.\n";
    exit;
}

#echo json_encode($result, JSON_NUMERIC_CHECK);
$json_data = json_encode($result);
file_put_contents('test.json', $json_data);

$jsonString = file_get_contents('test.json');
$json_new = substr($jsonString, 17,-2);
$json_new = str_ireplace('\"', '"', $json_new);
echo $json_new;

file_put_contents('test_new.json', $json_new);

?>