<?php
/* Plugin Name: Simple PayU LATAM
Description: Simple PayU LATAM (Latin America), process invoices, sell products
Version: 1.0
Author: Softpill.eu
Author URI: http://www.softpill.eu/
License: GPLv2 or later

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

define("SP_SPL_DIR", WP_PLUGIN_DIR."/".basename( dirname( __FILE__ ) ) );
define("SP_SPL_URL", plugins_url()."/".basename( dirname( __FILE__ ) ) );
if(is_admin()){
function sp_spl_activation() {
  global $wpdb;
  $table_name = $wpdb->prefix . "simplepayulatam";
  $sql="CREATE TABLE IF NOT EXISTS `$table_name` (
  `id`  int NULL AUTO_INCREMENT ,
  `title`  varchar(255) NULL ,
  `product_name`  varchar(255) NULL ,
  `payment_type`  tinyint NULL DEFAULT 0 ,
  `payment_value`  varchar(255) NULL DEFAULT '10.00' ,
  `min_payment`  varchar(255) NULL DEFAULT '1.00' ,
  `invoice`  tinyint NULL DEFAULT 0 ,
  `invoice_label`  varchar(255) NULL DEFAULT 'Invoice' ,
  `input_value_text`  varchar(255) NULL DEFAULT 'Payment' ,
  `currency`  varchar(255) NULL ,
  `default_country`  varchar(255) NULL DEFAULT 'GB' ,
  `show_tel`  tinyint NULL DEFAULT 0 ,
  `custom1`  varchar(255) NULL ,
  `custom_r1`  tinyint NULL DEFAULT 0 ,
  `custom2`  varchar(255) NULL ,
  `custom_r2`  tinyint NULL DEFAULT 0 ,
  `custom3`  varchar(255) NULL ,
  `custom_r3`  tinyint NULL DEFAULT 0 ,
  `mode`  varchar(255) NULL ,
  `payment_description`  text NULL ,
  `payment_button_text`  varchar(255) NULL DEFAULT 'Click to Pay' ,
  `popup_text`  text NULL ,
  `popup_btn_text`  varchar(255) NULL DEFAULT 'Click to Pay' ,
  `success_url`  varchar(255) NULL ,
  `failure_url`  varchar(255) NULL ,
  `mdate`  int NULL  ,
  PRIMARY KEY (`id`)
  )";
  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $sql );
  $table_name = $wpdb->prefix . "simplepayulatam_trans";
  $sql="CREATE TABLE IF NOT EXISTS `$table_name` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form` varchar(255) DEFAULT NULL,
  `product` varchar(255) DEFAULT NULL,
  `invoice` varchar(255) DEFAULT NULL,
  `payment` varchar(255) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `postcode` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `custom1` varchar(255) DEFAULT NULL,
  `custom2` varchar(255) DEFAULT NULL,
  `custom3` varchar(255) DEFAULT NULL,
  `mdate` int(11) NOT NULL,
  PRIMARY KEY (`id`)
  )";
  dbDelta( $sql );
}
register_activation_hook(__FILE__, 'sp_spl_activation');
function sp_spl_deactivation() {
}
register_deactivation_hook(__FILE__, 'sp_spl_deactivation');

require_once(SP_SPL_DIR.DIRECTORY_SEPARATOR."includes".DIRECTORY_SEPARATOR."simplepayulatam_admin.php");
require_once(SP_SPL_DIR.DIRECTORY_SEPARATOR."includes".DIRECTORY_SEPARATOR."simplepayulatam_forms.php");
require_once(SP_SPL_DIR.DIRECTORY_SEPARATOR."includes".DIRECTORY_SEPARATOR."simplepayulatam_about.php");
require_once(SP_SPL_DIR.DIRECTORY_SEPARATOR."includes".DIRECTORY_SEPARATOR."simplepayulatam.records.php");
require_once(SP_SPL_DIR.DIRECTORY_SEPARATOR."includes".DIRECTORY_SEPARATOR."simplepayulatam_records.php");
}
else{
//front-end
require_once(SP_SPL_DIR.DIRECTORY_SEPARATOR."includes".DIRECTORY_SEPARATOR."simplepayulatam_frontend.php");
}


?>