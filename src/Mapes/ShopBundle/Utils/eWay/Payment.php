<?php
namespace Mapes\ShopBundle\Utils\eWay;

/**
 * Contains details of a Payment
 */
class Payment {
    public $TotalAmount;
    /// <summary>The merchant's invoice number</summary>
    public $InvoiceNumber;
    /// <summary>merchants invoice description</summary>
    public $InvoiceDescription;
    /// <summary>The merchant's invoice reference</summary>
    public $InvoiceReference;
    /// <summary>The merchant's currency</summary>
    public $CurrencyCode;
}
?>
