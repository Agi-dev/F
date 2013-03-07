<?php
/**
 * F\Technical\Filesystem\Service is a class to handle file operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    Fran�ois <francoisschneider@neuf.fr>
 * @package   F\Technical\Filesystem
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Filesystem;

/**
 * @see F/Technical/Abstract/Service.php
 */
require_once 'F/Technical/Base/Service.php';

/**
 * F\Technical\Filesystem\Service is a class to handle file operations.
 *
 * @category F
 * @package F\Technical\Filesystem
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
     * @return \F\Technical\Filesystem\Service
     */
    public static function singleton()
    {
        return parent::singleton();
    }

    /**
     * Returns an instance of this service
     *
     * @return \F\Technical\Filesystem\Service
     */
    public static function factory($adapter = null)
    {
        return parent::factory($adapter);
    }

    /**
     * Returns the underlying adapter
     *
     * @return \F\Technical\Filesystem\Adapter\Definition
     */
    public function getAdapter()
    {
        return parent::getAdapter();
    }

    /**
     * Check if file exists throw exception if not
     *
     * @param string $filename
     *
     * @return \F\Technical\Filesystem\Service
     *
     * @throws RuntimeException
     */
    public function checkFileExists($filename)
    {
        if (false === $this->isFileExists($filename)) {
            $this->throwException('filesystem.file.notfound', $filename);
        }
        return $this;
    }

    /**
     * is file exists return true
     *
     * @param string $filename
     *
     * @return bool
     */
    public function isFileExists($filename)
    {
        return $this->getAdapter()->isFileExists($filename);
    }

    /**
     * Parse ini file
     *
     * @param string $filename
     *
     * @return array
     *
     * @thrown RuntimeException
     */
    public function parseIniFile($filename)
    {
        $this->checkFileExists($filename);
        return $this->getAdapter()->parseIniFile($filename);
    }

    /**
     * open file as resource
     *
     * @param string $filename
     *
     * @return resource
     *
     * @thrown \RuntimeException on error
     */
    public function appendFile($filename)
    {
        return $this->getAdapter()->fopen($filename, 'a');
    }

    /**
     * Writes the specified message to the specified opened resource.
     *
     * @param resource $resource
     *
     * @param string $content
     *
     * @return returns the number of bytes written, or FALSE on error
     */
    public function writeResource($resource, $content)
    {
        $this->checkResource($resource);
        return $this->getAdapter()->fwrite($resource, $content);
    }

    /**
     * check if resource is resource
     *
     * @param resource $resource
     *
     * @return \F\Technical\Filesystem\Service
     */
    public function checkResource($resource)
    {
        if (false === $this->getAdapter()->is_resource($resource)) {
            $this->throwException('filesystem.resource.badformat');
        }

        return $this;
    }

    /**
     * Close a file resource
     *
     * @param resource $resource
     *
     * @return \F\Technical\Filesystem\Service
     */
    public function closeResource($resource)
    {
        if (true === $this->getAdapter()->is_resource($resource)) {
            return $this->getAdapter()->fclose($resource);
        }
        return true;
    }

    /**
     * check if dir exist
     *
     * @param $path
     *
     * @return \F\Technical\Filesystem\Service
     *
     * @throw RuntimeException filesystem.dir.notfound
     */
    public function checkDirExists($path)
    {
        if (false === $this->isFileExists($path)) {
            $this->throwException('filesystem.dir.notfound', $path);
        }
        return $this;
    }

    /**
     * Reads entire file into a string
     *
     * @param $filename
     *
     * @return string
     */
    public function getFileContents($filename)
    {
        $this->checkFileExists($filename);
        return $this->getAdapter()->getFileContents($filename);
    }

    /**
     * Give file size in ko
     *
     * @param $filename
     *
     * @return int
     */
    public function getFileSize($filename)
    {
        $this->checkFileExists($filename);
        return $this->getAdapter()->getFileSize($filename);
    }

    /**
     * récupère l'extension du fichier
     *
     * @param string $filename
     *
     * @return string
     */
    public function getFileExtension($filename)
    {
        $file = basename($filename);
        $pPos = strrpos($file, '.');
        return substr($file, $pPos + 1);
    }

    /**
     * Copie la source vers la destination
     *
     * @param string $source
     * @param string $destination
     *
     * @return F\Technical\Filesystem\Service
     *
     * @throw RuntimeException filesystem.file.notfound
     */
    public function copyFile($source, $destination)
    {
        $this->checkFileExists($source);
        $this->getAdapter()->copy($source, $destination);
        return $this;
    }

    /**
     * Supprime le fichier
     *
     * @param string $filename
     *
     * @return \F\Technical\Filesystem\Service
     * @throw RuntimeException filesystem.delete.filename.denied
     */
    public function deleteFile($filename)
    {
        if (false === $this->getAdapter()->is_deletable($filename)) {
            $this->throwException('filesystem.delete.filename.denied', $filename);
        }
        $this->getAdapter()->unlink($filename);
        return $this;
    }

    /**
     * Copie le contenu d'un répertoire
     *
     *
     */
    public function copyContentDir($source, $destination)
    {
        $listFiles = array_diff($this->getAdapter()->scandir($source), array('.', '..'));
        foreach ($listFiles as $file) {
            $s = $source . '/' . $file;
            $d = $destination . '/' . $file;
            if ($this->getAdapter()->is_dir($s)) {
                $this->getAdapter()->mkdir($d);
                $this->copyContentDir($s, $d);
            } else {
                $this->getAdapter()->copy($s, $d);
            }
        }
        return $this;
    }

    /**
     * supprime un répertoire et son contenu
     *
     * @param string $folder répertoire à vider
     *
     * @return \F\Technical\Filesystem\Service
     */
    public function deleteDir($dir)
    {
        return $this->_deleteDir($dir);
    }

    /**
     * supprime le contenu d'un répertoire
     * @param unknown $dir
     * @return \F\Technical\Filesystem\Service
     */
    public function cleanDir($dir)
    {
        return $this->_deleteDir($dir, false);
    }

    /**
     *
     * @param unknown $dir
     * @param string $deleteMe
     */
    private function _deleteDir($dir, $deleteMe = true)
    {
        $listFiles = array_diff($this->getAdapter()->scandir($dir), array('.', '..'));
        foreach ($listFiles as $file) {
            $toDelete = $dir . '/' . $file;
            if (true === $this->getAdapter()->is_dir($toDelete)) {
                $this->_deleteDir($toDelete);
            } else {
                $this->deleteFile($toDelete);
            }
        }
        if (true === $deleteMe) {
            $this->getAdapter()->rmdir($dir);
        }
        return $this;
    }

    public function getMimeType($filename)
    {
        $mime_types = array(

            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'ppt' => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        $ext = $this->getFileExtension($filename);

        if (true === array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        }

        $this->throwException('filesystem.mime.notfound', $filename);
    }
}