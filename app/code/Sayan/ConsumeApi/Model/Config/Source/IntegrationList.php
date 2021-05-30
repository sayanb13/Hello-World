<?php
namespace Sayan\ConsumeApi\Model\Config\Source;

class IntegrationList implements \Magento\Framework\Data\OptionSourceInterface
{
 public function toOptionArray()
 {
  return [
    ['value' => 'api', 'label' => __('API')],
    ['value' => 'admin', 'label' => __('Magento Admin')]
  ];
 }
}