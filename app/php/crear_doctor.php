<?php
header('Access-Control-Allow-Origin: *');
/* Database connection information */
include("mysql.php" );
/*
 * Local functions
 */
function fatal_error($sErrorMessage = '') {
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error');
    die($sErrorMessage);
}
/*
 * MySQL connection
 */
if (!$gaSql['link'] = mysql_pconnect($gaSql['server'], $gaSql['user'], $gaSql['password'])) {
    fatal_error('Could not open connection to server');
}
if (!mysql_select_db($gaSql['db'], $gaSql['link'])) {
    fatal_error('Could not select database ');
}
mysql_query('SET names utf8');
/*
 * SQL queries
 * Get data to display
 */
$nombre = $_POST["nombreNuevo"];
$numcolegiado = $_POST["numcolegiadoNuevo"];
$clinicas = $_POST["clinicas2"];
//echo "id=$id nombre= $nombre colegiado= $numcolegiado clinicas= $clinicas";
//echo"$query <br>";
$query1 = "insert into doctores (nombre,numcolegiado) values( 
             '". $nombre . "', 
            '" . $numcolegiado . "')" ;
//echo"$query1 <br>";
$query_res1 = mysql_query($query1);
if($query_res1){
$sql = "SELECT id_doctor
        FROM doctores
        where numcolegiado='".$numcolegiado."'";
//echo "$sql <br>";
$res = mysql_query($sql);
while($row = mysql_fetch_array($res, MYSQL_ASSOC))
{
$id_nuevo=$row['id_doctor'];
}
}
//echo "idenuevo =>  $id_nuevo";
for ($i=0;$i<count($clinicas);$i++)    
{     
//echo "<br> CLinicaid " . $i . ": " . $clinicas[$i];   
$query2 = "insert into clinica_doctor (id_doctor,id_clinica) values( 
             ". $id_nuevo . ", 
            " . $clinicas[$i] . ")" ;
//echo"$query1";
            $query_res2 = mysql_query($query2);
} 
if (!$query_res1||!$res||$query_res2) {
   // $mensaje  = 'Error en la consulta de inserts: ' . mysql_error() . "\n";
   // $estado = mysql_errno();
    if (mysql_errno() == 1062) {
        $mensaje = "Imposible añadir el doctor, num colegiado ya existe";
        $estado = mysql_errno();
    } else {
        $mensaje = 'Error en la consulta: ' . mysql_error() . "\n";
        $estado = mysql_errno();
    }
}
else
{
    $mensaje = "Insercion correcta";
    $estado = 0;
}
$resultado = array();
 $resultado[] = array(
      'mensaje' => $mensaje,
      'estado' => $estado
   );
echo json_encode($resultado);
?>