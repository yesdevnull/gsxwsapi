<?php

error_reporting ( -1 );

/**
 * 
 * GSX Web Services API PHP Class
 * 
 * @author Dan "theblahman" Barrett <gsx@theblahman.net>
 * 
 * @package gsxwsapi
 * 
 */

class GSX {
	/**
	 *
	 * Valid Region Codes
	 *
	 * @var array Contains valid names for all the regions in which GSX is available
	 *
	 * @access protected
	 *
	 */
	protected $validRegionCodes = array (
		'am' ,
		'emea' ,
		'apac' ,
		'la',
	);
	
	/**
	 *
	 * Valid Language Codes
	 *
	 * This array of valid language codes is from the GSX API
	 * documentation.  This GSX class does its own checking of
	 * certain values since it's much faster to do validation 
	 * on our end.
	 *
	 * @var array Array of valid language codes
	 *
	 * @access protected
	 *
	 */
	protected $validLanguageCodes = array (
		'en' ,	// English
		'fr' ,	// Frence
		'de' ,	// German
		'es' ,	// Spanish
		'it' ,	// Italian
		'ja' ,	// Japanese
		'ko' ,	// Korean
		'zf' ,	// Traditional Chinese
		'zh'	// Simple Chinese
	);
	
	/**
	 *
	 * Valid Time Zones
	 *
	 * This array contains a list of all the valid timezone codes
	 * that GSX allows.
	 *
	 * @var array Array of valid timezones according to GSX
	 *
	 * @access protected
	 *
	 */
	protected $validTimeZones = array (
		'PDT' ,		// Pacific Daylight Time					UTC-7
		'GMT' ,		// Greenwich Mean Time						UTC
		'PST' ,		// Pacific Standard Time					UTC-8
		'CDT' ,		// Central Daylight Time					UTC-5
		'CST' ,		// Central Standard Time					UTC-6
		'EDT' ,		// Eastern Daylight Time					UTC-4
		'EST' ,		// Eastern Standard Time					UTC-5
		'CEST' ,	// Central European Summer Time				UTC+2
		'CET' ,		// Central European Time					UTC+1
		'JST' ,		// Japan Standard Time						UTC+9
		'IST' ,		// Indian Standard Time						UTC+5.5
		'CCT' ,		// Chinese Coast Time						UTC+8
		'AEST' ,	// Australian Eastern Standard Time			UTC+10
		'AEDT' ,	// Australian Eastern Daylight Time			UTC+11
		'ACST' ,	// Australian Central Standard Time			UTC+9.5
		'ACDT' ,	// Australian Central Daylight Time			UTC+10.5
		'NZST'		// New Zealand Standard Time				UTC+12
	);
	
	/**
	 *
	 * Valid API Modes
	 *
	 * This array contains the three valid modes for the GSX Web Services
	 * API - GSXIT (Testing), GSXUT (Testing) and GSX Production (Live)
	 *
	 * @var array Array of GSX testing and production modes.
	 *
	 * @access protected
	 *
	 */
	protected $validApiModes = array (
		'it' ,
		'ut' ,
		'production'
	);
	
	/**
	 *
	 * Valid Part Search
	 *
	 * This array contains all the variables we can search for in 
	 * the PartsLookup function of the GSX Web Services API.
	 *
	 * @var array Array of the valid variables for Part Search
	 *
	 * @see $this->part_lookup
	 *
	 * @access protected
	 *
	 */
	protected $validPartSearch = array (
		'eeeCode' ,
		'partNumber' ,
		'partDescription' ,
		'productName' ,
		'serialNumber'
	);
	
	/**
	 *
	 * Valid Repair Lookup
	 *
	 * This array contains all the variables we can search for in
	 * the RepairLookup function of the GSX Web Services API.
	 *
	 * @var array Array of the valid variables for Repair Lookup
	 *
	 * @see $this->repair_lookup
	 *
	 * @access protected
	 *
	 */
	protected $validRepairLookup = array (
		'serialNumber' ,
		'repairConfirmationNumber' ,
		'repairNumber' ,
		'repairStatus' ,
		'repairType' ,
		'purchaseOrderNumber' ,
		'technicianFirstName' ,
		'technicianLastName' ,
		'shipToCode' ,
		'soldToReferenceNumber' ,
		'incompleteRepair' ,
		'pendingShipment' ,
		'unreceivedModules' ,
		'fromDate' ,
		'toDate' ,
		'customerFirstName' ,
		'customerLastName' ,
		'customerEmailAddress'
	);
	
	/**
	 *
	 * Valid Repair Statuses
	 *
	 * This array contains all possible repair statuses in a GSX repair
	 *
	 * @var array Array of the valid Repair Statuses
	 *
	 * @see $this->repair_lookup()
	 *
	 * @access protected
	 *
	 */
	protected $validRepairStatus = array (
		'New' ,
		'Saved' ,
		'Open' ,
		'Declined',
		'On Hold' ,
		'Closed'
	);
	
	/**
	 *
	 * Valid Repair Type
	 *
	 * This array contains all the repairType possibilities for the 
	 * RepairLookup function.
	 *
	 * @var array Array of the valid Repair Types
	 *
	 * @see $this->repair_lookup()
	 *
	 * @access protected
	 *
	 */
	protected $validRepairType = array (
		'ON' ,
		'WH' ,
		'CA'
	);
	
	/**
	 *
	 * @var array Array of the valid Warranty Status Parameters
	 *
	 * @see $this->warranty_status()
	 *
	 * @access protected
	 * 
	 */
	protected $validWarrantyParams = array (
		'serialNumber' ,
		'unitReceivedDate' ,
		'partNumbers'
	);
	
	
	/**
	 *
	 * GSX Details
	 *
	 * This array contains all our important details regarding
	 * the usage of the GSX Web Services API including login details
	 * and localisation data.
	 *
	 * @var array Array that contains all the GSX authentication details
	 *
	 * @access protected
	 *
	 */
	protected $gsxDetails = array (
		'apiMode'			=> 'production' ,
		'regionCode'		=> 'apac' ,
		'userId'			=> '' ,
		'password'			=> '' ,
		'serviceAccountNo'	=> '' ,
		'languageCode'		=> 'en' ,
		'userTimeZone'		=> 'PDT' ,
		'returnFormat'		=> 'php' ,
		'gsxWsdl'				=> ''
	);
	
	/**
	 *
	 * WSDL Url
	 *
	 * This is our URL for the WSDL.  It can change depending on
	 * users location and their needs (APS, iPhone etc.)
	 *
	 * @var string WSDL URL
	 *
	 * @access protected
	 *
	 */
	protected $wsdlUrl;
	
	/**
	 *
	 * User Session ID
	 *
	 * Class variable for our GSX Authentication token.
	 *
	 * @var string Authentication ID
	 *
	 * @access protected
	 *
	 */
	protected $userSessionId;
	
	/**
	 *
	 * SOAP Client
	 *
	 * Class object for our GSX SOAP Client.
	 *
	 * @var object SOAP Client Object
	 *
	 * @access protected
	 *
	 */
	protected $soapClient;
	
	/**
	 *
	 * Constructor
	 *
	 * Builds the class and checks to see if all the details provided
	 * through the constructor are valid so we can authenticate without
	 * problems.
	 *
	 * $_gsxDetailsArray = array (
	 *		'apiMode'			=> 'production',
	 *		'regionCode'		=> 'apac',
	 *		'userId'			=> 'username@apple.com',
	 *		'password'			=> 'apple',
	 *		'serviceAccountNo'	=> '0000000000',
	 *		'languageCode'		=> 'en',
	 *		'userTimeZone'		=> 'AEST'
	 * );
	 *
	 * @param array GSX Details array which contains authentication and regional information
	 *
	 * @since 1.0
	 *
	 * @access public
	 *
	 */
	public function __construct ( $_gsxDetailsArray = array ( ) ) {
		// We default to using production mode for GSX
		if ( !isset( $_gsxDetailsArray['apiMode'] ) ) {
			$_gsxDetailsArray['apiMode'] = 'production';
		}
		
		if ( !in_array ( $_gsxDetailsArray['apiMode'] , $this->validApiModes ) ) {
			return $this->error ( __METHOD__ , __LINE__ , 'API Mode is invalid' );
		}
		
		$this->gsxDetails['apiMode'] = $_gsxDetailsArray['apiMode'];
		
		if ( $_gsxDetailsArray['regionCode'] == '' ) {
			return $this->error ( __METHOD__ , __LINE__ , 'User Region Code is blank' );
		}
		
		if ( !in_array ( $_gsxDetailsArray['regionCode'] , $this->validRegionCodes ) ) {
			return $this->error ( __METHOD__ , __LINE__ , 'User Region is invalid' );
		}
		
		$this->gsxDetails['regionCode'] = $_gsxDetailsArray['regionCode'];
		
		if ( $_gsxDetailsArray['userId'] == '' ) {
			return $this->error ( __METHOD__ , __LINE__ , 'User ID is blank' );
		}
		
		$this->gsxDetails['userId'] = $_gsxDetailsArray['userId'];
		
		if ( $_gsxDetailsArray['password'] == '' ) {
			return $this->error ( __METHOD__ , __LINE__ , 'Password is blank' );
		}
		
		$this->gsxDetails['password'] = $_gsxDetailsArray['password'];
		
		if ( $_gsxDetailsArray['serviceAccountNo'] == '' ) {
			return $this->error ( __METHOD__ , __LINE__ , 'Service Account Number is blank' );
		}
		
		$this->gsxDetails['serviceAccountNo'] = $_gsxDetailsArray['serviceAccountNo'];
		// If user has left languageCode empty, we assign the GSX default.
		$this->gsxDetails['languageCode'] = ( empty ( $_gsxDetailsArray['languageCode'] ) ) ? 'en' : $_gsxDetailsArray['languageCode'];
		// If user has left userTimeZone empty, we assign the GSX default.
		$this->gsxDetails['userTimeZone'] = ( empty ( $_gsxDetailsArray['userTimeZone'] ) ) ? 'PST' : $_gsxDetailsArray['userTimeZone'];
		
		$this->gsxDetails['returnFormat'] = $_gsxDetailsArray['returnFormat'];
		echo $_gsxDetailsArray['wsdl'];
		$this->gsxDetails['gsxWsdl'] = $_gsxDetailsArray['wsdl'];
		
		$this->authenticate();
	}
	
	/**
	 *
	 * Destruct
	 *
	 * Destructs a number of important class-related variables
	 *
	 * @param null
	 *
	 * @todo MOAR garbage collection.
	 *
	 * @since 1.0
	 *
	 * @access public
	 *
	 */
	public function __destruct ( ) {
		// We can destruct class settings, but I don't want to log out, purely for the reason if someone 
		// uses this class with a custom AJAX environment.
		unset ( $this->userSessionId );
	}
	
	/**
	 *
	 * Regex
	 *
	 * Using a valid regex token, we can obtain a certain chunk of 
	 * regex, that way we can recycle and easily change regex
	 * as GSX's API changes
	 *
	 * @param string Name of the regex pattern we want to apply and retrieve
	 *
	 * @return string The appropriate regex according to the string supplied in the param
	 *
	 * @since 1.0
	 *
	 * @access private
	 *
	 */
	private function _regex ( $pattern ) {
		switch ( $pattern ) {
			case 'dispatchId'	:
			case 'gsxId'		:
				return '/^[G]{1}[0-9]{9}$/ ';
			break;
			
			case 'serialNumber' :
				return '/^[A-Z0-9]{11,12}$/';
			break;
			
			case 'diagnosticEventNumber' :
				return '/^[0-9]{18,22}$/';
			break;
			
			case 'repairConfirmationNumber' :
				return '/^[0-9]{12}$/';
			break;
			
			case 'shipToAccountNumber' :
				return '/^[0-9]{10}$/';
			break;
			
			case 'partNumber' :
				return '/^([A-Z]{2})?[0-9]{3}\-[0-9]{4}$/';
			break;
			
			case 'eeeCode' :
				return '/^[0-9A-Z]{3}([0-9A-Z]{1})?$/';
			break;
			
			case 'email' :
				return '/^(.+)@(.+)$/i';
			break;
		}
	}
	
	/**
	 *
	 * Assign WSDL
	 *
	 * @param null
	 *
	 * @return string The WSDL URI for GSX.
	 *
	 * @since 1.0
	 *
	 * @access protected
	 *
	 */
	protected function assign_wsdl ( ) {
		$api_mode = ( $this->gsxDetails['apiMode'] == 'production' ) ? '' : $this->gsxDetails['regionCode'];
		
		if ( $this->gsxDetails['gsxWsdl'] != '' ) {
			return $this->wsdlUrl = $this->gsxDetails['gsxWsdl'];
		} else {
			return $this->wsdlUrl = 'https://gsxws' . $api_mode . '.apple.com/gsx-ws/services/' . $this->gsxDetails['regionCode'] . '/asp?wsdl';
		}
	}
	
	/**
	 *
	 * Initiate SOAP Client
	 *
	 * This here function initialises the SOAP Client for use with GSX.
	 *
	 * @param null
	 *
	 * @return object soapClient object.
	 *
	 * @since 1.0
	 *
	 * @access private
	 *
	 */
	private function initiate_soap_client ( ) {
		if ( empty ( $this->wsdlUrl ) ) {
			$this->assign_wsdl();
		}
		
		try {
			$this->soapClient = new SoapClient ( $this->wsdlUrl );
		} catch ( SoapFault $fault ) {
			return $this->soap_error ( $fault->faultcode , $fault->faultstring );
		}
		
		return $this->soapClient;
	}
	
	/**
	 *
	 * Authenticate
	 *
	 * Authenticates details with GSX Web Services and gets a session ID if
	 * the operation was successful
	 *
	 * @param null
	 *
	 * @return string Returns the userSessionId as created by GSX.
	 *
	 * @since 1.0
	 *
	 * @access public
	 *
	 */
	public function authenticate ( ) {
		if ( !is_object ( $this->soapClient ) ) {
			$this->initiate_soap_client();
		}
		
		$authentication_array = array (
			'AuthenticateRequest' => array (
				'userId'			=> $this->gsxDetails['userId'],
				'password'			=> $this->gsxDetails['password'],
				'serviceAccountNo'	=> $this->gsxDetails['serviceAccountNo'],
				'languageCode'		=> $this->gsxDetails['languageCode'],
				'userTimeZone'		=> $this->gsxDetails['userTimeZone']
			)
		);
		
		try {
			$authentication = $this->soapClient->Authenticate ( $authentication_array );
		} catch ( SoapFault $fault ) {
			return $this->soap_error ( $fault->faultcode , $fault->faultstring );
		}
		
		$authentication = $this->obj_to_arr ( $authentication );
		
		return $this->userSessionId = $authentication['AuthenticateResponse']['userSessionId'];
	}
	
	/**
	 *
	 * Logout
	 *
	 * Obtains a valid userSessionId before logging the user out.
	 *
	 * @param null
	 *
	 * @return bool true if logged out, false if logout failed.
	 *
	 * @since 1.0
	 *
	 * @access public
	 *
	 */
	public function logout ( ) {
		if ( !$this->userSessionId ) {
			return $this->error ( __METHOD__ , __LINE__ , 'No valid session ID' );
		}
		
		$logout_array = array (
			'LogoutRequest'	=> array (
				'userSession'	=> array (
					'userSessionId'	=> $this->userSessionId
				)
			)
		);
		
		try {
			$logout = $this->soapClient->Logout ( $logout_array );
		} catch ( SoapFault $fault ) {
			return $this->soap_error ( $fault->faultcode , $fault->faultstring );
		}
		
		$logout = $this->obj_to_arr ( $logout );
		
		return $this->output_format ( ( $logout['LogoutResponse']['logoutMessage'] == 'OK' ) ? true : false , $this->gsxDetails['returnFormat'] );
	}
	
	// REPAIR CREATION API SEGMENT
	
	/**
	 *
	 * Warranty Status
	 *
	 * @param mixed 
	 *
	 * @return array Return data with warranty information
	 *
	 * @since 1.0
	 *
	 * @access public
	 *
	 */
	public function warranty_status ( $request_data ) {
		if ( empty ( $request_data ) || count ( $request_data ) < 1 ) {
			return $this->error ( __METHOD__ , __LINE__ , 'No search parameters provided' );
		}
		
		if ( !$this->userSessionId ) {
			$this->authenticate();
		}
		
		// Time to build the basic frame of our lookup request
		$warranty_array = array (
			'WarrantyStatusRequest'	=> array (
				'userSession'			=> array (
					'userSessionId'			=> $this->userSessionId
				) ,
				'unitDetail' => array ( )
			)
		);
		
		if ( is_array ( $request_data ) ) {
			foreach ( $request_data as $paramKey => $paramValue ) {
				if ( array_search ( $paramKey , $this->validWarrantyParams ) ) {
					$warranty_array['WarrantyStatusRequest']['unitDetails'][$paramKey] = $paramValue;
				}
			}
		} elseif ( preg_match ( $this->_regex ( 'serialNumber' ) , $request_data ) ) { 
			// We're doing serial number matching
			$warranty_array['WarrantyStatusRequest']['unitDetail']['serialNumber'] = $request_data;
		}
		
		try {
			$warranty_lookup = $this->soapClient->WarrantyStatus ( $warranty_array );
		} catch ( SoapFault $fault ) {
			return $this->soap_error ( $fault->faultcode , $fault->faultstring );
		}
		
		$warranty_lookup = $this->obj_to_arr ( $warranty_lookup );
		
		$warranty_lookup['WarrantyStatusResponse']['warrantyDetailInfo']['manualURL'] = $this->locate_service_manual ( $warranty_lookup['WarrantyStatusResponse']['warrantyDetailInfo']['productDescription'] );
		
		return $warranty_lookup['WarrantyStatusResponse']['warrantyDetailInfo'];
	}
	
	public function product_model ( $serialNumber ) {
		if ( empty ( $serialNumber ) ) {
			return $this->error ( __METHOD__ , __LINE__ , 'No serial number provided' );
		}
		
		if ( !$this->userSessionId ) {
			$this->authenticate();
		}
		
		$product_array = array (
			'FetchProductModelRequest' => array (
				'userSession'				=> array (
					'userSessionId'				=> $this->userSessionId
				) ,
				'productModelRequest'		=> array (
					'serialNumber'				=> $serialNumber
				)
			)
		);
		
		try {
			$product_request = $this->soapClient->FetchProductModel ( $product_array );
		} catch ( SoapFault $fault ) {
			return $this->soap_error ( $fault->faultcode , $fault->faultstring );
		}
		
		$product_lookup = $this->obj_to_arr ( $warranty_request );
		
		return $this->output_format ( $product_lookup['FetchProductModelResponse']['productModelResponse'] , $this->gsxDetails['returnFormat'] );
	}
	
	// MISC FUNCTIONS
	
	private function output_format ( $output , $format = 'php' ) {
		switch ( $format ) {
			case 'php' :
			
				return $output;
			
			break;
			
			case 'json' :
			
				return json_encode ( $output );
			
			break;
			
			case 'xml' :
			
			break;
		}
	}
	
	/**
	 *
	 * Object to Array
	 *
	 * Found this nifty function on the PHP.net website comments somewhere...
	 *	Thanks to rarioj at gmail dot com (php.net/manual/en/function.get-object-vars.php#93416) for this function
	 *
	 * @param object The object in question.
	 *
	 * @return mixed Array/Object that contains data that has been converted from an object to an array.
	 *
	 * @access public
	 *
	 */
	public static function obj_to_arr ( $object ) {
		if ( is_object ( $object ) ) {
			$object = get_object_vars ( $object );
		}
		
		return is_array ( $object ) ? array_map ( __METHOD__ , $object ) : $object;
	}
	
	protected function error ( $method , $line , $message ) {
		return 'Function ' . $method . ' (Line: ' . $line . ') returned the error: ' . $message;
	}
	
	protected function soap_error ( $code , $string ) {
		return 'SOAP Error: ' . $string . ' (Code: ' . $code . ')';
	}
	
}

?>