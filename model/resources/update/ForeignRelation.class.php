<?php
/**
 * This action will add a 1:1 representation of 
 * 2 datatables which are added as database resources and have a FK relationship on a database level.
 *
 * @package The-Datatank/model/resources/actions
 * @copyright (C) 2011 by iRail vzw/asbl
 * @license AGPLv3
 * @author Jan Vansteenlandt
 */

include_once("AUpdater.class.php");
include_once("model/DBQueries.class.php");

class ForeignRelation extends AUpdater{
    

    public function __construct($package,$resource){
        parent::__construct($package,$resource);
        $this->parameters["foreign_package"] = "The foreign package name";
        $this->parameters["foreign_resource"] = "The foreign resource name";
        $this->parameters["original_column_name"] = "The original column name of the resource that points to another resource.";
        $this->parameters["foreign_column_name"] = "The column name of the resource to which being pointed.";
    
        $this->requiredParameters[] = "foreign_package";
        $this->requiredParameters[] = "foreign_resource";
        $this->requiredParameters[] = "original_column_name";
        $this->requiredParameters[] = "foreign_column_name";
    }

    protected function setParameter($key,$value){
        $this->$key = $value;
    }

    public function update(){
        $params = array();
        foreach($this->parameters as $key => $val){
            if(isset($this->$key)){
                $params[$key] = $this->$key;
            }
        }
        DBQueries::storeForeignRelation($package,$resource,$params);
    }

    public function getDocumentation(){
        return "This class will assign a relation between two resources, making it so you can link certain properties of one resource to another resource.";
        
    }
}
?>