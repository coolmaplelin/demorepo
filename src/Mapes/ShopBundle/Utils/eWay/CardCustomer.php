<?php
namespace Mapes\ShopBundle\Utils\eWay;

use Mapes\ShopBundle\Utils\eWay\CardDetails;

/**
 * Contains details of a Customer with card details
 */
class CardCustomer extends Customer {
    function __construct() {
        $this->CardDetails = new CardDetails();
    }
}

?>
