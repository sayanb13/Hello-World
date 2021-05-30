<?php
namespace Sayan\ConsumeApi\Block;

class ConsumeApi extends \Magento\Framework\View\Element\Template
{
    /**
     * ConsumeApi configuration model
     *
     * @var \Sayan\ConsumeApi\Model\RestClient
     */
    protected $_restClient;
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Tax\Model\Config $taxConfig
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Sayan\ConsumeApi\Model\RestClient $restClient,
        array $data = []
    ) {
        $this->_restClient = $restClient;
        parent::__construct($context, $data);
    }
	
	
	public function getConsumeApiData() {
		$response = $this->_restClient->getApiData();
		if (!empty($response->message)) {
			return $response->message;
		}
		
		return $response;
	}
}

?>