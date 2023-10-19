<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


$id     = ( isset( $_GET['id'] ) )     ? sanitize_text_field( $_GET['id'] )     : null;
$edit   = ( isset( $_GET['edit'] ) )   ? sanitize_text_field( $_GET['edit'] )   : null;
$folder = ( isset( $_GET['folder'] ) ) ? sanitize_text_field( $_GET['folder'] ) : null;

if(
	empty( $edit ) &&
	! empty( $id ) &&
	! empty( get_post( $id ) )
){
	require_once 'blocks/edit.php';
}

elseif(
	empty( $id ) &&
	empty( $edit )
){
	require_once 'folders/folder.php';
}

elseif(
	empty( $id ) &&
	! empty( $edit ) &&
	! empty( $folder ) &&
	! empty( get_term( $folder ) )
){
	require_once 'folders/edit.php';
}

else{
	require_once '404/404.php';
}
?>