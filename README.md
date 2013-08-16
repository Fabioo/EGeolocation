EGeolocation
============

Geolocation API Free Services for Yii framework

Gets data from ip informed via geolocation services Free.
   All Services:
 *  - FreeGeoIp  = http://freegeoip.net/
 *  - Ip-Api     = http://ip-api.com/
 *  - Pycox      = http://ip.pycox.com/
 *  - GeoPlugin  = http://www.geoplugin.net/
 *  - HostIp     = http://api.hostip.info/
 *  - PidGets    = http://pidgets.com/


Example:

Yii::import('ext.EGeolocation');

$Geolocation = new EGeolocation();
$data = $Geolocation->locate('187.15.205.239');

echo $data['country_name'];  // Brazil
echo $data['country_code'];  // BR
echo $data['region'];   // Rio de janeiro
echo $data['city'];   // Rio de janeiro
echo $data['latitude'];  // -22.9
echo $data['longitude']; // -43.2333


