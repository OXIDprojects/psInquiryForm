<?php
/**
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @copyright (c) Proud Sourcing GmbH | 2016
 * @link www.proudcommerce.com
 * @package psInquiryForm
 * @version 1.0.0
 **/

class psInquiryForm_oxemail extends psInquiryForm_oxemail_parent
{
    /**
     * Sets mailer additional settings and sends inquiry info mail to user.
     * Returns true on success.
     *
     * @param string $sEmailAddress Email address
     * @param string $sSubject      Email subject
     * @param string $sMessage      Email message text
     *
     * @return bool
     */
    public function sendInquiryMail($sEmailAddress = null, $sSubject = null, $sMessage = null)
    {

        // shop info
        $oShop = $this->_getShop();

        //set mail params (from, fromName, smtp)
        $this->_setMailParams($oShop);

        $this->setBody($sMessage);
        $this->setSubject($sSubject);

        $this->setRecipient(oxRegistry::getConfig()->getConfigParam("psinquiryform_settings_email"), "");
        $this->setFrom($oShop->oxshops__oxowneremail->value, $oShop->oxshops__oxname->getRawValue());
        $this->setReplyTo($sEmailAddress, "");

        return $this->send();
    }
}
