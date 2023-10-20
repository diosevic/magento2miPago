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

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class BaseConfig
{
    public const DEFAULT_MIPAGO_LABEL = 'mipago';

    /**
     * @var ScopeConfigInterface
     */
    protected ScopeConfigInterface $scopeConfig;
    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $storeManager;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }
    /**
     * @return string
     * @throws NoSuchEntityException
     */
    private function getStoreCode(): string
    {
        return $this->storeManager->getStore()->getCode();
    }

    /**
     * @param string $xmlPath
     * @return string
     * @throws NoSuchEntityException
     */
    public function getConfigValue(
        string $xmlPath
    ): string {
        $storeCode = $this->getStoreCode();

        return $this->scopeConfig->getValue($xmlPath, ScopeInterface::SCOPE_STORE, $storeCode);
    }

    /**
     * @param string $xmlPath
     * @return bool
     * @throws NoSuchEntityException
     */
    public function getConfigFlag(
        string $xmlPath
    ): bool {
        $storeCode = $this->getStoreCode();

        return $this->scopeConfig->isSetFlag($xmlPath, ScopeInterface::SCOPE_STORE, $storeCode);
    }
}
