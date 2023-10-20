<?php
/**
 * Chernandez_MiPago
 *
 * @category  Chernandez
 * @package   Chernandez_MiPago
 * @copyright Copyright © 2023. All rights reserved.
 * @author    cesarhndev@gmail.com
 */
namespace Chernandez\MiPago\Model\Config;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class ExtraChargeSettings extends BaseConfig implements ConfigProviderInterface
{
    public const XML_EXTRACHARGE_ENABLE_PATH = 'payment/mipago/enable_extracharge';
    public const XML_EXTRACHARGE_AMOUNT_PATH = 'payment/mipago/extracharge_amount';
    public const XML_EXTRACHARGE_LABEL_PATH = 'payment/mipago/extracharge_label';
    public const EXTRACHARGE_DEFAULT_LABEL = 'MiPago ExtraCharge';
    public const EXTRACHARGE_KEY = 'extracharge';

    /**
     * Get is MiPago payment is enabled
     *
     * @return bool
     */
    public function getIsExtraChargeEnabled(): bool
    {
        try {
            return $this->getConfigFlag(self::XML_EXTRACHARGE_ENABLE_PATH);
        } catch (NoSuchEntityException $e) {
            return false;
        }
    }

    /**
     * Get Amount of the extra-charge
     *
     * @return float
     */
    public function getExtraChargeAmount(): float
    {
        try {
            return (float)$this->getConfigValue(self::XML_EXTRACHARGE_AMOUNT_PATH);
        } catch (NoSuchEntityException $e) {
            return 0;
        }
    }

    /**
     * @return string
     */
    public function getExtraChargeLabel(): string
    {
        try {
            return $this->getConfigValue(self::XML_EXTRACHARGE_LABEL_PATH);
        } catch (NoSuchEntityException $e) {
            return self::EXTRACHARGE_DEFAULT_LABEL;
        }
    }

    /**
     * Check if we must apply extracharge
     *
     * @param string $paymentLabel
     * @return bool
     */
    public function doApplyExtraCharge(
        string $paymentLabel
    ): bool {
        return $this->getIsExtraChargeEnabled() && ($paymentLabel === self::DEFAULT_MIPAGO_LABEL);
    }

    /**
     * @return \array[][]
     */
    public function getConfig(): array
    {
        return [
            self::EXTRACHARGE_KEY => [
                    'label' => $this->getExtraChargeLabel(),
                    'enable' => $this->getIsExtraChargeEnabled()
            ]
        ];

    }
}
