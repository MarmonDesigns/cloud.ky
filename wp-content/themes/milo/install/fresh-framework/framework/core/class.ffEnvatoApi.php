<?php
/**
 * Class ffEnvatoApi
 *
 * class which interacts with the envato api server
 */
class ffEnvatoApi extends  ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
    /**
     * @var ffHttp
     */
    private $_http = null;
/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
    private $_urlVerifyPurchaseCode = 'http://marketplace.envato.com/api/edge/!!USERNAME!!/!!APIKEY!!/verify-purchase:!!PURCHASECODE!!.json';

    private $_urlItemDetails = 'http://marketplace.envato.com/api/edge/item:!!ITEM_ID!!.json';

    private $_apiKey = null;

    private $_username = null;
/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
    public function __construct( ffHttp $http ) {
        $this->_setHttp( $http );
    }
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/

    public function getItemInformationsBasedOnID( $itemId ) {
        $urlToItemDetails = $this->_getUrlItemDetails( $itemId );

        $responseFromEnvato = $this->_getResponseFromEnvato( $urlToItemDetails );

        if( isset( $responseFromEnvato['item'] ) ) {
            return $responseFromEnvato['item'];
        } else {
            return false;
        }
    }

    public function verifyPurchaseCode( $purchaseCode ) {
        $urlToVerification = $this->_getUrlVerifyPurchaseCode( $purchaseCode );

        $response = $this->_getHttp()->get( $urlToVerification );

        if( isset( $response['response'] ) && isset( $response['response']['code'] ) && (int)$response['response']['code'] == 200 && isset( $response['body'])) {
            $envatoJson = json_decode( $response['body'], true );

            if( isset( $envatoJson['verify-purchase'] )) {
                return $envatoJson['verify-purchase'];
            }
        }

        return null;
    }

/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/

    public function setApiKey( $apiKey ) {
        $this->_apiKey = $apiKey;
    }

    public function setUsername( $username ) {
        $this->_username = $username;
    }

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
    private function _getResponseFromEnvato( $url, $parseJSON = true ) {
        $response = $this->_getHttp()->get( $url );

        if( isset( $response['response'] ) && isset( $response['response']['code'] ) && (int)$response['response']['code'] == 200 && isset( $response['body'])) {
            if( $parseJSON ) {
                $envatoJSON = json_decode( $response['body'], true );

                return $envatoJSON;
            } else {
                return $response['body'];
            }
        }

        return null;
    }

    private function _getUrlVerifyPurchaseCode( $purchaseCode ) {
        $apiKey = urlencode($this->_getApiKey());
        $username = urlencode($this->_getUsername());
        $purchaseCodeEscaped = urlencode( $purchaseCode );

        $urlForReplace = $this->_urlVerifyPurchaseCode;

        $urlWithApiKey = str_replace('!!APIKEY!!', $apiKey, $urlForReplace );
        $urlWithUserName = str_replace('!!USERNAME!!', $username, $urlWithApiKey );
        $urlWithPurchaseCode = str_replace('!!PURCHASECODE!!', $purchaseCodeEscaped, $urlWithUserName );

        $finalURL = $urlWithPurchaseCode;

        return $finalURL;
    }

    private function _getUrlItemDetails( $itemId ) {
        $urlForReplace = $this->_urlItemDetails;

        $urlWithItemId = str_replace('!!ITEM_ID!!', $itemId, $urlForReplace );

        $finalURL = $urlWithItemId;

        return $finalURL;
    }

    private function _getApiKey() {
        if( $this->_apiKey == null ) {
            throw new ffException('ffEnvatoApi - NOT FILLED API KEY');
        }

        return $this->_apiKey;
    }

    private function _getUsername() {
        if( $this->_username == null ) {
            throw new ffException('ffEnvatoApi - NOT FILLED USERNAME');
        }

        return $this->_username;
    }

    /**
     * @return ffHttp
     */
    private function _getHttp()
    {
        return $this->_http;
    }

    /**
     * @param ffHttp $http
     */
    private function _setHttp($http)
    {
        $this->_http = $http;
    }


}