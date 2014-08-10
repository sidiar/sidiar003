<?php

namespace Magazine;

/**
 * Define una capa de abstracción que separa la estructura de los objetos del dominio de la estructura de la base de datos
 * Se basa en el Concrete Table Inheritance Pattern, solo que como php no es tipado fuerte se simplifica trasladando más operaciones al Abstract
 * 
 * @package Magazine
 * @author ariel
 * @see http://martinfowler.com/eaaCatalog/concreteTableInheritance.html
 */
abstract class AbstractContentMapper 
{
    
    
    private $contentTable;
   
     /*
     * @return string
     */    
    abstract protected function getTableName();
    
    /*
     * @param \Magazine\Content       $content
     * @return associative_array
     */    
    abstract protected function save($content);
    
    /*
     * @param Zend_Db_Table_Row $row
     * @return \AMC\ConcreteContent
     */    
    abstract protected function load($row);
    
    
    
    function __construct() {
        $this->contentTable = new \Zend_Db_Table('content');
    }
    
    /**
     * Ejecuta directamente el find method
     * Si php fuera un typed language, este método debería estar en la concreteClass
     * 
     * @param Integer   $id
     * @return \Magazine\Content (Concrete class)
     */
    function find($id) 
    {


        $findSelect = $this->contentTable->select()->setIntegrityCheck(false)
                    ->from(array('a' => 'content'))
                    ->join(array('c' => $this->getTableName()), 'a.id = c.content_id')
                    ->where('a.id = ?', $id);

        $row = $this->contentTable->fetchRow($findSelect);
            
        /* call to concrete load method */
        return $this->load($row);
    }

    
    
    
    
    
    /* 
     * Maps row properties to domainObject properties
     * called from concrete load method 
     * 
     * @param \Magazine\Content     &$content
     * @param Zend_Db_Table_Row     $row
     */
    protected function abstractLoad(&$content,$row) 
    {
        $content->id = $row->id;
        $content->status = $row->status;
        $content->title = $row->title;
        $content->text = $row->text;
        $content->creation_date = $row->creation_date;
        $content->publish_date_to = $row->publish_date_to;
        $content->publish_date_from = $row->publish_date_from;
        $content->expires = $row->expires;
        $content->view_count = $row->view_count;
        $content->share_count = $row->share_count;
        
        
        
    }
  
    
    /*
     * Crea un array asociativo con los campos no vacíos del contenido
     * 
     * @param \Magazine\Content       $content
     * @return associative_array
     */
    private function abstractSave($content) 
    {
        $result = array();
        
        $result['type_id'] = $content->getType_id();
        
        if (!empty($content->title)) {
            $result['title'] = $content->title;
        }

        if (!empty($content->text)) {
            $result['text'] = $content->text;
        }
        
        if (isset($content->status)) {
            $result['status'] = $content->status;
        }
        
        if (!empty($content->publish_date_from)) {
            $result['publish_date_from'] = $content->publish_date_from;
        }
        
        if (!empty($content->publish_date_to)) {
            $result['publish_date_to'] = $content->publish_date_to;
        }
        
        if (isset($content->expires)) {
            $result['expires'] = $content->expires;
        }
        
        return $result;
        
    }
    
    
    
    
    
    
    
    
    /*
     * Insert a new Content and a new Concrete row on the database
     * 
     * @param \Magazine\Content       $content
     * @returns integer
     */
    function add($content)
    {
        $content->id = $this->insertAbstract($content);
        
        if ($content->id) {
            return $this->insertConcrete($content);
        }else{
            return null;
        }
    }
    
    /*
     * Insert a new Content row in the database
     * 
     * @param \Magazine\Content       $content
     * @returns integer     new content id
     */
    private function insertAbstract($content) {
        $data = $this->abstractSave($content);
        
        return $this->contentTable->insert($data);
    }
    
    /*
     * Insert a new Concrete Content row in the database
     * 
     * @param \Magazine\Content       $content
     * @returns integer     content id
     */
    private function insertConcrete($content) {
        
        /* call to concrete class method save */
        $concrete_data = $this->save($content);
        
        $concreteTable = new \Zend_Db_Table($this->getTableName());
        
        if ($concreteTable->insert($concrete_data)) {
            return $content->id;
        } else { 
            return null;
        }
    }
    
    
    
    
    
    
    
    
    
    
    /*
     * @param \Magazine\Content 
     * @return Integer 1: Ok 0: Failed
     */
    function update($content)
    {
        $this->updateAbstract($content);
        return $this->updateConcrete($content);
    }
    
    /*
     * Insert a new Concrete Content row on the database
     * 
     * @param \Magazine\Content       $content
     * @returns integer
     */
    private function updateAbstract($content) 
    {
        
        $data = $this->abstractSave($content);
        unset($data['type_id']);

        $where = $this->contentTable->getAdapter()->quoteInto('id = ?', $content->id);
        
        return $this->contentTable->update($data, $where);
    }
    
    /*
     * Insert a new Concrete Content row on the database
     * 
     * @param \Magazine\Content       $content
     * @returns integer
     */
    private function updateConcrete($content) 
    {

        /* call to concrete class method save */
        $concrete_data = $this->save($content);
        
        $concreteTable = new \Zend_Db_Table($this->getTableName());

        $where = $concreteTable->getAdapter()->quoteInto('content_id = ?', $content->id);
        
        return $concreteTable->update($concrete_data, $where);
    }    
    
    
    
    
    
    
    
    /*
     * Delete content
     * 
     * @param Integer      $content_id
     * @returns integer
     */
    function delete($content_id) 
    {
        if ($this->deleteAbstract($content_id)) {            
            return ($this->deleteConcrete($content_id));
        }else{
            return 0;
        }
    }
    
    /*
     * Delete content
     * 
     * @param Integer      $content_id
     * @returns integer
     */
    private function deleteAbstract($content_id)
    {
        
        $where = $this->contentTable->getAdapter()->quoteInto('id = ?', $content_id);
        
        return $this->contentTable->delete($where);
        
    }
    
    /*
     * Delete concrete table content
     * 
     * @param Integer      $content_id
     * @returns integer
     */
    private function deleteConcrete($content_id)
    {
        $concreteTable = new \Zend_Db_Table($this->getTableName());
        
        $where = $concreteTable->getAdapter()->quoteInto('content_id = ?', $content_id);
        
        return $concreteTable->delete($where);
        
    }
            
    
}
