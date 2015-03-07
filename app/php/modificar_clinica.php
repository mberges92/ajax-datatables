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
$id = $_POST["idDoctor"];
$nombre = $_POST["nombre"];
$numcolegiado = $_POST["numcolegiado"];
$clinicas = $_POST["id_clinica"];
//echo "id=$id nombre= $nombre colegiado= $numcolegiado clinicas= $clinicas";
if($clinicas){
$query = "delete from clinica_doctor where id_doctor=" . $id;
$query_res = mysql_query($query);
}
//echo"$query <br>";
for ($i=0;$i<count($clinicas);$i++)    
{     
//echo "<br> CLinicaid " . $i . ": " . $clinicas[$i];   
$query1 = "insert into clinica_doctor (id_doctor,id_clinica) values( 
             ". $id . ", 
            " . $clinicas[$i] . ")" ;
//echo"$query1";
            $query_res = mysql_query($query1);
} 
/* Consulta UPDATE */
$query = "UPDATE doctores SET 
            nombre = '" . $nombre . "', 
            numcolegiado = '" . $numcolegiado . "' 
            WHERE id_doctor = '" . $id."'";
//mysql_query($query, $gaSql['link']) or fatal_error('MySQL Error: ' . mysql_errno());
/*En función del resultado correcto o no, mostraremos el mensaje que corresponda*/
$query_res = mysql_query($query);
// Comprobar el resultado
if (!$query_res) {
    $mensaje  = 'Error en la consulta: ' . mysql_error() ;
    $estado = mysql_errno();
    
}
else
{
    $mensaje = "Actualización correcta";
    $estado = 0;
}
$resultado = array();
 $resultado[] = array(
      'mensaje' => $mensaje,
      'estado' => $estado
   );
echo json_encode($resultado);
?>