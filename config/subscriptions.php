<?php
/**
 * Created by PhpStorm.
 * User: srapin
 * Date: 17.08.16
 * Time: 21:12
 */
return [
    'types' => [
        'free',
        'boutique',
        'company',
        'agency'
    ],
    'label' => [
        'leadspot_free'      => 'LeadSpot Free',
        'leadspot_boutique'  => 'LeadSpot Boutique',
        'leadspot_company'   => 'LeadSpot Company',
        'leadspot_agency'    => 'LeadSpot Agency'
    ],
	'free' => [
	    'price' => 0,
        'limit' => [
            'search'    => 30,
            'contacts'  => 10,
            'teamsize'  => 0
        ]
    ],
    'boutique'  => [
        'price' => 49,
        'limit' => [
            'search'    => 200,
            'contacts'  => 100,
            'teamsize'  => 1
        ]
    ],
    'company'   => [
        'price' => 129,
        'limit' => [
            'search'    => 1000,
            'contacts'  => 500,
            'teamsize'  => 3
        ]
    ],
    'agency'    => [
        'price' => 499,
        'limit' => [
            'search'    => 2000,
            'contacts'  => 1000,
            'teamsize'  => 1000
        ]
    ]
];