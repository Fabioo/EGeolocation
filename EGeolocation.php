<?php

/**
 * EGeolocation API Free Class file for Yii
 * 
 * Gets data from ip informed via geolocation services free.
 * API Services:
 *  - FreeGeoIp
 *  - Ip-Api
 *  - Pycox
 *  - GeoPlugin
 *  - HostIp
 *  - PidGets
 * 
 * @author Fabio Pereira <fabiotheend@gmail.com>
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package YiiExtensions.components
 */
class EGeolocation extends CComponent{

    /**
     * @name apiname
     * @var type string
     */
    protected $apiname = null;

    /**
     * API Services
     * @var type array
     */
    protected $apis = array(
        'freegeoip',
        'ip_api',
        'pycox',
        'geoplugin_net',
        'hostipInfo',
        'pidgets'
    );

    /**
     * @method getIp
     * @todo Get address IP real
     * @return type string
     */
    function getIp() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    /**
     * Pidgets - Service Geolocation API
     * @param type $ip
     * @return type array()
     */
    function pidgets($ip) {

        $data = array();
        $response = $this->fetch('http://geoip.pidgets.com/?ip=' . $ip . '&format=json');

        if ($response) {
            $response = @json_decode($response);
            if ($response) {
                $data['country_name'] = $response->country_name;          // Brazil
                $data['country_code'] = $response->country_code;   // BR
                $data['region'] = $response->region;              // Rio de janeiro -> region
                $data['city'] = $response->city;                // Rio de janeiro -> city
                $data['latitude'] = $response->latitude;          // Latitude  
                $data['longitude'] = $response->longitude;        // Longitude  
            }
        }
        return $data;
    }

    /**
     * @method pycox
     * @todo Service Geolocation API
     * @link http://ip.pycox.com/json/ 
     * @param type $ip
     * @return type array();
     */
    function pycox($ip) {

        $data = array();
        $response = $this->fetch('http://ip.pycox.com/json/' . $ip);

        if ($response) {
            $response = @json_decode($response);
            if ($response) {
                $data['country_name'] = $response->country_name;          // Brazil
                $data['country_code'] = $response->country_code;   // BR
                $data['region'] = $response->region_name;         // Rio de janeiro -> region
                $data['city'] = $response->city;                // Rio de janeiro -> city
                $data['latitude'] = $response->latitude;          // Latitude  
                $data['longitude'] = $response->longitude;        // Longitude  
            }
        }
        return $data;
    }

    /**
     * HostIp.info - Service Geolocation
     * http://api.hostip.info/
     * @param type $ip
     * @return string
     */
    function hostipInfo($ip) {
        $data = array();
        $response = $this->fetch('http://api.hostip.info/get_json.php?ip=' . $ip);

        if ($response) {
            $response = @json_decode($response);
            if ($response) {
                $data['country_name'] = $response->country_name;          // Brazil
                $data['country_code'] = $response->country_code;   // BR
                $data['region'] = '';                             // Rio de janeiro -> region
                $data['city'] = $response->city;                // Rio de janeiro -> city
                $data['latitude'] = '';                           // Latitude  
                $data['longitude'] = '';                          // Longitude  
            }
        }
        return $data;
    }

    /**
     * ip-api.com - Service Geolocation
     * http://ip-api.com/json/
     * @param type $ip
     * @return type
     */
    function ip_api($ip) {

        $data = array();
        $response = $this->fetch('http://ip-api.com/json/' . $ip);

        if ($response) {
            $response = @json_decode($response);
            if ($response) {
                if ($response->status == 'success') {
                    $data['country_name'] = $response->country;                 // Brazil
                    $data['country_code'] = $response->countryCode;      // BR
                    $data['region'] = $response->regionName;            // Rio de janeiro -> region
                    $data['city'] = $response->city;                  // Rio de janeiro -> city
                    $data['latitude'] = $response->lat;                 // Latitude  
                    $data['longitude'] = $response->lon;                // Longitude  
                }
            }
        }
        return $data;
    }

    /**
     * FreeGeoIp.net
     * http://freegeoip.net/json/
     * @param type $ip
     * @return type array
     */
    function freegeoip($ip) {

        $data = array();
        $response = $this->fetch('http://freegeoip.net/json/' . $ip);

        if ($response) {
            $response = @json_decode($response);
            if ($response) {
                $data['country_name'] = $response->country_name;          // Brazil
                $data['country_code'] = $response->country_code;   // BR
                $data['region'] = $response->region_name;         // Rio de janeiro -> region
                $data['city'] = $response->city;                // Rio de janeiro -> city
                $data['latitude'] = $response->latitude;          // Latitude  
                $data['longitude'] = $response->longitude;        // Longitude  
            }
        }
        return $data;
    }

    /**
     * GeoPlugin.net
     * http://www.geoplugin.net/php.gp?ip=
     * @param type $ip
     * @return type array
     */
    function geoplugin_net($ip) {

        $data = array();
        $response = $this->fetch('http://www.geoplugin.net/php.gp?ip=' . $ip);

        if ($response) {
            $response = @unserialize($response);
            if ($response) {
                $data['country_name'] = $response['geoplugin_countryName'];           // Brazil
                $data['country_code'] = $response['geoplugin_countryCode'];    // BR
                $data['region'] = $response['geoplugin_region'];              // Rio de janeiro -> region
                $data['city'] = $response['geoplugin_city'];                // Rio de janeiro -> city
                $data['latitude'] = $response['geoplugin_latitude'];          // Latitude  
                $data['longitude'] = $response['geoplugin_longitude'];        // Longitude  
            }
        }
        return $data;
    }

    /**
     * @method fetch
     * Fetches a URI and returns the contents of the call
     * EHttpClient could also be used
     * 
     * @param string $host
     * @see http://www.yiiframework.com/extension/ehttpclient/
     */
    protected function fetch($host) {

        $response = null;

        if (function_exists('curl_init')) {

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $host);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($ch);
            curl_close($ch);
        } else if (ini_get('allow_url_fopen')) {

            $response = @file_get_contents($host);
        }

        return $response;
    }

    /**
     * Locate - Gets data from ip informed via geolocation services free.
     * @author Fábio Pereira 
     * @link URL description
     * @param type $ip
     * @return type array
     */
    function locate($ip = null) {
        if (!isset($ip)) {
            $ip = $this->getIp();
        }
        $response = array();
        foreach ($this->apis as $api) {
            $response = $this->$api($ip);
            if (!empty($response)) {
                $this->apiname = $api;
                break;
            }
        }
        return $response;
    }

    /**
     * @method getApiName
     * @return type string
     */
    function getApiName() {
        return $this->apiname;
    }

}

?>
