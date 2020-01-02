<?php
namespace Meigee\Sirena\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Stdlib\CookieManagerInterface;

/**
 * Class CustomGridSwitcher
 * @package Meigee\Sirena\ViewModel
 */
class CustomGridSwitcher implements ArgumentInterface
{
    const CUSTOM_GRID_COOKIE = 'sirenaListingGridSwitcher';

    /**
     * @var CookieManagerInterface
     */
    private $cookieManager;

    /**
     * @var \Meigee\Sirena\ViewModel\ThemeConfigPhp
     */
    private $themeConfigPhp;

    /**
     * CustomGridSwitcher constructor.
     * @param CookieManagerInterface $cookieManager
     * @param \Meigee\Sirena\ViewModel\ThemeConfigPhp $themeConfigPhp
     */
    public function __construct(
        CookieManagerInterface $cookieManager,
        ThemeConfigPhp $themeConfigPhp
    ) {
        $this->cookieManager = $cookieManager;
        $this->themeConfigPhp = $themeConfigPhp;
    }

    /**
     * @return bool
     */
    public function isCustomSwitcherEnabled()
    {
        return (bool)$this->themeConfigPhp->getGridSwitcherCustom();
    }

    /**
     * @return null|string
     */
    public function getCustomGridCookie()
    {
        return $this->cookieManager->getCookie(self::CUSTOM_GRID_COOKIE);
    }

    /**
     * @return array|bool
     */
    public function getListingColumnsGrids()
    {
        $listingColumnsGridString = preg_replace('/\s+/','',$this->themeConfigPhp->getGridSwitcherCustomCols());
        $listingColumnsGridStringArray = explode(',', $listingColumnsGridString);
        if (count($listingColumnsGridStringArray) <= 0) {
            return false;
        }
        return $listingColumnsGridStringArray;
    }
}
