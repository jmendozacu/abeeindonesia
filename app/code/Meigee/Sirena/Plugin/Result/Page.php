<?php
namespace Meigee\Sirena\Plugin\Result;

use Magento\Framework\App\ResponseInterface;
use Meigee\Sirena\ViewModel\ThemeConfigPhp;

/**
 * Class Page
 * @package Meigee\Sirena\Plugin\Result
 */
class Page
{
    /**
     * @var ThemeConfigPhp
     */
    private $themeConfig;

    /**
     * Page constructor.
     * @param ThemeConfigPhp $themeConfig
     */
    public function __construct(ThemeConfigPhp $themeConfig)
    {
        $this->themeConfig = $themeConfig;
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
        $subject->getConfig()->addBodyClass($this->themeConfig->getHeaderLayout());
        $subject->getConfig()->addBodyClass($this->themeConfig->getContentLayout());
        $subject->getConfig()->addBodyClass($this->themeConfig->getFooterLayout());
        $subject->getConfig()->addBodyClass($this->themeConfig->getSiteRtl());
        $subject->getConfig()->addBodyClass($this->themeConfig->getHeaderStickyTablet());
        $subject->getConfig()->addBodyClass($this->themeConfig->getHeaderSticky());
        $subject->getConfig()->addBodyClass($this->themeConfig->getProductPageStyle());
        $subject->getConfig()->addBodyClass($this->themeConfig->getProductPageSidebarPosition());
        return [$response];
    }
}
