<?php

namespace App\Http\Controllers\Commands;

use App\Http\Controllers\Controller;

class ManageStoreEntryController extends Controller
{
    /**
     * validate customer data
     * @return array[]
     */
    public static function validateCustomerData(): array
    {
        return [
          'first_name' => [
              'sometimes',
              'string'
          ],
            'last_name' => [
                'sometimes',
                'string'
            ],
            'company_name' => [
                'sometimes',
                'string'
            ],
            'address' => [
                'sometimes',
                'string'
            ],
            'city' => [
                'sometimes',
                'string'
            ],
            'email' => [
                'sometimes',
                'email'
            ],
            'phone' => [
                'sometimes',
                'string'
            ],
            'create_account' => [
                'sometimes',
                'boolean'
            ]
        ];
    }

    /**
     * validate payment data
     * @return array[]
     */
    public static function validatePaymentData(): array
    {
        return [
            'payment_method' => [
                'sometimes',
                'string'
            ],
            'paypal_account' => [
                'sometimes',
                'string'
            ],
            'bank_account' => [
                'sometimes',
                'string'
            ],
            'cheque_details' => [
                'sometimes',
                'string'
            ],
        ];
    }

    /**
     * validate order data
     * @return array[]
     */
    public static function validateOrderData(): array
    {
        return [
            'shipping_address' => [
                'sometimes',
                'string'
            ],
            'ship_to_different_address'=> [
                'sometimes',
                'boolean'
            ],
            'order_notes' => [
                'sometimes',
                'string'
            ],
            'product' => [
                'sometimes',
                'string'
            ],
            'quantity' => [
                'sometimes',
                'integer'
            ],
            'cart_subtotal' => [
                'sometimes',
                'decimal'
            ],
            'shipping_handling' => [
                'sometimes',
                'string'
            ],
            'order_total' => [
                'sometimes',
                'decimal'
            ]
        ];
    }
}
