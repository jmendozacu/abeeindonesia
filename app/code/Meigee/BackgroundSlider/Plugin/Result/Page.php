<?php

namespace Meigee\BackgroundSlider\Plugin\Result;

use Magento\Framework\App\ResponseInterface;
use Meigee\BackgroundSlider\ViewModel\Slider;

/**
 * Class Page
 * @package Meigee\BackgroundSlider\Plugin\Result
 */
class Page
{
    /**
     * @var Slider
     */
    private $slider;

    /**
     * Page constructor.
     * @param Slider $slider
     */
    public function __construct(Slider $slider)
    {
        $this->slider = $slider;
    }

    /**
     * @param \Magento\Framework\View\Result\Page $subject
     * @param ResponseInterface $response
     * @return array
     */
    public function beforeRenderResult(
        \Magento\Framework\View\Result\Page $subject,
        ResponseInterface $response
    ) {
        if ($this->slider->getBackgroundSlider() && $this->slider->getIsBoxedContentThemeLayout()) {
            $subject->getConfig()->addBodyClass(Slider::BODY_CSS_CLASS);
        }
        return [$response];
    }
}
