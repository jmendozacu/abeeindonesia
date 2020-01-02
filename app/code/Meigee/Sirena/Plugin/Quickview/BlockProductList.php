<?php

namespace Meigee\Sirena\Plugin\Quickview;

class BlockProductList
{

    public function aroundGetProductDetailsHtml(
        \Magento\Catalog\Block\Product\ListProduct $subject,
        \Closure $proceed,
        \Magento\Catalog\Model\Product $product
        )
    {
        $result = $proceed($product);
        return $result;
    }
}
