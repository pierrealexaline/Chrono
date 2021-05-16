<?php

require  './../vendor/autoload.php';

use App\Chrono\Soap;

// Simplified array for Chronopost Soap api client

$shipping_params = [ 
    // Chronopost account api password / Mot de passe Api Cgronopost
    'password'                      => 666666, 
    // Chronopost account / Compte client chronopost
    'headerValue'                   => [
        "accountNumber"             => '66666666',
        "subAccount"                => '',
        "idEmit"                    => 'CHRFR',
        "identWebPro"               => '',    
    ],
    // Shipper / Expediteur
    'shipperValue' => [
        "shipperCivility"           => 'M',
        "shipperName"               => 'George TENANT',
        "shipperName2"               => '',
        "shipperContactName"        => 'George TENANT',
        "shipperAdress1"            => '1 rue du Prés salé',
        "shipperAdress2"            => '',
        "shipperZipCode"            => '17000',
        "shipperCity"               => 'SAINTES',
        "shipperCountry"            => 'FR',
        "shipperCountryName"        => 'FRANCE',
        "shipperEmail"              => 'george.tenant@classe.com',
        "shipperPhone"              => '0611223344',  
        "shipperMobilePhone"        => '0611223344',
        "shipperPreAlert"           => 0,
    ],
    // Customer / Client
    'customerValue' => [
        "customerCivility"          => 'M',
        "customerName"              => 'Jeanne-Coralie BARTA',
        "customerName2"              => '',            
        "customerContactName"       => 'Jeanne-Coralie BARTA',
        "customerAdress1"           => '401 RUE JEAN FLOUZE',
        "customerAdress2"           => 'res 2 etage 3 porte 8',
        "customerCity"              => 'BIARRITZ',
        "customerZipCode"           => '64200',
        "customerCountry"           => 'FR',
        "customerCountryName"       => 'FRANCE',                                                                                       
        "customerEmail"             => 'jc@barta.com',
        "customerMobilePhone"       => '0624278556',
        "customerPhone"             => '0624278556',
        "customerPreAlert"          => 0,
    ],
    // Recipient / Destinataire
    'recipientValue' => [
        "recipientCivility"         => 'M',
        "recipientName"             => 'Joseph GARCIA',
        "recipientName2"             => '',
        "recipientContactName"      => 'Joseph GARCIA',
        "recipientAdress1"          => '40 RUE JEAN PASCOU',
        "recipientAdress2"          => '',
        "recipientCity"             => 'BIGANOS',
        "recipientZipCode"          => '33160',
        "recipientCountry"          => 'FR',
        "recipientCountryName"      => 'FRANCE',
        "recipientEmail"            => 'jdoe@doremi.fr',
        "recipientMobilePhone"      => '0644444444',
        "recipientPhone"            => '0644444444',
        "recipientPreAlert"         => 0,  
    ],
    // Sky Bill / Etiquette de livraison / Caractéristique du colis
    'skybillValue' => [
        "productCode"               => '86',            
        "weightUnit"                => 'KGM',           
        "shipDate"                  => date('c'),       
        "shipHour"                  => date('G'),      
        "weight"                    => 0.1,              
        "service"                   => '0',              
        "objectType"                => 'MAR',
        "evtCode"                   => 'DC', 
        "bulkNumber"                => 1, 
    ],
    // client's ref. value / Code barre client
    'refValue' => [
        "shipperRef"                => '',            
        "recipientRef"              => '',      
        "customerSkybillNumber"     => '',
        "PCardTransactionNumber"    => '',
    ],
    // Skybill Params Value / Etiquette de livraison - format de fichiers /datas
    'skybillParamsValue' => [
        "mode"           => 'PDF',
    ],
]; 

$chronopost_client = new App\Chrono\Soap();
if(false!==$chronopost_client->soapCheck()) {
    $chrono_id = uniqId();
    try {
        $result = $chronopost_client->soapLaunch($shipping_params);
    } catch (SoapFault $soapFault) {
        var_dump($soapFault);
        exit($soapFault->faultstring);
    }
    if ($result->return->errorCode) {
        echo 'Erreur n° ' . $result->return->errorCode . ' : ' . 
        $result->return->errorMessage;
        var_dump($result);
    } else {
        $fp = fopen('pdf/chronopost_'.trim($chrono_id).'.pdf', 'w');
        fwrite($fp, $result->return->skybill);
        fclose($fp);
        echo 'MaBoutique.fr -> récuperer mon etiquette en PDF : <a href="/pdf/chronopost_'.trim($chrono_id).'.pdf">chronopost '.trim($chrono_id).'</a><br>' . PHP_EOL;
    }
} else {
    echo "<p>Soap not installed. Install Soap with : <br><em><code>sudo apt-get install php-soap</code></em>
    and <em><code>sudo systemctl restart apache2</code></em>.<br>Sometimes you will have to change this line in php.ini : <br>
    <em><code>;extension=soap</code></em> to <em><code>extension=soap</code></em></p>";
}
 