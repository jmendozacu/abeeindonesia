<?php
namespace Meigee\Sirena\Block\ProductWidget\Product;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\CatalogWidget\Model\Rule;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Serialize\Serializer\Json as JsonSerializer;
use Magento\Rule\Model\Condition\Sql\Builder;
use Magento\Widget\Helper\Conditions;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Meigee\ProductWidget\Block\Product\ProductsList;
use Meigee\Sirena\ViewModel\ThemeConfigPhp;
use Meigee\Sirena\ViewModel\ProductLabels;
use Meigee\Sirena\ViewModel\EnabledModuleCheck;

/**
 * Class ProductsListExtended
 * @package Meigee\Sirena\Block\ProductWidget\Product
 */
class ProductsListExtended extends ProductsList
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * Default value for number products per row on desktop (for custom auto grid)
     */
    const DEFAULT_PRODUCTS_PER_ROW_AUTO_GRID = 4;

    /**
     * Default value for number products per row on vertical tablet (for custom auto grid)
     */
    const DEFAULT_PRODUCTS_PER_ROW_TABLET_AUTO_GRID = 3;

    /**
     * Default value for number products per row on mobile (for custom auto grid)
     */
    const DEFAULT_PRODUCTS_PER_ROW_MOBILE_AUTO_GRID = 1;

    /**
     * Theme options
     *
     * @var \Meigee\Sirena\ViewModel\ThemeConfigPhp
     */
    private $themeConfigPhp;

    /**
     * @var ProductLabels
     */
    private $productLabels;

    /**
     * @var EnabledModuleCheck
     */
    private $enabledModuleCheck;

    /**
     * ProductsListExtended constructor.
     * @param Context $context
     * @param CollectionFactory $productCollectionFactory
     * @param HttpContext $httpContext
     * @param CategoryRepositoryInterface $categoryRepository
     * @param Rule $rule
     * @param Conditions $conditionsHelper
     * @param Builder $sqlBuilder
     * @param JsonSerializer $jsonSerializer
     * @param ResourceConnection $resource
     * @param Visibility $catalogProductVisibility
     * @param ScopeConfigInterface $scopeConfig
     * @param ThemeConfigPhp $themeConfigPhp
     * @param ProductLabels $productLabels
     * @param EnabledModuleCheck $enabledModuleCheck
     * @param array $data
     */
    public function __construct(
        Context $context,
        CollectionFactory $productCollectionFactory,
        HttpContext $httpContext,
        CategoryRepositoryInterface $categoryRepository,
        Rule $rule,
        Conditions $conditionsHelper,
        Builder $sqlBuilder,
        JsonSerializer $jsonSerializer,
        ResourceConnection $resource,
        Visibility $catalogProductVisibility,
        ScopeConfigInterface $scopeConfig,
        ThemeConfigPhp $themeConfigPhp,
        ProductLabels $productLabels,
        EnabledModuleCheck $enabledModuleCheck,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $productCollectionFactory,
            $httpContext,
            $categoryRepository,
            $rule,
            $conditionsHelper,
            $sqlBuilder,
            $jsonSerializer,
            $resource,
            $catalogProductVisibility,
            $data
        );
        $this->scopeConfig = $scopeConfig;
        $this->themeConfigPhp = $themeConfigPhp;
        $this->productLabels = $productLabels;
        $this->moduleEnabledCheck = $enabledModuleCheck;
    }

    /**
     * Return theme option: getLightbox
     *
     * @return string
     */
    public function getPhpConfigLigtbox()
    {
        return $this->themeConfigPhp->getLightbox();
    }

    /**
     * Return theme option: getLightboxHome
     *
     * @return string
     */
    public function getPhpConfigLigtboxHome()
    {
        return $this->themeConfigPhp->getLightboxHome();
    }

    /**
     * Return theme option: getProductShowQuickviewBtn
     *
     * @return string
     */
    public function getPhpConfigQuickview()
    {
        return $this->themeConfigPhp->getProductShowQuickviewBtn();
    }

    /**
     * Return theme option: getProductHoverType
     *
     * @return string
     */
    public function getPhpConfigHoverType()
    {
        return $this->themeConfigPhp->getProductHoverType();
    }

    /**
     * Return theme option: getLabelsType
     *
     * @return string
     */
    public function getPhpConfigLabelsType()
    {
        return $this->themeConfigPhp->getLabelsType();
    }

    /**
     * @param $product
     * @return bool
     */
    public function getProductNew($product)
    {
        return $this->productLabels->getProductNew($product);
    }

    /**
     * @param $product
     * @return bool
     */
    public function getProductSale($product)
    {
        return $this->productLabels->getProductSale($product);
    }

    /**
     * @param $product
     * @return bool|float|int
     */
    public function getProductOnlyLeft($product)
    {
        return $this->productLabels->getProductOnlyLeft($product);
    }

    /**
     * @param $product
     * @return bool|float|int|string
     */
    public function getProductSalePercent($product)
    {
        return $this->productLabels->getProductSalePercent($product);
    }

    /**
     * @return mixed
     */
    public function getPhpConfigCustomHover()
    {
        return $this->themeConfigPhp->getProductCustomHover();
    }

    /**
     * Return theme option: getProductCustomHoverType
     *
     * @return string
     */
    public function getPhpConfigCustomHoverType()
    {
        return $this->themeConfigPhp->getProductCustomHoverType();
    }

    /**
     * Return theme option: getSiteRtl
     *
     * @return string
     */
    public function getPhpConfigIsRtl()
    {
        return $this->themeConfigPhp->getSiteRtl();
    }

    /**
     * @param $configPath
     * @return mixed
     */
    public function getConfig($configPath)
    {
        return $this->scopeConfig->getValue(
            $configPath,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return bool
     */
    public function isQuickviewEnable()
    {
        if (!$this->moduleEnabledCheck->isModuleEnabled('WeltPixel_Quickview')) {
            return false;
        }
        return $this->getConfig('weltpixel_quickview/general/enable_product_listing');
    }

    /**
     *  Get value of grid widget number products per row on desktop parameter (for custom auto grid)
     *
     * @return string
     */
    public function getAutoGridProductItemCssLg()
    {
        if (!$this->hasData('products_per_row_auto_grid')) {
            $this->setData('products_per_row_auto_grid', self::DEFAULT_PRODUCTS_PER_ROW_AUTO_GRID);
        }
        return $this->getData('products_per_row_auto_grid');
    }

    /**
     *  Get value of grid widget number products per row on desktop parameter (for custom auto grid)
     *
     * @return string
     */
    public function getAutoGridProductItemCssMd()
    {
        if (!$this->hasData('products_per_row_auto_grid')) {
            $this->setData('products_per_row_auto_grid', self::DEFAULT_PRODUCTS_PER_ROW_AUTO_GRID);
        }
        return $this->getData('products_per_row_auto_grid');
    }

    /**
     *  Get value of grid widget number products per row on vertical tablet parameter (for custom auto grid)
     *
     * @return string
     */
    public function getAutoGridProductItemCssSm()
    {
        if (!$this->hasData('products_per_row_tablet_auto_grid')) {
            $this->setData('products_per_row_tablet_auto_grid', self::DEFAULT_PRODUCTS_PER_ROW_TABLET_AUTO_GRID);
        }
        return $this->getData('products_per_row_tablet_auto_grid');
    }

    /**
     *  Get value of grid widget number products per row on mobile parameter (for custom auto grid)
     *
     * @return string
     */
    public function getAutoGridProductItemCssXs()
    {
        if (!$this->hasData('products_per_row_mobile_auto_grid')) {
            $this->setData('products_per_row_mobile_auto_grid', self::DEFAULT_PRODUCTS_PER_ROW_MOBILE_AUTO_GRID);
        }
        return $this->getData('products_per_row_mobile_auto_grid');
    }

    /**
     * Generate media css classes of grid width on all devices (for custom auto grid)
     *
     * @return string
     */
    public function getAutoGridProductItemMediaCss()
    {
        $productItemMediaCss = $this->getMediaClass($this->getAutoGridProductItemCssLg(), self::MEDIA_CSS_LG);
        $productItemMediaCss .= $this->getMediaClass($this->getAutoGridProductItemCssMd(), self::MEDIA_CSS_MD);
        $productItemMediaCss .= $this->getMediaClass($this->getAutoGridProductItemCssSm(), self::MEDIA_CSS_SM);
        $productItemMediaCss .= $this->getMediaClass($this->getAutoGridProductItemCssXs(), self::MEDIA_CSS_XS);
        return trim($productItemMediaCss);
    }

    /**
     * Retrieve how many product slides should be displayed per page
     *
     * @return int
     */
    public function getVisibleSlides()
    {
        if ($this->hasData('visible_products')) {
            return $this->getData('visible_products');
        }
        return false;
    }

}
