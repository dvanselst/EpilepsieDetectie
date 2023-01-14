<?php
$url=$_SERVER['REQUEST_URI'];
header("Refresh: 5; URL=$url"); // Refresh the webpage every 5 seconds
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
<h1>Epilepsiedetectie Detectiesysteem Database</h1>
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
include('connection.php');
$id = $_POST['ID'] ?? null;
$id2 = $_POST['ID_range_val1'] ?? null;
$id3 = $_POST['ID_range_val2'] ?? null;
$result = mysqli_query($con,'SELECT * FROM data ORDER BY id DESC');
if(isset($_POST['change_value_1'])) {
    mysqli_query($con,"UPDATE `data` SET `Aanval` = 1 WHERE `data`.`id` = '$id' ");
    echo "ID $id aanval aangepast";
}  
if(isset($_POST['change_value_0'])) {
    mysqli_query($con,"UPDATE `data` SET `Aanval` = 0 WHERE `data`.`id` = '$id' ");
    echo  "ID $id aanval aangepast";
}  
if(isset($_POST['change_value_range_1'])) {
    mysqli_query($con,"UPDATE `data` SET `Aanval` = 1 WHERE `data`.`id` BETWEEN '$id2' AND '$id3' ");
    echo  "ID van $id2 tot $id3 aanval aangepast";
}  
if(isset($_POST['change_value_range_0'])) {
    mysqli_query($con,"UPDATE `data` SET `Aanval` = 0 WHERE `data`.`id` BETWEEN '$id2' AND '$id3' ");
    echo  "ID van $id2 tot $id3 aanval aangepast";
}  
$result = mysqli_query($con,'SELECT * FROM data ORDER BY id DESC');
while($row = mysqli_fetch_array($result))
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
echo "<td '.$css_class.'>" . $row['id'] . "</td>";
echo "<td '.$css_class.'>" . $row['event'] . "</td>";
echo "<td '.$css_class.'>" . $row['temperature'] . "</td>";
echo "<td '.$css_class.'>" . $row['humidity'] . "</td>";
echo "<td '.$css_class.'>" . $row['heat_index'] . "</td>";
if ($row['Aanval'] == 1)
    echo "<td '.$css_class.'>" . 'Ja' . "</td>";
else 
    echo "<td '.$css_class.'>" . 'Nee' . "</td>";


echo "</tr>";
}

mysqli_close($con);
?>
</table>
</body>
</html>
