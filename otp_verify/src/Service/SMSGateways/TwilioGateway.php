<?php

namespace Drupal\otp_verify\Service\SMSGateways;

use Twilio\Rest\Client;

/**
 * Handling Twilio sms gateway.
 *
 * @package Drupal\otp_verify\Service\SMSGateways.
 */
class TwilioGateway {

  /**
   * Send sms message using twilio gateway.
   *
   * @param string $phone
   *   User phone number.
   * @param string $message
   *   Message text.
   *
   * @throws \Exception
   */
  public function sendMessage($phone, $message = ''): void {
    try {
      $config = \Drupal::config('otp_verify.settings');
      $key_repository = \Drupal::service('key.repository');

      // Your Account SID from www.twilio.com/console.
      $sid = $key_repository
        ->getKey($config->get('sender_id'))
        ->getKeyValue();
      // Your Auth Token from www.twilio.com/console.
      $token = $key_repository
        ->getKey($config->get('token'))
        ->getKeyValue();
      // From a valid Twilio number.
      $provider = $config->get('provider_number');
      $client = new Client($sid, $token);
      $message = $client->messages->create(
        $phone,
        [
          'from' => $provider,
          'body' => $message,
        ]
      );

      if ($message->sid) {
        \Drupal::messenger()->addMessage(t('Verification otp code sent successfully'));
      }
    }
    catch (\Exception $ex) {
      throw new \Exception($ex->getMessage());
    }
  }

}
