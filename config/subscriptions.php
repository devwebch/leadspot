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
        'limit' => 3
    ],
    'advanced'  => [
        'price' => 75,
        'limit' => 50
    ],
    'pro'       => [
        'price' => 125,
        'limit' => 100
    ]
];