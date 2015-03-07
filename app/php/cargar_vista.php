<?php
/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */
header('Access-Control-Allow-Origin: *');
// DB table to use
$table = 'vdoctores';
 
// Table's primary key
$primaryKey = 'id_doctor';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'id_doctor', 'dt' => 'idDoctor' ),
    array( 'db' => 'nombre',  'dt' => 'nombre' ),
    array( 'db' => 'numcolegiado',   'dt' => 'numcolegiado' ),
    array( 'db' => 'nombre_clinica',     'dt' => 'nombreClinica' ),
    array( 'db' => 'id_clinica',     'dt' => 'idClinica' )
);
 
// SQL server connection information
/*
$sql_details = array(
    'user' => 'root',
    'pass' => 'root',
    'db'   => 'datatables',
    'host' => 'localhost'
);
*/
$sql_details = array(
    'user' => 'maberges_dwec',
    'pass' => '123456',
    'db'   => 'maberges_datatables',
    'host' => 'localhost'
);
 
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require( 'ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);