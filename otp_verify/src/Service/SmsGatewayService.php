<?php

namespace Drupal\otp_verify\service;

use Drupal\otp_verify\Service\SMSGateways\TwilioGateway;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Handler sms gateways messages.
 *
 * @package Drupal\otp_verify\Service.
 */
class SmsGatewayService {
  /**
   * Drupal\otp_verify\Service\SMSGateways\TwilioGateway definition.
   *
   * @var Drupal\otp_verify\Service\SMSGateways\TwilioGateway
   */
  private $smsGateway;

  /**
   * Constructor.
   *
   * @param Drupal\otp_verify\Service\TwilioGateway $smsGateway
   *   Sms gateway type.
   */
  public function __construct(TwilioGateway $smsGateway) {
    $this->smsGateway = $smsGateway;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('otp_verify.twilio')
    );
  }

  /**
   * Send sms message to user phone with verification message.
   *
   * @param string $phone
   *   User phone number.
   * @param string $message
   *   Verification message context.
   *
   * @throws \Exception
   */
  public function sendSmsMessage($phone, $message): void {
    $this->smsGateway->sendMessage($phone, $message);
  }

}
