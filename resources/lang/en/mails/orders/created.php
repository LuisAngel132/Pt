<?php

return [
    'subject' => 'New order created',
    'title'   => "HEY :customer",
    'message' => 'Your new <strong>order</strong> was successfully created <br> Right below are all the details about your new <strong>order</strong>. <br> Check them out',
    'labels'  => [
        'products'            => [
            'title'    => 'Products',
            'quantity' => 'Quantity',
            'price'    => 'Price',
            'piece'    => '{1}pc|[2,*]pcs',
        ],
        'additional_products' => [
            'title' => 'Additional Products',
        ],
        'payment_via'         => 'Payment via',
        'shipped_to'          => 'Shipped to',
        'charges'             => [
            'title'     => 'Charges',
            'subtotal'  => 'Subtotal',
            'shipping'  => 'Shipping',
            'fees'      => 'Fees',
            'discounts' => 'Discounts',
        ],
        'oxxo_stores'         => 'OXXO Stores',
        'ref_number'          => 'Reference Number',
    ],
];
