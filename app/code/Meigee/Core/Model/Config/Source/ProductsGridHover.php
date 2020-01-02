<?php
namespace Meigee\Core\Model\Config\Source;

class ProductsGridHover implements \Magento\Framework\Data\OptionSourceInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => __('Default Hover')],
            ['value' => 2, 'label' => __('Hover #2')]
        ];
    }
}
