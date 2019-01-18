# Appliance Library <img src="https://www.namirial.com/wp-content/uploads/logo-namirial-information-tecnology.png" width="50">
> Small PHP library for [Namirial SWS](https://www.firmacerta.it/index.php) services.

PHP Version  | Status  | Require
------------ | ------  | -------
PHP 7.2      | In Dev | Composer

> Install Library:

`composer require appliance/namirial-php`


> Start Appliance Object:

```
$namirial = new Appliance\Namirial\Service('ip address of sws');
```
💻 The class will connect via http protocol to your Web Service and load the functions from the WSDL
> Sign File (CAdES,XAdES,PAdES)

```
$namirial->sign('path/to/file/ALB1666197.xml'); 
```
🚀 The appliance will discover the file format automatically by choosing the most appropriate format for you 
