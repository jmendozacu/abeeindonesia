<?php
namespace Meigee\Core\Model\Config\Source;

class ProductPageStyle implements \Magento\Framework\Data\OptionSourceInterface
{
    public function toOptionArray()
    {
		return [
			  ['value' => 'product-with-bg', 'label' => __('Product with background')],
			  ['value' => '', 'label' => __('Default product')]
		];
    }
}
