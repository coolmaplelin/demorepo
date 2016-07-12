<?php
namespace Mapes\ShopBundle\Utils\eWay;
/**
 * Contains details to create a Shared Page Redirect
 */
class CreateAccessCodesSharedRequest extends CreateAccessCodeRequest {
    public $CancelUrl;
    public $LogoUrl;
    public $HeaderText;
    public $CustomerReadOnly;
}

?>
