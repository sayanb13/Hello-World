<?php

namespace Sayan\ConsumeApi\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
	const XML_PATH_API_ENABLED = 'consume_api/api_config/enable';
    const XML_PATH_API_URL = 'consume_api/api_config/api_url';
	const XML_PATH_API_HTTP_AUTH_ENABLED = 'consume_api/api_config/enable_auth';
    const XML_PATH_API_HTTP_AUTH_USERNAME = 'consume_api/api_config/auth_username';
    const XML_PATH_API_HTTP_AUTH_PASSWORD = 'consume_api/api_config/auth_password';
    const XML_PATH_API_HTTP_AUTH_USED = 'consume_api/api_config/integration';
    const XML_PATH_API_ADMIN_URL = 'consume_api/api_config/admin_api_url';
    const XML_PATH_API_ADMIN_USERNAME = 'consume_api/api_config/admin_auth_username';
    const XML_PATH_API_ADMIN_PASSWORD = 'consume_api/api_config/admin_auth_password';
	const XML_PATH_API_CUSTOMER_URL = 'consume_api/api_config/customer_api_url';
    const XML_PATH_API_CUSTOMER_USERNAME = 'consume_api/api_config/customer_auth_username';
    const XML_PATH_API_CUSTOMER_PASSWORD = 'consume_api/api_config/customer_auth_password';
	const CURL_ADAPTER_URL = 'Zend\Http\Client\Adapter\Curl';
	const CURL_TIMEOUT_SECONDS = 30;
	const CURL_MAX_REDIRECT = 0;
	
	/**
     * Data constructor.
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }
	
	/**
     * @param null $storeId
     * @return bool
     */
    public function getEnabled($storeId = null)
    {
        return (boolean)$this->scopeConfig->getValue(
            self::XML_PATH_API_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
	
	/**
     * @param null $storeId
     * @return string
     */
    public function getApiUrl($storeId = null)
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_PATH_API_URL,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
	
	public function getApiHttpAuthEnabled()
    {
        return (boolean)$this->scopeConfig->getValue(
            self::XML_PATH_API_HTTP_AUTH_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }
	
	public function getApiHttpAuthUsed()
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_PATH_API_HTTP_AUTH_USED,
            ScopeInterface::SCOPE_STORE
        );
    }
	
    public function getApiHttpAuthUsername()
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_PATH_API_HTTP_AUTH_USERNAME,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getApiHttpAuthPassword()
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_PATH_API_HTTP_AUTH_PASSWORD,
            ScopeInterface::SCOPE_STORE
        );
    }
	
	public function getApiAdminUrl()
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_PATH_API_ADMIN_URL,
            ScopeInterface::SCOPE_STORE
        );
    }
	
	public function getApiAdminAuthUsername()
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_PATH_API_ADMIN_USERNAME,
            ScopeInterface::SCOPE_STORE
        );
    }
	
	public function getApiAdminAuthPassword()
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_PATH_API_ADMIN_PASSWORD,
            ScopeInterface::SCOPE_STORE
        );
    }
	
	public function getOptions()
	{
		$options = array();
		$options['adapter'] = self::CURL_ADAPTER_URL;
		$options['maxredirects'] = self::CURL_MAX_REDIRECT;
		$options['timeout'] = self::CURL_TIMEOUT_SECONDS;
		
		return $options;
	}
}