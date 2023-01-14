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
.table_cells_odd {
background-color:#778899;
padding-right: 20px;
text-align:right;
}
.table_cells_even {
background-color:#87cefa;
padding-right: 20px;
text-align:right;
}
body { font-family: "Trebuchet MS", Courier; }
</style>
</head>
<body>
<h1>Epilepsiedetectie Detectiesysteem Database</h1>
<p>
<table border="0" cellspacing="0" cellpadding="4">
<tr>
<td class="table_titles">ID</td>
<td class="table_titles">Datum & Tijd</td>
<td class="table_titles">Temperatuur</td>
<td class="table_titles">Luchtvochtigheid</td>
<td class="table_titles">Hitte index</td>

</tr>
<?php
include('connection.php');
$result = mysqli_query($con,'SELECT * FROM data ORDER BY id DESC');
$oddrow = true;
while($row = mysqli_fetch_array($result))
{
if ($oddrow)
{
$css_class=' class="table_cells_odd"';
}
else
{
$css_class=' class="table_cells_even"';
}
$oddrow = !$oddrow;
echo "<tr>";
echo "<td '.$css_class.'>" . $row['id'] . "</td>";
echo "<td '.$css_class.'>" . $row['event'] . "</td>";
echo "<td '.$css_class.'>" . $row['temperature'] . "</td>";
echo "<td '.$css_class.'>" . $row['humidity'] . "</td>";
echo "<td '.$css_class.'>" . $row['heat_index'] . "</td>";
echo "</tr>";
}

mysqli_close($con);
?>
</table>
</body>
</html>
