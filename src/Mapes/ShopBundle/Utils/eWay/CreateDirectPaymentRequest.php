<?php
namespace Mapes\ShopBundle\Utils\eWay;

use Mapes\ShopBundle\Utils\eWay\CardCustomer;
use Mapes\ShopBundle\Utils\eWay\ShippingAddress;
use Mapes\ShopBundle\Utils\eWay\Payment;


/**
 * Contains details to complete a Direct Payment
 */
class CreateDirectPaymentRequest {
    public $Customer;

    public $ShippingAddress;
    public $Items;
    public $Options;

    public $Payment;
    public $CustomerIP;
    public $DeviceID;
    public $TransactionType;
    public $PartnerID;

    function __construct() {
        $this->Customer = new CardCustomer();
        $this->ShippingAddress = new ShippingAddress();
        $this->Payment = new Payment();
        $this->CustomerIP = $_SERVER["REMOTE_ADDR"];
    }
}

?>
