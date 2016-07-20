<?php


class ffEnvatoApiModern extends ffBasicObject {
    const FF_ERROR_NO = 'no_error';
    const FF_ERROR_TOKEN_EXPIRED = 'Token already expired';


/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
    /**
     * @var ffHttp
     */
    private $_http = null;

    /**
     * @var ffRequest
     */
    private $_request = null;
/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
    private $_urlGrantAccess = 'https://api.envato.com/authorization?response_type=code&client_id=!!CLIENT_ID!!&redirect_uri=!!REDIRECT_URI!!';

    private $_clientId = null;

    private $_clientSecret = null;
/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
    public function __construct( $http, $request ) {
        $this->_setHttp( $http );
        $this->_setRequest( $request );
    }
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
    public function requestBasedOnPersonalToken( $personalToken, $requestUrl ) {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $requestUrl );
        $headers = array('Authorization: Bearer '.$personalToken);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $serverOutput = curl_exec ($ch);



        return $serverOutput;
    }

    public function getItemDetailsFromSearch( $personalToken, $itemId, $itemName ) {
        $searchEncoded = $this->requestBasedOnPersonalToken( $personalToken, 'https://api.envato.com/v1/discovery/search/search/item?term='.urlencode( $itemName ) );

        $search = json_decode( $searchEncoded, true );

        if( !isset( $search['matches'] ) ) {
            return null;
        }

        $ourMatch = null;
        foreach( $search['matches'] as $oneMatch ) {
            if( $oneMatch['id'] == $itemId ) {
                $ourMatch = $oneMatch;
                break;
            }
        }

        return $ourMatch;
//        foreach( $)
    }

    public function getItemDetails( $personalToken, $itemId ) {
        $itemDetail = $this->requestBasedOnPersonalToken( $personalToken, 'https://api.envato.com/v2/market/catalog/item?id='.urlencode( $itemId ).'' );


        $itemDecoded =json_decode( $itemDetail, true );

        if( isset( $itemDecoded['number_of_sales'] ) ) {
            return $itemDecoded;
        } else {
            return null;
        }
    }


    public function getUserInformationsFromAccessCode( $code ) {

        $result = $this->getAccessAndRefreshTokensBasedOnCode( $code );

        $accessToken = $result['access_token'];
        $refreshToken = $result['refresh_token'];


        $userInfo = $this->getUserInformationsFromAccessToken( $accessToken );
        $userInfo['access_token'] = $accessToken;
        $userInfo['refresh_token'] = $refreshToken;

        return $userInfo;
    }


    public function getUserInformationsFromAccessCodeFromPostVariable() {
        $accessCode = $this->getAccessCode();
        return $this->getUserInformationsFromAccessCode( $accessCode );
    }

    public function getUserInformationsFromAccessToken( $accessToken ) {
        $userInfo = array();
        $userInfo['email'] = $this->getUserEmail($accessToken);
        $userInfo['username'] = $this->getUserName($accessToken);

        return $userInfo;
    }

    public function getUserName( $accessToken ) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,'https://api.envato.com/v1/market/private/user/username.json');
        $headers = array('Authorization: Bearer '.$accessToken);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $serverOutput = curl_exec ($ch);

        $serverOutputDecoded = json_decode( $serverOutput, true );

        if( isset( $serverOutputDecoded['username'] ) ) {
            return $serverOutputDecoded['username'];
        } else {
            return null;
        }


    }

    public function getUserEmail( $accessToken ) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"https://api.envato.com/v1/market/private/user/email.json");
        $headers = array('Authorization: Bearer '.$accessToken);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $serverOutput = curl_exec ($ch);

        $serverOutputDecoded = json_decode( $serverOutput, true );

        if( isset( $serverOutputDecoded['email'] ) ) {
            return $serverOutputDecoded['email'];
        } else {
            return null;
        }
    }


    public function getAccessAndRefreshTokensBasedOnCode( $code ) {
        $postParams = array();

        $postParams['grant_type'] = 'authorization_code';
        $postParams['code'] = $code;
        $postParams['client_id'] = $this->_getClientId();
        $postParams['client_secret'] = $this->_getClientSecret();

        $postQuery = http_build_query( $postParams );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"https://api.envato.com/token");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postQuery );
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));


        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $serverOutput = curl_exec ($ch);

        curl_close ($ch);

        $responseDecoded = json_decode( $serverOutput, true );

        if( !isset( $responseDecoded['access_token'] ) ) {
            return false;
        }

        $toReturn = array();
        $toReturn['access_token'] = $responseDecoded['access_token'];
        $toReturn['refresh_token'] = $responseDecoded['refresh_token'];

        return $toReturn;
    }

    public function getAccessTokenBasedOnRefreshToken( $refreshToken ) {
        $postParams = array();
        $postParams['grant_type'] = 'refresh_token';
        $postParams['refresh_token'] = $refreshToken;
        $postParams['client_id'] = $this->_getClientId();
        $postParams['client_secret'] = $this->_getClientSecret();

        $postQuery = http_build_query( $postParams );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"https://api.envato.com/token");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postQuery );
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));


        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $serverOutput = curl_exec ($ch);

        curl_close ($ch);

        $serverOutputDecoded = json_decode( $serverOutput, true );

        if( !$this->_checkRequestForErrors( $serverOutputDecoded ) && isset( $serverOutputDecoded['access_token'] ) ) {
            return $serverOutputDecoded['access_token'];
        }

        return false;

    }

    public function getUrlGrantAccessUrl( $redirectUrl ) {
        $clientIdEncoded = urlencode( $this->_getClientId() );
        $redirectUrlEncoded = urlencode( $redirectUrl );

        $urlWithoutReplacement = $this->_urlGrantAccess;

        $urlWithClientId = str_replace('!!CLIENT_ID!!', $clientIdEncoded, $urlWithoutReplacement );
        $urlWithRedirectedUrl = str_replace('!!REDIRECT_URI!!', $redirectUrlEncoded, $urlWithClientId );

        $urlFinal = $urlWithRedirectedUrl;

        return $urlFinal;
    }


    public function getAccessCode() {
        return $this->_getRequest()->get('code');
    }

    public function setClientId( $clientId ) {
        $this->_clientId = $clientId;
    }

    public function setClientSecret( $clientSecret ) {
        $this->_clientSecret = $clientSecret;
    }
/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
    private function _checkRequestForErrors( $returnValue ) {
        if( isset( $returnValue['error'] ) ) {
            if( isset($returnValue['error_description']) && $returnValue['error_description'] == ffEnvatoApiModern::FF_ERROR_TOKEN_EXPIRED ) {
                return ffEnvatoApiModern::FF_ERROR_TOKEN_EXPIRED;
            }
        }

        return false;
    }

    private function _getClientId() {
        if( $this->_clientId == null ) {
            throw new ffException('ffEnvatoApiModern - NO CLIENT ID FILLED');
        }

        return $this->_clientId;
    }

    private function _getClientSecret() {
        if( $this->_clientSecret == null ) {
            throw new ffException('ffEnvatoApiModern - NO CLIENT SECRET FILLED');
        }

        return $this->_clientSecret;
    }
/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
    /**
     * @return ffRequest
     */
    private function _getRequest()
    {
        return $this->_request;
    }

    /**
     * @param ffRequest $request
     */
    private function _setRequest($request)
    {
        $this->_request = $request;
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