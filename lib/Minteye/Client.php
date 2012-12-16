<?php

  namespace Minteye;

  use Core\Api\AbstractApi;
  

  class Client extends AbstractApi 
  {
      /**
       * Api
       * @param string $name
       * @return api type
       * @throws \InvalidArgumentException
       */
      public function api($name) 
      {
        if ( ! isset( $this->apis[ $name ] ) ) {
          switch ( $name ) 
          {
            case 'minteye':
              $api = new Api\MinteyeApi( $this );
              break;
            default:
              throw new \InvalidArgumentException();
              break;
          }
          $this->apis[ $name ] = $api;
        }
        
        return $this->apis[ $name ];
      }
      
      public function GenerateCaptcha( $asHtml = true ) 
      {
          $dummy = rand( 1, 9999999999 );
          $params = $this->buildParams( array( 'dummy' => $rand ) );
          	
          $result  = "<script src='" . $this->Get('Get', $params ) . "' type='text/javascript'></script>\n";
          $result .= "<noscript>\n";
          $result .= "\t<iframe src='" . $this->Get('NoScript', $params) . "' width='300' height='100' frameborder='0'></iframe>\n";
          $result .= "\t<table>\n";
          $result .= "\t<tr><td>Type challenge here:</td><td><input type='text' name='adscaptcha_response_field' value='' /></td></tr>\n";
          $result .= "\t<tr><td>Paste code here:</td><td><input type='text' name='adscaptcha_challenge_field' value='' /></td></tr>\n";
          $result .= "\t</table>\n";
          $result .= "</noscript>\n";

          return $result;
      }

      public function ValidateCaptcha( $challengeValue, $responseValue, $remoteAddress )
      {
          $params = $this->buildParams( 
                  array(
                      "ChallengeCode"   =>  $challengeValue,
                      "UserResponse"    =>  $responseValue,
                      "RemoteAddress"   =>  $remoteAddress
                  ));

          $result = $this->browser->submit(str_replace( ':path', 'Validate', $this->getOption( 'url' ) ), $params);

          return $result;
      }
      
      private function buildParams( $params = array() )
      {
        return array_merge( $params, array(
            'CaptchaId'   =>  $this->getOption('captcha_id'),
            'PublicKey'   =>  $this->getOption('public_key'),
            'PrivateKey'  =>  $this->getOption('private_key')
        ));
      }
  }
