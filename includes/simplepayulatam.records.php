<?php
/*
Copyright 2015  Softpill.eu  (email : mail@softpill.eu)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
if(!class_exists('WP_List_Table')){
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class SP_SPL_List_Table extends WP_List_Table {

	function get_columns(){
  $columns = array(
    'form' => 'Form',
    'fname'      => 'First Name',
    'lname'      => 'Last Name',
    'product'    => 'Product',
    'payment'      => 'Payment',
    'email'      => 'Email',
    'mdate'      => 'Date'
  );
  return $columns;
}

function prepare_items() {
  global $wpdb;
  $per_page=10;
  $columns = $this->get_columns();
  $hidden = array();
  $sortable = array();
  $this->_column_headers = array($columns, $hidden, $sortable);
  $sql="
  select * from ".$wpdb->prefix."simplepayulatam_trans
  where 1=1
  order by mdate desc
  ";
  $data=array();
  $results=$wpdb->get_results($sql);
  if(count($results)>0)
  {
    foreach($results as $r)
    {
      $data[]=array(
      'id'=>$r->id,
      'form'=>$r->form,
      'product'=>$r->product,
      'payment'=>$r->payment,
      'fname'=>'<a href="javascript:void(0);" onClick="javascript:openSPSPLRecord('.$r->id.');">'.$r->fname.'</a>',
      'lname'=>$r->lname,
      'email'=>$r->email,
      'mdate'=>date("d/m/y H:i",$r->mdate)
      );
    }
  }
  $current_page = $this->get_pagenum();
       
  $total_items = count($data);
  
  $data = array_slice($data,(($current_page-1)*$per_page),$per_page);
  
  $this->items = $data;
  
  $this->set_pagination_args( array(
      'total_items' => $total_items,                  
      'per_page'    => $per_page,                     
      'total_pages' => ceil($total_items/$per_page)   
  ) );
}
function column_default( $item, $column_name ) {
  switch( $column_name ) { 
    case 'form':
    case 'product':
    case 'payment':
    case 'fname':
    case 'lname':
    case 'email':
    case 'mdate':
      return $item[ $column_name ];
    default:
      return print_r( $item, true ) ; //Show the whole array for troubleshooting purposes
  }
}
}

?>