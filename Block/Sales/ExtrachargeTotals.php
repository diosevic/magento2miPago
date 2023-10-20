<?php
/**
 * Chernandez_MiPago
 *
 * @category  Chernandez
 * @package   Chernandez_MiPago
 * @copyright Copyright © 2023. All rights reserved.
 * @author    cesarhndev@gmail.com
 */

namespace Chernandez\MiPago\Block\Sales;

use Chernandez\MiPago\Model\Config\ExtraChargeSettings;
use Magento\Framework\DataObjectFactory;
use Magento\Framework\View\Element\Template;

class ExtrachargeTotals extends Template
{
    /**
     * @var DataObjectFactory
     */
    protected $dataObjectFactory;

    /**
     * @var ExtraChargeSettings
     */
    private $extraChargeSettings;

    /**
     * @param Template\Context $context
     * @param DataObjectFactory $dataObjectFactory
     * @param ExtraChargeSettings $extraChargeSettings
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        DataObjectFactory $dataObjectFactory,
        ExtraChargeSettings $extraChargeSettings,
        array $data = []
    ) {
        $this->dataObjectFactory = $dataObjectFactory;
        $this->extraChargeSettings = $extraChargeSettings;
        parent::__construct($context, $data);
    }

    /**
     * @return $this
     */
    public function initTotals()
    {
        $parentBlock = $this->getParentBlock();
        $order = $parentBlock->getSource();

        if ($order->getExtracharge() > 0) {
            $extracharge = $order->getExtracharge();
            $extrachargeTotal = [
                'code' => ExtraChargeSettings::EXTRACHARGE_KEY,
                'strong' => false,
                'value' => $extracharge,
                'base_value' => $extracharge,
                'label' => $this->extraChargeSettings->getExtraChargeLabel(),
            ];

            $parentBlock->addTotal($this->dataObjectFactory->create()->setData($extrachargeTotal));
        }

        return $this;
    }
}
