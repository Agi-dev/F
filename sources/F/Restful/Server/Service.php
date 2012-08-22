<?php
/**
 * F\Restful\Server\Service is a class to handle server operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    fschneider <francoisschneider@neuf.fr>
 * @package   F\Restful\Server
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Restful\Server;

/**
 * @see F/Technical/Abstract/Service.php
 */
require_once 'F/Technical/Base/Service.php';

/**
 * F\Restful\Server\Service is a class to handle server operations.
 *
 * @category F
 * @package F\Restful\Server
 * @copyright Copyright (c) 2012 <COPYRIGHT>
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
	 * @return \F\Restful\Server\Service
	 */
	public static function singleton()
	{
		return parent::singleton();
	}
	/**
	 * Returns an instance of this service
	 *
	 * @return \F\Restful\Server\Service
	 */
	public static function factory($adapter = null)
	{
		return parent::factory($adapter);
	}
	/**
	 * Returns the underlying adapter
	 *
	 * @return \F\Restful\Server\Adapter\Definition
	 */
	public function getAdapter()
	{
		return parent::getAdapter();
	}

	public function dispatch()
	{
		echo 'Dispatch Success';
	}
}

/*
Array
(
    [COMSPEC] => C:\WINNT\system32\cmd.exe
    [DOCUMENT_ROOT] => E:/dev/workspaces/perso/phpStorm/smartbacklog/server/public
    [GATEWAY_INTERFACE] => CGI/1.1
    [HTTP_ACCEPT] => text/html,application/xhtml+xml,application/xml;q=0.9,/*;q=0.8
    [HTTP_ACCEPT_ENCODING] => gzip, deflate
    [HTTP_ACCEPT_LANGUAGE] => fr,fr-fr;q=0.8,en-us;q=0.5,en;q=0.3
    [HTTP_CONNECTION] => keep-alive
    [HTTP_HOST] => smartrest
    [HTTP_USER_AGENT] => Mozilla/5.0 (Windows NT 5.1; rv:14.0) Gecko/20100101 Firefox/14.0.1
    [PATH] => C:\Program Files\AMD APP\bin\x86;C:\WINNT\system32;C:\WINNT;C:\WINNT\System32\Wbem;c:\progra~1\tivoli\lcf\bin\w32-ix86\tools;C:\Program Files\Tivoli\lcf\dat\1\cache\lib\w32-ix86;C:\Program Files\Tivoli\lcf\bin\w32-ix86\mrt;C:\Program Files\Tivoli\lcf\bin\w32-ix86\tools;E:\APPFT\maven3\bin;C:\Program Files\Windows Imaging;E:\APPFT\apache-ant-1.8.1\bin;C:\Program Files\TortoiseSVN\bin;C:\Program Files\Java\jdk6\bin;E:\APPFT\FlashBuilder4\player\win\10.1;E:\APPFT\GnuWin32\bin;E:\APPFT\subversion-1.5.2;E:\APPFT\apache-jmeter-2.6\bin;C:\Program Files\SafeNet\Authentication\SAC\x32;C:\Program Files\Git\cmd;C:\Program Files\TortoiseGit\bin;E:\APPFT\wamp\bin\mysql\mysql5.0.86\bin;E:\APPFT\wamp\bin\php\php5.2.11
    [PATHEXT] => .COM;.EXE;.BAT;.CMD;.VBS;.VBE;.JS;.JSE;.WSF;.WSH
    [PHP_SELF] => /index.php
    [QUERY_STRING] => q=test&p=z
    [REDIRECT_QUERY_STRING] => q=test&p=z
    [REDIRECT_STATUS] => 200
    [REDIRECT_URL] => /toto/tata
    [REMOTE_ADDR] => 127.0.0.1
    [REMOTE_PORT] => 1671
    [REQUEST_METHOD] => GET
    [REQUEST_TIME] => 1345649368
    [REQUEST_URI] => /toto/tata?q=test&p=z
	[SCRIPT_FILENAME] => E:/dev/workspaces/perso/phpStorm/smartbacklog/server/public/index.php
    [SCRIPT_NAME] => /index.php
    [SERVER_ADDR] => 127.0.0.1
    [SERVER_ADMIN] => admin@localhost
    [SERVER_NAME] => smartrest
    [SERVER_PORT] => 80
    [SERVER_PROTOCOL] => HTTP/1.1
    [SERVER_SIGNATURE] =>
    [SERVER_SOFTWARE] => Apache/2.2.21 (Win32) PHP/5.3.8
    [SystemRoot] => C:\WINNT
    [WINDIR] => C:\WINNT
)

 */