<?php
namespace Meigee\Sirena\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class ThemeConfigPhp implements ArgumentInterface
{

    const XML_PATH_HEADER_LAYOUT = 'sirena_general/sirena_layout/header_layout';
    const XML_PATH_CONTENT_LAYOUT = 'sirena_general/sirena_layout/content_layout';
    const XML_PATH_FOOTER_LAYOUT = 'sirena_general/sirena_layout/footer_layout';
    const XML_PATH_SITE_WIDTH = 'sirena_general/sirena_layout/container_width';
    const XML_PATH_SITE_RTL = 'sirena_general/sirena_layout/rtl_enabled';
    const XML_PATH_SEARCH_TYPE = 'sirena_general/sirena_header/header_search_type';
    const XML_PATH_HEADER_TRANSPARENCY = 'sirena_general/sirena_header/header_home_transparency';
    const XML_PATH_MENU_TRANSPARENCY = 'sirena_general/sirena_header/home_menu_transparency';
    const XML_PATH_HEADER_STICKY = 'sirena_general/sirena_header/sticky_header';
    const XML_PATH_HEADER_STICKY_OPACITY = 'sirena_general/sirena_header/sticky_header_opacity';
    const XML_PATH_HEADER_STICKY_TABLET = 'sirena_general/sirena_header/sticky_header_tablet';
    const XML_PATH_HEADER_STICKY_LOGO = 'sirena_general/sirena_header/sticky_header_logo';
    const XML_PATH_HEADER_STICKY_MENU = 'sirena_general/sirena_header/sticky_header_nav';
    const XML_PATH_HEADER_STICKY_SEARCH = 'sirena_general/sirena_header/sticky_header_search';
    const XML_PATH_FOOTER_CUSTOM = 'sirena_general/sirena_footer/custom_footer';
    const XML_PATH_FOOTER_CUSTOM_BLOCK = 'sirena_general/sirena_footer/custom_footer_block';
    const XML_PATH_LOGO_CHECKOUT = 'sirena_general/sirena_logo/checkout_logo_status';
    const XML_PATH_LOGO_CHECKOUT_SRC = 'sirena_general/sirena_logo/checkout_logo_image';
    const XML_PATH_LOGO_CUSTOM = 'sirena_general/sirena_logo/custom_logo_status';
    const XML_PATH_LOGO_CUSTOM_SRC = 'sirena_general/sirena_logo/custom_logo_image';
    const XML_PATH_SECOND_LOGO_CUSTOM_SRC = 'sirena_general/sirena_logo/second_custom_logo_image';
    const XML_PATH_LOGO_CUSTOM_ALT = 'sirena_general/sirena_logo/custom_logo_alt';
    const XML_PATH_MINICART_SHOW_ICON = 'sirena_general/sirena_topcart/icon';
    const XML_PATH_MINICART_SHOW_TEXT = 'sirena_general/sirena_topcart/text';
    const XML_PATH_MINICART_SHOW_COUNTER = 'sirena_general/sirena_topcart/counter';
    const XML_PATH_MINICART_TYPE = 'sirena_general/sirena_topcart/minicart_type';
    const XML_PATH_TOPLINKS_SHOW_COMPARE = 'sirena_general/sirena_toplinks/toplinks_compare';
    const XML_PATH_TOPLINKS_SHOW_WISHLIST = 'sirena_general/sirena_toplinks/toplinks_wishlist';
    const XML_PATH_TOPLINKS_SHOW_REGISTER = 'sirena_general/sirena_toplinks/toplinks_register';
    const XML_PATH_TOPLINKS_SHOW_LOGIN = 'sirena_general/sirena_toplinks/toplinks_login';
    const XML_PATH_GRID_SWITCHER_CUSTOM = 'sirena_general/sirena_product_listing/listing_custom_grid';
    const XML_PATH_GRID_SWITCHER_CUSTOM_COLS = 'sirena_general/sirena_product_listing/listing_grid_switcher';
    const XML_PATH_GRID_SWITCHER_DEFAULT_COLS = 'sirena_general/sirena_product_listing/grid_columns';
    const XML_PATH_PRODUCT_HOVER_TYPE = 'sirena_general/sirena_product_listing/grid_hover';
    const XML_PATH_PRODUCT_SHOW_NAME = 'sirena_general/sirena_product_listing/product_name';
    const XML_PATH_PRODUCT_SHOW_STARS = 'sirena_general/sirena_product_listing/rating_stars';
    const XML_PATH_PRODUCT_SHOW_PRICE = 'sirena_general/sirena_product_listing/product_price';
    const XML_PATH_PRODUCT_SHOW_ADD_TO_CART = 'sirena_general/sirena_product_listing/cart_btn';
    const XML_PATH_PRODUCT_SHOW_COMPARE_BTN = 'sirena_general/sirena_product_listing/compare_btn';
    const XML_PATH_PRODUCT_SHOW_QUICKVIEW_BTN = 'sirena_general/sirena_product_listing/quickview_btn';
    const XML_PATH_PRODUCT_SHOW_WISHLIST_BTN = 'sirena_general/sirena_product_listing/wishlist_btn';
    const XML_PATH_PRODUCT_SHOW_STOCK_STATUS = 'sirena_general/sirena_product_listing/stock_status';
    const XML_PATH_OPENED_LAYERED_NAV = 'sirena_general/sirena_product_listing/layer_accordion';
    const XML_PATH_PRODUCT_PAGE_STYLE = 'sirena_general/sirena_product_view/product_page_style';
    const XML_PATH_PRODUCT_PAGE_COLLAPSED_DESCRIPTION = 'sirena_general/sirena_product_view/product_description_collapse';
    const XML_PATH_PRODUCT_PAGE_CUSTOM_TAB = 'sirena_general/sirena_product_view/product_custom_tab';
    const XML_PATH_PRODUCT_PAGE_CUSTOM_TAB_BLOCK = 'sirena_general/sirena_product_view/product_custom_tab_block';
    const XML_PATH_PRODUCT_PAGE_GALLERY_TYPE = 'sirena_general/sirena_product_view/product_more_views_type';
    const XML_PATH_PRODUCT_PAGE_SIDEBAR_POSITION = 'sirena_general/sirena_product_view/product_sidebar_position';
    const XML_PATH_LANG_SWITCHER_TYPE = 'sirena_general/sirena_lang_switcher/lang_switcher_status';
    const XML_PATH_LANG_SWITCHER_SHOW_LABEL = 'sirena_general/sirena_lang_switcher/lang_switcher_label';
    const XML_PATH_CURRENCY_SWITCHER_TYPE = 'sirena_general/sirena_currency_switcher/currency_switcher_status';
    const XML_PATH_CURRENCY_SWITCHER_SHOW_LABEL = 'sirena_general/sirena_currency_switcher/currency_switcher_label';
    const XML_PATH_LABELS_SHOW_NEW = 'sirena_general/sirena_labels/label_new';
    const XML_PATH_LABELS_SHOW_SALE = 'sirena_general/sirena_labels/label_sale';
    const XML_PATH_LABELS_SHOW_ONLY_LEFT = 'sirena_general/sirena_labels/label_only_left';
    const XML_PATH_LABELS_SHOW_PERCENTAGE = 'sirena_general/sirena_labels/label_sale_percentage';
    const XML_PATH_LABELS_TYPE = 'sirena_general/sirena_labels/label_type';
    const XML_PATH_COUNTDOWN_ENABLED = 'sirena_general/sirena_countdown/timer_status';
    const XML_PATH_COUNTDOWN_ON_LISTING = 'sirena_general/sirena_countdown/timer_listing_status';
    const XML_PATH_COUNTDOWN_ON_LISTING_TYPE = 'sirena_general/sirena_countdown/timer_listing_display';
    const XML_PATH_COUNTDOWN_ON_PRODUCT_PAGE = 'sirena_general/sirena_countdown/timer_product_status';
    const XML_PATH_COUNTDOWN_ON_PRODUCT_PAGE_TYPE = 'sirena_general/sirena_countdown/timer_product_display';
    const XML_PATH_LIGHTBOX_ENABLED = 'sirena_general/sirena_lightbox/lightbox_status';
    const XML_PATH_LIGHTBOX_ON_HOME_PAGE = 'sirena_general/sirena_lightbox/lightbox_home';
    const XML_PATH_LIGHTBOX_ON_LISTING = 'sirena_general/sirena_lightbox/lightbox_listing';
    const XML_PATH_LIGHTBOX_ON_PRODUCT_PAGE = 'sirena_general/sirena_lightbox/lightbox_product';
    const XML_PATH_PRODUCT_CUSTOM_HOVER_ENABLED = 'sirena_general/sirena_image_hover/image_hover_status';
    const XML_PATH_PRODUCT_CUSTOM_HOVER_TYPE = 'sirena_general/sirena_image_hover/image_hover_type';
    const XML_PATH_CONTACTMAP_ENABLED = 'sirena_general/sirena_contactmap/contactmap_status';
    const XML_PATH_CONTACTMAP_API = 'sirena_general/sirena_contactmap/contactmap_api';
    const XML_PATH_CONTACTMAP_LATITUDE = 'sirena_general/sirena_contactmap/contactmap_latitude';
    const XML_PATH_CONTACTMAP_LONGITUDE = 'sirena_general/sirena_contactmap/contactmap_longitude';
    const XML_PATH_CONTACTMAP_ZOOM = 'sirena_general/sirena_contactmap/contactmap_zoom';
    const XML_PATH_CONTACTMAP_TYPE = 'sirena_general/sirena_contactmap/contactmap_type';
    const XML_PATH_CONTACTMAP_MARKER_ENABLED = 'sirena_general/sirena_contactmap/contactmap_marker';
    const XML_PATH_CONTACTMAP_MARKER_TEXT = 'sirena_general/sirena_contactmap/contactmap_marker_title';
    const XML_PATH_CONTACTMAP_CUSTOM_BLOCK_ENABLED = 'sirena_general/sirena_contactmap/contactmap_block_status';
    const XML_PATH_CONTACTMAP_CUSTOM_BLOCK = 'sirena_general/sirena_contactmap/contactmap_block_static';
    const XML_PATH_CONTACTMAP_CUSTOM_BLOCK_WIDTH = 'sirena_general/sirena_contactmap/contactmap_block_width';
    const XML_PATH_CONTACTMAP_CUSTOM_BLOCK_HEIGHT = 'sirena_general/sirena_contactmap/contactmap_block_height';
    const XML_PATH_CONTACTMAP_CUSTOM_BLOCK_POSITION = 'sirena_general/sirena_contactmap/contactmap_block_position';
    const XML_PATH_POPUP_ENABLED = 'sirena_general/sirena_popup_content/status';
    const XML_PATH_POPUP_BLOCK = 'sirena_general/sirena_popup_content/static';
    const XML_PATH_POPUP_EXPIRES = 'sirena_general/sirena_popup_content/expires';
    const XML_PATH_POPUP_ONLY_ON_HOME_PAGE = 'sirena_general/sirena_popup_content/onlyhome';
    const XML_PATH_POPUP_WIDTH = 'sirena_general/sirena_popup_content/width';
    const XML_PATH_POPUP_HEIGHT = 'sirena_general/sirena_popup_content/height';
    const XML_PATH_POPUP_SHOW_ON_MOBILE = 'sirena_general/sirena_popup_content/mobile';
    const XML_PATH_POPUP_SHOW_ON_TABLET = 'sirena_general/sirena_popup_content/tablet';
    const XML_PATH_FACEBOOK_SIDEBAR_ENABLED = 'sirena_general/sirena_facebook_block/status';
    const XML_PATH_FACEBOOK_SIDEBAR_URL = 'sirena_general/sirena_facebook_block/url';
    const XML_PATH_FACEBOOK_SIDEBAR_HEIGHT = 'sirena_general/sirena_facebook_block/height';
    const XML_PATH_FACEBOOK_SIDEBAR_SHOW_FRIENDS = 'sirena_general/sirena_facebook_block/faces';
    const XML_PATH_FACEBOOK_SIDEBAR_SHOW_SMALL_HEADER = 'sirena_general/sirena_facebook_block/smallheader';
    const XML_PATH_FACEBOOK_SIDEBAR_SHOW_POSTS = 'sirena_general/sirena_facebook_block/posts';
    const XML_PATH_FACEBOOK_SIDEBAR_HIDE_COVER = 'sirena_general/sirena_facebook_block/cover';
    const XML_PATH_FACEBOOK_SIDEBAR_ADAPTIVE_WIDTH = 'sirena_general/sirena_facebook_block/adaptive_width';
    
    private $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    public function getThemeConfig($constName, $storeId)
    {
        $constantValue = $this->getConst($constName);
        $config = $this->scopeConfig->getValue($constantValue, ScopeInterface::SCOPE_STORE, $storeId);
    	return $config;
    }

    private function getConst($constName)
    {
        $constName = 'self::' . $constName;
        return constant($constName);
    }

    public function getHeaderLayout()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_HEADER_LAYOUT, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getContentLayout()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_CONTENT_LAYOUT, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getFooterLayout()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_FOOTER_LAYOUT, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getSiteWidth()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_SITE_WIDTH, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getSiteRtl()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_SITE_RTL, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getSearchType()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_SEARCH_TYPE, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getHeaderTransparency()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_HEADER_TRANSPARENCY, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getMenuTransparency()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_MENU_TRANSPARENCY, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getHeaderSticky()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_HEADER_STICKY, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getHeaderStickyOpacity()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_HEADER_STICKY_OPACITY, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getHeaderStickyTablet()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_HEADER_STICKY_TABLET, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getHeaderStickyShowLogo()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_HEADER_STICKY_LOGO, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getHeaderStickyShowNav()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_HEADER_STICKY_MENU, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getHeaderStickyShowSearch()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_HEADER_STICKY_SEARCH, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getFooterCustom()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_FOOTER_CUSTOM, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getFooterCustomBlock()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_FOOTER_CUSTOM_BLOCK, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getLogoCheckout()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_LOGO_CHECKOUT, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getLogoCheckoutSrc()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_LOGO_CHECKOUT_SRC, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getLogoCustom()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_LOGO_CUSTOM, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getLogoCustomSrc()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_LOGO_CUSTOM_SRC, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getSecondLogoCustomSrc()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_SECOND_LOGO_CUSTOM_SRC, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getLogoCustomAlt()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_LOGO_CUSTOM_ALT, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getMinicartShowIcon()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_MINICART_SHOW_ICON, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getMinicartShowText()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_MINICART_SHOW_TEXT, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getMinicartShowCounter()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_MINICART_SHOW_COUNTER, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getMinicartType()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_MINICART_TYPE, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getToplinksShowCompare()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_TOPLINKS_SHOW_COMPARE, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getToplinksShowWishlist()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_TOPLINKS_SHOW_WISHLIST, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getToplinksShowRegister()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_TOPLINKS_SHOW_REGISTER, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getToplinksShowLogin()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_TOPLINKS_SHOW_LOGIN, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getGridSwitcherCustom()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_GRID_SWITCHER_CUSTOM, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getGridSwitcherCustomCols()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_GRID_SWITCHER_CUSTOM_COLS, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getGridSwitcherDefaultCols()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_GRID_SWITCHER_DEFAULT_COLS, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getProductHoverType()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_PRODUCT_HOVER_TYPE, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getProductShowName()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_PRODUCT_SHOW_NAME, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getProductShowStars()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_PRODUCT_SHOW_STARS, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getProductShowPrice()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_PRODUCT_SHOW_PRICE, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getProductShowAddtocart()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_PRODUCT_SHOW_ADD_TO_CART, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getProductShowCompareBtn()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_PRODUCT_SHOW_COMPARE_BTN, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getProductShowQuickviewBtn()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_PRODUCT_SHOW_QUICKVIEW_BTN, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getProductShowWishlistBtn()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_PRODUCT_SHOW_WISHLIST_BTN, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getProductShowStockStatus()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_PRODUCT_SHOW_STOCK_STATUS, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getOpenedLayeredNav()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_OPENED_LAYERED_NAV, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getProductPageStyle()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_PRODUCT_PAGE_STYLE, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getProductPageCollapsedDescription()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_PRODUCT_PAGE_COLLAPSED_DESCRIPTION, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getProductPageCustomTab()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_PRODUCT_PAGE_CUSTOM_TAB, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getProductPageCustomTabBlock()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_PRODUCT_PAGE_CUSTOM_TAB_BLOCK, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getProductPageGalleryType()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_PRODUCT_PAGE_GALLERY_TYPE, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getProductPageSidebarPosition()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_PRODUCT_PAGE_SIDEBAR_POSITION, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getLangSwitcherType()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_LANG_SWITCHER_TYPE, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getLangSwitcherShowLabel()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_LANG_SWITCHER_SHOW_LABEL, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getCurrencySwitcherType()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_CURRENCY_SWITCHER_TYPE, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getCurrencySwitcherShowLabel()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_CURRENCY_SWITCHER_SHOW_LABEL, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getLabelsShowNew()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_LABELS_SHOW_NEW, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getLabelsShowSale()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_LABELS_SHOW_SALE, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getLabelsShowOnlyLeft()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_LABELS_SHOW_ONLY_LEFT, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getLabelsShowPercentage()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_LABELS_SHOW_PERCENTAGE, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getLabelsType()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_LABELS_TYPE, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getCountdown()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_COUNTDOWN_ENABLED, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getCountdownListing()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_COUNTDOWN_ON_LISTING, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getCountdownListingType()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_COUNTDOWN_ON_LISTING_TYPE, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getCountdownProduct()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_COUNTDOWN_ON_PRODUCT_PAGE, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getCountdownProductType()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_COUNTDOWN_ON_PRODUCT_PAGE_TYPE, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getLightbox()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_LIGHTBOX_ENABLED, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getLightboxHome()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_LIGHTBOX_ON_HOME_PAGE, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getLightboxListing()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_LIGHTBOX_ON_LISTING, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getLightboxProductPage()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_LIGHTBOX_ON_PRODUCT_PAGE, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getProductCustomHover()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_PRODUCT_CUSTOM_HOVER_ENABLED, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getProductCustomHoverType()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_PRODUCT_CUSTOM_HOVER_TYPE, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getContactMap()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_CONTACTMAP_ENABLED, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getContactMapApi()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_CONTACTMAP_API, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getContactMapLatitude()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_CONTACTMAP_LATITUDE, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getContactMapLongitude()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_CONTACTMAP_LONGITUDE, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getContactMapZoom()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_CONTACTMAP_ZOOM, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getContactMapType()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_CONTACTMAP_TYPE, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getContactMapMarker()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_CONTACTMAP_MARKER_ENABLED, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getContactMapMarkerText()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_CONTACTMAP_MARKER_TEXT, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getContactMapCustomInfo()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_CONTACTMAP_CUSTOM_BLOCK_ENABLED, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getContactMapCustomInfoBlock()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_CONTACTMAP_CUSTOM_BLOCK, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getContactMapCustomInfoWidth()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_CONTACTMAP_CUSTOM_BLOCK_WIDTH, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getContactMapCustomInfoHeight()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_CONTACTMAP_CUSTOM_BLOCK_HEIGHT, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getContactMapCustomInfoPosition()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_CONTACTMAP_CUSTOM_BLOCK_POSITION, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getPopupMsg()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_POPUP_ENABLED, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getPopupMsgBlock()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_POPUP_BLOCK, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getPopupMsgExpires()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_POPUP_EXPIRES, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getPopupMsgOnlyHome()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_POPUP_ONLY_ON_HOME_PAGE, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getPopupMsgWidth()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_POPUP_WIDTH, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getPopupMsgHeight()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_POPUP_HEIGHT, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getPopupMsgMobile()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_POPUP_SHOW_ON_MOBILE, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getPopupMsgTablet()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_POPUP_SHOW_ON_TABLET, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getFacebookSidebar()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_FACEBOOK_SIDEBAR_ENABLED, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getFacebookSidebarUrl()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_FACEBOOK_SIDEBAR_URL, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getFacebookSidebarHeight()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_FACEBOOK_SIDEBAR_HEIGHT, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getFacebookSidebarShowFriends()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_FACEBOOK_SIDEBAR_SHOW_FRIENDS, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getFacebookSidebarSmallHeader()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_FACEBOOK_SIDEBAR_SHOW_SMALL_HEADER, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getFacebookSidebarShowPosts()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_FACEBOOK_SIDEBAR_SHOW_POSTS, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getFacebookSidebarHideCover()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_FACEBOOK_SIDEBAR_HIDE_COVER, ScopeInterface::SCOPE_STORE);
        return $config;
    }

    public function getFacebookSidebarAdaptWidth()
    {
        $config = $this->scopeConfig->getValue(self::XML_PATH_FACEBOOK_SIDEBAR_ADAPTIVE_WIDTH, ScopeInterface::SCOPE_STORE);
        return $config;
    }

}