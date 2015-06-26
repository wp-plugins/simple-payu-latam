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
function sp_spl_records(){
global $wpdb;
$action=isset($_POST['action'])?$_POST['action']:"";
if($action=="")
{
$myListTable = new SP_SPL_List_Table();
$myListTable->prepare_items(); 
?>
<script type="text/javascript">
<!--
function openSPSPLRecord(id)
{
  if(id>0)
  {
    document.getElementById('spspl_record_id').value=id;
    document.spspl.submit();
  }
}
//-->
</script>
<form name="spspl" method="post" action="">
<input type="hidden" name="action" value="view_record" />
<input type="hidden" name="id" id="spspl_record_id" value="" />
</form>
<div class="wrap">
<div id="icon-users" class="icon32"></div>
<h2>Simple PayU LATAM Records</h2>
<?php 
$myListTable->display(); 
?>
</div>
<?php
}
if($action=="view_record")
{
  $id=isset($_POST['id'])?intval($_POST['id']):0;
  ?>
  <div class="wrap">
  <div id="icon-users" class="icon32"></div>
  <form method="post" action="">
    <input type="submit" name="submit" id="submit" class="button button-secondary" value="Back">
  </form>
  <?php
  if($id>0)
  {
    $sql="
    select * from ".$wpdb->prefix."simplepayulatam_trans where id='".$id."'
    ";
    $result=$wpdb->get_row($sql);
    if(isset($result->id))
    {
    ?>
    <style>
    .cstm td{
    padding: 0px;
    }
    </style>
    <table class="form-table cstm">
      <tr>
        <td><strong>Form</strong></td>
        <td><?php echo $result->form;?></td>
      </tr>
      <tr>
        <td><strong>Product</strong></td>
        <td><?php echo $result->product;?></td>
      </tr>
      <tr>
        <td><strong>Invoice</strong></td>
        <td><?php echo $result->invoice;?></td>
      </tr>
      <tr>
        <td><strong>Payment</strong></td>
        <td><?php echo $result->payment;?></td>
      </tr>
      <tr>
        <td><strong>Currency</strong></td>
        <td><?php echo $result->currency;?></td>
      </tr>
      <tr>
        <td><strong>First Name</strong></td>
        <td><?php echo $result->fname;?></td>
      </tr>
      <tr>
        <td><strong>Last Name</strong></td>
        <td><?php echo $result->lname;?></td>
      </tr>
      <tr>
        <td><strong>Address</strong></td>
        <td><?php echo $result->address;?></td>
      </tr>
      <tr>
        <td><strong>City</strong></td>
        <td><?php echo $result->city;?></td>
      </tr>
      <tr>
        <td><strong>Postcode</strong></td>
        <td><?php echo $result->postcode;?></td>
      </tr>
      <tr>
        <td><strong>Country</strong></td>
        <td><?php echo $result->country;?></td>
      </tr>
      <tr>
        <td><strong>Email</strong></td>
        <td><?php echo $result->email;?></td>
      </tr>
      <tr>
        <td><strong>Phone</strong></td>
        <td><?php echo $result->phone;?></td>
      </tr>
      <tr>
        <td><strong>Custom 1</strong></td>
        <td><?php echo $result->custom1;?></td>
      </tr>
      <tr>
        <td><strong>Custom 2</strong></td>
        <td><?php echo $result->custom2;?></td>
      </tr>
      <tr>
        <td><strong>Custom 3</strong></td>
        <td><?php echo $result->custom3;?></td>
      </tr>
      <tr>
        <td><strong>Date</strong></td>
        <td><?php echo date("d/m/y H:i",$result->mdate);?></td>
      </tr>
      
    </table>
    <?php
    }
  }
  ?>
  </div>
  <?php
}
}
?>
