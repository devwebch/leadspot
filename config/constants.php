<?php
/**
 * Created by PhpStorm.
 * User: srapin
 * Date: 17.08.16
 * Time: 21:12
 */
return [
	'maps' => [
		'icon_blue'  => '/img/icn_pin_blue.png',
		'icon_red'  => '/img/icn_pin_red.png',
	],
    'lead' => [
        'status' => [
            0   => 'lead.status.neutral',
            1   => 'lead.status.processing',
            2   => 'lead.status.accepted',
            3   => 'lead.status.denied'
        ]
    ],
    'cms'   => [
        'drupal'                => 'Drupal',
        'expressionengine'      => 'ExpressionEngine',
        'joomla'                => 'Joomla!',
        'liferay'               => 'LifeRay',
        'magento'               => 'Magento',
        'sitecore'              => 'SiteCore',
        'typo3'                 => 'Typo3',
        'vbulletin'             => 'vBulletin',
        'wordpress'             => 'WordPress'
    ]
];