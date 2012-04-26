<?php
// @codeCoverageIgnoreStart
/**
 * F\Technical\Base\Table\Adapter\Definition
 * is the adapter interface for the i18n service.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    François Schneider <fschneider.ext@orange.com>
 * @package    F\Technical\Base\Table\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Base\Table\History;

/**
 * F\Technical\Base\Table\History\Definition
 * est l'interface du service historique à implémenter
 * pour gérer l'historisation
 *
 * @category   F
 * @package    F\Technical\Base\Table\Adapter
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
interface Definition
{
    /**
     * Sauvegarde l'historique
     * 
     * @param mixed $id
     * @param unknown_type $new
     * @param unknown_type $old
     * 
     * @return  int new id historique
     */
    public function save($tablename, $userCuid, $idTable, $type, $new, $old=null);
    
    /**
     * Récupère le type d'historique creation
     * 
     * @return string
     */
    public function getCreateType();
    
    /**
     * Récupère le type d'historique suppression
     *
     * @return string
     */
    public function getDeleteType();
    
    /**
     * Récupère le type d'historique modification
     *
     * @return string
     */
    public function getUpdateType();
}
// @codeCoverageIgnoreEnd