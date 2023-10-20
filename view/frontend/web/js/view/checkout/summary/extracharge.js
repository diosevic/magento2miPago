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
        'Magento_Checkout/js/view/summary/abstract-total',
        'Magento_Checkout/js/model/totals'
    ],
    function (Component, totals) {
        "use strict";
        return Component.extend({
            defaults: {
                template: 'Chernandez_MiPago/checkout/summary/extracharge'
            },

            getValue: function() {
                return this.getFormattedPrice(this.getExtracharge());
            },
            getExtracharge: function (){
                let extracharge = 0;
                if (this.totals()) {
                    extracharge = totals.getSegment('extracharge').value;
                }
                return extracharge;
            }
        });
    }
);