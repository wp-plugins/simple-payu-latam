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
function sp_spl_register_shortcodes(){
   add_shortcode('sp_spl_display_form', 'sp_spl_display_form');
}
function sp_spl_display_form($atts){
  global $wpdb;
  
  $table_name = $wpdb->prefix . "simplepayulatam";
  $html='';
  $id=0;
  $output_type=0;
  if(is_array($atts))
  {
    extract(shortcode_atts(array(
      'id' => 0,
    ), $atts));
    $output_type=0;
  }
  else
  {
    $output_type=1;
    $id=$atts;
  }

  $id=intval($id);
  
  if($id>0)
  {
    $sql="select * from $table_name where id='".$id."'";
    $forms = $wpdb->get_results($sql);
    if(isset($forms[0]))
    {
      $form=$forms[0];
      //skip if other instance and we redirect to SagePay
      if(isset($_REQUEST['sp_spl_action'])&&$_REQUEST['sp_spl_action']=='pay')
      {
        if(isset($_REQUEST['working_plugin'])&&$_REQUEST['working_plugin']!=$form->id)
        {
          return;
        }
      }
      $action=isset($_REQUEST['sp_spl_action'])?$_REQUEST['sp_spl_action']:"";
      if($action=='')
      {
        wp_enqueue_script( 'jquery' );
        wp_enqueue_style( 'sp_spl_display_css', SP_SPL_URL .'/css/jquery.remodal.css' );
        wp_enqueue_style( 'sp_spl_display_css2', SP_SPL_URL .'/css/sp_spl.css' );
        wp_enqueue_script( 'sp_spl_display_js', SP_SPL_URL . '/js/jquery.remodal.js');
        wp_enqueue_script( 'sp_spl_display_js2', SP_SPL_URL . '/js/sp_spl.js');
        $html=sp_spl_payment_form($form);
      }
      else if($action=='pay')
      {
        sp_spl_do_payment($form);
      }
    }
  }
  
  if($output_type==1)
  {
    echo $html;
  }
  else
  {
    return $html;
  }
}
add_action( 'init', 'sp_spl_register_shortcodes');

function sp_spl_payment_form($form)
{
  $html='';
  
  $mode=$form->mode;
  $success_url=$form->success_url;
  $payment=$form->payment_value;
  $payment_type=$form->payment_type;
  
  $sp_spl_payulatam_user = (get_option('sp_spl_payulatam_user') != '') ? get_option('sp_spl_payulatam_user') : '';
  $sp_spl_payulatam_password = (get_option('sp_spl_payulatam_password') != '') ? get_option('sp_spl_payulatam_password') : '';
  
  $sp_spl_payulatam_user_missing = 'Please input your Id Comercio (merchant ID)';
  $sp_spl_payulatam_password_missing = 'Please input your PayU Api key';

  if($sp_spl_payulatam_user=='')
  {
    return '<span class="sp_spl_err">'.$sp_spl_payulatam_user_missing.'</span>';
  }
  else if($sp_spl_payulatam_password=='')
  {
    return '<span class="sp_spl_err">'.$sp_spl_payulatam_password_missing.'</span>';
  }
  
  $pp_id=uniqid('sp_');
  
  $country_codes_arr=array('AF'=>'Afghanistan', 'AL'=>'Albania', 'DZ'=>'Algeria', 'AS'=>'American Samoa', 'AD'=>'Andorra', 'AO'=>'Angola', 'AI'=>'Anguilla', 'AQ'=>'Antarctica', 'AG'=>'Antigua and Barbuda', 'AR'=>'Argentina', 'AM'=>'Armenia', 'AW'=>'Aruba', 'AU'=>'Australia', 'AT'=>'Austria', 'AZ'=>'Azerbaijan', 'BS'=>'Bahamas', 'BH'=>'Bahrain', 'BD'=>'Bangladesh', 'BB'=>'Barbados', 'BY'=>'Belarus', 'BE'=>'Belgium', 'BZ'=>'Belize', 'BJ'=>'Benin', 'BM'=>'Bermuda', 'BT'=>'Bhutan', 'BO'=>'Bolivia', 'BA'=>'Bosnia and Herzegowina', 'BW'=>'Botswana', 'BV'=>'Bouvet Island', 'BR'=>'Brazil', 'IO'=>'British Indian Ocean Territory', 'BN'=>'Brunei Darussalam', 'BG'=>'Bulgaria', 'BF'=>'Burkina Faso', 'BI'=>'Burundi', 'KH'=>'Cambodia', 'CM'=>'Cameroon', 'CA'=>'Canada', 'XC'=>'Canary Islands', 'CV'=>'Cape Verde', 'KY'=>'Cayman Islands', 'CF'=>'Central African Republic', 'TD'=>'Chad', 'CL'=>'Chile', 'CN'=>'China', 'CX'=>'Christmas Island', 'CC'=>'Cocos (Keeling) Islands', 'CO'=>'Colombia', 'KM'=>'Comoros', 'CG'=>'Congo', 'CK'=>'Cook Islands', 'CR'=>'Costa Rica', 'CI'=>'Cote D\'Ivoire', 'HR'=>'Croatia', 'CU'=>'Cuba', 'CY'=>'Cyprus', 'CZ'=>'Czech Republic', 'DK'=>'Denmark', 'DJ'=>'Djibouti', 'DM'=>'Dominica', 'DO'=>'Dominican Republic', 'TP'=>'East Timor', 'XE'=>'East Timor', 'EC'=>'Ecuador', 'EG'=>'Egypt', 'SV'=>'El Salvador', 'GQ'=>'Equatorial Guinea', 'ER'=>'Eritrea', 'EE'=>'Estonia', 'ET'=>'Ethiopia', 'FK'=>'Falkland Islands (Malvinas)', 'FO'=>'Faroe Islands', 'FJ'=>'Fiji', 'FI'=>'Finland', 'FR'=>'France', 'FX'=>'France, Metropolitan', 'GF'=>'French Guiana', 'PF'=>'French Polynesia', 'TF'=>'French Southern Territories', 'GA'=>'Gabon', 'GM'=>'Gambia', 'GE'=>'Georgia', 'DE'=>'Germany', 'GH'=>'Ghana', 'GI'=>'Gibraltar', 'GR'=>'Greece', 'GL'=>'Greenland', 'GD'=>'Grenada', 'GP'=>'Guadeloupe', 'GU'=>'Guam', 'GT'=>'Guatemala', 'GN'=>'Guinea', 'GW'=>'Guinea-bissau', 'GY'=>'Guyana', 'HT'=>'Haiti', 'HM'=>'Heard and Mc Donald Islands', 'HN'=>'Honduras', 'HK'=>'Hong Kong', 'HU'=>'Hungary', 'IS'=>'Iceland', 'IN'=>'India', 'ID'=>'Indonesia', 'IR'=>'Iran (Islamic Republic of)', 'IQ'=>'Iraq', 'IE'=>'Ireland', 'IL'=>'Israel', 'IT'=>'Italy', 'JM'=>'Jamaica', 'JP'=>'Japan', 'XJ'=>'Jersey', 'JO'=>'Jordan', 'KZ'=>'Kazakhstan', 'KE'=>'Kenya', 'KI'=>'Kiribati', 'KP'=>'Korea, Democratic People\'s Republic of', 'KR'=>'Korea, Republic of', 'KW'=>'Kuwait', 'KG'=>'Kyrgyzstan', 'LA'=>'Lao People\'s Democratic Republic', 'LV'=>'Latvia', 'LB'=>'Lebanon', 'LS'=>'Lesotho', 'LR'=>'Liberia', 'LY'=>'Libyan Arab Jamahiriya', 'LI'=>'Liechtenstein', 'LT'=>'Lithuania', 'LU'=>'Luxembourg', 'MO'=>'Macau', 'MK'=>'Macedonia, The Former Yugoslav Republic of', 'MG'=>'Madagascar', 'MW'=>'Malawi', 'MY'=>'Malaysia', 'MV'=>'Maldives', 'ML'=>'Mali', 'MT'=>'Malta', 'MH'=>'Marshall Islands', 'MQ'=>'Martinique', 'MR'=>'Mauritania', 'MU'=>'Mauritius', 'YT'=>'Mayotte', 'MX'=>'Mexico', 'FM'=>'Micronesia, Federated States of', 'MD'=>'Moldova, Republic of', 'MC'=>'Monaco', 'MN'=>'Mongolia', 'ME'=>'Montenegro', 'MS'=>'Montserrat', 'MA'=>'Morocco', 'MZ'=>'Mozambique', 'MM'=>'Myanmar', 'NA'=>'Namibia', 'NR'=>'Nauru', 'NP'=>'Nepal', 'NL'=>'Netherlands', 'AN'=>'Netherlands Antilles', 'NC'=>'New Caledonia', 'NZ'=>'New Zealand', 'NI'=>'Nicaragua', 'NE'=>'Niger', 'NG'=>'Nigeria', 'NU'=>'Niue', 'NF'=>'Norfolk Island', 'MP'=>'Northern Mariana Islands', 'NO'=>'Norway', 'OM'=>'Oman', 'PK'=>'Pakistan', 'PW'=>'Palau', 'PA'=>'Panama', 'PG'=>'Papua New Guinea', 'PY'=>'Paraguay', 'PE'=>'Peru', 'PH'=>'Philippines', 'PN'=>'Pitcairn', 'PL'=>'Poland', 'PT'=>'Portugal', 'PR'=>'Puerto Rico', 'QA'=>'Qatar', 'RE'=>'Reunion', 'RO'=>'Romania', 'RU'=>'Russian Federation', 'RW'=>'Rwanda', 'KN'=>'Saint Kitts and Nevis', 'LC'=>'Saint Lucia', 'VC'=>'Saint Vincent and the Grenadines', 'WS'=>'Samoa', 'SM'=>'San Marino', 'ST'=>'Sao Tome and Principe', 'SA'=>'Saudi Arabia', 'SN'=>'Senegal', 'RS'=>'Serbia', 'SC'=>'Seychelles', 'SL'=>'Sierra Leone', 'SG'=>'Singapore', 'SK'=>'Slovakia (Slovak Republic)', 'SI'=>'Slovenia', 'SB'=>'Solomon Islands', 'SO'=>'Somalia', 'ZA'=>'South Africa', 'GS'=>'South Georgia and the South Sandwich Islands', 'ES'=>'Spain', 'LK'=>'Sri Lanka', 'XB'=>'St. Barthelemy', 'XU'=>'St. Eustatius', 'SH'=>'St. Helena', 'PM'=>'St. Pierre and Miquelon', 'SD'=>'Sudan', 'SR'=>'Suriname', 'SJ'=>'Svalbard and Jan Mayen Islands', 'SZ'=>'Swaziland', 'SE'=>'Sweden', 'CH'=>'Switzerland', 'SY'=>'Syrian Arab Republic', 'TW'=>'Taiwan', 'TJ'=>'Tajikistan', 'TZ'=>'Tanzania, United Republic of', 'TH'=>'Thailand', 'DC'=>'The Democratic Republic of Congo', 'TG'=>'Togo', 'TK'=>'Tokelau', 'TO'=>'Tonga', 'TT'=>'Trinidad and Tobago', 'TN'=>'Tunisia', 'TR'=>'Turkey', 'TM'=>'Turkmenistan', 'TC'=>'Turks and Caicos Islands', 'TV'=>'Tuvalu', 'UG'=>'Uganda', 'UA'=>'Ukraine', 'AE'=>'United Arab Emirates', 'GB'=>'United Kingdom', 'US'=>'United States', 'UM'=>'United States Minor Outlying Islands', 'UY'=>'Uruguay', 'UZ'=>'Uzbekistan', 'VU'=>'Vanuatu', 'VA'=>'Vatican City State (Holy See)', 'VE'=>'Venezuela', 'VN'=>'Viet Nam', 'VG'=>'Virgin Islands (British)', 'VI'=>'Virgin Islands (U.S.)', 'WF'=>'Wallis and Futuna Islands', 'EH'=>'Western Sahara', 'YE'=>'Yemen', 'ZM'=>'Zambia', 'ZW'=>'Zimbabwe');
  $us_states_arr=array('Please Select'=>'','Alabama'=>'AL', 'Alaska'=>'AK', 'Arizona'=>'AZ', 'Arkansas'=>'AR', 'California'=>'CA', 'Colorado'=>'CO', 'Connecticut'=>'CT', 'Delaware'=>'DE', 'District Of Columbia'=>'DC', 'Florida'=>'FL', 'Georgia'=>'GA', 'Hawaii'=>'HI', 'Idaho'=>'ID', 'Illinois'=>'IL', 'Indiana'=>'IN', 'Iowa'=>'IA', 'Kansas'=>'KS', 'Kentucky'=>'KY', 'Louisiana'=>'LA', 'Maine'=>'ME', 'Maryland'=>'MD', 'Massachusetts'=>'MA', 'Michigan'=>'MI', 'Minnesota'=>'MN', 'Mississippi'=>'MS', 'Missouri'=>'MO', 'Montana'=>'MT', 'Nebraska'=>'NE', 'Nevada'=>'NV', 'New Hampshire'=>'NH', 'New Jersey'=>'NJ', 'New Mexico'=>'NM', 'New York'=>'NY', 'North Carolina'=>'NC', 'North Dakota'=>'ND', 'Ohio'=>'OH', 'Oklahoma'=>'OK', 'Oregon'=>'OR', 'Pennsylvania'=>'PA', 'Rhode Island'=>'RI', 'South Carolina'=>'SC', 'South Dakota'=>'SD', 'Tennessee'=>'TN', 'Texas'=>'TX', 'Utah'=>'UT', 'Vermont'=>'VT', 'Virginia'=>'VA', 'Washington'=>'WA', 'West Virginia'=>'WV', 'Wisconsin'=>'WI', 'Wyoming'=>'WY');
  $default_country=$form->default_country;
  $show_state=' style="display:none;"';
  if($default_country=='US')
  {
    $show_state=' style="display:none;"';
  }
  
  $min_payment=$form->min_payment;
  $payment_type=$form->payment_type;
  $show_tel=$form->show_tel;
  $custom1=trim($form->custom1);
  $custom2=trim($form->custom2);
  $custom3=trim($form->custom3);
  $custom_r1=trim($form->custom_r1);
  $custom_r2=trim($form->custom_r2);
  $custom_r3=trim($form->custom_r3);
  $sp_spl_validation="
  function validatePayULATAM".$pp_id."()
  {
    var fname=document.getElementById('spsplBillingFirstnames".$pp_id."');
    var lname=document.getElementById('spsplBillingSurname".$pp_id."');
    var address=document.getElementById('spsplBillingAddress1".$pp_id."');
    var city=document.getElementById('spsplBillingCity".$pp_id."');
    var postcode=document.getElementById('spsplBillingPostCode".$pp_id."');
    var email=document.getElementById('spsplCustomerEMail".$pp_id."');
    var country=document.getElementById('spsplBillingCountry".$pp_id."');
    var state=document.getElementById('us_state".$pp_id."');
    ";
    if($show_tel==1)
    {
      $sp_spl_validation.="
      var phone=document.getElementById('spsplBillingPhone".$pp_id."');
      ";
    }
    if($custom1!="" && $custom_r1==1)
    {
      $sp_spl_validation.="
      var custom1=document.getElementById('spsplCustom1".$pp_id."');
      ";
    }
    if($custom2!="" && $custom_r2==1)
    {
      $sp_spl_validation.="
      var custom2=document.getElementById('spsplCustom2".$pp_id."');
      ";
    }
    if($custom3!="" && $custom_r3==1)
    {
      $sp_spl_validation.="
      var custom3=document.getElementById('spsplCustom3".$pp_id."');
      ";
    }
    if($payment_type==1)
    {
      $sp_spl_validation.="
    var amount=document.getElementById('payment_amount".$pp_id."');
    var min_amount=parseFloat(".$min_payment.");
      ";
    }
    if($payment_type==1)
    {
    $sp_spl_validation.="
      var the_amount=parseFloat(amount.value)+0;
      if(isNaN(the_amount))
      {
        alert('Please enter the Payment Value');
        amount.focus();
        return false;
      }
      else if(the_amount<min_amount)
      {
        alert('The entered value is too small');
        amount.focus();
        return false;
      }
      ";
    }
    $sp_spl_validation.="
    if(fname.value=='')
    {
      alert('Please enter your First Name');
      fname.focus();
      return false;
    }
    if(lname.value=='')
    {
      alert('Please enter your Surname');
      lname.focus();
      return false;
    }
    if(address.value=='')
    {
      alert('Please enter your Address');
      address.focus();
      return false;
    }
    if(city.value=='')
    {
      alert('Please enter your City');
      city.focus();
      return false;
    }
    if(postcode.value=='')
    {
      alert('Please enter your Postcode');
      postcode.focus();
      return false;
    }
    if(country.value=='US' && state.value=='')
    {
      alert('Please select your State');
      state.focus();
      return false;
    }
    if(email.value=='')
    {
      alert('Please enter your E-mail');
      email.focus();
      return false;
    }
    if(!validateEmail".$pp_id."(email.value))
    {
      alert('Please enter a valid E-mail address');
      email.focus();
      return false;
    }
    ";
    if($show_tel==1)
    {
      $sp_spl_validation.="
      if(phone.value=='')
      {
        alert('Please enter your Phone Nr');
        phone.focus();
        return false;
      }
      ";
    }
    if($custom1!="" && $custom_r1==1)
    {
      $sp_spl_validation.="
      if(custom1.value=='')
      {
        alert('Please enter ".$custom1."');
        custom1.focus();
        return false;
      }
      ";
    }
    if($custom2!="" && $custom_r2==1)
    {
      $sp_spl_validation.="
      if(custom2.value=='')
      {
        alert('Please enter ".$custom2."');
        custom2.focus();
        return false;
      }
      ";
    }
    if($custom3!="" && $custom_r3==1)
    {
      $sp_spl_validation.="
      if(custom3.value=='')
      {
        alert('Please enter ".$custom3."');
        custom3.focus();
        return false;
      }
      ";
    }
    $sp_spl_validation.="
    
    return true;
  }
  function validateEmail".$pp_id."(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
  }
  function checkUsStates".$pp_id."(obj)
  {
    if(obj.value=='US')
    {
      document.getElementById('us_state_row".$pp_id."').style.display='none';
    }
    else
    {
      document.getElementById('us_state_row".$pp_id."').style.display='none';
    }
  }
  ";
  $payment_description=$form->payment_description;
  $button_text=$form->payment_button_text;
  $popup_description=$form->popup_text;
  $invoice_label=$form->invoice_label;
  $currency=$form->currency;
  $amount_text=$form->input_value_text;
  $popup_button_text=$form->popup_btn_text;
  $show_invoice=$form->invoice;
  
  $sp_spl_popup_content='
  <div id="sp_spl_popup_content'.$pp_id.'" class="sp_spl_popup_content">
    <div class="sp_spl_popup_head">
      '.$popup_description.'
    </div>
    <div class="sp_spl_popup_content">
      <form action="" method="POST" class="PayULATAMForm" name="PayULATAMForm'.$pp_id.'">
        <input type="hidden" name="working_plugin" value="'.$form->id.'" />
        <input type="hidden" name="sp_spl_action" value="pay" />
        <table width="100%" class="sp_spl_popup_tbl">
        <tbody>
        ';
        
        if($show_invoice==1)
        {
        $sp_spl_popup_content.='

          <tr class="sp_spl_popup_row">
            <td>
              <label for="invoice'.$pp_id.'" class="sp_spl_popup_lbl">'.$invoice_label.'</label>
            </td>
            <td>
              <input type="text" class="sp_spl_popup_invoice_input" name="invoice" id="invoice'.$pp_id.'" value="" />
            </td>
          </tr>
          ';
        }
        
        if($payment_type==1)
        {
          $currency_str='';
          if($currency=='USD')
          {
            $currency_str='$';
          }
          else if($currency=='EUR')
          {
            $currency_str='&euro;';
          }
          else
          {
            $currency_str=$currency;
          }
          $sp_spl_popup_content.='
          <tr class="sp_spl_popup_row">
            <td>
              <label for="payment_amount'.$pp_id.'" class="sp_spl_popup_lbl">'.$amount_text.'</label>
            </td>
            <td>
              <input type="text" class="sp_spl_popup_payment_input" name="payment_amount" id="payment_amount'.$pp_id.'" value="'.$min_payment.'" />
              <span class="sp_spl_popup_curr_sym">'.$currency_str.'</span>
            </td>
          </tr>
          ';
        }
        $sp_spl_popup_content.='
          <tr class="sp_spl_popup_row">
            <td>
              <label for="spsplBillingFirstnames'.$pp_id.'" class="sp_spl_popup_lbl">First Name</label>
            </td>
            <td>
              <input type="text" class="sp_spl_popup_input" name="BillingFirstnames" id="spsplBillingFirstnames'.$pp_id.'" value="" />
            </td>
          </tr>
          <tr class="sp_spl_popup_row">
            <td>
              <label for="spsplBillingSurname'.$pp_id.'" class="sp_spl_popup_lbl">Surname</label>
            </td>
            <td>
              <input type="text" class="sp_spl_popup_input" name="BillingSurname" id="spsplBillingSurname'.$pp_id.'" value="" />
            </td>
          </tr>
          <tr class="sp_spl_popup_row">
            <td>
              <label for="spsplBillingAddress1'.$pp_id.'" class="sp_spl_popup_lbl">Address</label>
            </td>
            <td>
              <input type="text" class="sp_spl_popup_input" name="BillingAddress1" id="spsplBillingAddress1'.$pp_id.'" value="" />
            </td>
          </tr>
          <tr class="sp_spl_popup_row">
            <td>
              <label for="spsplBillingCity'.$pp_id.'" class="sp_spl_popup_lbl">City</label>
            </td>
            <td>
              <input type="text" class="sp_spl_popup_input" name="BillingCity" id="spsplBillingCity'.$pp_id.'" value="" />
            </td>
          </tr>
          <tr class="sp_spl_popup_row">
            <td>
              <label for="spsplBillingPostCode'.$pp_id.'" class="sp_spl_popup_lbl">Postcode</label>
            </td>
            <td>
              <input type="text" class="sp_spl_popup_input" name="BillingPostCode" id="spsplBillingPostCode'.$pp_id.'" value="" />
            </td>
          </tr>
          <tr class="sp_spl_popup_row">
            <td>
              <label for="spsplBillingCountry'.$pp_id.'" class="sp_spl_popup_lbl">Country</label>
            </td>
            <td>
              <select id="spsplBillingCountry'.$pp_id.'" name="BillingCountry" class="sp_spl_popup_input_co" onChange="javascript:checkUsStates'.$pp_id.'(this);">
                ';
            foreach($country_codes_arr as $code=>$name)
            {
              $selected_str="";
              if($code==$default_country)
              {
                $selected_str=' selected="selected"';
              }
              $sp_spl_popup_content.='<option'.$selected_str.' value="'.$code.'">'.$name.'</option>';
            }
                $sp_spl_popup_content.='
              </select>
            </td>
          </tr>
          <tr class="sp_spl_popup_row"'.$show_state.' id="us_state_row'.$pp_id.'">
            <td>
              <label for="us_state'.$pp_id.'" class="sp_spl_popup_lbl">State</label>
            </td>
            <td>
              <select id="us_state'.$pp_id.'" name="us_state" class="sp_spl_popup_input_co">
              ';
                foreach($us_states_arr as $name => $code)
                {
                  $sp_spl_popup_content.='<option value="'.$code.'">'.$name.'</option>';
                }
              $sp_spl_popup_content.='
              </select>
              </td>
            </tr>
          </tr>
          <tr class="sp_spl_popup_row">
            <td>
              <label for="spsplCustomerEMail'.$pp_id.'" class="sp_spl_popup_lbl">E-mail</label>
            </td>
            <td>
              <input type="text" class="sp_spl_popup_input" name="CustomerEMail" id="spsplCustomerEMail'.$pp_id.'" value="" />
            </td>
          </tr>
          ';
          if($show_tel==1)
          {
            $sp_spl_popup_content.='
            <tr class="sp_spl_popup_row">
              <td>
                <label for="spsplBillingPhone'.$pp_id.'" class="sp_spl_popup_lbl">Phone Nr.</label>
              </td>
              <td>
                <input type="text" class="sp_spl_popup_input" name="BillingPhone" id="spsplBillingPhone'.$pp_id.'" value="" />
              </td>
            </tr>
            ';
          }
          if($custom1!="")
          {
            $sp_spl_popup_content.='
            <tr class="sp_spl_popup_row">
              <td>
                <label for="spsplCustom1'.$pp_id.'" class="sp_spl_popup_lbl">'.$custom1.'</label>
              </td>
              <td>
                <input type="text" class="sp_spl_popup_input" name="custom1" id="spsplCustom1'.$pp_id.'" value="" />
              </td>
            </tr>
            ';
          }
          if($custom2!="")
          {
            $sp_spl_popup_content.='
            <tr class="sp_spl_popup_row">
              <td>
                <label for="spsplCustom2'.$pp_id.'" class="sp_spl_popup_lbl">'.$custom2.'</label>
              </td>
              <td>
                <input type="text" class="sp_spl_popup_input" name="custom2" id="spsplCustom2'.$pp_id.'" value="" />
              </td>
            </tr>
            ';
          }
          if($custom3!="")
          {
            $sp_spl_popup_content.='
            <tr class="sp_spl_popup_row">
              <td>
                <label for="spsplCustom3'.$pp_id.'" class="sp_spl_popup_lbl">'.$custom3.'</label>
              </td>
              <td>
                <input type="text" class="sp_spl_popup_input" name="custom3" id="spsplCustom3'.$pp_id.'" value="" />
              </td>
            </tr>
            ';
          }
          $sp_spl_popup_content.='
          <tr class="sp_spl_popup_submit_row">
            <td colspan="2">
              <a class="remodal-cancel" href="javascript:void(0);">Cancel</a>
              <a onClick="javascript:if(validatePayULATAM'.$pp_id.'()){document.PayULATAMForm'.$pp_id.'.submit();}" class="remodal-confirm sp_spl_submit_pay_submit" href="javascript:void(0);">'.$popup_button_text.'</a>
            </td>
          </tr>
          </tbody>
        </table>
      </form>
    </div>
  </div>
  ';
  $html='
  <script type="text/javascript">
  <!--
  var sp_spl_inst'.$pp_id.' = null;
  jQuery(document).ready(function(){
    sp_spl_inst'.$pp_id.' = jQuery("[data-remodal-id=sp_spl_open'.$pp_id.']").remodal();
  });
  window.remodalGlobals = {
     namespace: "remodal",
     defaults: {
       hashTracking: false,
       closeOnConfirm: false,
       closeOnCancel: true,
       closeOnEscape: false,
       closeOnAnyClick: false
    }
  };
  '.$sp_spl_validation.'
  //-->
  </script>

  <div class="sp_spl_wrp">
    <div class="sp_spl_description">
      '.$payment_description.'
    </div>
    <input type="button" onClick="javascript:sp_spl_inst'.$pp_id.'.open();" class="sp_spl_submit_pay" value="'.$button_text.'" />
  </div>
  
  <div class="remodal sp_spl_box" data-remodal-id="sp_spl_open'.$pp_id.'">
    <div class="sp_spl_window">
      '.$sp_spl_popup_content.'
    </div>
  </div>
  
  ';

  return $html;
}
function sp_spl_do_payment($form)
{
  global $wpdb;
  require_once(SP_SPL_DIR.DIRECTORY_SEPARATOR."includes".DIRECTORY_SEPARATOR."simplepayulatam_helper.php");
  $sp_spl_payulatam_user = (get_option('sp_spl_payulatam_user') != '') ? get_option('sp_spl_payulatam_user') : '';
  $sp_spl_payulatam_password = (get_option('sp_spl_payulatam_password') != '') ? get_option('sp_spl_payulatam_password') : '';
  $sp_spl_payulatam_accountid = (get_option('sp_spl_payulatam_accountid') != '') ? get_option('sp_spl_payulatam_accountid') : '';
  $sp_spl_payulatam_language = (get_option('sp_spl_payulatam_language') != '') ? get_option('sp_spl_payulatam_language') : 'EN';
  
  $error_check=0;
  $payment_amount=isset($_POST['payment_amount'])?sanitize_text_field($_POST['payment_amount']):0;
  $BillingFirstnames=isset($_POST['BillingFirstnames'])?sanitize_text_field($_POST['BillingFirstnames']):"";
  $BillingSurname=isset($_POST['BillingSurname'])?sanitize_text_field($_POST['BillingSurname']):"";
  $BillingAddress1=isset($_POST['BillingAddress1'])?sanitize_text_field($_POST['BillingAddress1']):"";
  $BillingCity=isset($_POST['BillingCity'])?sanitize_text_field($_POST['BillingCity']):"";
  $BillingPostCode=isset($_POST['BillingPostCode'])?sanitize_text_field($_POST['BillingPostCode']):"";
  $BillingCountry=isset($_POST['BillingCountry'])?sanitize_text_field($_POST['BillingCountry']):"";
  $BillingState=isset($_POST['us_state'])?sanitize_text_field($_POST['us_state']):"";
  $CustomerEMail=isset($_POST['CustomerEMail'])?sanitize_text_field($_POST['CustomerEMail']):"";
  $BillingPhone=isset($_POST['BillingPhone'])?sanitize_text_field($_POST['BillingPhone']):"";
  $invoice=isset($_POST['invoice'])?sanitize_text_field($_POST['invoice']):"";
  $custom1=isset($_POST['custom1'])?sanitize_text_field($_POST['custom1']):"";
  $custom2=isset($_POST['custom2'])?sanitize_text_field($_POST['custom2']):"";
  $custom3=isset($_POST['custom3'])?sanitize_text_field($_POST['custom3']):"";
  
  $min_payment=$form->min_payment;
  $payment_type=$form->payment_type;
  $payment_description=$form->payment_description;
  $button_text=$form->payment_button_text;
  $popup_description=$form->popup_text;
  $invoice_label=$form->invoice_label;
  $currency=$form->currency;
  $amount_text=$form->input_value_text;
  $default_country=$form->default_country;
  $popup_button_text=$form->popup_btn_text;
  $show_invoice=$form->invoice;
  $success_url=$form->success_url;
  $mode=$form->mode;
  $product_name=$form->product_name;
  $payment=$form->payment_value;
  
  if($payment_type==1)
  {
    $payment=$payment_amount+0;
    if($payment==0 || $payment<$min_payment)
    {
      $error_check=1;
    }
  }
  if($payment==0)
  {
    $error_check=1;
  }
  if($BillingFirstnames=='')
  {
    $error_check=1;
  }
  if($BillingSurname=='')
  {
    $error_check=1;
  }
  if($BillingAddress1=='')
  {
    $error_check=1;
  }
  if($BillingCity=='')
  {
    $error_check=1;
  }
  if($BillingPostCode=='')
  {
    $error_check=1;
  }
  if($BillingCountry=='')
  {
    $error_check=1;
  }
  if($BillingCountry=='US' && $BillingState=='')
  {
    $error_check=1;
  }
  if($error_check)
  {
    //error here
    ?>
    <div class="sp_spl_submit_error">ERROR! Please contact website administrator!</div>
    <?php
  }
  else
  {
    //all good submit the form
    $strBillingFirstnames=$BillingFirstnames;
    $strBillingSurname=$BillingSurname;
    $strBillingAddress1=$BillingAddress1;
    $strBillingCity=$BillingCity;
    $strBillingPostCode=$BillingPostCode;
    $strBillingCountry=$BillingCountry;
    
    $strDeliveryFirstnames=$strBillingFirstnames;
    $strDeliverySurname=$strBillingSurname;
    $strDeliveryAddress1=$strBillingAddress1;
    $strDeliveryCity=$strBillingCity;
    $strDeliveryPostCode=$strBillingPostCode;
    $strDeliveryCountry=$strBillingCountry;
    $payment+=0;
    //$payment=number_format($payment,2);
    $helper=new SP_SPL_Helper();
    
    $strVendorTxCode='spspl-'.$helper->generate_random_letters(4);
    
    //add trans id in urls
    if($success_url[strlen($success_url)-1]=='/')
    {
      $success_url.='?trans_id='.$strVendorTxCode;
    }
    else
    {
      $query = parse_url($success_url, PHP_URL_QUERY);
      if( $query ) {
          $success_url .= '&trans_id='.$strVendorTxCode;
      }
      else {
          $success_url .= '?trans_id='.$strVendorTxCode;
      }
    }

    //save in db
    $country_codes_arr=array('AF'=>'Afghanistan', 'AL'=>'Albania', 'DZ'=>'Algeria', 'AS'=>'American Samoa', 'AD'=>'Andorra', 'AO'=>'Angola', 'AI'=>'Anguilla', 'AQ'=>'Antarctica', 'AG'=>'Antigua and Barbuda', 'AR'=>'Argentina', 'AM'=>'Armenia', 'AW'=>'Aruba', 'AU'=>'Australia', 'AT'=>'Austria', 'AZ'=>'Azerbaijan', 'BS'=>'Bahamas', 'BH'=>'Bahrain', 'BD'=>'Bangladesh', 'BB'=>'Barbados', 'BY'=>'Belarus', 'BE'=>'Belgium', 'BZ'=>'Belize', 'BJ'=>'Benin', 'BM'=>'Bermuda', 'BT'=>'Bhutan', 'BO'=>'Bolivia', 'BA'=>'Bosnia and Herzegowina', 'BW'=>'Botswana', 'BV'=>'Bouvet Island', 'BR'=>'Brazil', 'IO'=>'British Indian Ocean Territory', 'BN'=>'Brunei Darussalam', 'BG'=>'Bulgaria', 'BF'=>'Burkina Faso', 'BI'=>'Burundi', 'KH'=>'Cambodia', 'CM'=>'Cameroon', 'CA'=>'Canada', 'XC'=>'Canary Islands', 'CV'=>'Cape Verde', 'KY'=>'Cayman Islands', 'CF'=>'Central African Republic', 'TD'=>'Chad', 'CL'=>'Chile', 'CN'=>'China', 'CX'=>'Christmas Island', 'CC'=>'Cocos (Keeling) Islands', 'CO'=>'Colombia', 'KM'=>'Comoros', 'CG'=>'Congo', 'CK'=>'Cook Islands', 'CR'=>'Costa Rica', 'CI'=>'Cote D\'Ivoire', 'HR'=>'Croatia', 'CU'=>'Cuba', 'CY'=>'Cyprus', 'CZ'=>'Czech Republic', 'DK'=>'Denmark', 'DJ'=>'Djibouti', 'DM'=>'Dominica', 'DO'=>'Dominican Republic', 'TP'=>'East Timor', 'XE'=>'East Timor', 'EC'=>'Ecuador', 'EG'=>'Egypt', 'SV'=>'El Salvador', 'GQ'=>'Equatorial Guinea', 'ER'=>'Eritrea', 'EE'=>'Estonia', 'ET'=>'Ethiopia', 'FK'=>'Falkland Islands (Malvinas)', 'FO'=>'Faroe Islands', 'FJ'=>'Fiji', 'FI'=>'Finland', 'FR'=>'France', 'FX'=>'France, Metropolitan', 'GF'=>'French Guiana', 'PF'=>'French Polynesia', 'TF'=>'French Southern Territories', 'GA'=>'Gabon', 'GM'=>'Gambia', 'GE'=>'Georgia', 'DE'=>'Germany', 'GH'=>'Ghana', 'GI'=>'Gibraltar', 'GR'=>'Greece', 'GL'=>'Greenland', 'GD'=>'Grenada', 'GP'=>'Guadeloupe', 'GU'=>'Guam', 'GT'=>'Guatemala', 'GN'=>'Guinea', 'GW'=>'Guinea-bissau', 'GY'=>'Guyana', 'HT'=>'Haiti', 'HM'=>'Heard and Mc Donald Islands', 'HN'=>'Honduras', 'HK'=>'Hong Kong', 'HU'=>'Hungary', 'IS'=>'Iceland', 'IN'=>'India', 'ID'=>'Indonesia', 'IR'=>'Iran (Islamic Republic of)', 'IQ'=>'Iraq', 'IE'=>'Ireland', 'IL'=>'Israel', 'IT'=>'Italy', 'JM'=>'Jamaica', 'JP'=>'Japan', 'XJ'=>'Jersey', 'JO'=>'Jordan', 'KZ'=>'Kazakhstan', 'KE'=>'Kenya', 'KI'=>'Kiribati', 'KP'=>'Korea, Democratic People\'s Republic of', 'KR'=>'Korea, Republic of', 'KW'=>'Kuwait', 'KG'=>'Kyrgyzstan', 'LA'=>'Lao People\'s Democratic Republic', 'LV'=>'Latvia', 'LB'=>'Lebanon', 'LS'=>'Lesotho', 'LR'=>'Liberia', 'LY'=>'Libyan Arab Jamahiriya', 'LI'=>'Liechtenstein', 'LT'=>'Lithuania', 'LU'=>'Luxembourg', 'MO'=>'Macau', 'MK'=>'Macedonia, The Former Yugoslav Republic of', 'MG'=>'Madagascar', 'MW'=>'Malawi', 'MY'=>'Malaysia', 'MV'=>'Maldives', 'ML'=>'Mali', 'MT'=>'Malta', 'MH'=>'Marshall Islands', 'MQ'=>'Martinique', 'MR'=>'Mauritania', 'MU'=>'Mauritius', 'YT'=>'Mayotte', 'MX'=>'Mexico', 'FM'=>'Micronesia, Federated States of', 'MD'=>'Moldova, Republic of', 'MC'=>'Monaco', 'MN'=>'Mongolia', 'ME'=>'Montenegro', 'MS'=>'Montserrat', 'MA'=>'Morocco', 'MZ'=>'Mozambique', 'MM'=>'Myanmar', 'NA'=>'Namibia', 'NR'=>'Nauru', 'NP'=>'Nepal', 'NL'=>'Netherlands', 'AN'=>'Netherlands Antilles', 'NC'=>'New Caledonia', 'NZ'=>'New Zealand', 'NI'=>'Nicaragua', 'NE'=>'Niger', 'NG'=>'Nigeria', 'NU'=>'Niue', 'NF'=>'Norfolk Island', 'MP'=>'Northern Mariana Islands', 'NO'=>'Norway', 'OM'=>'Oman', 'PK'=>'Pakistan', 'PW'=>'Palau', 'PA'=>'Panama', 'PG'=>'Papua New Guinea', 'PY'=>'Paraguay', 'PE'=>'Peru', 'PH'=>'Philippines', 'PN'=>'Pitcairn', 'PL'=>'Poland', 'PT'=>'Portugal', 'PR'=>'Puerto Rico', 'QA'=>'Qatar', 'RE'=>'Reunion', 'RO'=>'Romania', 'RU'=>'Russian Federation', 'RW'=>'Rwanda', 'KN'=>'Saint Kitts and Nevis', 'LC'=>'Saint Lucia', 'VC'=>'Saint Vincent and the Grenadines', 'WS'=>'Samoa', 'SM'=>'San Marino', 'ST'=>'Sao Tome and Principe', 'SA'=>'Saudi Arabia', 'SN'=>'Senegal', 'RS'=>'Serbia', 'SC'=>'Seychelles', 'SL'=>'Sierra Leone', 'SG'=>'Singapore', 'SK'=>'Slovakia (Slovak Republic)', 'SI'=>'Slovenia', 'SB'=>'Solomon Islands', 'SO'=>'Somalia', 'ZA'=>'South Africa', 'GS'=>'South Georgia and the South Sandwich Islands', 'ES'=>'Spain', 'LK'=>'Sri Lanka', 'XB'=>'St. Barthelemy', 'XU'=>'St. Eustatius', 'SH'=>'St. Helena', 'PM'=>'St. Pierre and Miquelon', 'SD'=>'Sudan', 'SR'=>'Suriname', 'SJ'=>'Svalbard and Jan Mayen Islands', 'SZ'=>'Swaziland', 'SE'=>'Sweden', 'CH'=>'Switzerland', 'SY'=>'Syrian Arab Republic', 'TW'=>'Taiwan', 'TJ'=>'Tajikistan', 'TZ'=>'Tanzania, United Republic of', 'TH'=>'Thailand', 'DC'=>'The Democratic Republic of Congo', 'TG'=>'Togo', 'TK'=>'Tokelau', 'TO'=>'Tonga', 'TT'=>'Trinidad and Tobago', 'TN'=>'Tunisia', 'TR'=>'Turkey', 'TM'=>'Turkmenistan', 'TC'=>'Turks and Caicos Islands', 'TV'=>'Tuvalu', 'UG'=>'Uganda', 'UA'=>'Ukraine', 'AE'=>'United Arab Emirates', 'GB'=>'United Kingdom', 'US'=>'United States', 'UM'=>'United States Minor Outlying Islands', 'UY'=>'Uruguay', 'UZ'=>'Uzbekistan', 'VU'=>'Vanuatu', 'VA'=>'Vatican City State (Holy See)', 'VE'=>'Venezuela', 'VN'=>'Viet Nam', 'VG'=>'Virgin Islands (British)', 'VI'=>'Virgin Islands (U.S.)', 'WF'=>'Wallis and Futuna Islands', 'EH'=>'Western Sahara', 'YE'=>'Yemen', 'ZM'=>'Zambia', 'ZW'=>'Zimbabwe');
    $product_name=sp_spl_check_string_length($product_name);
    $invoice=sp_spl_check_string_length($invoice);
    $payment=sp_spl_check_string_length($payment);
    $currency=sp_spl_check_string_length($currency);
    $strBillingFirstnames=sp_spl_check_string_length($strBillingFirstnames);
    $strBillingSurname=sp_spl_check_string_length($strBillingSurname);
    $strBillingAddress1=sp_spl_check_string_length($strBillingAddress1);
    $strBillingCity=sp_spl_check_string_length($strBillingCity);
    $strBillingPostCode=sp_spl_check_string_length($strBillingPostCode);
    $CustomerEMail=sp_spl_check_string_length($CustomerEMail);
    $BillingPhone=sp_spl_check_string_length($BillingPhone);
    $custom1=sp_spl_check_string_length($custom1);
    $custom2=sp_spl_check_string_length($custom2);
    $custom3=sp_spl_check_string_length($custom3);
    
    $wpdb->insert(
      $wpdb->prefix."simplepayulatam_trans",
      array(
      'form'=>$form->title,
      'product'=>$product_name,
      'invoice'=>$invoice,
      'payment'=>$payment,
      'currency'=>$currency,
      'fname'=>$strBillingFirstnames,
      'lname'=>$strBillingSurname,
      'address'=>$strBillingAddress1,
      'city'=>$strBillingCity,
      'postcode'=>$strBillingPostCode,
      'country'=>@$country_codes_arr[$strBillingCountry],
      'email'=>$CustomerEMail,
      'phone'=>$BillingPhone,
      'custom1'=>$custom1,
      'custom3'=>$custom3,
      'custom2'=>$custom2,
      'mdate'=>time()
      ),
      array(
      '%s','%s','%s','%d','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%d'
      )
    );
    
    $PaymentDescription=$product_name." - ".$invoice;

    $payment+=0;
    
    $myLiveUpdate = new sp_spl_LiveUpdatePayU($sp_spl_payulatam_password);

    $bill_total=$payment;
    $signature=md5("$sp_spl_payulatam_password~$sp_spl_payulatam_user~$strVendorTxCode~$bill_total~$currency");
    $post_variables = Array
    (
    "merchantId"=>$sp_spl_payulatam_user,
    "referenceCode"=>$strVendorTxCode,
    "description"=>$PaymentDescription,
    "amount"=>$bill_total,
    "tax"=>0,
    "taxReturnBase"=>0,
    "signature"=>$signature,
    "currency"=>$currency,
    "buyerEmail"=>$CustomerEMail,
    "payerFullName"=> $strBillingFirstnames . " " . $strBillingSurname,
    "billingAddress"=>$strBillingAddress1,
    "shippingAddress"=>$strBillingAddress1,
    "telephone"=>$BillingPhone,
    "billingCity"=>$strBillingCity,
    "shippingCity"=>$strBillingCity,
    "zipCode"=>$strBillingPostCode,
    "billingCountry"=>$strBillingCountry,
    "shippingCountry"=>$strBillingCountry,
    "buyerFullName"=> $strBillingFirstnames . " " . $strBillingSurname,
    "payerEmail"=>$CustomerEMail,
    "payerPhone"=>$BillingPhone,
    "lng"=>$sp_spl_payulatam_language
    );

    if($sp_spl_payulatam_accountid!="")
    {
      $post_variables["accountId"]=$sp_spl_payulatam_accountid;
    }
  	if($mode=='TEST')
	  {
	    $post_variables["test"]=1;
	  }
    
    if($success_url!="")
    {
      $post_variables["responseUrl"]=$success_url;
    }
    
    $pmb_button='Redirecting to payment page';
    
    $html = '<html><head><title>Redirection</title></head><body><div style="margin: auto; text-align: center;">';
		$html.= "\n".'<form name="sp_spl_payfrm" id="sp_spl_payfrm" action="https://gateway.payulatam.com/ppp-web-gateway/" method="post">';
	  foreach ($post_variables as $name => $value) {
			$html.= '
      <input type="hidden" name="' . $name . '" value="' . htmlspecialchars($value) . '" />';
		}
		$html.= '<input type="submit"  value="'.$popup_button_text.'" />';
		$html.= '</form></div>';
		
		$html.= ' <script type="text/javascript">';
		$html.= ' document.sp_spl_payfrm.submit();';
		$html.= ' </script></body></html>';
    
    ob_end_clean();
    
    echo $html;exit;

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