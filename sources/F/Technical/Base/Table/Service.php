<?php
/**
 * F\Technical\Base\Service is a class to handle Base operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    Francois Schneider <francoisschneider@neuf.fr>
 * @package   F\Technical\Base\Table
 * @copyright Copyright (c) 2011 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Base\Table;

require_once 'F/Technical/I18n/Service.php';

/**
 * F\Technical\Base\Table\Service is a class to handle Base table operations.
 *
 * @category F
 * @package F\Technical\Base\Table
 * @copyright Copyright (c) 2011 <COPYRIGHT>
 * @license <LICENSE>
 * @version Release: @package_version@
 * @since Class available since Release 0.0.1
 */
abstract class Service 
    extends \F\Technical\Base\Service
{
    protected $_tablename;
    
    /**
     * Returns the underlying adapter.
    
     * @return F\Technical\Base\Table\Adapter\Definition
     */
    public function getAdapter()
    {
    	return parent::getAdapter();
    }
    
    /**
	 * Constructs a new instance
	 *
	 * @param mixed $adapter the adapter
	 *
	 * @return F\Technical\Base\Table\Service
	 *
	 * @throws Exception if an error occured
	 */
	public function __construct($adapter = null)
    {
        parent::__construct($adapter);
        if ( false === isset($this->_tablename) ) {
 			$this->throwException('class.attribut.missing', '_tablename');
 		}
 		return $this;
    }
   
   /**
    * insertion en base
    * 
    * @param array $data
    * 
    * @return mixed id
    */
   public function insert($data, $history = true)
   {
       $id = $this->getAdapter()->insert($data, $this->_tablename);
       if ( true === $history ) {
           $this->_saveHistory($id, $data);
       }
       return $id;
   }
   
   /**
    * Récupère les données de la table courant pour un identifiant
    * @param unknown_type $id
    * 
    * @return array
    */
   public function getById($id)
   {
       $idColumnName = $this->getAdapter()->getIdColumn($this->_tablename);
       $sql = 'SELECT * FROM ' . $this->_tablename . ' WHERE ' . $idColumnName .' = ?';
       return $this->getAdapter()->fetchAll($sql, $id);
   }
   
   /**
    * Commence une transaction
    *
    * @return \F\Technical\Base\Table\Service
    */
   public function beginTransaction()
   {
       $this->getAdapter()->beginTransaction();
       return $this;
   }
   
   /**
    * Annule une transaction
    *
    * @return \F\Technical\Base\Table\Service
    */
   public function rollbackTransaction()
   {
       $this->getAdapter()->rollbackTransaction($this->getConnection());
       return $this;
   }
   
   /**
    * Valide une transaction
    *
    * @return \F\Technical\Base\Table\Service
    */
   public function commitTransaction()
   {
       $this->getAdapter()->commitTransaction($this->getConnection());
       return $this;
   }
   
   
   /**
    * Historique une maj en base
    * 
    * @param mixed $id
    * @param array $new
    * @param array $old (facultatif)
    * 
    * @return \F\Technical\Base\Table\Service
    */
   protected function _saveHistory($id, $new , $old = null)
   {
       $cuid = $this->getAdapter()->getCuidUserConnected();
            
            // Calcul du type et vérifications d'usage
        if (null == $old) {
            // Cas d'une création
            $type = $this->getAdapter()->getHistoryCreateType();
        } else if (null == $new) {
            // Cas d'une suppression
            $type = $this->getAdapter()->getHistoryDeleteType();
        } else {
           // Cas d'une mise à jour
            $type = $this->getAdapter()->getHistoryUpdateType();
            
            // On ne garde que les données différentes
            $keyDiff = array_keys(array_diff_assoc($new, $old));
            $new = $this->_keepOnlyUpdatedData($new, $keyDiff);
            $old = $this->_keepOnlyUpdatedData($old, $keyDiff);
       }
       	
       $this->getAdapter()->saveHistory($this->_tablename, $cuid, $id, $type, $new, $old);
       
       return $this;
   }
   
   /**
    * Supprime les lignes qui ne sosnt pas dans keyDiff
    * 
    * @param array $data
    * @param array $keyDiff
    * 
    * @return mixed
    */
   protected function _keepOnlyUpdatedData($data, $keyDiff) 
   {
       foreach( $data as $k => $v ) {
           if ( false === in_array($k, $keyDiff) ) {
               unset($data[$k]);
           }
       }
       
       return $data;
   }
}