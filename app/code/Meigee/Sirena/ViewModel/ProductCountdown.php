<?php
namespace Meigee\Sirena\ViewModel;

use Magento\Framework\Registry;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\App\Request\Http;

/**
 * Class ProductCountdown
 * @package Meigee\Sirena\ViewModel
 */
class ProductCountdown implements ArgumentInterface
{

    /**
     * @var Registry
     */
    private $registry;

    /**
     * @var
     */
    private $product;

    /**
     * @var DateTime
     */
    private $date;

    /**
     * @var Http
     */
    private $request;

    /**
     * ProductCountdown constructor.
     * @param Registry $registry
     * @param DateTime $date
     * @param Http $request
     */
    public function __construct(
        Registry $registry,
        DateTime $date,
        Http $request
    ) {
        $this->registry = $registry;
        $this->date = $date;
        $this->request = $request;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        if (is_null($this->product)) {
            $this->product = $this->registry->registry('current_product');
        }
        return $this->product;
    }

    /**
     * @return string
     */
    public function getTodayDate()
    {
        return $this->date->gmtDate();
    }

    /**
     * @return bool
     */
    public function isCategoryPage()
    {
        if ($this->request->getFullActionName() == 'catalog_category_view') {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function isProductPage()
    {
        if ($this->request->getFullActionName() == 'catalog_product_view') {
            return true;
        }
        return false;
    }

}