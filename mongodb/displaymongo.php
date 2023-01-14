<?php
$url=$_SERVER['REQUEST_URI'];
header("Refresh: 10; URL=$url"); // Refresh the webpage every 5 seconds
?>
<html>
<head>
<title>Epilepsie detectie Test</title>
<style type="text/css">
.table_titles {
padding-right: 20px;
padding-left: 20px;
color:#FFF;
background-color:#1e90ff;
}
table {
border: 2px solid #333;
}
.table_cells_geen_aanval {
background-color:#87cefa;
padding-right: 20px;
text-align:right;
}
.table_cells_wel_aanval {
background-color:#b22222;
padding-right: 20px;
text-align:right;
}
body { font-family: "Trebuchet MS", Courier; }
</style>
</head>
<body>
<h1>Epilepsie Detectiesysteem Database</h1>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
ID:
<input type="text" name="ID" width="10" height="10" placeholder="ID">
<input type="submit" name="change_value_1" value="Aanval Ja"/>
<input type="submit" name="change_value_0" value="Aanval Nee"/>
<p>
ID Range:
<input type="text" name="ID_range_val1" width="10" height="10" placeholder="van">
-
<input type="text" name="ID_range_val2" width="10" height="10" placeholder="tot">
<input type="submit" name="change_value_range_1" value="Aanval Ja"/>
<input type="submit" name="change_value_range_0" value="Aanval Nee"/>
<p>
<table border="0" cellspacing="0" cellpadding="4">
<tr>
<td class="table_titles">ID</td>
<td class="table_titles">Datum & Tijd</td>
<td class="table_titles">Temperatuur</td>
<td class="table_titles">Luchtvochtigheid</td>
<td class="table_titles">Hitte index</td>
<td class="table_titles">Aanval</td>
</tr>
<?php
require_once '/usr/local/etc/php/8.2/vendor/autoload.php';
$client = new MongoDB\Client('mongodb://localhost:27017');
$database = $client->Arduino_Test_DB2;
$id = $_POST['ID'] ?? null;
$id2 = $_POST['ID_range_val1'] ?? null;
$id3 = $_POST['ID_range_val2'] ?? null;
$ids = range ($id2,$id3);
$cursor = $database->data->find();
$result = 1;
if(isset($_POST['change_value_1'])) {
$updateResult  = $database->data->updateOne(
        ['_id' => intval($id)],
        ['$set' => ['Aanval' => 1]]
    );
    echo "ID $id aanval aangepast";
}  
if(isset($_POST['change_value_0'])) {
    $updateResult  = $database->data->updateOne(
        ['_id' => intval($id)],
        ['$set' => ['Aanval' => 0]]
    );
    echo "ID $id aanval aangepast";
}  
if(isset($_POST['change_value_range_1'])) {
    $updateResult  = $database->data->updateMany(
        ['_id' => [ '$in' => $ids]],
        ['$set' => ['Aanval' => 1]]
    );
    echo  "ID van $id2 tot $id3 aanval aangepast";
}  
if(isset($_POST['change_value_range_0'])) {
    $updateResult  = $database->data->updateMany(
        ['_id' => [ '$in' => $ids]],
        ['$set' => ['Aanval' => 0]]
    );
    echo  "ID van $id2 tot $id3 aanval aangepast";
}  

foreach ($cursor as $row)
{    
if ($row['Aanval'] == 1)
{
$css_class=' class="table_cells_wel_aanval"';
}
else
{
$css_class=' class="table_cells_geen_aanval"';
}    
echo "<tr>";
echo "<td '.$css_class.'>" . $row['_id'] . "</td>";
echo "<td '.$css_class.'>" . $row['date'] . "</td>";
echo "<td '.$css_class.'>" . $row['temperature'] . "</td>";
echo "<td '.$css_class.'>" . $row['humidity'] . "</td>";
echo "<td '.$css_class.'>" . $row['heat_index'] . "</td>";
if ($row['Aanval'] == 1)
    echo "<td '.$css_class.'>" . 'Ja' . "</td>";
else 
    echo "<td '.$css_class.'>" . 'Nee' . "</td>";

echo "</tr>";
}
?>
</table>
</body>
</html>
