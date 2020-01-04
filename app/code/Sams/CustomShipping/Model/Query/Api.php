<?php
namespace Sams\CustomShipping\Model\Query;

use Magento\Framework\HTTP\ZendClientFactory;

class Api
{
    const CITY_KAB = 'Kabupaten';
    const CITY_KOT = 'Kota';

    protected $_httpClient;
    protected $key;

    public function __construct(ZendClientFactory $httpClient)
    {
        $this->_httpClient = $httpClient;
        $this->key = '740f60f5764adf293b88989e737101fe';
    }

    public function apiCaller($url, $method, $params, $header = null)
    {
        $apiCaller = $this->_httpClient->create();
        $apiCaller->setUri($url);
        $apiCaller->setMethod($method);
        $apiCaller->setHeaders([
            'Content-Type: application/x-www-form-urlencoded',
            'Accept: application/json',
            'Key: ' . $this->key,
        ]);

        $apiCaller->setParameterPost($params); //or parameter get
        return $apiCaller->request();
    }

    public function getOngkir($origin, $destination, $weight, $courier)
    {
        $params = [
            'origin'          => $origin,
            'originType'      => 'city',
            'destination'     => $destination,
            'destinationType' => 'city',
            'weight'          => $weight,
            'courier'         => strtolower($courier)
        ];

        $ongkir = $this->apiCaller('https://pro.rajaongkir.com/api/cost', \Zend_Http_Client::POST, $params, $this->key);

        if ($ongkir->getStatus() == 200) {
            return json_decode($ongkir->getBody());
        } else {
            return 0;
        }
    }

    /**
     * Get all provinces from RajaOngkir.
     * 
     * @return object
     */
    public function getProvinces()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: {$this->key}"
            ),
        ));

        $response = json_decode(curl_exec($curl));
        $err = curl_error($curl);

        // curl_close($curl);
        // echo 'string';
        // var_dump($response);
        // var_dump($err);
        // die;

        if (!empty($err)) {
            return "cURL Error #:" . $err;
        } else {
            $results = array();

            if (!empty($response->rajaongkir->results)) {
                foreach($response->rajaongkir->results as $result) {
                    $results[$result->province_id] = $result->province;
                }
            }

            return $results;
        }
    }

    /**
     * Get all cities from RajaOngkir.
     * 
     * @return object
     */
    public function getCities()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/city",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: {$this->key}"
            ),
        ));

        $response = json_decode(curl_exec($curl));
        $err = curl_error($curl);

        curl_close($curl);

        if (!empty($err)) {
            return "cURL Error #:" . $err;
        } else {
            $results = array();

            if (!empty($response->rajaongkir->results)) {
                foreach($response->rajaongkir->results as $result) {
                    $results[$result->city_id] = $result->city_name;
                }
            }

            return $results;
        }
    }

    /**
     * Get all subdistrict from RajaOngkir.
     * 
     * @return object
     */
    public function getSubdistrict($city)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/subdistrict",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: {$this->key}"
            ),
        ));

        $response = json_decode(curl_exec($curl));
        $err = curl_error($curl);

        curl_close($curl);

        if (!empty($err)) {
            return "cURL Error #:" . $err;
        } else {
            $results = array();

            if (!empty($response->rajaongkir->results)) {
                foreach($response->rajaongkir->results as $result) {
                    $results[$result->city_id] = $result->city_name;
                }
            }

            return $results;
        }
    }
}
