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

class psInquiryForm_view extends oxUBase
{

    /**
     * Entered user data.
     *
     * @var array
     */
    protected $_aUserData = null;

    /**
     * Entered inquiry subject.
     *
     * @var string
     */
    protected $_sInquirySubject = null;

    /**
     * Entered conatct message.
     *
     * @var string
     */
    protected $_sInquiryMessage = null;

    /**
     * Class handling CAPTCHA image.
     *
     * @var object
     */
    protected $_oCaptcha = null;

    /**
     * Inquiry email send status.
     *
     * @var object
     */
    protected $_blInquirySendStatus = null;

    /**
     * Current class template name.
     *
     * @var string
     */
    protected $_sThisTemplate = 'psinquiryform_view.tpl';

    /**
     * Current view search engine indexing state
     *
     * @var int
     */
    protected $_iViewIndexState = VIEW_INDEXSTATE_NOINDEXNOFOLLOW;

    /**
     * Composes and sends user written message, returns false if some parameters
     * are missing.
     *
     * @return bool
     */
    public function send()
    {
        $aParams = oxRegistry::getConfig()->getRequestParameter('editval');

        // checking email address
        if (!oxRegistry::getUtils()->isValidEmail($aParams['oxuser__oxusername'])) {
            oxRegistry::get("oxUtilsView")->addErrorToDisplay('ERROR_MESSAGE_INPUT_NOVALIDEMAIL');

            return false;
        }

        // spam spider prevension
        $sMac = oxRegistry::getConfig()->getRequestParameter('c_mac');
        $sMacHash = oxRegistry::getConfig()->getRequestParameter('c_mach');
        $oCaptcha = $this->getCaptcha();

        if (!$oCaptcha->pass($sMac, $sMacHash)) {
            // even if there is no exception, use this as a default display method
            oxRegistry::get("oxUtilsView")->addErrorToDisplay('MESSAGE_WRONG_VERIFICATION_CODE');

            return false;
        }

        /*
         * psInquiryForm: additional code check for required fields disabled
         *
        if (!$aParams['oxuser__oxfname'] || !$aParams['oxuser__oxusername']) {
            // even if there is no exception, use this as a default display method
            oxRegistry::get("oxUtilsView")->addErrorToDisplay('ERROR_MESSAGE_INPUT_NOTALLFIELDS');
            return false;
        }
        */

        $oLang = oxRegistry::getLang();
        $sMessage = $oLang->translateString('PS_INQUIRYFORM_FROM') . " " .
                    $oLang->translateString($aParams['oxuser__oxsal']) . " " .
                    $aParams['oxuser__oxfname'] . " " .
                    $aParams['oxuser__oxlname'] . "(" . $aParams['oxuser__oxusername'] . ")<br /><br />" .
                    nl2br(oxRegistry::getConfig()->getRequestParameter('c_message'));

        $oEmail = oxNew('oxemail');
        $sSubject = oxRegistry::getConfig()->getConfigParam("psinquiryform_settings_subject");
        if ($oEmail->sendInquiryMail($aParams['oxuser__oxusername'], $sSubject, $sMessage)) {
            $this->_blInquirySendStatus = 1;
        } else {
            oxRegistry::get("oxUtilsView")->addErrorToDisplay('ERROR_MESSAGE_CHECK_EMAIL');
        }
    }

    /**
     * Template variable getter. Returns entered user data
     *
     * @return object
     */
    public function getUserData()
    {
        if ($this->_oUserData === null) {
            $this->_oUserData = oxRegistry::getConfig()->getRequestParameter('editval');
        }

        return $this->_oUserData;
    }

    /**
     * Template variable getter. Returns entered inquiry subject
     *
     * @return object
     */
    public function getInquirySubject()
    {
        if ($this->_sInquirySubject === null) {
            $this->_sInquirySubject = oxRegistry::getConfig()->getRequestParameter('c_subject');
        }

        return $this->_sInquirySubject;
    }

    /**
     * Template variable getter. Returns entered message
     *
     * @return object
     */
    public function getInquiryMessage()
    {
        if ($this->_sInquiryMessage === null) {
            $this->_sInquiryMessage = oxRegistry::getConfig()->getRequestParameter('c_message');
        }

        return $this->_sInquiryMessage;
    }

    /**
     * Template variable getter. Returns object of handling CAPTCHA image
     *
     * @return object
     */
    public function getCaptcha()
    {
        if ($this->_oCaptcha === null) {
            $this->_oCaptcha = oxNew('oxCaptcha');
        }

        return $this->_oCaptcha;
    }

    /**
     * Template variable getter. Returns status if email was send succesfull
     *
     * @return object
     */
    public function getInquirySendStatus()
    {
        return $this->_blInquirySendStatus;
    }

    /**
     * Returns Bread Crumb - you are here page1/page2/page3...
     *
     * @return array
     */
    public function getBreadCrumb()
    {
        $aPaths = array();
        $aPath = array();

        $aPath['title'] = oxRegistry::getLang()->translateString('PS_INQUIRYFORM_TITLE', oxRegistry::getLang()->getBaseLanguage(), false);
        $aPath['link'] = $this->getLink();
        $aPaths[] = $aPath;

        return $aPaths;
    }

    /**
     * Page title
     *
     * @return string
     */
    public function getTitle()
    {
        return oxRegistry::getLang()->translateString('PS_INQUIRYFORM_TITLE', oxRegistry::getLang()->getBaseLanguage(), false);
    }
}
