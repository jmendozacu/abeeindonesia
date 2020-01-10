<?php

namespace Sams\RajaongkirPos\Model\Carrier;

use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Shipping\Model\Carrier\CarrierInterface;
use Sams\CustomShipping\Model\Query\Api as ApiData;
use Magento\Store\Model\ScopeInterface;
/**
 * Custom shipping model
 */
class Customshipping extends AbstractCarrier implements CarrierInterface
{
    /**
     * @var string
     */
    protected $_code = 'rajaongkirpos';

    /**
     * @var string
     */
    protected $_courier = 'POS';

    protected $_logger;
    /**
     * @var bool
     */
    protected $_isFixed = true;

    /**
     * @var \Magento\Shipping\Model\Rate\ResultFactory
     */
    protected $_rateResultFactory;

    /**
     * @var \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory
     */
    protected $_rateMethodFactory;

    protected $_apiData;

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory
     * @param \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory,
        \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory,
        ApiData $apiData,
        array $data = []
    ) {
        $this->_rateResultFactory = $rateResultFactory;
        $this->_rateMethodFactory = $rateMethodFactory;
        $this->_logger            = $logger;
        $this->_apiData           = $apiData;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
    }

    /**
     * Custom Shipping Rates Collector
     *
     * @param RateRequest $request
     * @return \Magento\Shipping\Model\Rate\Result|bool
     */
    public function collectRates(RateRequest $request)
    {
        if (!$this->getConfigFlag('active')) {
            return false;
        }

        $storeConfig = $this->_scopeConfig->getValue(
            'general/store_information/city',
            ScopeInterface::SCOPE_STORE
        );

        $weight = $request->getPackageWeight() * 1000;
        /** @var \Magento\Shipping\Model\Rate\Result $result */
        $result = $this->_rateResultFactory->create();

        $allowedCountry = explode(",",$this->getConfigData("specificcountry"));
        if ($request->getDestCountryId() != "ID"){
            $countryIdRajaongkir = $this->_apiData->getCountryDestinationByCode($request->getDestCountryId());
        }

        if (!empty($countryIdRajaongkir) && is_numeric($countryIdRajaongkir)){
            $response = $this->_apiData->getInternationalCost($storeConfig,$countryIdRajaongkir, $weight, $this->_courier);
            if (!empty($response->rajaongkir->results[0]->costs)) {
                foreach ($response->rajaongkir->results[0]->costs as $cost) {
                    $method = $this->generateMethods($cost->service, $cost->cost, $this->_courier);
                    $result->append($method);
                }
            }
        }
        else{
            $destCity = explode("-", $request->getDestCity());
            $destCityId = $destCity[0];
            $response = $this->_apiData->getOngkir($storeConfig, $destCityId, $weight, $this->_courier);
            if (!empty($response->rajaongkir->results[0]->costs)) {
                foreach ($response->rajaongkir->results[0]->costs as $cost) {
                    $method = $this->generateMethods($cost->service, $cost->cost[0]->value, $this->_courier);
                    $result->append($method);
                }
            }
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getAllowedMethods()
    {
        return [$this->_code => $this->getConfigData('name')];
    }

    public function generateMethods($service, $price, $courier)
    {
        $method = $this->_rateMethodFactory->create();
        $method->setCarrier($this->_code);
        $method->setCarrierTitle($courier);
        $method->setMethod($service);
        $method->setMethodTitle($service);
        $method->setPrice($price);
        $method->setCost($price);
        return $method;
    }
}
