# Chrono
A chronopost Soap Api connector for create PDF Sky bill

## installation

Download or clone these repository and use composer :

``` composer install ```

Then launch a local server on public directory


## Usage

This class implement a client soap server from the native php soap server class.
The wsdl is configured and embeded in a constant in the Chrono\Stickers class.
All the parametters ara configured externaly in an array.


### Exemple :

See index.php and change the variables (at least the account id and password.)

 
## Source

chronopost official documentation (see docts directory)
https://github.com/bvrignaud/chronopost