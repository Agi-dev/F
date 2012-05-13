<?php
// @codeCoverageIgnoreStart
/**
 * F\Technical\I18n\Adapter\Definition
 * is the adapter interface for the i18n service.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    François Schneider <fschneider.ext@orange.com>
 * @package    F\Technical\I18n\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\I18n\Adapter;

/**
 * F\Technical\I18n\Adapter\Definition
 * is the adapter interface for the i18n service
 * that define all the primitives required.
 *
 * @category   F
 * @package    F\Technical\I18n\Adapter
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
interface Definition
{
	/**
	 * Vérifie qu'un fichier existe
	 *
	 * @param string $filename chemin complet du fichier
	 *
	 *  @return F\Technical\I18n\Adapter\Definition
	 *  
	 *  @throw RuntimeException file.notfound
	 */
	public function checkFileExists($filename);

	/**
	 * Lit le fichier de traduction
	 *
	 * @param string $filename
	 *
	 * @return array ($key => $value);
	 */
	public function getI18nContent($filename);

	/**
	 * Ajoute un fichier i18n dans le registre de traduction
	 *
	 * @param string $filename
	 *
	 * @return bool;
	 */
	public function addI18nTranslation($filename);

	/**
	 * Récupère les traductions courante
	 *
	 * @return array
	 */
	public function getI18nTranslation();
}
// @codeCoverageIgnoreEnd