<?php

return [
    'subject' => 'Nuevo pedido solicitado',
    'title'   => "HOLA :customer",
    'message' => 'Tu nuevo <strong>pedido</strong> ha sido creado con éxito <br> A continuación, encontrarás todos los detalles sobre tu <strong>pedido</strong> <br> Echa un vistazo',
    'labels'  => [
        'products'            => [
            'title'    => 'Productos',
            'quantity' => 'Cantidad',
            'price'    => 'Precio',
            'piece'    => '{1}pza|[2,*]pzas',
        ],
        'additional_products' => [
            'title' => 'Productos Adicionales',
        ],
        'payment_via'         => 'Forma de pago',
        'shipped_to'          => 'Enviado a',
        'charges'             => [
            'title'     => 'Cargos',
            'subtotal'  => 'Subtotal',
            'shipping'  => 'Envíos',
            'fees'      => 'Comisiones',
            'discounts' => 'Descuentos',
        ],
        'oxxo_stores'         => 'Tiendas OXXO',
        'ref_number'          => 'Número de Referencia',
    ],
];
