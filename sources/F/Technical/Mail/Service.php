<?php
/**
 * F\Technical\Mail\Service is a class to handle mail operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    fschneider <fschneider@astek.fr>
 * @package   F\Technical\Mail
 * @copyright Copyright (c) 2013 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Mail;

/**
 * @see F/Technical/Abstract/Service.php
 */
require_once 'F/Technical/Base/Service.php';

/**
 * F\Technical\Mail\Service is a class to handle mail operations.
 *
 * @category F
 * @package F\Technical\Mail
 * @copyright Copyright (c) 2013 <COPYRIGHT>
 * @license <LICENSE>
 * @version Release: @package_version@
 * @since Class available since Release 0.0.1
 */
class Service
    extends \F\Technical\Base\Service
{
	/**
	 * Returns the singleton of this service
	 *
	 * @return \F\Technical\Mail\Service
	 */
	public static function singleton()
	{
		return parent::singleton();
	}
	/**
	 * Returns an instance of this service
	 *
	 * @return \F\Technical\Mail\Service
	 */
	public static function factory($adapter = null)
	{
		return parent::factory($adapter);
	}
	/**
	 * Returns the underlying adapter
	 *
	 * @return \F\Technical\Mail\Adapter\Definition
	 */
	public function getAdapter()
	{
		return parent::getAdapter();
	}
	
	/**
	 * Vérifie un email
	 * 
	 * @param unknown $email
	 * @param unknown $type
	 * 
	 * @throw RuntimeException mail.badformat
	 * @return \F\Technical\Mail\Service
	 */
	public function checkEmail($email, $type) 
	{
		if(false === $this->getAdapter()->isMailValide($email)) {
			$this->throwException('mail.badformat', $email, $type);
		}
		return $this;
	}
	
	/**
	 * Envoie un mail
	 * 
	 * @param mixed $to destinataire : string ou array(mail=>nom)
	 * @param mixed $from expéditeur : string ou array(mail=>nom)
	 * @param string $object Sujet du mail
	 * @param string $body Corps du mail 
	 * @param array $options Options (array(cc=>, attachment=>))
	 * 
	 * @return \F\Technical\Mail\Service
	 */
	public function send($to, $from, $object, $body, $options = array()) 
	{
		if(!is_array($to)) {
			$to = array($to => null);
		}
		if(!is_array($from)) {
			$from = array($from => null);
		}
	
		if(!is_array($body)) {
			$body = array('text' => $body);
		}
		 
		if(count($from) > 1) {
			$this->throwException('mail.from.unexpected');
		}
		 
		$this->_checkEmails($to, 'To');
		$this->_checkEmails($from, 'From');
	
		if(true === isset($options['cc'])) {
			if(!is_array($options['cc'])) {
				$options['cc'] = array($options['cc'] => null);
			}
			 
			$this->_checkEmails($options['cc'], 'Cc');
		}
	
		if(true === empty($object)) {
			$this->throwException('mail.object.missing');
		}
		 
		 
		 
		if(false === isset($body['text']) || true === empty($body['text'])) {
			$this->throwException('mail.body.missing');
		}
		 
				 
		$this->getAdapter()->setSubject($object);
		$this->getAdapter()->setBodyText($body['text']);
		foreach($from as $mail => $nom) {
			$this->getAdapter()->setFrom($mail, $nom);
		}
		 
		foreach($to as $mail => $nom) {
			$this->getAdapter()->addTo($mail, $nom);
		}
		if(isset($options['cc'])) {
			foreach($options['cc'] as $mail => $nom) {
				$this->getAdapter()->addCc($mail, $nom);
			}
		}
		 
		// gestion des attachments
		if ( true === isset($options['attachment']) ) {
			if ( false === is_array($options['attachment']) ) {
				$options['attachment'] = array($options['attachment']);
			}
			 
			// vérification que l'attachement existe
			foreach( $options['attachment'] as $att ){
				if (false === $this->getAdapter()->isFileExists($att) ) {
					$this->throwException('mail.att.notfound', $att);
				}
				$this->getAdapter()
					 ->addAttachment($att, $this->getAdapter()->getFileMimeType($att));
			}
		}
		 
		$isSent = $this->getAdapter()->sendMail();
		return $this;
	}
	
	/**
	 * Verification d'une liste de mail
	 * 
	 * @param array $mails
	 * @param string $type
	 * 
	 * * @throw RuntimeException mail.badformat
	 */
	protected function _checkEmails($mails, $type) {
		foreach($mails as $email => $nom) {
			$this->checkEmail($email, $type);
		}
		return $this;
	}
}