<?php

function getInfo($number){
	$api = 'https://t.me/teamx1337official'.$number;
	// EDIT THIS URL WITH YOUR PROVIDER URL
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $api);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
		'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36'
	));
	$content = curl_exec($curl);
	curl_close($curl);
	return $content;
}

class NID{
	private $number;
	

    public function __construct($number){
        $this->number = $number;
    }

	function info(){
		return getInfo($this->number);
	}
}
