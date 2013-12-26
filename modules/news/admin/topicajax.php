<?php

/**
 * @Project NUKEVIET 3.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2012 VINADES.,JSC. All rights reserved
 * @Createdate 2-9-2010 14:43
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$q = $nv_Request->get_title( 'term', 'get', '', 1 );
if( empty( $q ) ) return;

//$sql = "SELECT title FROM " . NV_PREFIXLANG . "_" . $module_data . "_topics WHERE title LIKE '%" . $db->dblikeescape( $q ) . "%' OR keywords LIKE '%" . $db->dblikeescape( $q ) . "%' ORDER BY weight ASC LIMIT 50";
$sdr->reset()
	->select('title')
	->from(NV_PREFIXLANG . "_" . $module_data . "_topics")
	->where( "title LIKE '%" . $db->dblikeescape( $q ) . "%' OR keywords LIKE '%" . $db->dblikeescape( $q ) . "%'"  )
	->order( 'weight ASC' )
	->limit('50');	
$result = $db->query( $sdr->get() );

$array_data = array();
while( list( $title ) = $db->sql_fetchrow( $result, 1 ) )
{
	$array_data[] = $title;
}

header( 'Cache-Control: no-cache, must-revalidate' );
header( 'Content-type: application/json' );

ob_start( 'ob_gzhandler' );
echo json_encode( $array_data );
exit();

?>