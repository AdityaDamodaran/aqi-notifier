<?php
spl_autoload_register(function ($class_name) {
    
    if (file_exists(__DIR__ .'\\'. $class_name . '.php')) {
        include __DIR__ .'\\'. $class_name . '.php';
    }
});
/*CONFIG*/    
include 'config.php';
/*END CONFIG*/

$greeting="Good morning";
date_default_timezone_set($timezone);
$currentTime=localtime(time(), true);
if($currentTime['tm_hour']>=12&&$currentTime['tm_hour']<=17)
    $greeting="Good afternoon";
else if($currentTime['tm_hour']>17&&$currentTime['tm_hour']<=19)
    $greeting="Good evening";
else if($currentTime['tm_hour']>19)
      $greeting="Good night";
$apiClient = new APIClient();
$aqiObject= $apiClient->getAirQualityDataViaAPI($stationID, $apiToken);
//$aqiObject= $apiClient->getAirQualityDataViaHTMLScrape($city);
if($mode==='html'){
?>
<link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet"> 
<body style="background:black;font-family: 'Roboto Slab';">
      <h1 style="color:white;text-align: center;font-family: 'Roboto Slab','Serif';font-weight: lighter;text-transform: uppercase;margin-bottom: 0;">Good morning, User Name</h1>
<h1 style="color:wheat;text-align: center;font-family: 'Roboto Slab','Serif';font-weight: lighter;text-transform: uppercase;margin-bottom: 0;/*! text-decoration: underline; */">The Air Quality Index reading for delhi today is:</h1>
<div class="whitebox" style="background-color:white;background: linear-gradient(white, lightgrey, white);margin-left: auto;margin-right: auto;border-radius: 4px;padding-bottom: 12px;padding-left: 12px;width: 45%;padding-right: 12px;">
<h1 style="color:<?php echo $aqiObject->AQIColour;?>;text-align: center;font-weight: lighter;font-family: 'Roboto Slab','Serif';font-size: 115px;margin-bottom: 0;"><?php echo $aqiObject->AQIValue;?></h1>
<h5 style="color:<?php echo $aqiObject->AQIColour;?>;text-align: center;font-weight: lighter;font-family: 'Roboto Slab','Serif';font-size: 212%;margin-top: 0px;text-transform: uppercase;margin-bottom: 0;text-decoration: underline;"><?php echo $aqiObject->AQIDescription;?></h5>
<h5 style="color:black;text-align: center;font-weight: lighter;font-family: 'Roboto Slab','Serif';font-size: 18px;margin-top: 10px;text-transform: uppercase;margin-bottom: 16px;"><?php echo $aqiObject->AQIHealthImplications;?></h5>
</div>
<p style="color:wheat;text-align: center;font-weight: lighter;font-family: 'Roboto Slab','Serif';font-size: 12px;margin-top: 10px;margin-bottom: 16px;">Powered by: wapi.info/aqjcn.org</h5>
<p style="color:wheat;text-align: center;font-weight: lighter;font-family: 'Roboto Slab','Serif';font-size: 12px;margin-top: 10px;text-transform: uppercase;margin-bottom: 16px;">SERVER GENERATED FOR USER NAME</h5>
</body>
<?php 
}
else{
    $mail = new Mail();
    $mail->sendMail($greeting,$username,$city,$aqiObject);
}
?>
