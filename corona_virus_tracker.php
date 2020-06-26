<?php 
/**
*Plugin Name: Covid-19 Live Tracker
* Plugin URI: https://github.com/ianaleck/corona-wordpress-livetracker
*Author: Ian Aleck
* Author URI: https://github.com/ianaleck
*Version: 1.0.1
*Description: Corona Virus / Covid-19 Live Tracker plugin to get Live data for table and or map
**/
if (!defined('ABSPATH')) {
  exit;
}

function ianaleckcorona_function($atts){
  extract(shortcode_atts(array(
    'theme' => 'light',
    'area' => 'summary',
    'usstate' => '',
    'loop'  => 5,
    'type' => 'table',
    'title' => 'World Statistics'
  ),$atts));
  $id = time().rand (5, 50);
  $object = (object)[
    'theme' => $theme,
    'area' => $area,
    'usstate' => $usstate,
    'loop'  => $loop,
    'type' => $type,
    'title' => $title,
    'id' => $id
  ];
  if ($object->type=="map") {
    $object->area = "map";
  }
  add_action('wp_footer', function($arguments) use ($object) { 
    ?>
    <script>
    jQuery(function($) {
      $("#<?= esc_attr($object->id) ?>").coronaTracker({
        area:"<?= esc_attr($object->area) ?>",
        usstate:"<?= esc_attr($object->usstate) ?>",
        theme:"<?= esc_attr($object->theme) ?>",
        loop:<?= esc_attr((int)$object->loop) ?>,
        type:"<?= esc_attr($object->type) ?>",
        title:"<?= esc_attr($object->title) ?>"
      }).initialize();
      
    });
    </script>
    <?php
  }, 1, 5);
  return '<div id="'.esc_attr($id).'"></div>';
}
add_shortcode('ia_covid19','ianaleckcorona_function');

function ia_covid19_admin_menu_option(){
  add_menu_page('Covid-19 Live Tracker', 'Covid-19 Tracker', 'manage_options','ia_covid19_tracker','ia_covid19_page','',200);
}
add_action('admin_menu', 'ia_covid19_admin_menu_option');
function ia_covid_ln_reg_css_and_js()
{
  wp_enqueue_style('ianaleck_covid-19_css', plugins_url('inc/coronatracker.css',__FILE__ ) );
  wp_enqueue_style('ianaleck_covid-19_css', plugins_url('inc/jquery-jvectormap-2.0.5.css',__FILE__ ));
  wp_enqueue_script('ianaleck_covid-19_jvect', plugins_url('inc/jquery-jvectormap-2.0.5.min.js',__FILE__ ), array('jquery') );
  wp_enqueue_script('ianaleck_covid-19_jvect_mill', plugins_url('inc/jquery-jvectormap-world-mill-en.js',__FILE__ ), array('jquery') );
  wp_enqueue_script('ianaleck_covid-19_js', plugins_url('inc/jquery.coronatracker.js',__FILE__ ), array('jquery') );
}
add_action('wp_enqueue_scripts', 'ia_covid_ln_reg_css_and_js');
function ia_covid_ln_reg_css_and_jsadmin()
{
  wp_enqueue_style('ianaleck_covid-19_css', plugins_url('inc/style.css',__FILE__ ));
}
add_action('admin_enqueue_scripts', 'ia_covid_ln_reg_css_and_jsadmin');
function sample_admin_notice__success() {
  ?>
  <div class="notice notice-success is-dismissible">
    <p><?php _e( 'Done!', 'sample-text-domain' ); ?></p>
  </div>
  <?php
}
function ia_covid19_page(){
  $notice = "";
  $errors = 0;
  $error_messages = "";
  
  if (array_key_exists("ianaleckcorona_area",$_POST)) {
    //Lets Sanitize
    $type = sanitize_text_field($_POST['ianaleckcorona_type']);
    $loop = sanitize_text_field($_POST['ianaleckcorona_loop']);
    $theme = sanitize_text_field($_POST['ianaleckcorona_theme']);
    $area = sanitize_text_field($_POST['ianaleckcorona_area']);
    $usstate = sanitize_text_field($_POST['ianaleckcorona_usstate']);
    $title = sanitize_text_field($_POST['ianaleckcorona_title']);
    //Lets Validate
    //Types
    $errors = 0;
    
    $accepted_types = ['table','map'];
    $error = in_array(strtolower($type),$accepted_types)?false:true;
    $error?$errors++:$errors+0;
      
    $error_messages.= $error?' * type should be either map or table ':'';
    // Loops
    $error = is_numeric((float)$loop)?false:true;
    $error?$errors++:$errors+0;

    $error_messages.= $error?' * loop should be a valid numeric value ':'';
    // Theme
    $accepted_themes = ['light','dark'];
    $error = in_array(strtolower($theme),$accepted_themes)?false:true;
    $error?$errors++:$errors+0;
    
    $error_messages.= $error?' * theme should be either light or dark ':'';
    // Area
    $countries = array
    (
      'ALL' => 'All Countries',
      'SUMMARY' => 'Summary',
      'AF' => 'Afghanistan',
      'AX' => 'Aland Islands',
      'AL' => 'Albania',
      'DZ' => 'Algeria',
      'AS' => 'American Samoa',
      'AD' => 'Andorra',
      'AO' => 'Angola',
      'AI' => 'Anguilla',
      'AQ' => 'Antarctica',
      'AG' => 'Antigua And Barbuda',
      'AR' => 'Argentina',
      'AM' => 'Armenia',
      'AW' => 'Aruba',
      'AU' => 'Australia',
      'AT' => 'Austria',
      'AZ' => 'Azerbaijan',
      'BS' => 'Bahamas',
      'BH' => 'Bahrain',
      'BD' => 'Bangladesh',
      'BB' => 'Barbados',
      'BY' => 'Belarus',
      'BE' => 'Belgium',
      'BZ' => 'Belize',
      'BJ' => 'Benin',
      'BM' => 'Bermuda',
      'BT' => 'Bhutan',
      'BO' => 'Bolivia',
      'BA' => 'Bosnia And Herzegovina',
      'BW' => 'Botswana',
      'BV' => 'Bouvet Island',
      'BR' => 'Brazil',
      'IO' => 'British Indian Ocean Territory',
      'BN' => 'Brunei Darussalam',
      'BG' => 'Bulgaria',
      'BF' => 'Burkina Faso',
      'BI' => 'Burundi',
      'KH' => 'Cambodia',
      'CM' => 'Cameroon',
      'CA' => 'Canada',
      'CV' => 'Cape Verde',
      'KY' => 'Cayman Islands',
      'CF' => 'Central African Republic',
      'TD' => 'Chad',
      'CL' => 'Chile',
      'CN' => 'China',
      'CX' => 'Christmas Island',
      'CC' => 'Cocos (Keeling) Islands',
      'CO' => 'Colombia',
      'KM' => 'Comoros',
      'CG' => 'Congo',
      'CD' => 'Congo, Democratic Republic',
      'CK' => 'Cook Islands',
      'CR' => 'Costa Rica',
      'CI' => 'Cote D\'Ivoire',
      'HR' => 'Croatia',
      'CU' => 'Cuba',
      'CY' => 'Cyprus',
      'CZ' => 'Czech Republic',
      'DK' => 'Denmark',
      'DJ' => 'Djibouti',
      'DM' => 'Dominica',
      'DO' => 'Dominican Republic',
      'EC' => 'Ecuador',
      'EG' => 'Egypt',
      'SV' => 'El Salvador',
      'GQ' => 'Equatorial Guinea',
      'ER' => 'Eritrea',
      'EE' => 'Estonia',
      'ET' => 'Ethiopia',
      'FK' => 'Falkland Islands (Malvinas)',
      'FO' => 'Faroe Islands',
      'FJ' => 'Fiji',
      'FI' => 'Finland',
      'FR' => 'France',
      'GF' => 'French Guiana',
      'PF' => 'French Polynesia',
      'TF' => 'French Southern Territories',
      'GA' => 'Gabon',
      'GM' => 'Gambia',
      'GE' => 'Georgia',
      'DE' => 'Germany',
      'GH' => 'Ghana',
      'GI' => 'Gibraltar',
      'GR' => 'Greece',
      'GL' => 'Greenland',
      'GD' => 'Grenada',
      'GP' => 'Guadeloupe',
      'GU' => 'Guam',
      'GT' => 'Guatemala',
      'GG' => 'Guernsey',
      'GN' => 'Guinea',
      'GW' => 'Guinea-Bissau',
      'GY' => 'Guyana',
      'HT' => 'Haiti',
      'HM' => 'Heard Island & Mcdonald Islands',
      'VA' => 'Holy See (Vatican City State)',
      'HN' => 'Honduras',
      'HK' => 'Hong Kong',
      'HU' => 'Hungary',
      'IS' => 'Iceland',
      'IN' => 'India',
      'ID' => 'Indonesia',
      'IR' => 'Iran, Islamic Republic Of',
      'IQ' => 'Iraq',
      'IE' => 'Ireland',
      'IM' => 'Isle Of Man',
      'IL' => 'Israel',
      'IT' => 'Italy',
      'JM' => 'Jamaica',
      'JP' => 'Japan',
      'JE' => 'Jersey',
      'JO' => 'Jordan',
      'KZ' => 'Kazakhstan',
      'KE' => 'Kenya',
      'KI' => 'Kiribati',
      'KR' => 'Korea',
      'KW' => 'Kuwait',
      'KG' => 'Kyrgyzstan',
      'LA' => 'Lao People\'s Democratic Republic',
      'LV' => 'Latvia',
      'LB' => 'Lebanon',
      'LS' => 'Lesotho',
      'LR' => 'Liberia',
      'LY' => 'Libyan Arab Jamahiriya',
      'LI' => 'Liechtenstein',
      'LT' => 'Lithuania',
      'LU' => 'Luxembourg',
      'MO' => 'Macao',
      'MK' => 'Macedonia',
      'MG' => 'Madagascar',
      'MW' => 'Malawi',
      'MY' => 'Malaysia',
      'MV' => 'Maldives',
      'ML' => 'Mali',
      'MT' => 'Malta',
      'MH' => 'Marshall Islands',
      'MQ' => 'Martinique',
      'MR' => 'Mauritania',
      'MU' => 'Mauritius',
      'YT' => 'Mayotte',
      'MX' => 'Mexico',
      'FM' => 'Micronesia, Federated States Of',
      'MD' => 'Moldova',
      'MC' => 'Monaco',
      'MN' => 'Mongolia',
      'ME' => 'Montenegro',
      'MS' => 'Montserrat',
      'MA' => 'Morocco',
      'MZ' => 'Mozambique',
      'MM' => 'Myanmar',
      'NA' => 'Namibia',
      'NR' => 'Nauru',
      'NP' => 'Nepal',
      'NL' => 'Netherlands',
      'AN' => 'Netherlands Antilles',
      'NC' => 'New Caledonia',
      'NZ' => 'New Zealand',
      'NI' => 'Nicaragua',
      'NE' => 'Niger',
      'NG' => 'Nigeria',
      'NU' => 'Niue',
      'NF' => 'Norfolk Island',
      'MP' => 'Northern Mariana Islands',
      'NO' => 'Norway',
      'OM' => 'Oman',
      'PK' => 'Pakistan',
      'PW' => 'Palau',
      'PS' => 'Palestinian Territory, Occupied',
      'PA' => 'Panama',
      'PG' => 'Papua New Guinea',
      'PY' => 'Paraguay',
      'PE' => 'Peru',
      'PH' => 'Philippines',
      'PN' => 'Pitcairn',
      'PL' => 'Poland',
      'PT' => 'Portugal',
      'PR' => 'Puerto Rico',
      'QA' => 'Qatar',
      'RE' => 'Reunion',
      'RO' => 'Romania',
      'RU' => 'Russian Federation',
      'RW' => 'Rwanda',
      'BL' => 'Saint Barthelemy',
      'SH' => 'Saint Helena',
      'KN' => 'Saint Kitts And Nevis',
      'LC' => 'Saint Lucia',
      'MF' => 'Saint Martin',
      'PM' => 'Saint Pierre And Miquelon',
      'VC' => 'Saint Vincent And Grenadines',
      'WS' => 'Samoa',
      'SM' => 'San Marino',
      'ST' => 'Sao Tome And Principe',
      'SA' => 'Saudi Arabia',
      'SN' => 'Senegal',
      'RS' => 'Serbia',
      'SC' => 'Seychelles',
      'SL' => 'Sierra Leone',
      'SG' => 'Singapore',
      'SK' => 'Slovakia',
      'SI' => 'Slovenia',
      'SB' => 'Solomon Islands',
      'SO' => 'Somalia',
      'ZA' => 'South Africa',
      'GS' => 'South Georgia And Sandwich Isl.',
      'ES' => 'Spain',
      'LK' => 'Sri Lanka',
      'SD' => 'Sudan',
      'SR' => 'Suriname',
      'SJ' => 'Svalbard And Jan Mayen',
      'SZ' => 'Swaziland',
      'SE' => 'Sweden',
      'CH' => 'Switzerland',
      'SY' => 'Syrian Arab Republic',
      'TW' => 'Taiwan',
      'TJ' => 'Tajikistan',
      'TZ' => 'Tanzania',
      'TH' => 'Thailand',
      'TL' => 'Timor-Leste',
      'TG' => 'Togo',
      'TK' => 'Tokelau',
      'TO' => 'Tonga',
      'TT' => 'Trinidad And Tobago',
      'TN' => 'Tunisia',
      'TR' => 'Turkey',
      'TM' => 'Turkmenistan',
      'TC' => 'Turks And Caicos Islands',
      'TV' => 'Tuvalu',
      'UG' => 'Uganda',
      'UA' => 'Ukraine',
      'AE' => 'United Arab Emirates',
      'GB' => 'United Kingdom',
      'US' => 'United States',
      'UM' => 'United States Outlying Islands',
      'UY' => 'Uruguay',
      'UZ' => 'Uzbekistan',
      'VU' => 'Vanuatu',
      'VE' => 'Venezuela',
      'VN' => 'Viet Nam',
      'VG' => 'Virgin Islands, British',
      'VI' => 'Virgin Islands, U.S.',
      'WF' => 'Wallis And Futuna',
      'EH' => 'Western Sahara',
      'YE' => 'Yemen',
      'ZM' => 'Zambia',
      'ZW' => 'Zimbabwe'
    );
    $error = array_key_exists(mb_strtoupper($area),$countries)?false:true;
    $error?$errors++:$errors+0;
  
    $error_messages.= $error?' * area should be a valid country iso2 code, all or summary <br>':'';
    //Title
    $error = is_string($title)?false:true;
    $error?$errors++:$errors+0;
    
    $error_messages.= $error?' * please provide a valide title':'';
    
    $tag = '[ia_covid19';
    $tag .= ' type="'.$type.'"';
    $tag .= ' loop="'.$loop.'"';
    $tag .= ' theme="'.$theme.'"';
    
    if (($type)=="table") {
      $tag .= ' area="'.$area.'"';
      $tag .= ' usstate="'.$usstate.'"';
      $tag .= ' title="'.$title.'"';
    }
    $tag .= ']';

  
    $error_messages = $errors>0?"You have submitted some invalid data. Please review the following ".$error_messages:"";
    
    ?>
    <?php if ($errors==0): ?>
      </p>
      <div class="notice notice-success is-dismissible">
      <h3><?php _e( 'Widget Created!', 'sample-text-domain' ); ?></h3>
      </div>
      <?php else: ?>
        <div class="notice notice-error is-dismissible">
        <h3><?php _e( 'Error Occured, check below!', 'sample-text-domain' ); ?></h3>
        </div>
    <?php endif; ?>
    
    <?php
  }
  ?>
  <div class="wrap">
  <h3>Covid-19 Live Tracker</h3>
  
  <p>Corona Virus / Covid-19 JQuery Live Tracker is a wordpress plugin, built with JQuery's Ajax to get Live data in a table and or map <br> Version: 1.0.0 <br> Website: <a href="https://github.com/ianaleck">https://github.com/ianaleck</a></p>
  <hr>
  <div class="container">
  <h2>Create Live Tracker Widget</h2>
  <?php if (empty($error_messages)&&array_key_exists("ianaleckcorona_area",$_POST)): ?>
     
     <h4>Copy the shortcode below to where you want the widget to be dsiplayed.</h4><h3><?= esc_attr($tag) ?></h3>
     
     <?php else: ?>
     <?php print esc_html($error_messages); ?>   
    <?php endif; ?>
  <form method="post" class="ia_covid19_create_widget">
  <fieldset>
  <label for="">Select Area</label>
  <select  name="ianaleckcorona_area" required>
  <option value="summary">Summary</option>
  <option value="all">ALL</option>
  <option value="AF">Afghanistan</option>
  <option value="AX">Åland Islands</option>
  <option value="AL">Albania</option>
  <option value="DZ">Algeria</option>
  <option value="AS">American Samoa</option>
  <option value="AD">Andorra</option>
  <option value="AO">Angola</option>
  <option value="AI">Anguilla</option>
  <option value="AQ">Antarctica</option>
  <option value="AG">Antigua and Barbuda</option>
  <option value="AR">Argentina</option>
  <option value="AM">Armenia</option>
  <option value="AW">Aruba</option>
  <option value="AU">Australia</option>
  <option value="AT">Austria</option>
  <option value="AZ">Azerbaijan</option>
  <option value="BS">Bahamas</option>
  <option value="BH">Bahrain</option>
  <option value="BD">Bangladesh</option>
  <option value="BB">Barbados</option>
  <option value="BY">Belarus</option>
  <option value="BE">Belgium</option>
  <option value="BZ">Belize</option>
  <option value="BJ">Benin</option>
  <option value="BM">Bermuda</option>
  <option value="BT">Bhutan</option>
  <option value="BO">Bolivia, Plurinational State of</option>
  <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
  <option value="BA">Bosnia and Herzegovina</option>
  <option value="BW">Botswana</option>
  <option value="BV">Bouvet Island</option>
  <option value="BR">Brazil</option>
  <option value="IO">British Indian Ocean Territory</option>
  <option value="BN">Brunei Darussalam</option>
  <option value="BG">Bulgaria</option>
  <option value="BF">Burkina Faso</option>
  <option value="BI">Burundi</option>
  <option value="KH">Cambodia</option>
  <option value="CM">Cameroon</option>
  <option value="CA">Canada</option>
  <option value="CV">Cape Verde</option>
  <option value="KY">Cayman Islands</option>
  <option value="CF">Central African Republic</option>
  <option value="TD">Chad</option>
  <option value="CL">Chile</option>
  <option value="CN">China</option>
  <option value="CX">Christmas Island</option>
  <option value="CC">Cocos (Keeling) Islands</option>
  <option value="CO">Colombia</option>
  <option value="KM">Comoros</option>
  <option value="CG">Congo</option>
  <option value="CD">Congo, the Democratic Republic of the</option>
  <option value="CK">Cook Islands</option>
  <option value="CR">Costa Rica</option>
  <option value="CI">Côte d'Ivoire</option>
  <option value="HR">Croatia</option>
  <option value="CU">Cuba</option>
  <option value="CW">Curaçao</option>
  <option value="CY">Cyprus</option>
  <option value="CZ">Czech Republic</option>
  <option value="DK">Denmark</option>
  <option value="DJ">Djibouti</option>
  <option value="DM">Dominica</option>
  <option value="DO">Dominican Republic</option>
  <option value="EC">Ecuador</option>
  <option value="EG">Egypt</option>
  <option value="SV">El Salvador</option>
  <option value="GQ">Equatorial Guinea</option>
  <option value="ER">Eritrea</option>
  <option value="EE">Estonia</option>
  <option value="ET">Ethiopia</option>
  <option value="FK">Falkland Islands (Malvinas)</option>
  <option value="FO">Faroe Islands</option>
  <option value="FJ">Fiji</option>
  <option value="FI">Finland</option>
  <option value="FR">France</option>
  <option value="GF">French Guiana</option>
  <option value="PF">French Polynesia</option>
  <option value="TF">French Southern Territories</option>
  <option value="GA">Gabon</option>
  <option value="GM">Gambia</option>
  <option value="GE">Georgia</option>
  <option value="DE">Germany</option>
  <option value="GH">Ghana</option>
  <option value="GI">Gibraltar</option>
  <option value="GR">Greece</option>
  <option value="GL">Greenland</option>
  <option value="GD">Grenada</option>
  <option value="GP">Guadeloupe</option>
  <option value="GU">Guam</option>
  <option value="GT">Guatemala</option>
  <option value="GG">Guernsey</option>
  <option value="GN">Guinea</option>
  <option value="GW">Guinea-Bissau</option>
  <option value="GY">Guyana</option>
  <option value="HT">Haiti</option>
  <option value="HM">Heard Island and McDonald Islands</option>
  <option value="VA">Holy See (Vatican City State)</option>
  <option value="HN">Honduras</option>
  <option value="HK">Hong Kong</option>
  <option value="HU">Hungary</option>
  <option value="IS">Iceland</option>
  <option value="IN">India</option>
  <option value="ID">Indonesia</option>
  <option value="IR">Iran, Islamic Republic of</option>
  <option value="IQ">Iraq</option>
  <option value="IE">Ireland</option>
  <option value="IM">Isle of Man</option>
  <option value="IL">Israel</option>
  <option value="IT">Italy</option>
  <option value="JM">Jamaica</option>
  <option value="JP">Japan</option>
  <option value="JE">Jersey</option>
  <option value="JO">Jordan</option>
  <option value="KZ">Kazakhstan</option>
  <option value="KE">Kenya</option>
  <option value="KI">Kiribati</option>
  <option value="KP">Korea, Democratic People's Republic of</option>
  <option value="KR">Korea, Republic of</option>
  <option value="KW">Kuwait</option>
  <option value="KG">Kyrgyzstan</option>
  <option value="LA">Lao People's Democratic Republic</option>
  <option value="LV">Latvia</option>
  <option value="LB">Lebanon</option>
  <option value="LS">Lesotho</option>
  <option value="LR">Liberia</option>
  <option value="LY">Libya</option>
  <option value="LI">Liechtenstein</option>
  <option value="LT">Lithuania</option>
  <option value="LU">Luxembourg</option>
  <option value="MO">Macao</option>
  <option value="MK">Macedonia, the former Yugoslav Republic of</option>
  <option value="MG">Madagascar</option>
  <option value="MW">Malawi</option>
  <option value="MY">Malaysia</option>
  <option value="MV">Maldives</option>
  <option value="ML">Mali</option>
  <option value="MT">Malta</option>
  <option value="MH">Marshall Islands</option>
  <option value="MQ">Martinique</option>
  <option value="MR">Mauritania</option>
  <option value="MU">Mauritius</option>
  <option value="YT">Mayotte</option>
  <option value="MX">Mexico</option>
  <option value="FM">Micronesia, Federated States of</option>
  <option value="MD">Moldova, Republic of</option>
  <option value="MC">Monaco</option>
  <option value="MN">Mongolia</option>
  <option value="ME">Montenegro</option>
  <option value="MS">Montserrat</option>
  <option value="MA">Morocco</option>
  <option value="MZ">Mozambique</option>
  <option value="MM">Myanmar</option>
  <option value="NA">Namibia</option>
  <option value="NR">Nauru</option>
  <option value="NP">Nepal</option>
  <option value="NL">Netherlands</option>
  <option value="NC">New Caledonia</option>
  <option value="NZ">New Zealand</option>
  <option value="NI">Nicaragua</option>
  <option value="NE">Niger</option>
  <option value="NG">Nigeria</option>
  <option value="NU">Niue</option>
  <option value="NF">Norfolk Island</option>
  <option value="MP">Northern Mariana Islands</option>
  <option value="NO">Norway</option>
  <option value="OM">Oman</option>
  <option value="PK">Pakistan</option>
  <option value="PW">Palau</option>
  <option value="PS">Palestinian Territory, Occupied</option>
  <option value="PA">Panama</option>
  <option value="PG">Papua New Guinea</option>
  <option value="PY">Paraguay</option>
  <option value="PE">Peru</option>
  <option value="PH">Philippines</option>
  <option value="PN">Pitcairn</option>
  <option value="PL">Poland</option>
  <option value="PT">Portugal</option>
  <option value="PR">Puerto Rico</option>
  <option value="QA">Qatar</option>
  <option value="RE">Réunion</option>
  <option value="RO">Romania</option>
  <option value="RU">Russian Federation</option>
  <option value="RW">Rwanda</option>
  <option value="BL">Saint Barthélemy</option>
  <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
  <option value="KN">Saint Kitts and Nevis</option>
  <option value="LC">Saint Lucia</option>
  <option value="MF">Saint Martin (French part)</option>
  <option value="PM">Saint Pierre and Miquelon</option>
  <option value="VC">Saint Vincent and the Grenadines</option>
  <option value="WS">Samoa</option>
  <option value="SM">San Marino</option>
  <option value="ST">Sao Tome and Principe</option>
  <option value="SA">Saudi Arabia</option>
  <option value="SN">Senegal</option>
  <option value="RS">Serbia</option>
  <option value="SC">Seychelles</option>
  <option value="SL">Sierra Leone</option>
  <option value="SG">Singapore</option>
  <option value="SX">Sint Maarten (Dutch part)</option>
  <option value="SK">Slovakia</option>
  <option value="SI">Slovenia</option>
  <option value="SB">Solomon Islands</option>
  <option value="SO">Somalia</option>
  <option value="ZA">South Africa</option>
  <option value="GS">South Georgia and the South Sandwich Islands</option>
  <option value="SS">South Sudan</option>
  <option value="ES">Spain</option>
  <option value="LK">Sri Lanka</option>
  <option value="SD">Sudan</option>
  <option value="SR">Suriname</option>
  <option value="SJ">Svalbard and Jan Mayen</option>
  <option value="SZ">Swaziland</option>
  <option value="SE">Sweden</option>
  <option value="CH">Switzerland</option>
  <option value="SY">Syrian Arab Republic</option>
  <option value="TW">Taiwan, Province of China</option>
  <option value="TJ">Tajikistan</option>
  <option value="TZ">Tanzania, United Republic of</option>
  <option value="TH">Thailand</option>
  <option value="TL">Timor-Leste</option>
  <option value="TG">Togo</option>
  <option value="TK">Tokelau</option>
  <option value="TO">Tonga</option>
  <option value="TT">Trinidad and Tobago</option>
  <option value="TN">Tunisia</option>
  <option value="TR">Turkey</option>
  <option value="TM">Turkmenistan</option>
  <option value="TC">Turks and Caicos Islands</option>
  <option value="TV">Tuvalu</option>
  <option value="UG">Uganda</option>
  <option value="UA">Ukraine</option>
  <option value="AE">United Arab Emirates</option>
  <option value="GB">United Kingdom</option>
  <option value="US">United States</option>
  <option value="UM">United States Minor Outlying Islands</option>
  <option value="UY">Uruguay</option>
  <option value="UZ">Uzbekistan</option>
  <option value="VU">Vanuatu</option>
  <option value="VE">Venezuela, Bolivarian Republic of</option>
  <option value="VN">Viet Nam</option>
  <option value="VG">Virgin Islands, British</option>
  <option value="VI">Virgin Islands, U.S.</option>
  <option value="WF">Wallis and Futuna</option>
  <option value="EH">Western Sahara</option>
  <option value="YE">Yemen</option>
  <option value="ZM">Zambia</option>
  <option value="ZW">Zimbabwe</option>
  </select>
  </fieldset>
  <fieldset>
  <label for="">If US State</label>
  <select name="ianaleckcorona_usstate">
  <option value=""></option>
  <option value="alabama">Alabama</option>
<option value="alaska">Alaska</option>
<option value="american samoa">American Samoa</option>
<option value="arizona">Arizona</option>
<option value="arkansas">Arkansas</option>
<option value="california">California</option>
<option value="colorado">Colorado</option>
<option value="connecticut">Connecticut</option>
<option value="delaware">Delaware</option>
<option value="dc">DC</option>
<option value="florida">Florida</option>
<option value="georgia">Georgia</option>
<option value="guam">Guam</option>
<option value="hawaii">Hawaii</option>
<option value="idaho">Idaho</option>
<option value="illinois">Illinois</option>
<option value="indiana">Indiana</option>
<option value="iowa">Iowa</option>
<option value="kansas">Kansas</option>
<option value="kentucky">Kentucky</option>
<option value="louisiana">Louisiana</option>
<option value="maine">Maine</option>
<option value="maryland">Maryland</option>
<option value="massachusetts">Massachusetts</option>
<option value="michigan">Michigan</option>
<option value="minnesota">Minnesota</option>
<option value="minor outlying islands">Minor Outlying Islands</option>
<option value="mississippi">Mississippi</option>
<option value="missouri">Missouri</option>
<option value="montana">Montana</option>
<option value="nebraska">Nebraska</option>
<option value="nevada">Nevada</option>
<option value="new hampshire">New Hampshire</option>
<option value="new jersey">New Jersey</option>
<option value="new mexico">New Mexico</option>
<option value="new york">New York</option>
<option value="north carolina">North Carolina</option>
<option value="north dakota">North Dakota</option>
<option value="northern mariana islands">Northern Mariana Islands</option>
<option value="ohio">Ohio</option>
<option value="oklahoma">Oklahoma</option>
<option value="oregon">Oregon</option>
<option value="pennsylvania">Pennsylvania</option>
<option value="puerto rico">Puerto Rico</option>
<option value="rhode island">Rhode Island</option>
<option value="south carolina">South Carolina</option>
<option value="south dakota">South Dakota</option>
<option value="tennessee">Tennessee</option>
<option value="texas">Texas</option>
<option value="u.s. virgin islands">U.S. Virgin Islands</option>
<option value="utah">Utah</option>
<option value="vermont">Vermont</option>
<option value="virginia">Virginia</option>
<option value="washington">Washington</option>
<option value="west virginia">West Virginia</option>
<option value="wisconsin">Wisconsin</option>
<option value="wyoming">Wyoming</option>
  </select>
  </fieldset>
  <fieldset>
  <label for="">Select Theme</label>
  <select required name="ianaleckcorona_theme">
  <option value="light">Light</option>
  <option value="dark">Dark</option>
  </select>
  </fieldset>
  <fieldset>
  <label for="">Select Refresh Time In Minutes</label>
  <br><small>This is the wait preriod in minutes before the next ajax update</small>
  <select required name="ianaleckcorona_loop">
  <option value="0">Never</option>
  <option value="5">5 Mins</option>
  <option value="10">10 Mins</option>
  <option value="15">15 Mins</option>
  <option value="30">30 Mins</option>
  </select>
  </fieldset>
  <fieldset>
  <label for="">Select Type</label>
  <select required name="ianaleckcorona_type">
  <option value="table">List</option>
  <option value="map">Map</option>
  </select>
  </fieldset>
  <fieldset>
  <label for="">Title</label>
  <br><small>Leave blank to deactivate</small>
  <input type="text" name="ianaleckcorona_title" placeholder="Enter Widget Title" value="World Stats">
  </fieldset>
  <br>
  <button class="button button-primary" type="submit" name="ianaleckcorona_submit">GENERATE</button>
  </form>
  <hr>
  <br>
  <style>.bmc-button img{height: 34px !important;width: 35px !important;margin-bottom: 1px !important;box-shadow: none !important;border: none !important;vertical-align: middle !important;}.bmc-button{padding: 7px 10px 7px 10px !important;line-height: 35px !important;height:51px !important;min-width:217px !important;text-decoration: none !important;display:inline-flex !important;color:#FFFFFF !important;background-color:#FF813F !important;border-radius: 5px !important;border: 1px solid transparent !important;padding: 7px 10px 7px 10px !important;font-size: 22px !important;letter-spacing: 0.6px !important;box-shadow: 0px 1px 2px rgba(190, 190, 190, 0.5) !important;-webkit-box-shadow: 0px 1px 2px 2px rgba(190, 190, 190, 0.5) !important;margin: 0 auto !important;font-family:'Cookie', cursive !important;-webkit-box-sizing: border-box !important;box-sizing: border-box !important;-o-transition: 0.3s all linear !important;-webkit-transition: 0.3s all linear !important;-moz-transition: 0.3s all linear !important;-ms-transition: 0.3s all linear !important;transition: 0.3s all linear !important;}.bmc-button:hover, .bmc-button:active, .bmc-button:focus {-webkit-box-shadow: 0px 1px 2px 2px rgba(190, 190, 190, 0.5) !important;text-decoration: none !important;box-shadow: 0px 1px 2px 2px rgba(190, 190, 190, 0.5) !important;opacity: 0.85 !important;color:#FFFFFF !important;}</style><link href="https://fonts.googleapis.com/css?family=Cookie" rel="stylesheet"><a class="bmc-button" target="_blank" href="https://www.buymeacoffee.com/ianaleck"><img src="https://cdn.buymeacoffee.com/buttons/bmc-new-btn-logo.svg" alt="Buy me a coffee"><span style="margin-left:15px;font-size:28px !important;">Buy me a coffee</span></a>
  </div>
  </div>
  <?php
}
?>