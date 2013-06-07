<?php
// @codeCoverageIgnoreStart
/**
 * F\Technical\Mail\Adapter\Definition
 * is the adapter interface for the mail service.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    fschneider <fschneider@astek.fr>
 * @package    F\Technical\Mail\Adapter
 * @copyright Copyright (c) 2013 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Mail\Adapter;

/**
 * F\Technical\Mail\Adapter\Definition
 * is the adapter interface for the mail service
 * that define all the primitives required.
 *
 * @category   F
 * @package    F\Technical\Mail\Adapter
 * @copyright  Copyright (c) 2013 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
interface Definition
{
	/**
	 * Return true si le mail est valide
	 * @param string $email
	 * @return boolean
	 */
	public function isMailValide($email);
	
	/**
	 * Envoie le mail
	 * @return bool
	 */
	public function sendMail();
	
	/**
	 * Sets the subject of the message
	 *
	 * @param   string    $subject
	 * @throws  \Zend_Mail_Exception
	 */
	public function setSubject($subject);
	
	/**
	 * Adds To-header and recipient, $email can be an array, or a single string address
	 *
	 * @param  string|array $email
	 * @param  string $name
	 */
	public function addTo($email, $name='');
	
	/**
	 * Adds Cc-header and recipient, $email can be an array, or a single string address
	 *
	 * @param  string|array    $email
	 * @param  string    $name
	 */
	public function addCc($email, $name='');
	
	/**
	 * Adds Bcc recipient, $email can be an array, or a single string address
	 *
	 * @param  string|array    $email
	 */
	public function addBcc($email);
	
	/**
	 * Sets the text body for the message.
	 *
	 * @param  string $txt
	 * @param  string $charset
	 * @param  string $encoding
	 */
	public function setBodyText($txt, $charset = null, $encoding = \Zend_Mime::ENCODING_QUOTEDPRINTABLE);
	
	/**
	 * Sets From-header and sender of the message
	 *
	 * @param  string    $email
	 * @param  string    $name
	 * @return Zend_Mail Provides fluent interface
	 * @throws Zend_Mail_Exception if called subsequent times
	 */
	public function setFrom($email, $name = null);
	
	/**
	 * ajoute un fichier joint au mail
	 * @param string $filename
	 * @param string $mime
	 * @return \Asm\Technical\Mail\Adapter\Definition
	 */
	public function addAttachment($filename, $mime);
	
	/**
	 * Verifie que le fichier existe
	 * @param string $filename
	 * @return bool
	 */
	public function isFileExists($filename);
	
	/**
	 * Récupère le mime type du fichier
	 *  
	 * @param unknown $filename
	 * 
	 * @return string
	 */
	public function getFileMimeType($filename);
}
// @codeCoverageIgnoreEnd