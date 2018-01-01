<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail{
        function sendMail($greeting,$username,$city,$aqiObject){
            $mail = new PHPMailer(true);                              
            try {
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
                include 'config.php';
                $mail->SMTPDebug = 2;
                $mail->isSMTP();     
                $mail->Host = $mailHost;  
                $mail->SMTPAuth = true;           
                $mail->Username = $mailUsername;                 
                $mail->Password = $mailPassword;                         
                $mail->SMTPSecure = 'tls';                            
                $mail->Port = $mailPort;                                    
                $mail->setFrom($mailFromAddress, 'AQI Notifier');
                $mail->addAddress($mailToAddress, $username);     
                $mail->addReplyTo($mailReplyToAddress, 'AQI Notifier');
                $mail->isHTML(true);                                 
                $mail->Subject = '[Air Quality Index Notifier] Your daily AQI report';
                $mail->Body    = $this->buildMailHTML($greeting,$username,$city,$aqiObject);
                $mail->AltBody = 'Please use an email client with HTML-email support to view this message in its entirety.';
                $mail->send();
                echo 'Report sent';
            } catch (\Exception $e) {
                echo 'Report could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            }
        }
    
    
    function buildMailHTML($greeting,$username,$city,$aqiObject){
        $strMail = <<<EOT
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="background:#000">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Title</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
    <style>
@media screen { 
@font-face {
  font-family: 'Roboto Slab';
  font-style: normal;
  font-weight: 400;
  src: local('Roboto Slab Regular'), local('RobotoSlab-Regular'), url(https://fonts.gstatic.com/s/robotoslab/v7/y7lebkjgREBJK96VQi37ZobN6UDyHWBl620a-IRfuBk.woff) format('woff');
}

}
      a:hover{color:#147dc2}
      a:active{color:#147dc2}
      a:visited{color:#2199e8}
      h1 a:visited{color:#2199e8}
      h2 a:visited{color:#2199e8}
      h3 a:visited{color:#2199e8}
      h4 a:visited{color:#2199e8}
      h5 a:visited{color:#2199e8}
      h6 a:visited{color:#2199e8}
      table.button:hover table tr td a{color:#fefefe}
      table.button:active table tr td a{color:#fefefe}
      table.button table tr td a:visited{color:#fefefe}
      table.button.tiny:hover table tr td a{color:#fefefe}
      table.button.tiny:active table tr td a{color:#fefefe}
      table.button.tiny table tr td a:visited{color:#fefefe}
      table.button.small:hover table tr td a{color:#fefefe}
      table.button.small:active table tr td a{color:#fefefe}
      table.button.small table tr td a:visited{color:#fefefe}
      table.button.large:hover table tr td a{color:#fefefe}
      table.button.large:active table tr td a{color:#fefefe}
      table.button.large table tr td a:visited{color:#fefefe}
      table.button:hover table td{background:#147dc2;color:#fefefe}
      table.button:visited table td{background:#147dc2;color:#fefefe}
      table.button:active table td{background:#147dc2;color:#fefefe}
      table.button:hover table a{border:0 solid #147dc2}
      table.button:visited table a{border:0 solid #147dc2}
      table.button:active table a{border:0 solid #147dc2}
      table.button.secondary:hover table td{background:#919191;color:#fefefe}
      table.button.secondary:hover table a{border:0 solid #919191}
      table.button.secondary:hover table td a{color:#fefefe}
      table.button.secondary:active table td a{color:#fefefe}
      table.button.secondary table td a:visited{color:#fefefe}
      table.button.success:hover table td{background:#23bf5d}
      table.button.success:hover table a{border:0 solid #23bf5d}
      table.button.alert:hover table td{background:#e23317}
      table.button.alert:hover table a{border:0 solid #e23317}
      table.button.warning:hover table td{background:#cc8b00}
      table.button.warning:hover table a{border:0px solid #cc8b00}
      .thumbnail:hover{box-shadow:0 0 6px 1px rgba(33, 153, 232, 0.5)}
      .thumbnail:focus{box-shadow:0 0 6px 1px rgba(33, 153, 232, 0.5)}
    </style>
    <style type="text/css">

      .ExternalClass {
        width: 100%; }
        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
          line-height: 100%; }
      @media only screen {
        html {
          min-height: 100%;
          background: #f3f3f3; } }
      @media only screen and (max-width: 596px) {
        .small-float-center {
          margin: 0 auto !important;
          float: none !important;
          text-align: center !important; }
        .small-text-center {
          text-align: center !important; }
        .small-text-left {
          text-align: left !important; }
        .small-text-right {
          text-align: right !important; } }
        @media only screen and (max-width: 596px) {
          .hide-for-large {
            display: block !important;
            width: auto !important;
            overflow: visible !important;
            max-height: none !important;
            font-size: inherit !important;
            line-height: inherit !important; } }
      @media only screen and (max-width: 596px) {
        table.body table.container .hide-for-large,
        table.body table.container .row.hide-for-large {
          display: table !important;
          width: 100% !important; } }
      @media only screen and (max-width: 596px) {
        table.body table.container .callout-inner.hide-for-large {
          display: table-cell !important;
          width: 100% !important; } }
      @media only screen and (max-width: 596px) {
        table.body table.container .show-for-large {
          display: none !important;
          width: 0;
          mso-hide: all;
          overflow: hidden; } }
      @media only screen and (max-width: 596px) {
        table.body img {
          width: auto;
          height: auto; }
        table.body center {
          min-width: 0 !important; }
        table.body .container {
          width: 95% !important; }
        table.body .columns,
        table.body .column {
          height: auto !important;
          -moz-box-sizing: border-box;
          -webkit-box-sizing: border-box;
          box-sizing: border-box;
          padding-left: 16px !important;
          padding-right: 16px !important; }
          table.body .columns .column,
          table.body .columns .columns,
          table.body .column .column,
          table.body .column .columns {
            padding-left: 0 !important;
            padding-right: 0 !important; }
        table.body .collapse .columns,
        table.body .collapse .column {
          padding-left: 0 !important;
          padding-right: 0 !important; }
        td.small-1,
        th.small-1 {
          display: inline-block !important;
          width: 8.33333% !important; }
        td.small-2,
        th.small-2 {
          display: inline-block !important;
          width: 16.66667% !important; }
        td.small-3,
        th.small-3 {
          display: inline-block !important;
          width: 25% !important; }
        td.small-4,
        th.small-4 {
          display: inline-block !important;
          width: 33.33333% !important; }
        td.small-5,
        th.small-5 {
          display: inline-block !important;
          width: 41.66667% !important; }
        td.small-6,
        th.small-6 {
          display: inline-block !important;
          width: 50% !important; }
        td.small-7,
        th.small-7 {
          display: inline-block !important;
          width: 58.33333% !important; }
        td.small-8,
        th.small-8 {
          display: inline-block !important;
          width: 66.66667% !important; }
        td.small-9,
        th.small-9 {
          display: inline-block !important;
          width: 75% !important; }
        td.small-10,
        th.small-10 {
          display: inline-block !important;
          width: 83.33333% !important; }
        td.small-11,
        th.small-11 {
          display: inline-block !important;
          width: 91.66667% !important; }
        td.small-12,
        th.small-12 {
          display: inline-block !important;
          width: 100% !important; }
        .columns td.small-12,
        .column td.small-12,
        .columns th.small-12,
        .column th.small-12 {
          display: block !important;
          width: 100% !important; }
        table.body td.small-offset-1,
        table.body th.small-offset-1 {
          margin-left: 8.33333% !important;
          Margin-left: 8.33333% !important; }
        table.body td.small-offset-2,
        table.body th.small-offset-2 {
          margin-left: 16.66667% !important;
          Margin-left: 16.66667% !important; }
        table.body td.small-offset-3,
        table.body th.small-offset-3 {
          margin-left: 25% !important;
          Margin-left: 25% !important; }
        table.body td.small-offset-4,
        table.body th.small-offset-4 {
          margin-left: 33.33333% !important;
          Margin-left: 33.33333% !important; }
        table.body td.small-offset-5,
        table.body th.small-offset-5 {
          margin-left: 41.66667% !important;
          Margin-left: 41.66667% !important; }
        table.body td.small-offset-6,
        table.body th.small-offset-6 {
          margin-left: 50% !important;
          Margin-left: 50% !important; }
        table.body td.small-offset-7,
        table.body th.small-offset-7 {
          margin-left: 58.33333% !important;
          Margin-left: 58.33333% !important; }
        table.body td.small-offset-8,
        table.body th.small-offset-8 {
          margin-left: 66.66667% !important;
          Margin-left: 66.66667% !important; }
        table.body td.small-offset-9,
        table.body th.small-offset-9 {
          margin-left: 75% !important;
          Margin-left: 75% !important; }
        table.body td.small-offset-10,
        table.body th.small-offset-10 {
          margin-left: 83.33333% !important;
          Margin-left: 83.33333% !important; }
        table.body td.small-offset-11,
        table.body th.small-offset-11 {
          margin-left: 91.66667% !important;
          Margin-left: 91.66667% !important; }
        table.body table.columns td.expander,
        table.body table.columns th.expander {
          display: none !important; }
        table.body .right-text-pad,
        table.body .text-pad-right {
          padding-left: 10px !important; }
        table.body .left-text-pad,
        table.body .text-pad-left {
          padding-right: 10px !important; }
        table.menu {
          width: 100% !important; }
          table.menu td,
          table.menu th {
            width: auto !important;
            display: inline-block !important; }
          table.menu.vertical td,
          table.menu.vertical th, table.menu.small-vertical td,
          table.menu.small-vertical th {
            display: block !important; }
        table.menu[align="center"] {
          width: auto !important; }
        table.button.small-expand,
        table.button.small-expanded {
          width: 100% !important; }
          table.button.small-expand table,
          table.button.small-expanded table {
            width: 100%; }
            table.button.small-expand table a,
            table.button.small-expanded table a {
              text-align: center !important;
              width: 100% !important;
              padding-left: 0 !important;
              padding-right: 0 !important; }
          table.button.small-expand center,
          table.button.small-expanded center {
            min-width: 0; } }
    </style>
  </head>
  <body style="min-width:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;box-sizing:border-box;color:#0a0a0a;font-family:'Roboto Slab', Arial, sans-serif;font-weight:normal;padding:0;margin:0;Margin:0;text-align:left;font-size:16px;line-height:1.3;width:100% !important;background:black;font-family: 'Roboto Slab','Serif';">
    <!-- <style> -->
    <table class="body" data-made-with-foundation style="border-spacing:0;border-collapse:collapse;vertical-align:top;background:#f3f3f3;height:100%;width:100%;color:#0a0a0a;font-family:'Roboto Slab', Arial, sans-serif;font-weight:normal;padding:0;margin:0;Margin:0;text-align:left;font-size:16px;line-height:1.3;background:#000;">
      <tr style="padding:0;vertical-align:top;text-align:left;">
        <td class="float-center" align="center" valign="top" style="word-wrap:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;vertical-align:top;color:#0a0a0a;font-family:'Roboto Slab', Arial, sans-serif;font-weight:normal;padding:0;margin:0;Margin:0;text-align:left;font-size:16px;line-height:1.3;margin:0 auto;Margin:0 auto;float:none;text-align:center;border-collapse:collapse !important;">
          <center style="width:100%;min-width:580px;">
            <table class="container" style="border-spacing:0;border-collapse:collapse;padding:0;vertical-align:top;text-align:left;background:#fefefe;width:580px;margin:0 auto;Margin:0 auto;text-align:inherit;">
              <tr style="padding:0;vertical-align:top;text-align:left;">
                <td style="word-wrap:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;vertical-align:top;color:#0a0a0a;font-family:'Roboto Slab', Arial, sans-serif;font-weight:normal;padding:0;margin:0;Margin:0;text-align:left;font-size:16px;line-height:1.3;border-collapse:collapse !important;">
                  <table class="row" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;padding:0;width:100%;position:relative;display:table;">
                    <tr style="padding:0;vertical-align:top;text-align:left;">
                      <th class="large-6 first columns" style="color:#0a0a0a;font-family:'Roboto Slab', Arial, sans-serif;font-weight:normal;padding:0;margin:0;Margin:0;text-align:left;font-size:16px;line-height:1.3;margin:0 auto;Margin:0 auto;padding-bottom:16px;width:274px;padding-left:8px;padding-right:8px;padding-left:16px;background:#000;">
                        <h1 style="color:#0a0a0a;padding:0;margin:0;Margin:0;text-align:left;line-height:1.3;color:inherit;word-wrap:normal;margin-top:15px;font-weight:normal;margin-bottom:10px;Margin-bottom:10px;font-size:34px;color:white;text-align: center;font-family: 'Roboto Slab','Serif';font-weight: lighter;text-transform: uppercase;margin-bottom: 0;">{$greeting}, {$username}</h1>
                        <h1 style="color:#0a0a0a;padding:0;margin:0;Margin:0;text-align:left;line-height:1.3;color:inherit;word-wrap:normal;font-weight:normal;margin-bottom:10px;Margin-bottom:10px;font-size:34px;color:wheat;text-align: center;font-family: 'Roboto Slab','Serif';font-weight: lighter;text-transform: uppercase;margin-bottom: 0;/*! text-decoration: underline; */;">The Air Quality Index reading for {$city} today is:</h1>
                        <div class="whitebox" style="background-color:white;background: linear-gradient(white, lightgrey, white);margin-left: auto;margin-right: auto;border-radius: 4px;padding-bottom: 12px;padding-left: 12px;padding-right: 12px;">
                          <h1 style="color:{$aqiObject->AQIColour};padding:0;margin:0;Margin:0;text-align:left;line-height:1.3;color:inherit;word-wrap:normal;font-weight:normal;margin-bottom:10px;Margin-bottom:10px;font-size:34px;color:red;text-align: center;font-weight: lighter;font-family: 'Roboto Slab','Serif';font-size: 115px;margin-bottom: 0;">{$aqiObject->AQIValue}</h1>
                          <h5 style="color:{$aqiObject->AQIColour};padding:0;margin:0;Margin:0;text-align:left;line-height:1.3;color:inherit;word-wrap:normal;font-weight:normal;margin-bottom:10px;Margin-bottom:10px;font-size:20px;color:red;text-align: center;font-weight: lighter;font-family: 'Roboto Slab','Serif';font-size: 212%;margin-top: 0px;text-transform: uppercase;margin-bottom: 0;text-decoration: underline;">{$aqiObject->AQIDescription}</h5>
                          <h5 style="color:#0a0a0a;padding:0;margin:0;Margin:0;text-align:left;line-height:1.3;color:inherit;word-wrap:normal;font-weight:normal;margin-bottom:10px;Margin-bottom:10px;font-size:20px;color:black;text-align: center;font-weight: lighter;font-family: 'Roboto Slab','Serif';font-size: 18px;margin-top: 10px;text-transform: uppercase;margin-bottom: 16px;">{$aqiObject->AQIHealthImplications}</h5>
                        </div>
                        <p style="margin:0 0 0 10px;Margin:0 0 0 10px;color:#0a0a0a;font-family:'Roboto Slab';font-weight:normal;padding:0;margin:0;Margin:0;text-align:left;font-size:16px;line-height:1.3;margin-bottom:10px;Margin-bottom:10px;color:wheat;text-align: center;font-weight: lighter;font-size: 12px;margin-top: 10px;margin-bottom: 16px;">Powered by: wapi.info/aqjcn.org
                        </p>
                        <p style="margin:0 0 0 10px;Margin:0 0 0 10px;color:#0a0a0a;font-family:'Roboto Slab';font-weight:normal;padding:0;margin:0;Margin:0;text-align:left;font-size:16px;line-height:1.3;margin-bottom:10px;Margin-bottom:10px;color:wheat;text-align: center;font-weight: lighter;font-size: 12px;margin-top: 10px;text-transform: uppercase;margin-bottom: 16px;">SERVER GENERATED FOR {$username}
    </p>
                      </th>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </center>
        </td>
      </tr>
    </table>
  </body>
</html>
EOT;
        return $strMail;
    }
}
?>