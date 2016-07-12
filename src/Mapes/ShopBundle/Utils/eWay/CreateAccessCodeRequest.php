<?php

/**
 * Contains details to create a Transparent Redirect Access Code
 */
namespace Mapes\ShopBundle\Utils\eWay;

use Mapes\ShopBundle\Utils\eWay\Customer;
use Mapes\ShopBundle\Utils\eWay\ShippingAddress;
use Mapes\ShopBundle\Utils\eWay\Payment;

class CreateAccessCodeRequest {
    public $Customer;

    public $ShippingAddress;
    public $Items;
    public $Options;

    public $Payment;
    public $RedirectUrl;
    public $Method;
    public $TransactionType;
    public $CustomerIP;
    public $DeviceID;

    function __construct() {
        $this->Customer = new Customer();
        $this->ShippingAddress = new ShippingAddress();
        $this->Payment = new Payment();
        $this->CustomerIP = $_SERVER["REMOTE_ADDR"];
    }
}

?>
