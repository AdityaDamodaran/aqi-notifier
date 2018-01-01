<?php
spl_autoload_register(function ($class_name) {
    if (file_exists(__DIR__ . $class_name . '.php')) {
        include __DIR__ . $class_name . '.php';
    }
});

class APIClient
{

    function getHealthImplication($AQIDescription)
    {
        $healthImplications['Good'] = "Enjoy your usual outdoor activities.";
        $healthImplications['Moderate'] = "Adults and children with lung problems, and adults with heart problems, who experience symptoms, should consider reducing strenuous physical activity, particularly outdoors. 	Enjoy your usual outdoor activities.";
        $healthImplications['Unhealthy for Sensitive Groups'] = "Adults and children with lung problems, and adults with heart problems, should reduce strenuous physical exertion, particularly outdoors, and particularly if they experience symptoms. People with asthma may find they need to use their reliever inhaler more often. Older people should also reduce physical exertion. 	Anyone experiencing discomfort such as sore eyes, cough or sore throat should consider reducing activity, particularly outdoors.";
        $healthImplications['Unhealthy'] = "Adults and children with lung problems, and adults with heart problems, should reduce strenuous physical exertion, particularly outdoors, and particularly if they experience symptoms. People with asthma may find they need to use their reliever inhaler more often. Older people should also reduce physical exertion. 	Anyone experiencing discomfort such as sore eyes, cough or sore throat should consider reducing activity, particularly outdoors.";
        $healthImplications['Very Unhealthy'] = "Adults and children with lung problems, adults with heart problems, and older people, should avoid strenuous physical activity. People with asthma may find they need to use their reliever inhaler more often. 	Reduce physical exertion, particularly outdoors, especially if you experience symptoms such as cough or sore throat.";
        $healthImplications['Hazardous'] = "You might want to find a gas mask";
        $healthImplications['Apocalyptic'] = "Get out of there ASAP!";
        return $healthImplications[$AQIDescription];
    }

    function getAQIDescription($AQIValue)
    {
        if ($AQIValue <= 50)
            return 'Good';
        if ($AQIValue <= 100)
            return 'Moderate';
        if ($AQIValue <= 150)
            return 'Unhealthy for Sensitive Groups';
        if ($AQIValue <= 200)
            return 'Unhealthy';
        if ($AQIValue <= 300)
            return 'Very Unhealthy';
        if ($AQIValue <= 499)
            return 'Hazardous';
        return 'Apocalyptic';
    }

    function getAQIColour($AQIDescription)
    {
        if ($AQIDescription === 'Good')
            return '#009966';
        if ($AQIDescription === 'Moderate')
            return '#ffde33';
        if ($AQIDescription === 'Unhealthy for Sensitive Groups')
            return '#ff9933';
        if ($AQIDescription === 'Unhealthy')
            return '#cc0033';
        if ($AQIDescription === 'Very Unhealthy')
            return '#660099';
        if ($AQIDescription === 'Hazardous')
            return 'red';
        return 'red';
    }

    function getAirQualityDataViaAPI($stationID, $apiToken)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://api.waqi.info/feed/@" . $stationID . "/?token=" . $apiToken);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $output = json_decode($output);
        curl_close($ch);
        $out = new AQIObject();
        $out->AQIValue = $output->data->aqi;
        $out->AQIDescription = $this->getAQIDescription($out->AQIValue);
        $out->AQIHealthImplications = $this->getHealthImplication($out->AQIDescription);
        $out->AQIColour = $this->getAQIColour($out->AQIDescription);
        
        return $out;
    }

    function getAirQualityDataViaHTMLScrape($cityName)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://aqicn.org/city/" . $cityName);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        // preg_match('/<div class="aqivalue" id="aqiwgtvalue" style=" font-size:80px; background-color: #7e0023;color:#ffffff; " title="(?P<description>[A-Za-z]*)">(?P<value>[0-9]*)<\/div>/', $output,$matches);
        // preg_match("/<div class=\"aqivalue\" id=\"aqiwgtvalue\" style=\" font-size:80px; background-color: #7e0023;color:#ffffff; \" title=\"(?P<description>[A-Za-z]*)\">(?P<value>[0-9]*)<\/div>/", $output, $matches);
        curl_close($ch);
        libxml_use_internal_errors(true);
        $doc = new DomDocument();
        $doc->validateOnParse = true;
        $doc->loadHTML($output);
        $out = new AQIObject();
        $out->AQIValue = $doc->getElementById('aqiwgtvalue')->nodeValue;
        $out->AQIDescription = $doc->getElementById('aqiwgtvalue')->getAttribute('title');
        if ($out->AQIValue >= 500)
            $out->AQIDescription = 'Apocalyptic';
        $out->AQIHealthImplications = $this->getHealthImplication($out->AQIDescription);
        $out->AQIColour = $this->getAQIColour($out->AQIDescription);
        return $out;
    }
}
?>