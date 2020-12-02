<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Define Ajax Request
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

define('USER_IMG_NA', './assets/front/uploads/user.jpg');

//
define('MYSQL_TIME_ZONE', '+5:00');
define('APP_TIME_ZONE', 'Asia/Karachi');
date_default_timezone_set(APP_TIME_ZONE);

define('IS_CATALOG', false);
define('IS_BRAND', true);
define('CHK_MAX_QTY', false);
define('CURRENCY', 'Rs. ');
define('ZERO_PRICE', '<p><span class="price" id="price-0"><span class="currency-symbol">Rs. </span>0</span></p>');//Free || 0
define('CURRENCY_DECIMALS', 2);
define('WATERMARK', false);
define('SHIPPING_BILLING_ADD', false);
define('UPDATE_CART', false);
/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */