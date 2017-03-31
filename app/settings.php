<?php

return [
	'settings' => [
		'displayErrorDetails' => true,

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/templates/',
        ],

		'logger' => [
			'name' => 'slim-list-app',
			'path' => __DIR__.'/../logs/app.log',
			'level'=> \Monolog\Logger::DEBUG
		]
	]
];