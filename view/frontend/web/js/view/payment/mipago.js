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
    'uiComponent',
    'Magento_Checkout/js/model/payment/renderer-list'
  ],
  function (Component, rendererList) {
    'use strict';
    const isEnabled = window.checkoutConfig.payment.mipago.enable;
    if (isEnabled) {
        rendererList.push(
            {
                type: 'mipago',
                component: 'Chernandez_MiPago/js/view/payment/method-renderer/payment_method'
            }
        );
    }
    return Component.extend({});
  }
);
