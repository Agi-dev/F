<?php
/**
 * F\Technical\Mail\Service is
 * a class to handle mail operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    fschneider <fschneider@.fr>
 * @package    F\Technical\Mail\Adapter
 * @copyright Copyright (c) 2013 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Mail;


/**
 * @see tests/integration/php/bootstrap.php
 */
require_once __DIR__ . '/../../../bootstrap.php';

/**
 * @see F/Technical/Base/Test/Integration/Service.php
 */
require_once 'F/Technical/Base/Test/Integration/Service.php';

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
class TechnicalMailInteTest
    extends \F\Technical\Base\Test\Integration\Service
{
    /**
     * @return \F\Technical\Mail\Service
     */
    public function s()
    {
        return parent::s();
    }

     /**
     * checkMail
     */    
    
    public function testCheckMailWithSuccess() 
    {
    	$email = 'astek@cea.com';
    
    	$actual = $this->s()->checkEmail($email, 'Type');
    	$expected = get_class($this->s());
    	$this->assertInstanceOf($expected, $actual);
    }
    
    public function testCheckMailInvalidThrowsException() 
    {
    	$email = 'astek@ceacom';
    
    	$this->setExpectedException('RuntimeException', 'Le courriel Type:\''.$email.'\' semble être invalide');
    	$actual = $this->s()->checkEmail($email, 'Type');
    }
    
    public function testCheckMailWithPlusWithSuccess() 
    {
    	$email = 'astek+sous-dossier.blabla.r@toto.bidule.trucé.machin.cea.com';
    
    	$actual = $this->s()->checkEmail($email, 'Type');
    	$expected = get_class($this->s());
    	$this->assertInstanceOf($expected, $actual);
    }
}