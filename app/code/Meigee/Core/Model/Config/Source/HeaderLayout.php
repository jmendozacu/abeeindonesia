<?php
namespace Meigee\Core\Model\Config\Source;

class HeaderLayout implements \Magento\Framework\Data\OptionSourceInterface
{
    const HEADER_WIDE = 'header-wide';
    const HEADER_BOXED = 'header-boxed';
    const HEADER_BOXED_CONTENT = 'header-boxed-content';

    public function toOptionArray()
    {
        return [
            ['value' => self::HEADER_WIDE, 'label' => __('Wide')],
            ['value' => self::HEADER_BOXED, 'label' => __('Boxed')],
            ['value' => self::HEADER_BOXED_CONTENT, 'label' => __('Wide with Boxed content')]
        ];
    }
}
