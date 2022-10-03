<?php

namespace zsign\api;

use zsign\SignException;


class PrefillField{

	private $field_label;
	private $field_value;
	private $default_value;

	private $field_category;
	private $field_type_name;

	function __construct( $field=null ){

		if( gettype( $field ) == "object" ){
			$field = json_decode( json_encode($field) , true );
		}

		switch( $field["field_category"] ){
		// VALIDATION
			case "dropdown":
			case "checkbox":
			case "textfield":
			case "datefield":
				// allowed field types
				break;

			case "image":
				throw new SignException('Image fields are autofilled from Zoho Sign Profile Settings', -1);
			case "filefield":
			case "radiogroup":
			default:
				throw new SignException('Invalid PREFILL-FIELD type', -1);

		}

		$this->field_label			 = $field["field_label"] ;
		$this->field_value			 = isset( $field["default_value"] ) ? $field["default_value"] : null ; // assigned to default value
		$this->default_value		 = isset( $field["default_value"] ) ? $field["default_value"] : null ;

		$this->field_category		 = $field["field_category"] ;
		$this->field_type_name		 = $field["field_type_name"] ;

	}

	// GETTERS
	function getFieldLabel(){
		return $this->field_label;
	}

	function getFieldValue(){
		return $this->field_value;
	}

	function getDefaultValue(){
		return $this->default_value;
	}

	function getFieldCategory(){
		return $this->field_category;
	}

	function getFieldTypeName(){
		return $this->field_type_name;
	}

	// SETTERS

	function setFieldValue( $field_value ){
		$this->field_value 	= $field_value;
	}


	// CONSTRUCT JSON

	function constructJson(){

		$response[ $this->field_label ] = $this->field_value;

		return $response;
	}

}
