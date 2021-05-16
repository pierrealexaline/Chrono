<?php

// Pierre Alexaline - infocarto.at.infocarto.fr - May,17,2021
// CHRONOPOST SOAP API - Shipping Service Simple Wrapper and connector in PHP

namespace App\Chrono;  

class Soap{

    const WSDL_SHIPPING_SERVICE = "https://ws.chronopost.fr/shipping-cxf/ShippingServiceWS?wsdl";
 
    /**
     * Check Soap PHP extension availability
    */
    public function soapCheck() : bool
    {
        if (!extension_loaded('soap')) {
            return false;
        }
        return true;
    }
    /**
     * Launch the Soap client with Chronopost wsdl and parameters
    */
    public function soapLaunch(array $params)
    {
        
        $chronopost_client = new \soapClient(self::WSDL_SHIPPING_SERVICE);
        $chronopost_client->soap_defencoding = 'UTF-8';
        $chronopost_client->decode_utf8 = false;

        return $chronopost_client->shipping($params);
    }
}
