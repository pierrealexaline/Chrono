# Chrono

A chronopost Soap Api connector for create Sky bill PDF 

## installation

- Download or clone these repository and use composer :

``` composer install ```

- Then launch a local server on public directory
  
``` php -S localhost:8000 ```

- [ Do not forget to made RW public/pdf/ for generate pdf in the index.php exemple ]

## Usage

This class implement a client soap server from the native php soap server class.
The wsdl is configured and embeded in a constant in the Chrono\Soap class.
All the others parameters ara configured externaly in an array.

### Exemple of how to lauch the soap server and get results or catch exceptions

See index.php for  simplified array of chronopost api parameters to print PDF stickers / Sky bill,
and change this variables by your own (at least the account id and password)...

```
// public/index.php

require  './../vendor/autoload.php';

use App\Chrono\Soap;

// ...

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
 
```

### exemple of a complete array of parameters

```
// public/index.php

$shipping_params = [ 
    // Chronopost account api password / Mot de passe Api Cgronopost
    'password'                  => 666666,                                      //YOUR CHRONOPOST API PASSWORD ex : 666666       *******************  CHANGE WITH YOUR   
    // Chronopost account / Compte client chronopost
    'headerValue'                   => [
        "accountNumber"             => '66666666',                              //YOUR CHRONOPOST ACCOUNT NUMBER ex : 58879868   *******************  CHANGE WITH YOUR 
        "subAccount"                => '',
        "idEmit"                    => 'CHRFR',                                 // Chronopost FR (string)
        "identWebPro"               => '',                                      // string
    ],
    // Shipper / Expediteur
    'shipperValue' => [
        "shipperAdress1"            => '1 rue du Général',
        "shipperAdress2"            => '',
        "shipperCity"               => 'RODEZ',
        "shipperCivility"           => 'M',
        "shipperContactName"        => 'George TENANT',
        "shipperCountry"            => 'FR',
        "shipperCountryName"        => 'FRANCE',
        "shipperEmail"              => 'george.tenant@classe.com',              
        "shipperMobilePhone"        => '0611223344',
        "shipperName"               => 'George TENANT',                         
        "shipperName2"              => '',
        "shipperPhone"              => '0611223344',                            
        "shipperPreAlert"           => 0,                                       // @var intType de préalerte (MAS) -> 0 : pas de préalerte | 11 : abonnement tracking expéditeur 
        "shipperZipCode"            => '12000',
    ],
    // Customer / Client
    'customerValue' => [
        "customerAdress1"           => '40 RUE J. JAURES',
        "customerAdress2"           => 'res 2 etage 3 porte 8',
        "customerCity"              => 'BIARRITZ',
        "customerCivility"          => 'M',
        "customerContactName"       => 'Jeanne-Coralie BARTA',
        "customerCountry"           => 'FR',
        "customerCountryName"       => 'FRANCE',                                                                                       
        "customerEmail"             => 'jc@coralie.com',                        
        "customerMobilePhone"       => '0624278556',                            
        "customerName"              => 'Jeanne-Coralie BARTA',                  
        "customerName2"             => '',                                      
        "customerPhone"             => '0624278556',                            
        "customerPreAlert"          => 0,                                       
        "customerZipCode"           => '64200',                                 
        "printAsSender"             => 'N',                                     // Utiliser comme expediteur sur l'etiquette finale O/N
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
    // Sky Bill / Etiquette de livraison / Caractéristique du colis
    'skybillValue' => [
        "productCode"               => '86',            // Code Produit Chronopost [0 : Chrono Retrait Bureau | 1 : Chrono 13 | 86 : Chrono Relais | cf Docts ANNEXE 8 ]
        "weightUnit"                => 'KGM',           // Unité poids | defaut: KGM (Kilogrammes) | recommandation 20 de l’UN/ECE
        "shipDate"                  => date('c'),       // Date d'expédition (dateTime)
        "shipHour"                  => date('G'),       // Heure d'expédition - Heure de génération de l'envoi (heure  courante), entre 0 et 23 - (int)
        "weight"                    => 0.4,               // Poids en KG (float)
        "service"                   => '0',             // Jour de livraison : 0 - Normal | 1 - Livraison lundi (FR) | 6 - Livraison samedi (FR) (string)
        "objectType"                => 'MAR',           // Type colis (DOC:documents/MAR:marchandises) (string)
        "bulkNumber"                => 1,               // Nombre total de colis
        "codCurrency"               => 'EUR',           // Devise du Retour Express de paiement EUR (Euro) par defaut
        "codValue"                  => 0,               // Valeur Retour Express paiement
        "customsCurrency"           => 'EUR',           // Devise valeur déclarée en douane (string)
        "customsValue"              => 0,               // Valeur déclarée en douane (int)
        "evtCode"                   => 'DC',            // Code événement suivi Chronopost - Champ fixe : DC (string)
        "insuredCurrency"           => 'EUR',           // Devise valeur assurée (string)
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
        "customerSkybillNumber"     => '',              // string Numéro colis client 15 carac max -> code barre A4 - ex 123456789
        "PCardTransactionNumber"    => '',              // string             
        "recipientRef"              => '',              // string Référence Destinataire - Champ libre (imprimable sur la facture) - critère de recherche suivi (ex: '24') (*)
        "shipperRef"                => '',              // string Référence Expéditeur - Champ libre (imprimable sur la facture) - critère de recherche suivi -> 
                                                        // * Chrono Relais (86), Chrono Relais 9 (80), Chrono Relais Europe (3T)*  et Chrono Zengo Relais 13 (3K) 
                                                        // remplir avec code du point relais Réf Expéditeur (ex: '000000000000001')
    ],
    // Skybill Params Value / Etiquette de livraison - format de fichiers /datas
    'skybillParamsValue' => [
        "mode"           => 'PDF',                          // Format final etiquette : default PDF | ...
    ],
];

```
## Todo

Make a functionnal wrapper for the entire Chronopost Soap API .... lot of work !

## Source

- chronopost official documentation (see docts directory)
- https://github.com/bvrignaud/chronopost