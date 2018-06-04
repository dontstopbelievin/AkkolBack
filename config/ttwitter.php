<?php

// You can find the keys here : https://apps.twitter.com/

return [
	'debug'               => function_exists('env') ? env('APP_DEBUG', false) : false,

	'API_URL'             => 'api.twitter.com',
	'UPLOAD_URL'          => 'upload.twitter.com',
	'API_VERSION'         => '1.1',
	'AUTHENTICATE_URL'    => 'https://api.twitter.com/oauth/authenticate',
	'AUTHORIZE_URL'       => 'https://api.twitter.com/oauth/authorize',
	'ACCESS_TOKEN_URL'    => 'https://api.twitter.com/oauth/access_token',
	'REQUEST_TOKEN_URL'   => 'https://api.twitter.com/oauth/request_token',
	'USE_SSL'             => true,

	'CONSUMER_KEY'        => function_exists('env') ? env('TWITTER_CONSUMER_KEY', '687FkYHF4RWTsqYboQAwibTzV') : '',
	'CONSUMER_SECRET'     => function_exists('env') ? env('TWITTER_CONSUMER_SECRET', 'vK4ThYqU1Mdn1Qtkfmz1uAIKUq9bZKVfc3pj7Enhhc3Ca19h6k') : '',
	'ACCESS_TOKEN'        => function_exists('env') ? env('TWITTER_ACCESS_TOKEN', '1002505773476442112-pE6rbJUH6asE4xNrKfZAsebzDJKqDn') : '',
	'ACCESS_TOKEN_SECRET' => function_exists('env') ? env('TWITTER_ACCESS_TOKEN_SECRET', 'rlKdorpTTn3Wos7JF8vBouTRfwhvVkX3Hl6jZC7R1ctVC') : '',
];
