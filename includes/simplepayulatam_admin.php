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
function sp_spl_admin_icon()
{
	echo '
		<style> 
      #toplevel_page_sp_spl_payment_forms div.wp-menu-image:before { content: "\f174"; }
		</style>
	';
  //get other icons from http://melchoyce.github.io/dashicons/
}
add_action( 'admin_head', 'sp_spl_admin_icon' );
add_action('admin_menu', 'sp_spl_menus');

function sp_spl_menus() {
    add_menu_page('Simple PayU LATAM', 'Simple PayU LATAM', 'administrator', 'sp_spl_payment_forms', 'sp_spl_payment_forms',"","26.1345623");
    add_submenu_page('sp_spl_payment_forms', 'Payment Forms', 'Payment Forms', 'administrator', 'sp_spl_payment_forms', 'sp_spl_payment_forms');
    add_submenu_page('sp_spl_payment_forms', 'Records', 'Records', 'administrator', 'sp_spl_records', 'sp_spl_records');
    add_submenu_page('sp_spl_payment_forms', 'Settings', 'Settings', 'administrator', 'sp_spl_settings', 'sp_spl_settings');
    add_submenu_page('sp_spl_payment_forms', 'About', 'About', 'administrator', 'sp_spl_about', 'sp_spl_about');
    
    add_action( 'admin_init', 'sp_spl_register_settings' );
}

function sp_spl_register_settings() {
	register_setting( 'sp_spl_settings_group', 'sp_spl_payulatam_user' );
  register_setting( 'sp_spl_settings_group', 'sp_spl_payulatam_password' );
  register_setting( 'sp_spl_settings_group', 'sp_spl_payulatam_accountid' );
  register_setting( 'sp_spl_settings_group', 'sp_spl_payulatam_language' );
}

function sp_spl_admin_notice() {
  global $pagenow;
  if ($pagenow == 'admin.php' && $_GET['page'] == 'sp_spl_settings') {
    $errors = get_settings_errors();
    if(isset($errors[0]['message']))
    {
      ?>
      <div class="<?php echo $errors[0]['type'];?>">
          <p><?php echo $errors[0]['message'];?></p>
      </div>
      <?php
    }
  }
}
add_action( 'admin_notices', 'sp_spl_admin_notice' );
function sp_spl_settings() {
    $sp_spl_payulatam_user = (get_option('sp_spl_payulatam_user') != '') ? get_option('sp_spl_payulatam_user') : '';
    $sp_spl_payulatam_password = (get_option('sp_spl_payulatam_password') != '') ? get_option('sp_spl_payulatam_password') : '';
    $sp_spl_payulatam_accountid = (get_option('sp_spl_payulatam_accountid') != '') ? get_option('sp_spl_payulatam_accountid') : '';
    $sp_spl_payulatam_language = (get_option('sp_spl_payulatam_language') != '') ? get_option('sp_spl_payulatam_language') : 'EN';
    
    ?>
            <form method="post" action="options.php">
            
            <?php settings_fields( 'sp_spl_settings_group' ); ?>
            <?php do_settings_sections( 'sp_spl_settings_group' ); ?>
            
            <h2>PayU LATAM Configuration</h2>

            <table class="form-table">
                <tr>
                      <th scope="row"><label for="sp_spl_payulatam_user">Id Comercio (merchant ID)</label></th>
                      <td><input type="text" name="sp_spl_payulatam_user" id="sp_spl_payulatam_user" value="<?php echo $sp_spl_payulatam_user;?>" /></td>
                </tr>
                <tr>
                      <th scope="row"><label for="sp_spl_payulatam_password">PayU Api key</label></th>
                      <td><input type="text" name="sp_spl_payulatam_password" id="sp_spl_payulatam_password" value="<?php echo $sp_spl_payulatam_password;?>" /></td>
                </tr>
                <tr>
                      <th scope="row"><label for="sp_spl_payulatam_accountid">Account ID (Brazil,Mexic)</label></th>
                      <td><input type="text" name="sp_spl_payulatam_accountid" id="sp_spl_payulatam_accountid" value="<?php echo $sp_spl_payulatam_accountid;?>" /></td>
                </tr>
                <tr>
                      <th scope="row"><label for="sp_spl_payulatam_language">Language (EN,ES,PT)</label></th>
                      <td><input type="text" name="sp_spl_payulatam_language" id="sp_spl_payulatam_language" value="<?php echo $sp_spl_payulatam_language;?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
            </form>
    <?php
}
?>