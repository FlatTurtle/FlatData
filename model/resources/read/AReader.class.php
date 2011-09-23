<?php
/**
 * Abstract class for reading(fetching) a resource
 *
 * @package The-Datatank/model/resources/read
 * @copyright (C) 2011 by iRail vzw/asbl
 * @license AGPLv3
 * @author Jan Vansteenlandt
 */

class AReader{

    public static $BASICPARAMS = array("callback", "filterBy","filterValue","filterOp");
    // package and resource are always the two minimum parameters
    protected $parameters = array();
    protected $requiredParameters = array();
    protected $optionalParameters = array();
    protected $package;
    protected $resource;

    public function __construct($package,$resource){
        $this->package = $package;
        $this->resource = $resource;
    }
    
    /**
     * execution method
     */
    abstract public function read();

    public function processParameters(){
	// Check all GET parameters and give them to setParameter, which needs to be handled by the extended method.
	foreach($_GET as $key => $value){
	    //the method and module will already be parsed by another system
	    //we don't need the format as well, this is used by printer
	    if(!in_array($key,self::$BASICPARAMS)){
		//check whether this parameter is in the documented parameters
		$params = $this->getParameters();
		if(isset($params[$key])){
		    $this->setParameter($key,$value);
		}else{
		    throw new ParameterDoesntExistTDTException($key);
		}
	    }
	}
    }

    abstract protected function setParameter($key, $value);
    
    /**
     * get the required parameters
     * @return Array with all the required Read parameters
     */
    public function getRequiredParameters(){
        return $this->requiredParameters;
    }

    /**
     * get the optional parameters
     * @return Array with all the optional Read parameters
     */
    public function getParameters(){
        return $this->optionalParameters;
    }
    
    /**
     * get the documentation about getting of a resource
     * @return String with some documentation about the resource
     */
    abstract public function getDocumentation();

    /**
     * get the allowed formats
     * @return Array with all of the allowed formatter names
     */
    abstract public function getAllowedFormatters();

    /*
     * get the creation time
     */

    public function getCreationTime(){
        return DBQueries::getCreationTime($this->package,$this->resource);    
    }
    
    /*
     * get the modification time
     */
    public function getModificationTime(){
        return DBQueries::getModificationTime($this->package,$this->resource);
    }
}
?>