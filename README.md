MinteyeBundle
=============

ORM agnostic php library to access minteye api

Installation
=============
Add to composer
```js
    "require": {
        "ner0tic/php-api-core":     "*",
        "ner0tic/php-minteye-api":   "*"
        // ...
```
Create your config file `app/config/minteye.xml`
```xml
  <parameters>
    <parameter key="minteye.url">http://api.adscaptcha.com/:path.aspx</parameter>
    <parameter key="minteye.captcha_id">XXXX</parameter>
    <parameter key="minteye.public_key">XXXXXXXXXXXXXXX</parameter>
    <parameter key="minteye.private_key">XXXXXXXXXXXXXXXX</parameter>
  </parameters>
```

Usage
=============

Client side (displaying) usage:
```php
$minteye = new \Minteye\Client();

$captcha = $minteye->generateCaptcha();
echo $captcha;
```

Server side (validating) usage:
```php
$minteye = new \Minteye\Client();

$challenge  = $_POST['adscaptcha_challenge_field'];
$response   = $_POST['adscaptcha_response_field'];

$validated = $minteye->ValidateCaptcha($challenge, $response, $_SERVER['REMOTE_ADDR']);

if( $validated )
{
  // validation passed, do stuff...
}
else
{
  // captcha check fail, show error message
}
```