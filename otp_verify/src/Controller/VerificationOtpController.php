<?php

namespace Drupal\otp_verify\Controller;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\otp_verify\service\SmsGatewayService;
use Drupal\otp_verify\service\VerificationCodeService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Handler of user Verification Otp code.
 */
class VerificationOtpController extends ControllerBase {
  /**
   * Sms Gateway Service.
   *
   * @var Drupal\otp_verify\Service\SmsGatewayService
   */
  protected $smsGatewayService;

  /**
   * Otp Verification code Service.
   *
   * @var Drupal\otp_verify\Service\VerificationCodeService
   */
  protected $verificationCodeService;

  /**
   * Constructs a new Class.
   *
   * @param Drupal\otp_verify\Service\SmsGatewayService $smsGatewayService
   *   The smsGateway.
   * @param Drupal\otp_verify\Service\VerificationCodeService $verificationCodeService
   *   The verificationCode.
   */
  public function __construct(
      VerificationCodeService $verificationCodeService,
      SmsGatewayService $smsGatewayService
  ) {
    $this->verificationCodeService = $verificationCodeService;
    $this->smsGatewayService = $smsGatewayService;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('otp_verify.verification_code'),
      $container->get('otp_verify.gateway')
    );
  }

  /**
   * Checks access for a specific request.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   Run access checks for this account.
   *
   * @return \Drupal\Core\Access\AccessResultInterface
   *   The access result.
   */
  public function access(AccountInterface $account) {
    // Check permissions and combine that with any custom access checking.
    // Needed pass forward parameters from the route and/or request as needed.
    return AccessResult::allowedIf(!$this->verificationCodeService->isVerified($account->id()));
  }

}
