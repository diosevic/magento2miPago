<?php
/**
 * Chernandez_MiPago
 *
 * @category  Chernandez
 * @package   Chernandez_MiPago
 * @copyright Copyright © 2023. All rights reserved.
 * @author    cesarhndev@gmail.com
 */
namespace Chernandez\MiPago\Plugin;

use Chernandez\MiPago\Model\Config\ExtraChargeSettings;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\Data\CartExtension;
use Magento\Quote\Api\Data\CartExtensionFactory;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Api\Data\CartSearchResultsInterface;

/**
 * Class CartRepositoryPlugin
 */
class CartRepositoryPlugin
{
    /**
     * @var CartExtensionFactory
     */
    private $extensionFactory;

    /**
     * @var ExtraChargeSettings
     */
    private $extraChargeSettings;

    public function __construct(
        CartExtensionFactory $orderExtensionFactory,
        ExtraChargeSettings $extraChargeSettings
    ) {
        $this->extensionFactory = $orderExtensionFactory;
        $this->extraChargeSettings = $extraChargeSettings;
    }

    /**
     * @param CartRepositoryInterface $subject
     * @param CartInterface $resultEntity
     * @return CartInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGet(
        CartRepositoryInterface $subject,
        CartInterface $resultEntity
    ) {
        /** @var CartExtension $extensionAttributes */
        $extensionAttributes = $resultEntity->getExtensionAttributes() ?: $this->extensionFactory->create();
        $extensionAttributes->setExtracharge($resultEntity->getData('extracharge'));
        $resultEntity->setExtensionAttributes($extensionAttributes);

        return $resultEntity;
    }

    /**
     * @param CartRepositoryInterface $subject
     * @param CartSearchResultsInterface $resultCart
     * @return CartSearchResultsInterface
     */
    public function afterGetList(
        CartRepositoryInterface $subject,
        CartSearchResultsInterface $resultCart
    ) {
        foreach ($resultCart->getItems() as $order) {
            $this->afterGet($subject, $order);
        }

        return $resultCart;
    }

    /**
     * Saving extracharge for a quote
     * TODO. Remove workaround (find why native functionality extracharge is always 0)
     *
     * @param CartRepositoryInterface $subject
     * @param CartInterface $result
     * @return array
     */
    public function beforeSave(
        CartRepositoryInterface $subject,
        CartInterface $quote
    ) {
        $extensionAttributes = $quote->getExtensionAttributes() ?: $this->extensionFactory->create();
        if ($extensionAttributes !== null && $extensionAttributes->getExtracharge() !== null) {
            /*** START WORK AROUND ***/
            $paymentMethod = $quote->getPayment()->getMethod();
            if (($paymentMethod === null) || !$this->extraChargeSettings->doApplyExtraCharge($paymentMethod)) {
                $quote->setExtracharge($this->extraChargeSettings->getExtraChargeAmount());
            }
            /*** END WORK AROUND ***/
        }

        return [$quote];
    }
}
