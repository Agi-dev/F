<?php
/**
 * F\Technical\Mail\Service is
 * a class to handle mail operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    fschneider <fschneider@cea.fr>
 * @package    F\Technical\Mail\Adapter
 * @copyright Copyright (c) 2013 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Mail;

/**
 * @see tests/unit/php/bootstrap.php
 */
require_once __DIR__ . '/../../../bootstrap.php';


/**
 * @see F/Technical/Base/Test/Service.php
 */
require_once 'F/Technical/Base/Test/Service.php';

/**
 * F\Technical\Mail\Service is
 * a class to handle mail operations.
 *
 * @category F
 * @package F\Technical\Mail
 * @copyright  Copyright (c) 2013 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
class TechnicalMailUnitTest
extends \F\Technical\Base\Test\Service
{
	/**
	 * @return \F\Technical\Mail\Service
	 */
	public function s()
	{
		return parent::s();
	}
	/**
	 * @return \F\Technical\Mail\Adapter\Mock
	 */
	public function m()
	{
		return parent::m();
	}

    /**
	 * checkEmail
	 */
    public function testCheckMailWithSuccess() 
    {
        $this->mock('isMailValide', true);
	    $email = 'asteak@cea.com';
	    
	    $actual = $this->s()->checkEmail($email, 'Type');
	    $this->assertInstanceOfService($actual); 
	}
	
	public function testCheckMailInvalidThrowsException() 
	{
	    $this->mock('isMailValide', false);
	    $email = 'Mail incorrect';
	     
	    $this->setExpectedException('RuntimeException', 'Le courriel Type:\''.$email.'\' semble être invalide');
	    $actual = $this->s()->checkEmail($email, 'Type');
	}
	
	/**
	 * send
	 */
	public function testSendWithBadFormatToMailAdressThrowsException() 
	{
		$this->mock('isMailValide', false);
		 
		$to = 'Mail Invalide';
		$from = 'valide@cea.com';
		$object = 'Test d\'intégration astek';
		$body = 'Contenu du mail texte';
	
		$this->setExpectedException('RuntimeException', "Le courriel To:'$to' semble être invalide");
		 
		$this->s()->send($to, $from, $object, $body);
	
	}
	
	public function testSendWithBadFormatFromMailAdressThrowsException() 
	{
		$this->mock('isMailValide', true);
		$this->mock('isMailValide', false);
		$this->mock('sendMail', true);
	
		$to = 'fschneider.ext@cea.com';
		$from = 'astekcea.com';
		$object = 'Test d\'intégration astek';
		$body = 'Contenu du mail texte';
	
		$this->setExpectedException('RuntimeException', 'Le courriel From:\''.$from.'\' semble être invalide');
			
		$this->s()->send($to, $from, $object, $body);
	}
	
	public function testSendWithoutObjectThrowsException() 
	{
		$this->mock('isMailValide', true);
		$this->mock('isMailValide', true);
		 
		$to = 'fschneider.ext@cea.com';
		$from = 'astekcea.com';
		$object = '';
		$body = 'Contenu du mail texte';
		 
		$this->setExpectedException('RuntimeException', 'Impossible d\'envoyer un mail sans objet');
	
		$this->s()->send($to, $from, $object, $body);
	}
	
	public function testSendWithoutBodyTextThrowsException() 
	{
		$this->mock('isMailValide', true);
		$this->mock('isMailValide', true);
		 
		$to = 'fschneider.ext@cea.com';
		$from = 'astekcea.com';
		$object = 'Test d\'intégration astek';
		$body = '';
		 
		$this->setExpectedException('RuntimeException', 'Impossible d\'envoyer un mail sans corps');
	
		$this->s()->send($to, $from, $object, $body);
	}
	
	public function testSendWithNamedRecipientWithSuccess() 
	{
		$this->mock('isMailValide', true);
		$this->mock('isMailValide', true);
		$this->mock('isMailValide', true);
		$this->mock('sendMail', true);
		$this->mock('getBaseUrl', 'http://localhost/');
		$this->mock('setSubject', null);
		$this->mock('addTo', null);
		$this->mock('addTo', null);
		$this->mock('addCc', null);
		$this->mock('addBcc', null);
		$this->mock('setFrom', null);
		$this->mock('setBodyHtml', null);
		$this->mock('setBodyText', null);
	
		$to = array('fschneider.ext@cea.com' => 'PLM', 'toto@cea.com' => 'Toto');
		$from = array('astekcea.com' => 'astek');
		$object = 'Test d\'intégration astek';
		$body = 'Contenu du mail texte';
	
		$actual = $this->s()->send($to, $from, $object, $body);
		$this->assertInstanceOfService($actual);
	}
    
	public function testSendSuccess() {
		 
		$this->mock('isMailValide', true);
		$this->mock('isMailValide', true);
		$this->mock('getBaseUrl', 'http://localhost/');
		$this->mock('sendMail', true);
		$this->mock('setSubject', null);
		$this->mock('addTo', null);
		$this->mock('addCc', null);
		$this->mock('addBcc', null);
		$this->mock('setFrom', null);
		$this->mock('setBodyHtml', null);
		$this->mock('setBodyText', null);
	
		$to = 'pmassard.ext@orange.com';
		$from = 'kcporange.com';
		$object = 'Test d\'intégration KCP';
		$body = 'Contenu du mail texte';
			
		$actual = $this->s()->send($to, $from, $object, $body);
		$this->assertInstanceOfService($actual);
	
		$expected = array('pmassard.ext@orange.com', null);
		$actual = $this->m()->getCallArgs('addTo');
		$this->assertEquals($expected, $actual);
		 
		$expected = array('kcporange.com', null);
		$actual = $this->m()->getCallArgs('setFrom');
		$this->assertEquals($expected, $actual);
	
		$expected = 'Contenu du mail texte';
		$actual = $this->m()->getCallArgs('setBodyText');
		$this->assertEquals($expected, $actual[0]);
		 
		$expected = 'Test d\'intégration KCP';
		$actual = $this->m()->getCallArgs('setSubject');
		$this->assertEquals($expected, $actual[0]);
	}
	
	public function testSendWithAttachmentNotFoundThrowRuntimeException()
	{
		$to = 'pmassard.ext@orange.com';
		$from = 'kcporange.com';
		$object = 'Test d\'intégration KCP';
		$html = '<span style="color:blue;-moz-color:red"/>Toto</span><a href="/public">toto</a>';
		$body = 'Contenu du mail texte';
		$options = array('attachment' => 'attachmentNotExist');
		 
		$this->mock('isMailValide', true);
		$this->mock('isMailValide', true);
		$this->mock('getBaseUrl', 'http://localhost/');
		$this->mock('setSubject');
		$this->mock('addTo');
		$this->mock('addCc');
		$this->mock('addBcc');
		$this->mock('setFrom');
		$this->mock('setBodyHtml');
		$this->mock('setBodyText');
		$this->mock('isFileExists', false);
		 
		$this->setExpectedException('RuntimeException', "Le fichier joint 'attachmentNotExist' n'existe pas");
		$this->s()->send($to, $from, $object, $body, $options);
		 
	}
	
	public function testSendWithOneAttachmentSuccess()
	{
		$to = 'pmassard.ext@orange.com';
		$from = 'kcporange.com';
		$object = 'Test d\'intégration KCP';
		$html = '<span style="color:blue;-moz-color:red"/>Toto</span><a href="/public">toto</a>';
		$body = 'Contenu du mail texte';
		$options = array('attachment' => 'attachmentOne');
	
		$this->mock('isMailValide', true);
		$this->mock('isMailValide', true);
		$this->mock('getBaseUrl', 'http://localhost/');
		$this->mock('setSubject');
		$this->mock('addTo');
		$this->mock('addCc');
		$this->mock('addBcc');
		$this->mock('setFrom');
		$this->mock('setBodyHtml');
		$this->mock('setBodyText');
		$this->mock('isFileExists', true);
		$this->mock('getFileMimeType', 'mimetype');
		$this->mock('addAttachment');
		$this->mock('sendMail', true);
	
		$actual = $this->s()->send($to, $from, $object, $body, $options);
		$this->assertInstanceOfService($actual);
		$actual = $this->m()->getCallArgs('addAttachment');
		$this->assertEquals(array('attachmentOne', 'mimetype'), $actual);
		 
	}
	
	public function testSendWithManyAttachmentSuccess()
	{
		$to = 'pmassard.ext@orange.com';
		$from = 'kcporange.com';
		$object = 'Test d\'intégration KCP';
		$html = '<span style="color:blue;-moz-color:red"/>Toto</span><a href="/public">toto</a>';
		$body = 'Contenu du mail texte';
		$options = array('attachment' => array('attachmentOne', 'attachmentTwo','attachmentThree'));
		 
		$this->mock('isMailValide', true);
		$this->mock('isMailValide', true);
		$this->mock('getBaseUrl', 'http://localhost/');
		$this->mock('setSubject');
		$this->mock('addTo');
		$this->mock('addCc');
		$this->mock('addBcc');
		$this->mock('setFrom');
		$this->mock('setBodyHtml');
		$this->mock('setBodyText');
		$this->mock('isFileExists', true);
		$this->mock('isFileExists', true);
		$this->mock('isFileExists', true);
		$this->mock('addAttachment');
		$this->mock('getFileMimeType', 'mimetype1');
		$this->mock('addAttachment');
		$this->mock('getFileMimeType', 'mimetype2');
		$this->mock('addAttachment');
		$this->mock('getFileMimeType', 'mimetype3');
		$this->mock('sendMail', true);
		 
		$actual = $this->s()->send($to, $from, $object, $body, $options);
		$this->assertInstanceOfService($actual);
		$actual = $this->m()->getCallArgs('addAttachment', 0);
		$this->assertEquals(array('attachmentOne', 'mimetype1'), $actual);
		$actual = $this->m()->getCallArgs('addAttachment', 1);
		$this->assertEquals(array('attachmentTwo', 'mimetype2'), $actual);
		$actual = $this->m()->getCallArgs('addAttachment', 2);
		$this->assertEquals(array('attachmentThree', 'mimetype3'), $actual);
	}
    
}