<?php

namespace Sayan\ConsumeApi\Model;

use Sayan\ConsumeApi\Helper\Data;

class RestClient
{
	/**
     * @var Data
     */
    protected $configDataHelper;
	
    /**
     * TaxAndFees constructor.
     * @param RestClient $restClient
     * @param Data $configDataHelper
     */
    public function __construct(
        Data $configDataHelper
    )
    {
        $this->configDataHelper = $configDataHelper;
    }
	
	/**
     * @param array $request
     * @return array|bool|string|\Zend_Http_Response
     */
    public function getApiData()
    {	
		$mainApiUrl = $this->configDataHelper->getApiUrl();
        $httpAuthEnabled = $this->configDataHelper->getApiHttpAuthEnabled();
        $httpAuthUsedFor = $this->configDataHelper->getApiHttpAuthUsed();
		
        if(!$httpAuthEnabled) {
			return false;
		}
		
		$token = '';
		$data = array();
		$apiUrl = '';
		$apiUsername = '';
		$apiPassword = '';
		
		if ($httpAuthUsedFor == 'api') {
			$apiUrl = $mainApiUrl;
			$apiUsername = $this->configDataHelper->getApiHttpAuthUsername();
			$apiPassword = $this->configDataHelper->getApiHttpAuthPassword();
			
		} else if ($httpAuthUsedFor == 'admin') {
			$apiUrl = $this->configDataHelper->getApiAdminUrl();
			$apiUsername = $this->configDataHelper->getApiAdminAuthUsername();
			$apiPassword = $this->configDataHelper->getApiAdminAuthPassword();
		}
		
		$data = array("username" => $apiUsername, "password" => $apiPassword);                                                                    
		$dataString = json_encode($data);
		
		$postOptions = $this->configDataHelper->getOptions();
		$postOptions['curloptions'] = [CURLOPT_FOLLOWLOCATION => true, CURLOPT_POSTFIELDS => $dataString];
		
		$token = $this->POST($apiUrl, $dataString, $postOptions);

		if (!empty($token->message)) {
			return $token->message;
		}
		
		$getOptions = $this->configDataHelper->getOptions();
		$getOptions['curloptions'] = [CURLOPT_FOLLOWLOCATION => true];
		return $this->GET($mainApiUrl, $token, $getOptions);
    }
	
	public function POST($apiUrl, $dataString, $options) {
		$httpHeaders = new \Zend\Http\Headers();
		$client = new \Zend\Http\Client();
		$request = new \Zend\Http\Request();
		
		$httpHeaders->addHeaders([
		   'Content-Type' => 'application/json',
		   'Content-Length: ' . strlen($dataString)
		]);

		$request->setHeaders($httpHeaders);
		$request->setUri($apiUrl);
		$request->setMethod(\Zend\Http\Request::METHOD_POST);
		 		
		$client->setOptions($options);
		$response = $client->send($request);
		
		return json_decode($response->getBody());
	}
	
	public function GET($apiUrl, $token, $options) {
		$httpHeaders = new \Zend\Http\Headers();
		$client = new \Zend\Http\Client();
		$request = new \Zend\Http\Request();

		$httpHeaders->addHeaders([
		   'Authorization' => 'Bearer ' . $token,
		   'Accept' => 'application/json',
		   'Content-Type' => 'application/json'
		]);
		
		$request->setHeaders($httpHeaders);
		$request->setUri($apiUrl);
		$request->setMethod(\Zend\Http\Request::METHOD_GET);
				
		$client->setOptions($options);
		$response = $client->send($request);

		return json_decode($response->getBody());
	}
}