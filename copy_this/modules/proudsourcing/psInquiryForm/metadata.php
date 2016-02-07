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

/**
 * Metadata version
 */
$sMetadataVersion = '1.1';

/**
 * Module information
 */
$aModule = array(
    'id'           => 'psInquiryForm',
    'title'        => 'psInquiryForm',
    'description'  => array(
        'de' => 'Anfrageformular mit eigenen Felder (analog Kontaktformular).',
        'en' => 'Inquiry form with individual fields (analogical contact form).'
    ),
    'thumbnail'    => 'logo.jpg',
    'version'      => '1.0.0',
    'author'       => 'Proud Sourcing GmbH',
    'url'          => 'http://www.proudcommerce.com/',
    'email'        => 'support@proudcommerce.com',
    'extend'       => array(
        'oxemail'     => 'proudsourcing/psInquiryForm/core/psinquiryform_oxemail',
    ),
    'files' => array(
        'psinquiryform_view'     => 'proudsourcing/psInquiryForm/application/controllers/psinquiryform_view.php',
    ),
    'templates' => array(
        'psinquiryform_view.tpl'          => 'proudsourcing/psInquiryForm/application/views/azure/tpl/psinquiryform_view.tpl',
    ),
    'blocks' => array(
    ),
    'settings' => array(
        array('group' => 'psinquiryform_settings', 'name' => 'psinquiryform_settings_email', 'type' => 'str', 'value' => "", 'position' => 1),
        array('group' => 'psinquiryform_settings', 'name' => 'psinquiryform_settings_subject', 'type' => 'str', 'value' => "Anfrage", 'position' => 2),
    ),
);