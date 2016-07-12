<?php
/**
 * A PHP eWAY Rapid API library implementation.
 * This class is an example of how to connect to eWAY's Rapid API.
 *
 * Requires PHP 5.3 or greater with the cURL extension
 *
 * @see http://api-portal.anypoint.mulesoft.com/eway/api/eway-rapid-31-api/docs/
 * @version 1.0
 * @package eWAY
 * @author eWAY
 * @copyright (c) 2014, Web Active Corporation Pty Ltd
 */

//namespace eWAY;

/**
 * eWAY Rapid 3.1 Library
 *
 * Check examples for usage
 *
 * @package eWAY
 */
 
namespace Mapes\ShopBundle\Utils\eWay;

use Mapes\ShopBundle\Utils\eWay\ResponseCode;
use Mapes\ShopBundle\Utils\eWay\Options;
use Mapes\ShopBundle\Utils\eWay\Option;
use Mapes\ShopBundle\Utils\eWay\Items;
use Mapes\ShopBundle\Utils\eWay\LineItem;


class RapidAPI {

    /**
     * @var string the eWAY endpoint
     */
    private $_url;

    /**
     * @var bool true if using eWAY sandbox
     */
    private $sandbox;

    /**
     * @var string the eWAY API key
     */
    private $username;

    /**
     * @var string the eWAY API password
     */
    private $password;

    /**
     * RapidAPI constructor
     *
     * @param string $username your eWAY API Key
     * @param string $password your eWAY API Password
     * @param string $params set $params['sandbox'] to true to use the sandbox for testing
     */
    function __construct($username, $password, $params=array()) {
        if (strlen($username) === 0 || strlen($password) === 0) {
            die("Username and Password are required");
        }

        $this->username = $username;
        $this->password = $password;

        if (count($params) && isset($params['sandbox']) && $params['sandbox']) {
            $this->_url = 'https://api.sandbox.ewaypayments.com/';
            $this->sandbox = true;
        } else {
            $this->_url = 'https://api.ewaypayments.com/';
            $this->sandbox = false;
        }
    }

    /**
     * Create a request for a Transparent Redirect Access Code
     *
     * @param eWAY\CreateAccessCodeRequest $request
     * @return object
     */
    public function CreateAccessCode($request) {
        if ( isset($request->Options) && count($request->Options->Option) ) {
            $i = 0;
            $tempClass = new \stdClass();
            foreach ($request->Options->Option as $Option) {
                $tempClass->Options[$i] = $Option;
                $i++;
            }
            $request->Options = $tempClass->Options;
        }
        if ( isset($request->Items) && count($request->Items->LineItem) ) {
            $i = 0;
            $tempClass = new \stdClass();
            foreach ($request->Items->LineItem as $LineItem) {
                // must be strings
                $LineItem->Quantity = strval($LineItem->Quantity);
                $LineItem->UnitCost = strval($LineItem->UnitCost);
                $LineItem->Tax = strval($LineItem->Tax);
                $LineItem->Total = strval($LineItem->Total);
                $tempClass->Items[$i] = $LineItem;
                $i++;
            }
            $request->Items = $tempClass->Items;
        }

        $request = json_encode($request);
        $response = $this->PostToRapidAPI("AccessCodes", $request);
        return json_decode($response);
    }

    /**
     * Get the result from an AccessCode after a customer has completed
     * a payment
     *
     * @param eWAY\GetAccessCodeResultRequest $request
     * @return object
     */
    public function GetAccessCodeResult($request) {
        $request = json_encode($request);
        $response = $this->PostToRapidAPI("AccessCode/" . $_GET['AccessCode'], $request, false);
        return json_decode($response);
    }

    /**
     * Create an AccessCode for a Responsive Shared Page payment
     *
     * @param eWAY\CreateAccessCodesSharedRequest $request
     * @return object type
     */
    public function CreateAccessCodesShared($request) {
        if ( isset($request->Options) && count($request->Options->Option) ) {
            $i = 0;
            $tempClass = new \stdClass();
            foreach ($request->Options->Option as $Option) {
                $tempClass->Options[$i] = $Option;
                $i++;
            }
            $request->Options = $tempClass->Options;
        }
        if ( isset($request->Items) && count($request->Items->LineItem) ) {
            $i = 0;
            $tempClass = new \stdClass();
            foreach ($request->Items->LineItem as $LineItem) {
                // must be strings
                $LineItem->Quantity = strval($LineItem->Quantity);
                $LineItem->UnitCost = strval($LineItem->UnitCost);
                $LineItem->Tax = strval($LineItem->Tax);
                $LineItem->Total = strval($LineItem->Total);
                $tempClass->Items[$i] = $LineItem;
                $i++;
            }
            $request->Items = $tempClass->Items;
        }

        $request = json_encode($request);
        $response = $this->PostToRapidAPI("AccessCodesShared", $request);
        return json_decode($response);
    }


    /**
     * Perform a Direct Payment
     *
     * Note: Before being able to send credit card data via the direct API, eWAY
     * must enable it on the account. To be enabled on a live account eWAY must
     * receive proof that the environment is PCI-DSS compliant.
     *
     * @param eWAY\CreateDirectPaymentRequest $request
     * @return object
     */
    public function DirectPayment($request) {
        if ( isset($request->Options) && count($request->Options->Option) ) {
            $i = 0;
            $tempClass = new \stdClass();
            foreach ($request->Options->Option as $Option) {
                $tempClass->Options[$i] = $Option;
                $i++;
            }
            $request->Options = $tempClass->Options;
        }
        if ( isset($request->Items) && count($request->Items->LineItem) ) {
            $i = 0;
            $tempClass = new \stdClass();
            foreach ($request->Items->LineItem as $LineItem) {
                $tempClass->Items[$i] = $LineItem;
                $i++;
            }
            $request->Items = $tempClass->Items;
        }

        $request = json_encode($request);
        $response = $this->PostToRapidAPI("Transaction", $request);
        return json_decode($response);
    }

    /**
     * Fetches the message associated with a Response Code
     *
     * @param string $code
     * @return string
     */
    public function getMessage($code) {
        return ResponseCode::getMessage($code);
    }

    /**
     * A Function for doing a Curl GET/POST
     *
     * @param string $url the path for this request
     * @param Request $request
     * @param boolean $IsPost set to false to perform a GET
     * @return string
     */
    private function PostToRapidAPI($url, $request, $IsPost = true) {
        $url = $this->_url . $url;
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
        curl_setopt($ch, CURLOPT_USERPWD, $this->username . ":" . $this->password);
        if ($IsPost)
            curl_setopt($ch, CURLOPT_POST, true);
        else
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        // Uncomment this if you are getting SSL errors (common in WAMP)
        // Make sure it is enabled when you go live!
        if($this->sandbox)
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        

        // Ucomment for CURL debugging
        //curl_setopt($ch, CURLOPT_VERBOSE, true);

        $response = curl_exec($ch);

        if (curl_errno($ch) != CURLE_OK) {
            echo "<h2>POST Error: " . curl_error($ch) . " URL: $url</h2><pre>";
            die();
        } else {
            $info = curl_getinfo($ch);
            if ($info['http_code'] == 401 || $info['http_code'] == 404) {
                $__is_in_sandbox = $this->sandbox ? ' (Sandbox)' : ' (Live)';
                echo "<h2>Please check the API Key and Password $__is_in_sandbox</h2><pre>";
                die();
            }

            curl_close($ch);
            return $response;
        }
    }
}

