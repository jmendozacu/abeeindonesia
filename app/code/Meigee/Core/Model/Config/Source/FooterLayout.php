<?php
namespace Meigee\Core\Model\Config\Source;

class FooterLayout implements \Magento\Framework\Data\OptionSourceInterface
{
    const FOOTER_WIDE = 'footer-wide';
    const FOOTER_BOXED = 'footer-boxed';
    const FOOTER_BOXED_CONTENT = 'footer-boxed-content';

    public function toOptionArray()
    {
		return [
            ['value' => self::FOOTER_WIDE, 'label' => __('Wide')],
            ['value' => self::FOOTER_BOXED, 'label' => __('Boxed')],
            ['value' => self::FOOTER_BOXED_CONTENT, 'label' => __('Wide with Boxed content')]
		];
    }
}

