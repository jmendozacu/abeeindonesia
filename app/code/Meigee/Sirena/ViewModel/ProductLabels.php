<?php
namespace Meigee\Sirena\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class ProductLabels
 * @package Meigee\Sirena\ViewModel
 */
class ProductLabels implements ArgumentInterface
{
    private $localeDate;
    private $scopeConfig;
    private $stockItemRepository;
    private $themeConfig;

    /**
     * ProductLabels constructor.
     * @param TimezoneInterface $localeDate
     * @param ScopeConfigInterface $scopeConfig
     * @param StockRegistryInterface $stockItemRepository
     * @param ThemeConfigPhp $themeConfig
     */
    public function __construct(
        TimezoneInterface $localeDate,
        ScopeConfigInterface $scopeConfig,
        StockRegistryInterface $stockItemRepository,
        ThemeConfigPhp $themeConfig
    ) {
        $this->localeDate = $localeDate;
        $this->scopeConfig = $scopeConfig;
        $this->stockItemRepository = $stockItemRepository;
        $this->themeConfig = $themeConfig;
    }

    /**
     * @param $product
     * @return bool
     */
    public function getProductNew($product)
    {
        if (!$this->themeConfig->getLabelsShowNew()) {
            return false;
        }

        $newsFromDate = $product->getNewsFromDate();
        $newsToDate = $product->getNewsToDate();
        if (!$newsFromDate && !$newsToDate) {
            return false;
        }

        return $this->localeDate->isScopeDateInInterval(
            $product->getStore(),
            $newsFromDate,
            $newsToDate
        );
    }

    /**
     * @param $product
     * @return bool
     */
    public function getProductSale($product)
    {
        if (!$this->themeConfig->getLabelsShowSale()) {
            return false;
        }

        $finalPrice = $product->getPriceInfo()->getPrice('final_price')->getAmount()->getValue();
        $regularPrice = $product->getPriceInfo()->getPrice('regular_price')->getAmount()->getValue();
        if($regularPrice != $finalPrice){
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $product
     * @return bool|float|int
     */
    public function getProductOnlyLeft($product)
    {
        if (!$this->themeConfig->getLabelsShowOnlyLeft()) {
            return false;
        }

        $stockThresholdQty = $this->scopeConfig->getValue('cataloginventory/options/stock_threshold_qty', ScopeInterface::SCOPE_STORE);
        $productStockItem = $this->stockItemRepository->getStockItem($product->getId(), $product->getStore()->getWebsiteId());
        if(!empty($productStockItem->getData())) {
            $productQty = $productStockItem->getQty();
            if($productQty != 0 and $productQty < $stockThresholdQty){
                return $productQty + 1;
            }else{
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * @param $product
     * @return bool|float|int|string
     */
    public function getProductSalePercent($product)
    {
        if (!$this->themeConfig->getLabelsShowPercentage()) {
            return false;
        }

        $finalPrice = $product->getPriceInfo()->getPrice('final_price')->getAmount()->getValue();
        $regularPrice = $product->getPriceInfo()->getPrice('regular_price')->getAmount()->getValue();
        if($finalPrice && $regularPrice) {
            $sale = 100 - (($finalPrice * 100)/$regularPrice);
            $sale = number_format($sale);
            if($sale > 0) {
                return $sale;
            } else {
                return false;
            }
        }
        return false;
    }
}
