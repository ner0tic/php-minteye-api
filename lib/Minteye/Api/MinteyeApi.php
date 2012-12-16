<?php
namespace Minteye\Api;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;

use Core\Api\AbstractApi;
use Minteye\Client;

class MinteyeApi extends AbstractApi
{
  public function __construct(Client $client = null) 
  {
    $this->client = $client instanceof Client ? $client : new Client();
    
    $xml = simplexml_load_file( __DIR__ . '../Resources/config/minteye.xml' );
    foreach( $xml->parameters as $parameter )
    {
      $this->client->setOption($parameter->key, $parameter);
    }
    $this->client->setOption('certificate', false); // 'Resources/config/certificate.pem');
    
  }
}
