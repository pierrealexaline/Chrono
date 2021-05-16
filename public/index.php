<?php
  
 
    require  './../vendor/autoload.php';

    use App\Chrono\Stickers; 

$shipping_params = [ 
    // Chronopost account api password / Mot de passe Api Cgronopost
    'password'                  => 666666,              //YOUR CHRONOPOST API PASSWORD ex : 666666       *******************  CHANGE WITH YOUR   
    // Chronopost account / Compte client chronopost
    'headerValue'                   => [
        "accountNumber"             => '66666666',      //YOUR CHRONOPOST ACCOUNT NUMBER ex : 58879868   *******************  CHANGE WITH YOUR 
        "subAccount"                => '',
        "idEmit"                    => 'CHRFR',         // Chronopost FR (string)
        "identWebPro"               => '',              // string
    ],
    // Shipper / Expediteur
    'shipperValue' => [
        "shipperAdress1"            => '1 rue du Général',
        "shipperAdress2"            => '',
        "shipperCity"               => 'Pom Pom Galli',
        "shipperCivility"           => 'M',
        "shipperContactName"        => 'George Abitbol',
        "shipperCountry"            => 'FR',
        "shipperCountryName"        => 'FRANCE',
        "shipperEmail"              => 'George.Abitbol@classe.com',
        "shipperMobilePhone"        => '0611223344',
        "shipperName"               => 'George',
        "shipperName2"              => 'Abitbol',
        "shipperPhone"              => '',
        "shipperPreAlert"           => 0,               // @var intType de préalerte (MAS) -> 0 : pas de préalerte | 11 : abonnement tracking expéditeur 
        "shipperZipCode"            => '50000',
    ],
    // Customer / Client
    'customerValue' => [
        "customerAdress1"           => '40 RUE J. JAURES',
        "customerAdress2"           => 'res 2 etage 3 porte 8',
        "customerCity"              => 'BIARRITZ',
        "customerCivility"          => 'M',
        "customerContactName"       => 'Jeanne-Coralie',
        "customerCountry"           => 'FR',
        "customerCountryName"       => 'FRANCE',
        "customerEmail"             => 'jc@coralie.com',
        "customerMobilePhone"       => '0624278556',
        "customerName"              => '',
        "customerName2"             => '',
        "customerPhone"             => '',
        "customerPreAlert"          => 0,               // not used
        "customerZipCode"           => '64200',
        "printAsSender"             => 'N', 
    ],
    // Recipient / Destinataire
    'recipientValue' => [
        "recipientAdress1"          => '40 RUE JEAN PASCOU',
        "recipientAdress2"          => '',
        "recipientCity"             => 'BIGANOS',
        "recipientContactName"      => 'Joe Doe',
        "recipientCountry"          => 'FR',
        "recipientCountryName"      => 'FRANCE',
        "recipientEmail"            => 'jdoe@doremi.fr',
        "recipientMobilePhone"      => '0644444444',
        "recipientName"             => '',
        "recipientName2"            => '',
        "recipientPhone"            => '',
        "recipientPreAlert"         => 0,
        "recipientZipCode"          => '33160',
        "recipientCivility"         => 'M',
    ],   
    // client's ref. value / Code barre client
    'refValue' => [
        "shipperRef"                => '',              // Réf Expéditeur (ex: '000000000000001')
        "recipientRef"              => '',              // Réf Destinataire (ex: '24')
        "customerSkybillNumber"     => '',              //123456789
    ],
    // Sky Bill / Etiquette de livraison / Caractéristique du colis
    'skybillValue' => [
        "productCode"               => '86',            // Code Produit Chronopost [0 : Chrono Retrait Bureau | 1 : Chrono 13 | 86 : Chrono Relais | cf ANNEXE 8 : CODES PRODUITS ACCEPTES PAR LE WS SHIPPING]
        "weightUnit"                => 'KGM',           // Unité de poids | defaut: KGM (Kilogrammes) | recommandation 20 de l’UN/ECE
        "shipDate"                  => date('c'),       // Date d'expédition (dateTime)
        "shipHour"                  => date('G'),       // Heure d'expédition - Heure de  génération  de  l'envoi  (heure  courante), doit être compris entre 0 et 23 - (int)
        "weight"                    => 2,               // Poids (float)
        "service"                   => '0',             // Jour de livraison : 0 - Normal | 1 - Livraison  lundi (uniquement  pour  les codes produits nationaux) | 6 - Livraison  samedi (uniquement  pour  les codes produits nationaux) (string)
        "objectType"                => 'MAR',           // Type de colis (DOC:documents/MAR:marchandises) (string)
        "bulkNumber"                => 1,               // Nombre total de colis
        "codCurrency"               => 'EUR',           // Devise  du  Retour  Express de paiement EUR (Euro) par defaut
        "codValue"                  => 0,               // Valeur  Retour  Express  de paiement
        "customsCurrency"           => 'EUR',           // Devise   de   la   valeur déclarée en douane (string)
        "customsValue"              => 0,               // Valeur déclarée en douane (int)
        "evtCode"                   => 'DC',            // Code  événement  de  suivi Chronopost - Champ fixe : DC (string)
        "insuredCurrency"           => 'EUR',           // Devise   de   la   valeur assurée (string)
        "insuredValue"              => 0,               // Valeur assurée (int)
        "masterSkybillNumber"       => '?',
        "portCurrency"              => 'EUR',           // string
        "portValue"                 => 0,               // float
        "skybillRank"               => 1,               // string  ?????
        "height"                    => '10', 
        "length"                    => '20', 
        "width"                     => '30',
    ],
    // Pickup On Request parameters / Paramètres Enlèvement Sur Demande
    'esdValue' => [
        "closingDateTime"           => '',              // dateTime
        "height"                    => '',              // float
        "length"                    => '',              // float
        "retrievalDateTime"         => '',              // dateTime
        "shipperBuildingFloor"      => '',              // string
        "shipperCarriesCode"        => '',              // string
        "shipperServiceDirection"   => '',              // string
        "specificInstructions"      => '',              // string
        "width"                     => '',              // float
    ],

    // Reference values / Valeurs de réference
    'refValue' => [
        "customerSkybillNumber"     => '',              // string Numéro de colis client 15 carac max -> code barre A4
        "PCardTransactionNumber"    => '',              // string             
        "recipientRef"              => '',              // string Référence Destinataire - Champ libre (imprimable sur la facture) - critère de recherche dans le suivi (*)
        "shipperRef"                => '',              // string Référence Expéditeur - Champ libre (imprimable sur la facture) - critère de recherche dans le suivi -> 
                                                        // * Chrono Relais (86), Chrono Relais 9 (80), Chrono Relais Europe (3T)*  et Chrono Zengo Relais 13 (3K) 
                                                        // remplir avec le code du point relais 
    ],
    // Skybill Params Value / Etiquette de livraison - format de fichiers /datas
    'skybillParamsValue' => [
        "mode"           => 'PDF',                          // Format final etiquette : default PDF | ...
    ],
];

  
        
$chronopost_client = new App\Chrono\Stickers();

try {
    $result = $chronopost_client->createPDF($shipping_params);
} catch (SoapFault $soapFault) {
    var_dump($soapFault);
    exit($soapFault->faultstring);
}

if ($result->return->errorCode) {
    echo 'Erreur n° ' . $result->return->errorCode . ' : ' . $result->return->errorMessage;
    var_dump($result);
} else {
    // ...get PDF ex : print in a file
    $fp = fopen('pdf/data.pdf', 'w');
    fwrite($fp, $result->return->skybill);
    fclose($fp);
    echo 'OK';
}