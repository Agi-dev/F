<?php
// @codeCoverageIgnoreStart
/**
 * F\Technical\Mail\Adapter\Native is
 * the native adapter for the mail service,
 * that implements PHP natives primitives.
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
 * @see F/Technical/Mail/Adapter/Definition.php
 */
require_once 'F/Technical/Mail/Adapter/Definition.php';
require_once 'Zend/Mail.php';
require_once 'Zend/Validate/EmailAddress.php';

/**
 * F\Technical\Mail\Adapter\Native is the native adapter
 * for the mail service, that implements PHP natives primitives.
 *
 * @category   F
 * @package    F\Technical\Mail\Adapter
 * @copyright  Copyright (c) 2013 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
class Native
    implements Definition
{
	/**
	 * zend mail
	 * @var Zend_Mail
	 */
	protected $_mail;
	
	
	/**
	 * constructeur
	 */
	public function __construct()
	{
		$this->_mail = new \Zend_Mail('UTF-8');
	}
	
	/* (non-PHPdoc)
	 * @see Asm\Technical\Mail\Adapter.Definition::isMailValide()
	 */
	public function isMailValide($email) 
	{
		$validateur = new \Zend_Validate_EmailAddress();
		return $validateur->isValid($email);
	}
	
	/* (non-PHPdoc)
	 * @see Asm\Technical\Mail\Adapter.Definition::sendMail()
	 */
	public function sendMail() 
	{
		$res = $this->_mail->send();
		// On réinitialise le mail
		$this->_mail = new \Zend_Mail('UTF-8');
		return $res;
	}
	
	
	/* (non-PHPdoc)
	 * @see Asm\Technical\Mail\Adapter.Definition::addBcc()
	 */
	public function addBcc($email) 
	{
		return $this->_mail->addBcc($email);
	}
	
	/* (non-PHPdoc)
	 * @see Asm\Technical\Mail\Adapter.Definition::addCc()
	 */
	public function addCc($email, $name = '') 
	{
		return $this->_mail->addCc($email, $name);
	}
	
	/* (non-PHPdoc)
	 * @see Asm\Technical\Mail\Adapter.Definition::addTo()
 	 */
	public function addTo($email, $name = '') 
	{
		return $this->_mail->addTo($email, $name);
	}
	
	/* (non-PHPdoc)
	 * @see Asm\Technical\Mail\Adapter.Definition::setBodyText()
	 */
	public function setBodyText($txt, $charset = null, $encoding = \Zend_Mime::ENCODING_QUOTEDPRINTABLE) 
	{
		return $this->_mail->setBodyText($txt, $charset, $encoding);
	}
	
	/* (non-PHPdoc)
	 * @see Asm\Technical\Mail\Adapter.Definition::setSubject()
	 */
	public function setSubject($subject) 
	{
		return $this->_mail->setSubject($subject);
	}
	
	/* (non-PHPdoc)
	 * @see Asm\Technical\Mail\Adapter.Definition::setFrom()
	 */
	public function setFrom($email, $name = null) 
	{
		return $this->_mail->setFrom($email, $name);
	}
	
	/* (non-PHPdoc)
	 * @see Asm\Technical\Mail\Adapter.Definition::addAttachment()
	 */
	public function addAttachment($filename, $mime) 
	{
		$this->_mail->createAttachment(file_get_contents($filename), $mime,
				\Zend_Mime::DISPOSITION_INLINE, \Zend_Mime::ENCODING_BASE64, basename($filename));
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \F\Technical\Mail\Adapter\Definition::isFileExists()
	 */
	public function isFileExists($filename)
	{
		return \F\Technical\Filesystem\Service::singleton()->isFileExists($filename);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \F\Technical\Mail\Adapter\Definition::getFileMimeType()
	 */
	public function getFileMimeType($filename)
	{
		return \F\technical\filesystem\Service::singleton()->getMimeType($filename);
	}
}
// @codeCoverageIgnoreEnd