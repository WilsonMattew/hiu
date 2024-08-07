<?php
/*
- Use PAYTM_ENVIRONMENT as 'PROD' if you wanted to do transaction in production environment else 'TEST' for doing transaction in testing environment.
- Change the value of PAYTM_MERCHANT_KEY constant with details received from Paytm.
- Change the value of PAYTM_MERCHANT_MID constant with details received from Paytm.
- Change the value of PAYTM_MERCHANT_WEBSITE constant with details received from Paytm.
- Above details will be different for testing and production environment.
*/

// GETTING PAYTM KEYS
$paytm_keys = json_decode(get_settings('paytm_keys'), true);

define('PAYTM_ENVIRONMENT'      , $paytm_keys[0]['MODE']); // PROD OR TEST
define('PAYTM_MERCHANT_KEY'     , $paytm_keys[0]['PAYTM_MERCHANT_KEY']); //Change this constant's value with Merchant key received from Paytm.
define('PAYTM_MERCHANT_MID'     , $paytm_keys[0]['PAYTM_MERCHANT_MID']); //Change this constant's value with MID (Merchant ID) received from Paytm.
define('PAYTM_MERCHANT_WEBSITE' , $paytm_keys[0]['PAYTM_MERCHANT_WEBSITE']); //Change this constant's value with Website name received from Paytm.


if (PAYTM_ENVIRONMENT == 'PROD') {
	$PAYTM_STATUS_QUERY_NEW_URL='https://securegw.paytm.in/merchant-status/getTxnStatus';
	$PAYTM_TXN_URL='https://securegw.paytm.in/theia/processTransaction';
}else{
	$PAYTM_STATUS_QUERY_NEW_URL='https://securegw-stage.paytm.in/merchant-status/getTxnStatus';
	$PAYTM_TXN_URL='https://securegw-stage.paytm.in/theia/processTransaction';
}

define('PAYTM_REFUND_URL', '');
define('PAYTM_STATUS_QUERY_URL', $PAYTM_STATUS_QUERY_NEW_URL);
define('PAYTM_STATUS_QUERY_NEW_URL', $PAYTM_STATUS_QUERY_NEW_URL);
define('PAYTM_TXN_URL', $PAYTM_TXN_URL);
?>
