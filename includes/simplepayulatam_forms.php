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
function sp_spl_payment_forms(){
global $wpdb;
$action=isset($_POST['action'])?$_POST['action']:"";
$table_name = $wpdb->prefix . "simplepayulatam";
if($action=='add_new')
{
  ?>
  <div class="wrap">
  <form method="post" action="">
    <input type="hidden" name="action" value="save_new" />
    <h2>Add New Payment Form</h2>
    <table class="form-table">
      <tr>
        <th scope="row"><a href="" class="button button-secondary">Cancel</a></th>
        <td colspan="2"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save New Payment Form" /></td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_title">Title</th>
        <td><input type="text" name="sp_spl_title" id="sp_spl_title" value="" /></td>
        <td>Payment Form Title, not used in front-end</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_product_name">Product Name</th>
        <td><input type="text" name="sp_spl_product_name" id="sp_spl_product_name" value="Product" /></td>
        <td>Product name that will appear in PayU Romania Transaction Description.</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_payment_type">Payment Type</th>
        <td>
        <select name="sp_spl_payment_type" id="sp_spl_payment_type">
          <option value="0" selected="selected">Fixed</option>
	        <option value="1">Custom Input</option>
        </select>
        </td>
        <td>Fixed or Custom Input by customer</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_payment_value">Payment Value</th>
        <td><input type="text" name="sp_spl_payment_value" id="sp_spl_payment_value" value="10.00" /></td>
        <td>Enter the value for fixed payment (decimals separated by . )</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_min_payment">Min Payment Value</th>
        <td><input type="text" name="sp_spl_min_payment" id="sp_spl_min_payment" value="1.00" /></td>
        <td>Minimum Payment Value for customer input payment</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_invoice">Invoice Field</th>
        <td>
        <select name="sp_spl_invoice" id="sp_spl_invoice">
          <option value="0">No</option>
	        <option value="1" selected="selected">Yes</option>
        </select>
        </td>
        <td>Show the custom invoice field? This will add a dummy product in the PayU Romania transaction for a custom Invoice number</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_invoice_label">Invoice Label</th>
        <td><input type="text" name="sp_spl_invoice_label" id="sp_spl_invoice_label" value="Invoice" /></td>
        <td>Invoice field label</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_input_value_text">Input Value Text</th>
        <td><input type="text" name="sp_spl_input_value_text" id="sp_spl_input_value_text" value="Payment" /></td>
        <td>Label for customer input payment value</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_currency">Currency</th>
        <td>
        <select name="sp_spl_currency" id="sp_spl_currency">
          <option value="USD" selected="selected">USD</option>
    			<option value="ARS">ARS</option>
          <option value="BRL">BRL</option>
          <option value="COP">COP</option>
          <option value="MXN">MXN</option>
          <option value="PEN">PEN</option>
        </select>
        </td>
        <td>Select Payment Currency</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_default_country">Default Country</th>
        <td><input type="text" name="sp_spl_default_country" id="sp_spl_default_country" value="AR" /></td>
        <td>Default Billining Country, Alphanumeric Max 2 characters (ISO 3166-1 country code of the cardholder's billing address)</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_show_tel">Show Telephone Field?</th>
        <td>
        <select name="sp_spl_show_tel" id="sp_spl_show_tel">
          <option value="0" selected="selected">No</option>
        	<option value="1">Yes</option>
        </select>
        </td>
        <td>Show the Telephone field or not</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_custom1">Custom Field 1</th>
        <td><input type="text" name="sp_spl_custom1" id="sp_spl_custom1" value="" /></td>
        <td>Custom field to show to the customer (i.e.: Age), saved in records, empty to disable</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_custom_r1">Custom Field 1 Required</th>
        <td>
        <select name="sp_spl_custom_r1" id="sp_spl_custom_r1">
          <option value="0" selected="selected">No</option>
        	<option value="1">Yes</option>
        </select>
        </td>
        <td>Custom field is Required or not</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_custom2">Custom Field 2</th>
        <td><input type="text" name="sp_spl_custom2" id="sp_spl_custom2" value="" /></td>
        <td>Custom field to show to the customer (i.e.: Age), saved in records, empty to disable</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_custom_r1">Custom Field 2 Required</th>
        <td>
        <select name="sp_spl_custom_r2" id="sp_spl_custom_r2">
          <option value="0" selected="selected">No</option>
        	<option value="1">Yes</option>
        </select>
        </td>
        <td>Custom field is Required or not</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_custom3">Custom Field 3</th>
        <td><input type="text" name="sp_spl_custom3" id="sp_spl_custom3" value="" /></td>
        <td>Custom field to show to the customer (i.e.: Age), saved in records, empty to disable</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_custom_r1">Custom Field 3 Required</th>
        <td>
        <select name="sp_spl_custom_r3" id="sp_spl_custom_r3">
          <option value="0" selected="selected">No</option>
        	<option value="1">Yes</option>
        </select>
        </td>
        <td>Custom field is Required or not</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_mode">Mode</th>
        <td>
        <select name="sp_spl_mode" id="sp_spl_mode">
        	<option value="TEST" selected="selected">TEST</option>
        	<option value="LIVE">LIVE</option>
        </select>
        </td>
        <td>Select Transaction Mode</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_payment_description">Payment Description</th>
        <td><textarea name="sp_spl_payment_description" id="sp_spl_payment_description"></textarea></td>
        <td>Enter text before the payment button, can be HTML</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_payment_button_text">Payment Button Text</th>
        <td><input type="text" name="sp_spl_payment_button_text" id="sp_spl_payment_button_text" value="Click to Pay" /></td>
        <td>Payment Button Text, i.e. Click to Pay</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_popup_text">Pop-up Text</th>
        <td><textarea name="sp_spl_popup_text" id="sp_spl_popup_text"></textarea></td>
        <td>Enter text before the pop-up form, can be HTML</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_popup_btn_text">Pop-up Button Text</th>
        <td><input type="text" name="sp_spl_popup_btn_text" id="sp_spl_popup_btn_text" value="Click to Pay" /></td>
        <td>Pop-up payment Button Text, i.e. Click to Pay</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_success_url">Return URL</th>
        <td><input type="text" name="sp_spl_success_url" id="sp_spl_success_url" value="<?php echo get_site_url(); ?>" /></td>
        <td>Success URL, http://www.your-website.com, http or https</td>
      </tr>
      <tr>
        <th scope="row"><a href="" class="button button-secondary">Cancel</a></th>
        <td colspan="2"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save New Payment Form" /></td>
      </tr>
    </table>
  </form>
  </div>
  <?php
}
if($action=='save_edit')
{
  $form_id=isset($_POST['form_id'])?intval($_POST['form_id']):0;
  if($form_id>0)
  {
  $_POST1 = array_map('stripslashes_deep', $_POST);//why auto adding slashes??
  
  $title=isset($_POST1['sp_spl_title'])?sanitize_text_field($_POST1['sp_spl_title']):"";
  $product_name=isset($_POST1['sp_spl_product_name'])?sanitize_text_field($_POST1['sp_spl_product_name']):"";
  $payment_type=isset($_POST1['sp_spl_payment_type'])?intval($_POST1['sp_spl_payment_type']):0;
  $payment_value=isset($_POST1['sp_spl_payment_value'])?sanitize_text_field($_POST1['sp_spl_payment_value']):"";
  $min_payment=isset($_POST1['sp_spl_min_payment'])?intval($_POST1['sp_spl_min_payment']):0;
  $invoice=isset($_POST1['sp_spl_invoice'])?sanitize_text_field($_POST1['sp_spl_invoice']):"";
  $invoice_label=isset($_POST1['sp_spl_invoice_label'])?sanitize_text_field($_POST1['sp_spl_invoice_label']):"";
  $input_value_text=isset($_POST1['sp_spl_input_value_text'])?sanitize_text_field($_POST1['sp_spl_input_value_text']):"";
  $currency=isset($_POST1['sp_spl_currency'])?sanitize_text_field($_POST1['sp_spl_currency']):"";
  $default_country=isset($_POST1['sp_spl_default_country'])?sanitize_text_field($_POST1['sp_spl_default_country']):"";
  $show_tel=isset($_POST1['sp_spl_show_tel'])?intval($_POST1['sp_spl_show_tel']):0;
  $custom1=isset($_POST1['sp_spl_custom1'])?sanitize_text_field($_POST1['sp_spl_custom1']):"";
  $custom2=isset($_POST1['sp_spl_custom2'])?sanitize_text_field($_POST1['sp_spl_custom2']):"";
  $custom3=isset($_POST1['sp_spl_custom3'])?sanitize_text_field($_POST1['sp_spl_custom3']):"";
  $custom_r1=isset($_POST1['sp_spl_custom_r1'])?intval($_POST1['sp_spl_custom_r1']):0;
  $custom_r2=isset($_POST1['sp_spl_custom_r2'])?intval($_POST1['sp_spl_custom_r2']):0;
  $custom_r3=isset($_POST1['sp_spl_custom_r3'])?intval($_POST1['sp_spl_custom_r3']):0;
  $mode=isset($_POST1['sp_spl_mode'])?sanitize_text_field($_POST1['sp_spl_mode']):"";
  $payment_description=isset($_POST1['sp_spl_payment_description'])?balanceTags(trim((string)$_POST1['sp_spl_payment_description'])):"";
  $payment_button_text=isset($_POST1['sp_spl_payment_button_text'])?sanitize_text_field($_POST1['sp_spl_payment_button_text']):"";
  $popup_text=isset($_POST1['sp_spl_popup_text'])?balanceTags(trim((string)$_POST1['sp_spl_popup_text'])):"";
  $popup_btn_text=isset($_POST1['sp_spl_popup_btn_text'])?sanitize_text_field($_POST1['sp_spl_popup_btn_text']):"";
  $success_url=isset($_POST1['sp_spl_success_url'])?esc_url($_POST1['sp_spl_success_url']):"";
    
  $title=sp_spl_check_string_length($title);
  $product_name=sp_spl_check_string_length($product_name);
  $payment_type=sp_spl_check_string_length($payment_type,1);
  $payment_value=sp_spl_check_string_length($payment_value);
  $min_payment=sp_spl_check_string_length($min_payment);
  $invoice=sp_spl_check_string_length($invoice,1);
  $invoice_label=sp_spl_check_string_length($invoice_label);
  $input_value_text=sp_spl_check_string_length($input_value_text);
  $currency=sp_spl_check_string_length($currency,3);
  $default_country=sp_spl_check_string_length($default_country,2);
  $show_tel=sp_spl_check_string_length($show_tel,1);
  $custom1=sp_spl_check_string_length($custom1);
  $custom2=sp_spl_check_string_length($custom2);
  $custom3=sp_spl_check_string_length($custom3);
  $custom_r1=sp_spl_check_string_length($custom_r1,1);
  $custom_r2=sp_spl_check_string_length($custom_r2,1);
  $custom_r3=sp_spl_check_string_length($custom_r3,1);
  $mode=sp_spl_check_string_length($mode);
  $payment_description=sp_spl_check_string_length($payment_description,1000);
  $payment_button_text=sp_spl_check_string_length($payment_button_text);
  $popup_text=sp_spl_check_string_length($popup_text,1000);
  $popup_btn_text=sp_spl_check_string_length($popup_btn_text);
  $success_url=sp_spl_check_string_length($success_url);
  
  $wpdb->update(
    $table_name,
    array(
      'title'=>$title,
      'product_name'=>$product_name,
      'payment_type'=>$payment_type,
      'payment_value'=>$payment_value,
      'min_payment'=>$min_payment,
      'invoice'=>$invoice,
      'invoice_label'=>$invoice_label,
      'input_value_text'=>$input_value_text,
      'currency'=>$currency,
      'default_country'=>$default_country,
      'show_tel'=>$show_tel,
      'custom1'=>$custom1,
      'custom2'=>$custom2,
      'custom3'=>$custom3,
      'custom_r1'=>$custom_r1,
      'custom_r2'=>$custom_r2,
      'custom_r3'=>$custom_r3,
      'mode'=>$mode,
      'payment_description'=>$payment_description,
      'payment_button_text'=>$payment_button_text,
      'popup_text'=>$popup_text,
      'popup_btn_text'=>$popup_btn_text,
      'success_url'=>$success_url,
      'failure_url'=>$failure_url,
      'mdate'=>time()
    ),
    array('id' => $form_id),
    array(
  		'%s','%s','%d','%d','%d','%d','%s','%s','%s',
      '%s','%d','%s','%s','%s','%d','%d','%d','%s','%s',
      '%s','%s','%s','%s','%d'
  	),
    array('%d')
  );
  
  if(isset($wpdb->last_error) && $wpdb->last_error!="")
  {
    add_settings_error(
      'sp_spl_opperation_messages',
      esc_attr( 'settings_updated' ),
      "DB ERROR: ".$wpdb->last_error,
      'error'
    );
    $action="edit_form";
  }
  else
  {
    add_settings_error(
      'sp_spl_opperation_messages',
      esc_attr( 'settings_updated' ),
      "Updated Payment Form",
      'updated'
    );
    $action="edit_form";
  }
  }
  else
  {
    $action="";
  }
}
if($action=='edit_form')
{
  $form_id=isset($_POST['form_id'])?intval($_POST['form_id']):0;
  if($form_id>0)
  {
    $sql="select * from $table_name where id='".$form_id."'";
    $form = $wpdb->get_results($sql);
    if(isset($form[0]))
    {
      $form=$form[0];
      $payment_type0="";
      $payment_type1="";
      if($form->payment_type==0)
      {
        $payment_type0=' selected="selected"';
      }
      if($form->payment_type==1)
      {
        $payment_type1=' selected="selected"';
      }
      $invoice0="";
      $invoice1="";
      if($form->invoice==0)
      {
        $invoice0=' selected="selected"';
      }
      if($form->invoice==1)
      {
        $invoice1=' selected="selected"';
      }
      $mode1="";
      $mode2="";
      if($form->mode=='LIVE')
      {
        $mode2=' selected="selected"';
      }
      if($form->mode=='TEST')
      {
        $mode1=' selected="selected"';
      }
      $currency0="";
      $currency1="";
      $currency2="";
      $currency3="";
      $currency4="";
      $currency5="";
      if($form->currency=='USD')
      {
        $currency0=' selected="selected"';
      }
      if($form->currency=='ARS')
      {
        $currency1=' selected="selected"';
      }
      if($form->currency=='BRL')
      {
        $currency2=' selected="selected"';
      }
      if($form->currency=='COP')
      {
        $currency3=' selected="selected"';
      }
      if($form->currency=='MXN')
      {
        $currency4=' selected="selected"';
      }
      if($form->currency=='PEN')
      {
        $currency5=' selected="selected"';
      }
      $show_tel0="";
      $show_tel1="";
      if($form->show_tel==0)
      {
        $show_tel0=' selected="selected"';
      }
      if($form->show_tel==1)
      {
        $show_tel1=' selected="selected"';
      }
      $custom_r10="";
      if($form->custom_r1==0)
      {
        $custom_r10=' selected="selected"';
      }
      $custom_r11="";
      if($form->custom_r1==1)
      {
        $custom_r11=' selected="selected"';
      }
      $custom_r20="";
      if($form->custom_r2==0)
      {
        $custom_r20=' selected="selected"';
      }
      $custom_r21="";
      if($form->custom_r2==1)
      {
        $custom_r21=' selected="selected"';
      }
      $custom_r30="";
      if($form->custom_r3==0)
      {
        $custom_r30=' selected="selected"';
      }
      $custom_r31="";
      if($form->custom_r3==1)
      {
        $custom_r31=' selected="selected"';
      }
      $errors = get_settings_errors('sp_spl_opperation_messages');
      if(is_array($errors))
      {
        foreach($errors as $err)
        {
        ?>
        <div class="<?php echo $err['type'];?>">
            <p><?php echo $err['message'];?></p>
        </div>
        <?php
        }
      }
  ?>
  <div class="wrap">
  <form method="post" action="">
    <input type="hidden" name="form_id" value="<?php echo $form->id;?>" />
    <input type="hidden" name="action" value="save_edit" />
    <h2>Edit Payment Form</h2>
    <table class="form-table">
      <tr>
        <th scope="row"><a href="" class="button button-secondary">Return</a></th>
        <td colspan="2"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Payment Form" /></td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_title">Title</th>
        <td><input type="text" name="sp_spl_title" id="sp_spl_title" value="<?php echo esc_attr($form->title);?>" /></td>
        <td>Payment Form Title, not used in front-end</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_product_name">Product Name</th>
        <td><input type="text" name="sp_spl_product_name" id="sp_spl_product_name" value="<?php echo esc_attr($form->product_name);?>" /></td>
        <td>Product name that will appear in PayU Romania Transaction Description.</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_payment_type">Payment Type</th>
        <td>
        <select name="sp_spl_payment_type" id="sp_spl_payment_type">
          <option value="0"<?php echo $payment_type0;?>>Fixed</option>
	        <option value="1"<?php echo $payment_type1;?>>Custom Input</option>
        </select>
        </td>
        <td>Fixed or Custom Input by customer</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_payment_value">Payment Value</th>
        <td><input type="text" name="sp_spl_payment_value" id="sp_spl_payment_value" value="<?php echo esc_attr($form->payment_value);?>" /></td>
        <td>Enter the value for fixed payment (decimals separated by . )</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_min_payment">Min Payment Value</th>
        <td><input type="text" name="sp_spl_min_payment" id="sp_spl_min_payment" value="<?php echo esc_attr($form->min_payment);?>" /></td>
        <td>Minimum Payment Value for customer input payment</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_invoice">Invoice Field</th>
        <td>
        <select name="sp_spl_invoice" id="sp_spl_invoice">
          <option value="0"<?php echo $invoice0;?>>No</option>
	        <option value="1"<?php echo $invoice1;?>>Yes</option>
        </select>
        </td>
        <td>Show the custom invoice field? This will add a dummy product in the PayU Romania transaction for a custom Invoice number</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_invoice_label">Invoice Label</th>
        <td><input type="text" name="sp_spl_invoice_label" id="sp_spl_invoice_label" value="<?php echo esc_attr($form->invoice_label);?>" /></td>
        <td>Invoice field label</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_input_value_text">Input Value Text</th>
        <td><input type="text" name="sp_spl_input_value_text" id="sp_spl_input_value_text" value="<?php echo esc_attr($form->input_value_text);?>" /></td>
        <td>Label for customer input payment value</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_currency">Currency</th>
        <td>
        <select name="sp_spl_currency" id="sp_spl_currency">
          <option value="USD"<?php echo $currency0;?>>USD</option>
    			<option value="ARS"<?php echo $currency1;?>>ARS</option>
          <option value="BRL"<?php echo $currency2;?>>BRL</option>
          <option value="COP"<?php echo $currency3;?>>COP</option>
          <option value="MXN"<?php echo $currency4;?>>MXN</option>
          <option value="PEN"<?php echo $currency5;?>>PEN</option>
        </select>
        </td>
        <td>Select Payment Currency</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_default_country">Default Country</th>
        <td><input type="text" name="sp_spl_default_country" id="sp_spl_default_country" value="<?php echo esc_attr($form->default_country);?>" /></td>
        <td>Default Billining Country, Alphanumeric Max 2 characters (ISO 3166-1 country code of the cardholder's billing address)</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_show_tel">Show Telephone Field?</th>
        <td>
        <select name="sp_spl_show_tel" id="sp_spl_show_tel">
          <option value="0"<?php echo $show_tel0;?>>No</option>
        	<option value="1"<?php echo $show_tel1;?>>Yes</option>
        </select>
        </td>
        <td>Show the Telephone field or not</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_custom1">Custom Field 1</th>
        <td><input type="text" name="sp_spl_custom1" id="sp_spl_custom1" value="<?php echo esc_attr($form->custom1);?>" /></td>
        <td>Custom field to show to the customer (i.e.: Age), saved in records, empty to disable</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_custom_r1">Custom Field 1 Required</th>
        <td>
        <select name="sp_spl_custom_r1" id="sp_spl_custom_r1">
          <option value="0"<?php echo $custom_r10;?>>No</option>
        	<option value="1"<?php echo $custom_r11;?>>Yes</option>
        </select>
        </td>
        <td>Custom field is Required or not</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_custom2">Custom Field 2</th>
        <td><input type="text" name="sp_spl_custom2" id="sp_spl_custom2" value="<?php echo esc_attr($form->custom2);?>" /></td>
        <td>Custom field to show to the customer (i.e.: Age), saved in records, empty to disable</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_custom_r2">Custom Field 2 Required</th>
        <td>
        <select name="sp_spl_custom_r2" id="sp_spl_custom_r2">
          <option value="0"<?php echo $custom_r20;?>>No</option>
        	<option value="1"<?php echo $custom_r21;?>>Yes</option>
        </select>
        </td>
        <td>Custom field is Required or not</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_custom3">Custom Field 3</th>
        <td><input type="text" name="sp_spl_custom3" id="sp_spl_custom3" value="<?php echo esc_attr($form->custom3);?>" /></td>
        <td>Custom field to show to the customer (i.e.: Age), saved in records, empty to disable</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_custom_r3">Custom Field 3 Required</th>
        <td>
        <select name="sp_spl_custom_r3" id="sp_spl_custom_r3">
          <option value="0"<?php echo $custom_r30;?>>No</option>
        	<option value="1"<?php echo $custom_r31;?>>Yes</option>
        </select>
        </td>
        <td>Custom field is Required or not</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_mode">Mode</th>
        <td>
        <select name="sp_spl_mode" id="sp_spl_mode">
        	<option value="TEST"<?php echo $mode1;?>>TEST</option>
        	<option value="LIVE"<?php echo $mode2;?>>LIVE</option>
        </select>
        </td>
        <td>Select Transaction Mode</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_payment_description">Payment Description</th>
        <td><textarea name="sp_spl_payment_description" id="sp_spl_payment_description"><?php echo esc_attr($form->payment_description);?></textarea></td>
        <td>Enter text before the payment button, can be HTML</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_payment_button_text">Payment Button Text</th>
        <td><input type="text" name="sp_spl_payment_button_text" id="sp_spl_payment_button_text" value="<?php echo esc_attr($form->payment_button_text);?>" /></td>
        <td>Payment Button Text, i.e. Click to Pay</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_popup_text">Pop-up Text</th>
        <td><textarea name="sp_spl_popup_text" id="sp_spl_popup_text"><?php echo esc_attr($form->popup_text);?></textarea></td>
        <td>Enter text before the pop-up form, can be HTML</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_popup_btn_text">Pop-up Button Text</th>
        <td><input type="text" name="sp_spl_popup_btn_text" id="sp_spl_popup_btn_text" value="<?php echo esc_attr($form->popup_btn_text);?>" /></td>
        <td>Pop-up payment Button Text, i.e. Click to Pay</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_spl_success_url">Return URL</th>
        <td><input type="text" name="sp_spl_success_url" id="sp_spl_success_url" value="<?php echo esc_attr($form->success_url);?>" /></td>
        <td>Success URL, http://www.your-website.com, http or https</td>
      </tr>
      <tr>
        <th scope="row"><a href="" class="button button-secondary">Return</a></th>
        <td colspan="2"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Payment Form" /></td>
      </tr>
    </table>
  </form>
  </div>
  <?php
  }
  else
  {
    $action="";
  }
  }
  else
  {
    $action="";
  }
}
if($action=='save_new')
{
  $_POST1 = array_map('stripslashes_deep', $_POST);//why auto adding slashes??
  
  $title=isset($_POST1['sp_spl_title'])?sanitize_text_field($_POST1['sp_spl_title']):"";
  $product_name=isset($_POST1['sp_spl_product_name'])?sanitize_text_field($_POST1['sp_spl_product_name']):"";
  $payment_type=isset($_POST1['sp_spl_payment_type'])?intval($_POST1['sp_spl_payment_type']):0;
  $payment_value=isset($_POST1['sp_spl_payment_value'])?sanitize_text_field($_POST1['sp_spl_payment_value']):"";
  $min_payment=isset($_POST1['sp_spl_min_payment'])?intval($_POST1['sp_spl_min_payment']):0;
  $invoice=isset($_POST1['sp_spl_invoice'])?sanitize_text_field($_POST1['sp_spl_invoice']):"";
  $invoice_label=isset($_POST1['sp_spl_invoice_label'])?sanitize_text_field($_POST1['sp_spl_invoice_label']):"";
  $input_value_text=isset($_POST1['sp_spl_input_value_text'])?sanitize_text_field($_POST1['sp_spl_input_value_text']):"";
  $currency=isset($_POST1['sp_spl_currency'])?sanitize_text_field($_POST1['sp_spl_currency']):"";
  $default_country=isset($_POST1['sp_spl_default_country'])?sanitize_text_field($_POST1['sp_spl_default_country']):"";
  $show_tel=isset($_POST1['sp_spl_show_tel'])?intval($_POST1['sp_spl_show_tel']):0;
  $custom1=isset($_POST1['sp_spl_custom1'])?sanitize_text_field($_POST1['sp_spl_custom1']):"";
  $custom2=isset($_POST1['sp_spl_custom2'])?sanitize_text_field($_POST1['sp_spl_custom2']):"";
  $custom3=isset($_POST1['sp_spl_custom3'])?sanitize_text_field($_POST1['sp_spl_custom3']):"";
  $custom_r1=isset($_POST1['sp_spl_custom_r1'])?intval($_POST1['sp_spl_custom_r1']):0;
  $custom_r2=isset($_POST1['sp_spl_custom_r2'])?intval($_POST1['sp_spl_custom_r2']):0;
  $custom_r3=isset($_POST1['sp_spl_custom_r3'])?intval($_POST1['sp_spl_custom_r3']):0;
  $mode=isset($_POST1['sp_spl_mode'])?sanitize_text_field($_POST1['sp_spl_mode']):"";
  $payment_description=isset($_POST1['sp_spl_payment_description'])?balanceTags(trim((string)$_POST1['sp_spl_payment_description'])):"";
  $payment_button_text=isset($_POST1['sp_spl_payment_button_text'])?sanitize_text_field($_POST1['sp_spl_payment_button_text']):"";
  $popup_text=isset($_POST1['sp_spl_popup_text'])?balanceTags(trim((string)$_POST1['sp_spl_popup_text'])):"";
  $popup_btn_text=isset($_POST1['sp_spl_popup_btn_text'])?sanitize_text_field($_POST1['sp_spl_popup_btn_text']):"";
  $success_url=isset($_POST1['sp_spl_success_url'])?esc_url($_POST1['sp_spl_success_url']):"";
  
  $title=sp_spl_check_string_length($title);
  $product_name=sp_spl_check_string_length($product_name);
  $payment_type=sp_spl_check_string_length($payment_type,1);
  $payment_value=sp_spl_check_string_length($payment_value);
  $min_payment=sp_spl_check_string_length($min_payment);
  $invoice=sp_spl_check_string_length($invoice,1);
  $invoice_label=sp_spl_check_string_length($invoice_label);
  $input_value_text=sp_spl_check_string_length($input_value_text);
  $currency=sp_spl_check_string_length($currency,3);
  $default_country=sp_spl_check_string_length($default_country,2);
  $show_tel=sp_spl_check_string_length($show_tel,1);
  $custom1=sp_spl_check_string_length($custom1);
  $custom2=sp_spl_check_string_length($custom2);
  $custom3=sp_spl_check_string_length($custom3);
  $custom_r1=sp_spl_check_string_length($custom_r1,1);
  $custom_r2=sp_spl_check_string_length($custom_r2,1);
  $custom_r3=sp_spl_check_string_length($custom_r3,1);
  $mode=sp_spl_check_string_length($mode);
  $payment_description=sp_spl_check_string_length($payment_description,1000);
  $payment_button_text=sp_spl_check_string_length($payment_button_text);
  $popup_text=sp_spl_check_string_length($popup_text,1000);
  $popup_btn_text=sp_spl_check_string_length($popup_btn_text);
  $success_url=sp_spl_check_string_length($success_url);
  
  $wpdb->insert(
    $table_name,
    array(
      'title'=>$title,
      'product_name'=>$product_name,
      'payment_type'=>$payment_type,
      'payment_value'=>$payment_value,
      'min_payment'=>$min_payment,
      'invoice'=>$invoice,
      'invoice_label'=>$invoice_label,
      'input_value_text'=>$input_value_text,
      'currency'=>$currency,
      'default_country'=>$default_country,
      'show_tel'=>$show_tel,
      'custom1'=>$custom1,
      'custom2'=>$custom2,
      'custom3'=>$custom3,
      'custom_r1'=>$custom_r1,
      'custom_r2'=>$custom_r2,
      'custom_r3'=>$custom_r3,
      'mode'=>$mode,
      'payment_description'=>$payment_description,
      'payment_button_text'=>$payment_button_text,
      'popup_text'=>$popup_text,
      'popup_btn_text'=>$popup_btn_text,
      'success_url'=>$success_url,
      'failure_url'=>$failure_url,
      'mdate'=>time()
    ),
    array(
  		'%s','%s','%d','%d','%d','%d','%s','%s','%s',
      '%s','%d','%s','%s','%s','%d','%d','%d','%s','%s',
      '%s','%s','%s','%s','%d'
  	)
  );

  if(isset($wpdb->last_error) && $wpdb->last_error!="")
  {
    add_settings_error(
      'sp_spl_opperation_messages',
      esc_attr( 'settings_updated' ),
      "DB ERROR: ".$wpdb->last_error,
      'error'
    );
    $action="";
  }
  else
  {
    add_settings_error(
      'sp_spl_opperation_messages',
      esc_attr( 'settings_updated' ),
      "Added New Payment Form",
      'updated'
    );
    $action="";
  }
  $action="";
}

if($action=='delete_form')
{
  $form_id=isset($_POST['form_id'])?intval($_POST['form_id']):0;
  if($form_id>0)
  {
    $wpdb->delete($table_name,array('id'=>$form_id));
    if(isset($wpdb->last_error) && $wpdb->last_error!="")
    {
      add_settings_error(
        'sp_spl_opperation_messages',
        esc_attr( 'settings_updated' ),
        "DB ERROR: ".$wpdb->last_error,
        'error'
      );
      $action="";
    }
    else
    {
      add_settings_error(
        'sp_spl_opperation_messages',
        esc_attr( 'settings_updated' ),
        "Deleted Payment Form",
        'updated'
      );
      $action="";
    }
  }
  $action="";
}
if($action=="copy_form")
{
  $form_id=isset($_POST['form_id'])?intval($_POST['form_id']):0;
  if($form_id>0)
  {
    $sql="insert into $table_name (title,product_name,payment_type,payment_value,min_payment,invoice,invoice_label,input_value_text,currency,default_country,mode,
payment_description,payment_button_text,popup_text,popup_btn_text,success_url,failure_url,mdate) 
(select concat(title,' Copy'),product_name,payment_type,payment_value,min_payment,invoice,invoice_label,input_value_text,currency,default_country,mode,
payment_description,payment_button_text,popup_text,popup_btn_text,success_url,failure_url,UNIX_TIMESTAMP() from $table_name where id='".$form_id."')";
    $wpdb->query($sql);
    if(isset($wpdb->last_error) && $wpdb->last_error!="")
    {
      add_settings_error(
        'sp_spl_opperation_messages',
        esc_attr( 'settings_updated' ),
        "DB ERROR: ".$wpdb->last_error,
        'error'
      );
      $action="";
    }
    else
    {
      add_settings_error(
        'sp_spl_opperation_messages',
        esc_attr( 'settings_updated' ),
        "Copied Payment Form",
        'updated'
      );
      $action="";
    }
  }
  $action="";
}
if($action=="")
{
$errors = get_settings_errors('sp_spl_opperation_messages');
if(is_array($errors))
{
  foreach($errors as $err)
  {
  ?>
  <div class="<?php echo $err['type'];?>">
      <p><?php echo $err['message'];?></p>
  </div>
  <?php
  }
}

$sql="select * from $table_name where 1=1 order by title asc";
$forms = $wpdb->get_results($sql);

?>
<div class="wrap">
<h2>Payment Forms</h2>
<form method="post" action="">
  <input type="hidden" name="action" value="add_new" />
  <input type="submit" name="submit" id="submit" class="button button-primary" value="Add New" />
</form>
<br />
<table class="widefat">
<thead>
    <tr>
        <th>Edit</th>
        <th>Title</th>
        <th>Type</th>
        <th>Value</th>
        <th>Shortcode</th>
        <th>Template Function</th>
        <th>Date Updated</th>
        <th>Copy</th>
        <th>Delete</th>
    </tr>
</thead>
<tfoot>
    <tr>
    <th>Edit</th>
    <th>Title</th>
    <th>Type</th>
    <th>Value</th>
    <th>Shortcode</th>
    <th>Template Function</th>
    <th>Date Updated</th>
    <th>Copy</th>
    <th>Delete</th>
    </tr>
</tfoot>
<tbody>
<?php
if(count($forms)>0)
{
  foreach($forms as $form)
  {
    $form_type=($form->payment_type=='0')?"Fixed":"Custom Input";
?>
   <tr>
     <td>
      <form method="post" action="">
        <input type="hidden" name="action" value="edit_form" />
        <input type="hidden" name="form_id" value="<?php echo $form->id;?>" />
        <input type="submit" name="submit" id="submit" class="button button-secondary" value="Edit" />
      </form>
     </td>
     <td><strong><?php echo $form->title;?></strong></td>
     <td><?php echo $form_type;?></td>
     <td><?php echo $form->payment_value;?></td>
     <td>[sp_spl_display_form id=<?php echo $form->id;?>]</td>
     <td>if( function_exists( 'sp_spl_display_form' ) ){ sp_spl_display_form( <?php echo $form->id;?> ); }</td>
     <td><?php echo date("F d, Y H:i",$form->mdate);?></td>
    <td>
    <form method="post" action="" onSubmit="return confirm('Copy this Payment Form?')">
      <input type="hidden" name="action" value="copy_form" />
      <input type="hidden" name="form_id" value="<?php echo $form->id;?>" />
      <input type="submit" name="submit" id="submit" class="button button-secondary" value="Copy" />
     </form>
    </td>
    <td>
     <form method="post" action="" onSubmit="return confirm('Are you sure you want to delete this Payment Form?')">
      <input type="hidden" name="action" value="delete_form" />
      <input type="hidden" name="form_id" value="<?php echo $form->id;?>" />
      <input type="submit" name="submit" id="submit" class="button button-secondary" value="Delete" />
     </form>
    </td>
   </tr>
<?php
  }
}
else
{
  ?>
   <tr>
     <td colspan="9">No records</td>
   </tr>
  <?php
}
?>
</tbody>
</table>
</div>
<?php
}
}
function sp_spl_check_string_length($string,$length=255)
{
  $string=(string)$string;
  if($string!="")
  {
    $length=intval($length);
    if($length>0)
    {
      if(strlen($string)>$length)
        $string=substr($string,0,255);
      return $string;
    }
  }
  return $string;
}
?>