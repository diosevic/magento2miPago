/**
 * Chernandez_MiPago
 *
 * @category  Chernandez
 * @package   Chernandez_MiPago
 * @copyright Copyright © 2023. All rights reserved.
 * @author    cesarhndev@gmail.com
 */

define(
    [
        'Chernandez_MiPago/js/view/checkout/summary/extracharge',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/checkout-data',
        'ko'
    ],
    function (Component, quote, checkoutData, ko) {
        'use strict';
        return Component.extend({
            totals: quote.getTotals(),
            title: window.checkoutConfig.extracharge.label,

            /**
             * @override
             */
            isDisplayed: function () {
                return checkoutData.getSelectedPaymentMethod() === 'mipago';
            }
        });
    }
);