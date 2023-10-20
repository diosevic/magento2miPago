<?php
/**
 * Chernandez_MiPago
 *
 * @category  Chernandez
 * @package   Chernandez_MiPago
 * @copyright Copyright © 2023. All rights reserved.
 * @author    cesarhndev@gmail.com
 */

namespace Chernandez\MiPago\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Chernandez\MiPago\Model\Config\MiPagoSettings;

class SetExtrachargeForOrder implements ObserverInterface
{
    /**
     * Saving extracharge field from quote to order
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        /** @var OrderInterface $order */
        $order = $observer->getEvent()->getOrder();
        $quote = $observer->getEvent()->getQuote();

        if ($order->getPayment() && $order->getPayment()->getMethod() === MiPagoSettings::DEFAULT_MIPAGO_LABEL) {
            $order->setExtracharge($quote->getExtracharge());
        }
    }
}
