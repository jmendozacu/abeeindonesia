<?php
namespace Meigee\Core\Model\Config\Source;

class ContentLayout implements \Magento\Framework\Data\OptionSourceInterface
{
    const CONTENT_WIDE = 'content-wide';
    const CONTENT_BOXED = 'content-boxed';
    const CONTENT_BOXED_CONTENT = 'content-boxed-content';

    public function toOptionArray()
    {
        return [
            ['value' => self::CONTENT_WIDE, 'label' => __('Wide')],
            ['value' => self::CONTENT_BOXED, 'label' => __('Boxed')],
            ['value' => self::CONTENT_BOXED_CONTENT, 'label' => __('Wide with Boxed content')]
        ];
    }
}
