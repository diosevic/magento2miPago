<?php
/**
 * Chernandez_MiPago
 *
 * @category  Chernandez
 * @package   Chernandez_MiPago
 * @copyright Copyright © 2023. All rights reserved.
 * @author    cesarhndev@gmail.com
 */
namespace Chernandez\MiPago\Model\Quote\Total;

use Chernandez\MiPago\Model\Config\ExtraChargeSettings;
use Magento\Quote\Api\Data\ShippingAssignmentInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Address\Total;
use Magento\Quote\Model\Quote\Address\Total\AbstractTotal as AddressAbstractTotal;

class ExtraCharge extends AddressAbstractTotal
{
    /**
     * @var ExtraChargeSettings
     */
    private ExtraChargeSettings $extraChargeSettings;

    /**
     * @param ExtraChargeSettings $extraChargeSettings
     */
    public function __construct(
        ExtraChargeSettings $extraChargeSettings
    ) {
        $this->extraChargeSettings = $extraChargeSettings;
    }

    /**
     * Collect totals
     *
     * @param Quote $quote
     * @param ShippingAssignmentInterface $shippingAssignment
     * @param Total $total
     * @return $this|ExtraCharge
     */
    public function collect(
        Quote $quote,
        ShippingAssignmentInterface $shippingAssignment,
        Total $total
    ) {
        $total->setTotalAmount($this->getCode(), 0);
        $total->setBaseTotalAmount($this->getCode(), 0);
        $total->setExtracharge(0);

        parent::collect($quote, $shippingAssignment, $total);
        $paymentMethod = $quote->getPayment()->getMethod();

        if (($paymentMethod === null) || !$this->extraChargeSettings->doApplyExtraCharge($paymentMethod)) {
            return $this;
        }

        $extraCharge = $this->extraChargeSettings->getExtraChargeAmount();
        $quote->setExtracharge($this->extraChargeSettings->getExtraChargeAmount());
        $total->setTotalAmount($this->getCode(), $extraCharge);
        $total->setBaseTotalAmount($this->getCode(), $extraCharge);
        $total->setExtracharge($extraCharge);

        return $this;
    }

    /**
     * Fetch extracharge
     *
     * @param Quote $quote
     * @param Total $total
     * @return array
     */
    public function fetch(Quote $quote, Total $total): array
    {
        return [
            [
                'code' => $this->getCode(),
                'title' => $this->extraChargeSettings->getExtraChargeLabel(),
                'value' => $this->extraChargeSettings->getExtraChargeAmount()
            ]
        ];
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return ExtraChargeSettings::EXTRACHARGE_KEY;
    }
}
