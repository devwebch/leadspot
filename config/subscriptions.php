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
        'advanced',
        'pro'
    ],
    'label' => [
        'leadspot_free'      => 'LeadSpot Free',
        'leadspot_advanced'  => 'LeadSpot Advanced',
        'leadspot_pro'       => 'LeadSpot Pro'
    ],
	'free' => [
	    'price' => 0,
        'limit' => [
            'search'    => 50,
            'contacts'  => 10
        ]
    ],
    'advanced'  => [
        'price' => 75,
        'limit' => [
            'search'    => 200,
            'contacts'  => 100
        ]
    ],
    'pro'       => [
        'price' => 125,
        'limit' => [
            'search'    => 1000,
            'contacts'  => 500
        ]
    ]
];