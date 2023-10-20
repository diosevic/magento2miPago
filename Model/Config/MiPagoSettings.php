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

class MiPagoSettings extends BaseConfig implements ConfigProviderInterface
{
    public const XML_MIPAGO_ENABLE_PATH = 'payment/mipago/active';

    /**
     * Get is MiPago payment is enabled
     *
     * @return bool
     */
    public function getIsMiPagoEnabled(): bool
    {
        try {
            return $this->getConfigFlag(self::XML_MIPAGO_ENABLE_PATH);
        } catch (NoSuchEntityException $e) {
            return false;
        }
    }

    /**
     * @inheritDoc
     * @return array
     */
    public function getConfig()
    {
        return [
            'payment' => [
                self::DEFAULT_MIPAGO_LABEL => [
                    'enable' => $this->getIsMiPagoEnabled()
                ]
            ]
        ];
    }
}
