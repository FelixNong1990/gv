<?php

/**
 * Class IntColumn is a child column class used
 * to describe columns with float numeric content
 *
 * @author Alexander Gilmanov
 *
 * @since May 2012
 */

class DateColumn extends Column {
	
    protected $_jsDataType = 'date';
    protected $_dataType = 'date';
    
    public function __construct( $params = array () ) {
		parent::__construct( $params );
		$this->_dataType = 'date';
		
		switch(get_option('wdtDateFormat')){
			case 'd/m/Y':
				$this->_jsDataType = 'date-eu';
				break;
			case 'd-m-Y':
				$this->_jsDataType = 'date-dd-mmm-yyyy';
				break;
		}
				
    }
    
    public function formatHandler( $cell ) {
		if(!is_array($cell->getContent())){
			$value = $cell->getContent();
			if(!empty($value)){
				return date(get_option('wdtDateFormat'), $value);
			}
		}else{
			$value = $cell->getContent();
			return date(get_option('wdtDateFormat'), $value['value']);
		}
    }        
    
}


?>
