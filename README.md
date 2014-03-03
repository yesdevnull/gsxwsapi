# GSX Web Services API
A PHP Class by Dan "theblahman" Barrett

This class is intended for AASPs only

**This project is no longer maintained as I'm no longer a member of an AASP**

Web: http://theblahman.net

Content Outputs:
* PHP
* JSON
* .plist

## REQUIRES

* PHP 5.3 and greater
* SOAP module for PHP
* JSON module for PHP

## USAGE

### INSTANTIATION
```php
require_once ( 'gsxwsapi/gsx.php' );
	
$details = array (
	'apiMode'			=> 'production',
	'regionCode'		=> 'apac',
	'userId'			=> 'user@example.net',
	'password'			=> 'professor',
	'serviceAccountNo'	=> '0000XXXXXX',
	'languageCode'		=> 'en',
	'userTimeZone'		=> 'AEST' ,
	'returnFormat'		=> 'php' ,
);
	
$gsx = new GSX ( $details );
```

### OBTAIN WARRANTY FROM SERIAL NUMBER
```php
$gsx->lookup ( 'SERIALNUM' , 'warranty' );
```

### LIST PARTS FOR SERIAL
```php
$gsx->part ( 'SERIALNUM' );
```

OR

```PHP
$gsx->part ( array ( 'serialNumber' => 'SERIALNUM' ) );
```

Or to specify certain parts within a serial number, combine serial number with a part description to get a filtered list:

```php
$gsx->part ( array ( 'serialNumber' => 'SERIALNUM' , 'partDescription' => 'fan' ) );
```

### PART DETAILS AND INFO
```php
$gsx->part ( '922-9225' );
```

OR

```php
$gsx->part ( array ( 'partNumber' => '922-9225' ) );
```

## FUTURE PLANS

I hope to provide much nicer output than what is currently present.

Current:
```php
array(1) {
  ["PartsLookupResponse"]=>
  array(3) {
    ["operationId"]=>
    string(23) "miscOpId"
    ["parts"]=>
    array(9) {
      ["partDescription"]=>
      string(3) "Fan"
      ["eeeCode"]=>
      string(0) ""
      ["exchangePrice"]=>
      string(1) "0"
      ["laborTier"]=>
      string(4) "LAB1"
      ["partNumber"]=>
      string(8) "922-9643"
      ["partType"]=>
      string(11) "Replacement"
      ["stockPrice"]=>
      string(4) "20.8"
      ["componentCode"]=>
      string(1) "1"
      ["isSerialized"]=>
      string(1) "N"
    }
    ["communicationMessage"]=>
    string(0) ""
  }
}
```

I'd ideally like to provide cleaner output along with HTTP style codes; in fact, codes will copy current HTTP/1.1 codes.

Planned:
```php
array(1){
	["ResponseArray"]=>
	array(4) {
		["type"]=>
		string(6) "output"
		["code"]=>
		string(3) "200"
		["responseData"]=>
		array(9) {
			["partDescription"]=>
			string(3) "Fan"
			["eeeCode"]=>
			string(0) ""
			["exchangePrice"]=>
			string(1) "0"
			["laborTier"]=>
			string(4) "LAB1"
			["partNumber"]=>
			string(8) "922-9643"
			["partType"]=>
			string(11) "Replacement"
			["stockPrice"]=>
			string(4) "20.8"
			["componentCode"]=>
			string(1) "1"
			["isSerialized"]=>
			string(1) "N"
		}
		["urgentMessage"]=>
		string(0) ""
	}
}
```

Coming soon:
* Clean display of content along with appropriate return codes
* _hopefully_ clean error output

[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/yesdevnull/gsxwsapi/trend.png)](https://bitdeli.com/free "Bitdeli Badge")

