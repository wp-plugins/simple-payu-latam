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
if(defined('WP_UNINSTALL_PLUGIN') ){
  global $wpdb;
  $table_name = $wpdb->prefix . "simplepayulatam";
  $sql="DROP TABLE IF EXISTS $table_name";
  $wpdb->query($sql);
  $table_name = $wpdb->prefix . "simplepayulatam_trans";
  $sql="DROP TABLE IF EXISTS $table_name";
  $wpdb->query($sql);
  delete_option( 'sp_spl_payulatam_user' );
  delete_option( 'sp_spl_payulatam_password' );
  delete_option( 'sp_spl_payulatam_accountid' );
}
?>