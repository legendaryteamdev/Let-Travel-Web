<?php

$controller = 'MyProfile\Controller@';
$api->get('/', 				['as' => 'get', 			'uses' => $controller.'get']);
$api->put('/', 				['as' => 'put', 			'uses' => $controller.'put']);
$api->put('/change-password', 		['as' => 'change-password', 	'uses' => $controller.'changePassword']); //Update
$api->get('/logs', 					['as' => 'logs', 				'uses' => $controller.'logs']); 



//==============================================================>> Security
$controller = 'MyProfile\Security@';
//========================>> Email Verification
$api->get('/send-email-verify-code', 	['as' => 'send-email-verify-code', 	'uses' => $controller.'sendEmailVerifyCode']);
$api->get('/verify-email', 				['as' => 'verify-email', 			'uses' => $controller.'verifyEmail']);

//========================>> Phone Verification
$api->get('/send-phone-verify-code', 	['as' => 'send-phone-verify-code', 	'uses' => $controller.'sendPhoneVerifyCode']);
$api->get('/verify-phone', 				['as' => 'verify-phone', 			'uses' => $controller.'verifyPhone']);

//========================>> Telegram Service
$api->get('/check-telegram-account', 	['as' => 'check-telegram-account', 	'uses' => $controller.'checkTelegramAccount']);

//========================>> Google Auth
$api->get('/get-google-2fa-qr', 		['as' => 'get-google-2fa-qr', 		'uses' => $controller.'getGoogle2FAQR']);
$api->get('/verify-google-2fa', 		['as' => 'verify-google-2fa', 		'uses' => $controller.'verifyGoogle2FA']);
$api->get('/disable-google-2fa', 		['as' => 'disable-google-2fa', 		'uses' => $controller.'disableGoogle2FA']);

