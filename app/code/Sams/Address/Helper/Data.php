<?php
namespace Sams\Address\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;
 
class Data extends AbstractHelper
{
    /**
     * Get all provinces from RajaOngkir.
     * 
     * @return object
     */
    public function getProvinces()
    {
        $data = ["province_id" => "1", "province" => "Bali"];
        return $data;
        $api_key = $this->scopeConfig->getValue(
            'rajaongkir/general/api_key',
            ScopeInterface::SCOPE_STORE
		);
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
                "key: {$api_key}"
            ),
        ));

        $response = json_decode(curl_exec($curl));
        $err = curl_error($curl);

        curl_close($curl);

        if (!empty($err)) {
            return "cURL Error #:" . $err;
        } else {
            $results = array();
            $previous_province = '';

            if (!empty($response->rajaongkir->results)) {
                foreach($response->rajaongkir->results as $result) {
                    if ($previous_province == $result->province) {
                        continue;
                    } else {
                        $previous_province = $result->province;
                    }

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
        $api_key = $this->scopeConfig->getValue(
            'rajaongkir/general/api_key',
            ScopeInterface::SCOPE_STORE
		);
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
                "key: {$api_key}"
            ),
        ));

        $response = json_decode(curl_exec($curl));
        $err = curl_error($curl);

        curl_close($curl);

        if (!empty($err)) {
            return "cURL Error #:" . $err;
        } else {
            $results = array();
            $previous_city = '';

            if (!empty($response->rajaongkir->results)) {
                foreach($response->rajaongkir->results as $result) {
                    if ($previous_city == $result->city_name) {
                        continue;
                    } else {
                        $previous_city = $result->city_name;
                    }

                    $results[$result->city_id] = $result->city_name;
                }
            }

            return $results;
        }
    }

    /**
     * Get all cities filtered by province from RajaOngkir.
     *
     * @return object
     */
    public function getCitiesByProvince()
    {
        $api_key = $this->scopeConfig->getValue(
            'rajaongkir/general/api_key',
            ScopeInterface::SCOPE_STORE
        );
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
                "key: {$api_key}"
            ),
        ));

        $response = json_decode(curl_exec($curl));
        $err = curl_error($curl);

        curl_close($curl);

        if (!empty($err)) {
            return "cURL Error #:" . $err;
        } else {
            $results = array();
            $previous_city = '';

            if (!empty($response->rajaongkir->results)) {
                foreach($response->rajaongkir->results as $result) {
                    if ($previous_city == $result->city_name) {
                        continue;
                    } else {
                        $previous_city = $result->city_name;
                    }

                    $results[$result->province_id][$result->city_id] = $result->city_name;
                }
            }

            return $results;
        }
    }
}