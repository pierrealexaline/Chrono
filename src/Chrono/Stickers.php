<?php

namespace App\Chrono;  

class Stickers{

    const WSDL_SHIPPING_SERVICE = "https://ws.chronopost.fr/shipping-cxf/ShippingServiceWS?wsdl";

    public function __construct()
    {
        // Check SOAP availability
        if (!extension_loaded('soap')) {
            die('SOAP extension not available !');
        }
    }

    public function createPDF(array $params)
    {
        
        $chronopost_client = new \soapClient(self::WSDL_SHIPPING_SERVICE);
        $chronopost_client->soap_defencoding = 'UTF-8';
        $chronopost_client->decode_utf8 = false;

        return $chronopost_client->shipping($params);
    }

}
