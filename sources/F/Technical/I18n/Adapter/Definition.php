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
	 * Vérifie d'un fichier existe
	 *
	 * @param sting $filename chemin complet du fichier
	 *
	 *  @return bool
	 */
	public function fileExists($filename);

	/**
	 * Lit le fichier de traduction
	 *
	 * @param string $filename
	 *
	 * @return array ($key => $value);
	 */
	public function getI18nContent($filename);

	/**
	 * Teste si le fichier est un fichier plat (et non pas un répertoire) ou un lien symbolique
	 *
	 * @param string $filename
	 *
	 * @return bool;
	 */
	public function isFile($filename);

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