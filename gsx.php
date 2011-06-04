<?php

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
			'apiMode'			=> 'production',
			'regionCode'		=> 'apac',
			'userId'			=> '',
			'password'			=> '',
			'serviceAccountNo'	=> '',
			'languageCode'		=> 'en',
			'userTimeZone'		=> 'PDT'
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
		
	}

?>