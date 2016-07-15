<?php

class ffCiphers extends ffBasicObject {
	
	public function getAuthKey() {
		$key = 'sample-coding-key';
		if( defined('AUTH_KEY') ) {
			$key = AUTH_KEY;
		}
		
		return $key;
	}

    public function getNonceKey() {
        $key = 'sample-nonce-key';
        if( defined('NONCE_KEY') ) {
            $key = NONCE_KEY;
        }

        return $key;
    }

    public function generateRandomString( $length ) {
        $authKey = $this->getAuthKey();
        $nonceKey = $this->getNonceKey();
        $ourBasicModificator = '01sdsdad234567asd89asdfghbsdasdcdefasdshijklmnopqrasdxsadyzfdfdAdsdsLretMNOPhgfdQRSTUxaasdddsgsVWXYsapokijuhytgd';

        $modificator = base64_encode( $authKey . $ourBasicModificator . $nonceKey );

        return substr(str_shuffle( $modificator ), 0, $length);
    }

	public function freshfaceCipher_encode( $value, $key = null) {
		
		if( $key == null ) {
			$key = $this->getAuthKey();
		}
		//var_dump( $key );
		$keyNumber = 0;
		foreach( str_split($key) as $oneLetter ) {
			$keyNumber += ord($oneLetter);
		}
		
		$encodedValue = array();
		foreach( str_split( $value ) as $oneLetter ) {
			
			$oneLetterValue = ord($oneLetter);
			$oneLetterValueNew = $oneLetterValue + $keyNumber;

			$encodedValue[] = $oneLetterValueNew;
		}
		
		return implode( ',',$encodedValue);
	}
	
	public function freshfaceCipher_decode( $value, $key = null ) {
		
		if( $key == null ) {
			$key = $this->getAuthKey();
		}
		
		$keyNumber = 0;
		foreach( str_split($key) as $oneLetter ) {
			$keyNumber += ord($oneLetter);
		}
		
		$decodedValue = array();
		$splitedValue = explode(',', $value);
		
		foreach( $splitedValue as $oneLetterEncoded ) {
			$oneLetterDecoded = $oneLetterEncoded - $keyNumber;
			$decodedValue[] = chr( $oneLetterDecoded );
		}
		return implode('', $decodedValue );
	}
}