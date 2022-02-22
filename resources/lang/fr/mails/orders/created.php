<?php

return [
    'subject' => 'Nouvel ordre créé',
    'title'   => "HEY :customer",
    'message' => "Votre nouvelle <strong>commande</strong> a été créée avec succès. <br> Ci-dessous se trouvent tous les détails de votre nouvelle <strong>commande</strong>. <br> Jetez un coup d'œil",
    'labels'  => [
        'products'            => [
            'title'    => 'Produits',
            'quantity' => 'Quantité',
            'price'    => 'Prix',
            'piece'    => '{1}pce.|[2,*]pcs.',
        ],
        'additional_products' => [
            'title' => 'Produits Additionnels',
        ],
        'payment_via'         => 'Paiements',
        'shipped_to'          => 'Envois',
        'charges'             => [
            'title'     => 'Cargos',
            'subtotal'  => 'Sous-total',
            'shipping'  => 'Envois',
            'fees'      => 'Commissions',
            'discounts' => 'Remises',
        ],
        'oxxo_stores'         => 'Magasins OXXO',
        'ref_number'          => "Numéro de Référence",
    ],
];
