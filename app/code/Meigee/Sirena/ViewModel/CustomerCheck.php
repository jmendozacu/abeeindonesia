<?php
namespace Meigee\Sirena\ViewModel;

use Magento\Customer\Model\Context;

/**
 * Class CustomerCheck
 * @package Meigee\Sirena\ViewModel
 */
class CustomerCheck implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /**
     * @var \Magento\Framework\App\Http\Context
     */
    protected $httpContext;

    /**
     * CustomerCheck constructor.
     * @param \Magento\Framework\App\Http\Context $httpContext
     */
    public function __construct(
        \Magento\Framework\App\Http\Context $httpContext
    ) {
        $this->httpContext = $httpContext;
    }

    /**
     * @return mixed|null
     */
    public function isCustomerLoggedIn()
    {
    	return $this->httpContext->getValue(Context::CONTEXT_AUTH);
    }
}