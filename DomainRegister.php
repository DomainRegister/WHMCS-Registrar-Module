<?php

/* * ********************************************************************
 * 
 * Copyright (c) DomainRegister, PERSOLVO d.o.o. -  All Rights Reserved 
 * 
 * 
 *
 *  DomainRegister        https://domainregister.international
 *  CONTACT                        ->       support@domainregister.it
 *
 *
 *
 *
 * This software is furnished under a license and may be used and copied
 * only  in  accordance  with  the  terms  of such  license and with the
 * inclusion of the above copyright notice.  This software  or any other
 * copies thereof may not be provided or otherwise made available to any
 * other person.  No title to and  ownership of the  software is  hereby
 * transferred.
 *
 *
 *      software version 2.00
 *      software release 20210309a
 * ******************************************************************** */



use domainsReseller\module\PdoWrapper;

if (!defined('DS'))
	define('DS', DIRECTORY_SEPARATOR);
include_once dirname(__FILE__) . DS . 'PdoWrapper.php';
include_once dirname(__FILE__) . DS . 'class.api.php';

/**
* FUNCTION DomainRegister_getConfigArray()
* @param array $params
* @return array $return
*/
function DomainRegister_getConfigArray() {
	$configarray = array(
		"FriendlyName" => array(
			"Type"          => "System",
			"Value"         => "DomainRegister"
		),
		"Description" => array(
			"Type"          => "System",
			"Value"         => "DomainRegister allows you to manage .it domains and the widest variety of TLD.<br> Don't have a DomainRegister account yet? Register here for free: <a href=\"https://domainregister.international/register.php\">https://domainregister.international</a>"
		),
		"api_email" => array(
			"FriendlyName"  => "User Email",
			"Type"          => "text",
			"Size"          => "40",
			"Description"   => "Enter the email address used for your main account on DomainRegister"
		),
		"api_key" => array(
			"FriendlyName"  => "API Key",
			"Type"          => "text",
			"Size"          => "40",
			"Description"   => "Enter the API key received from DomainRegister"
		),
        "test" => array(
			"FriendlyName"  => "test mode",
			'Type'          => 'yesno',
			"Description"   => "Tick to enable test mode (sandbox)"
		),
	);
	return $configarray;
}

/**
* FUNCTION DomainRegister_RegisterDomain()
* Register Domain
* @param array $params
* @return array $return
*/
function DomainRegister_RegisterDomain($params)
{
	$API = new DomainRegister_API($params['api_email'], $params['api_key']);
        $requeststring = array(
		'action'			=> 'RegisterDomain',
		'sld'				=> $params["sld"],
		'tld'				=> $params["tld"],
		'regperiod'			=> $params["regperiod"],
		'nameserver1'       => $params["ns1"],
		'nameserver2'       => $params["ns2"],
		'nameserver3'       => $params["ns3"],
		'nameserver4'       => $params["ns4"],
		'nameserver5'       => $params["ns5"],
		'dnsmanagement'		=> $params['dnsmanagement']	? 1 : 0,
		'emailforwarding'	=> $params['emailforwarding']	? 1 : 0,
		'idprotection'		=> $params['idprotection']	? 1 : 0,
        'firstname'         => $params["firstname"],
		'lastname'			=> $params["lastname"],
		'companyname'       => $params["companyname"],
		'address1'			=> $params["address1"],
		'address2'			=> $params["address2"],
		'city'              => $params["city"],
		'state'             => $params["state"],
		'country'			=> $params["country"],
		'postcode'			=> $params["postcode"],
		'phonenumber'       => $params["phonenumber"],
        'fullphonenumber'   => $params["fullphonenumber"],
		'email'             => $params["adminemail"],
		'adminfirstname'	=> $params["adminfirstname"],
		'adminlastname'		=> $params["adminlastname"],
		'admincompanyname'	=> $params["admincompanyname"],
		'adminaddress1'		=> $params["adminaddress1"],
		'adminaddress2'		=> $params["adminaddress2"],
		'admincity'			=> $params["admincity"],
		'adminstate'		=> $params["adminstate"],
		'admincountry'		=> $params["admincountry"],
		'adminpostcode'		=> $params["adminpostcode"],
		'adminphonenumber'	=> $params["adminphonenumber"],
        'adminfullphonenumber'  => $params["adminfullphonenumber"],
		'adminemail'		=> $params["adminemail"],
        'domainfields'      => base64_encode(serialize($params["additionalfields"]))
	);
        
        if(isset($params['phonenumberformatted']))
        {
            $requeststring['phonenumberformatted'] = $params['phonenumberformatted'];
        }
        if(isset($params['statecode']))
        {
            $requeststring['statecode'] = $params['statecode'];
        }        
        if(isset($params['adminfullstate']))
        {
            $requeststring['adminfullstate'] = $params['adminfullstate'];
        }
        if(isset($params['countrycode']))
        {
            $requeststring['countrycode'] = $params['countrycode'];
        }        
        if(isset($params['fullstate']))
        {
            $requeststring['fullstate'] = $params['fullstate'];
        }
        
	$result = $API->simpleCall('POST', $requeststring);

	return $API->getError() ? array( 'error' => $API->getError() ) : 'success';
}

/**
* FUNCTION DomainRegister_TransferDomain()
* Transfer Domain
* @param array $params
* @return array $return
*/
function DomainRegister_TransferDomain($params)
{
	$API = new DomainRegister_API($params['api_email'], $params['api_key']);
        $requeststring = array(
        'action'			=> 'TransferDomain',
		'transfersecret'    => $params['transfersecret'],
		'sld'				=> $params["sld"],
		'tld'				=> $params["tld"],
		'regperiod'			=> $params["regperiod"],
		'nameserver1'       => $params["ns1"],
		'nameserver2'       => $params["ns2"],
		'nameserver3'       => $params["ns3"],
		'nameserver4'       => $params["ns4"],
		'nameserver5'       => $params["ns5"],
		'dnsmanagement'		=> $params['dnsmanagement']	? 1 : 0,
		'emailforwarding'	=> $params['emailforwarding']	? 1 : 0,
		'idprotection'		=> $params['idprotection']	? 1 : 0,
        'firstname'         => $params["firstname"],
		'lastname'			=> $params["lastname"],
		'companyname'       => $params["companyname"],
		'address1'			=> $params["address1"],
		'address2'			=> $params["address2"],
		'city'              => $params["city"],
		'state'             => $params["state"],
		'country'			=> $params["country"],
		'postcode'			=> $params["postcode"],
		'phonenumber'       => $params["phonenumber"],
        'fullphonenumber'   => $params["fullphonenumber"],
		'email'             => $params["email"],
		'adminfirstname'	=> $params["adminfirstname"],
		'adminlastname'		=> $params["adminlastname"],
		'admincompanyname'	=> $params["admincompanyname"],
		'adminaddress1'		=> $params["adminaddress1"],
		'adminaddress2'		=> $params["adminaddress2"],
		'admincity'			=> $params["admincity"],
		'adminstate'		=> $params["adminstate"],
		'admincountry'		=> $params["admincountry"],
		'adminpostcode'		=> $params["adminpostcode"],
		'adminphonenumber'	=> $params["adminphonenumber"],
        'adminfullphonenumber'  => $params["adminfullphonenumber"],
		'adminemail'		=> $params["adminemail"],
        'domainfields'      => base64_encode(serialize($params["additionalfields"]))
	);
        
        if(isset($params['phonenumberformatted']))
        {
            $requeststring['phonenumberformatted'] = $params['phonenumberformatted'];
        }
        if(isset($params['statecode']))
        {
            $requeststring['statecode'] = $params['statecode'];
        }        
        if(isset($params['adminfullstate']))
        {
            $requeststring['adminfullstate'] = $params['adminfullstate'];
        }
        if(isset($params['countrycode']))
        {
            $requeststring['countrycode'] = $params['countrycode'];
        }          
        if(isset($params['fullstate']))
        {
            $requeststring['fullstate'] = $params['fullstate'];
        }        
        
        $API->simpleCall('POST', $requeststring);
	
	return $API->getError() ? array( 'error' => $API->getError() ) : 'success';
}

/**
* FUNCTION DomainRegister_RenewDomain
* Renew Domain
* @param array $params
* @return array $return
*/
function DomainRegister_RenewDomain($params) {
	$API = new DomainRegister_API($params['api_email'], $params['api_key']);
	$API->simpleCall('POST', array(
		'action'		=> 'RenewDomain',
		'sld'			=> $params["sld"],
		'tld'			=> $params["tld"],
		'regperiod'		=> $params["regperiod"],
	));
	
	return $API->getError() ? array( 'error' => $API->getError() ) : 'success';
}

/**
* FUNCTION DomainRegister_getNameserver
* Get name servers
* @param array $params
* @return array $return
*/
function DomainRegister_GetNameservers($params){
        $API  = new DomainRegister_API($params['api_email'], $params['api_key']);
	$data = $API->simpleCall('POST', array(
		'action'		=> 'GetNameservers',
        'sld'			=> $params["sld"],
		'tld'			=> $params["tld"],
	));
       
        if($data['result']=='success'){
            for($i=1;$i<=5;$i++)
            {
                $return['ns'.$i] = $data['ns'.$i];
            }  
        } else return array('error'=>$API->getError());
        return $return;      
}

/**
* FUNCTION DomainRegister_SaveNameservers
* Save nameservers
* @param array $params
* @return array $return
*/
function DomainRegister_SaveNameservers($params){   
    $API  = new DomainRegister_API($params['api_email'], $params['api_key']);
    $data = $API->simpleCall('POST', array(
            'action'                => 'SaveNameservers',
            'sld'                   => $params["sld"],
            'tld'                   => $params["tld"],
            'nameserver1'           => $params["ns1"],
            'nameserver2'           => $params["ns2"],
            'nameserver3'           => $params["ns3"],
            'nameserver4'           => $params["ns4"],
            'nameserver5'           => $params["ns5"],
    ));

    if($data['result']=='success')
        return true;
    else
        return array('error'=>$API->getError());
    
}

/**
* FUNCTION DomainRegister_ReleaseDomain
* Release Domain
* @param array $params
* @return array $return
*/
function DomainRegister_ReleaseDomain($params){
    $API  = new DomainRegister_API($params['api_email'], $params['api_key']);
    $data = $API->simpleCall('POST', array(
            'action'		=> 'ReleaseDomain',
            'sld'		=> $params["sld"],
            'tld'		=> $params["tld"],
            'newtag'            => $params['transfertag'],
            'transfertag'       => $params['transfertag']
    ));

    if($data['result']=='success')
        return true;
    else
        return array('error'=>$API->getError());
}



/**
* FUNCTION DomainRegister_getContactDetails
* Get Contact Details
* @param array $params
* @return array $return
*/
function DomainRegister_GetContactDetails($params){
    $API  = new DomainRegister_API($params['api_email'], $params['api_key']);
    $data = $API->simpleCall('POST', array(
            'action'		=> 'GetContactDetails',
            'sld'		=> $params["sld"],
            'tld'		=> $params["tld"],
    ));
   
    if($data['result']=='success'){
        unset($data['result']);
        $new = array();
        foreach($data as $key=>$val){
            foreach($val as $k => $v){
                $new[$key][str_replace('_', ' ',$k)] = $v;
            }
        }
        
        return $new;
    } else
        return array('error'=>$API->getError());
 
}

/**
* FUNCTION DomainRegister_SaveContactDetails
* Save Contact Details
* @param array $params
* @return array $return
*/
function DomainRegister_SaveContactDetails($params){
    $new = array();
        foreach($params['contactdetails'] as $key=>$val){
            foreach($val as $k => $v){
                $new[$key][str_replace(' ', '_',$k)] = $v;
            }
    }
    
    $API  = new DomainRegister_API($params['api_email'], $params['api_key']);
    $te = array(
            'action'		=> 'SaveContactDetails',
            'sld'		=> $params["sld"],
            'tld'		=> $params["tld"],
            'contactdetails'    => $new,
    );

    $data = $API->simpleCall('POST', $te);

    if($data['result']=='success'){
        unset($data['result']);
        return $data;
    } else
        return array('error'=>$API->getError());
 
}


/**
* FUNCTION DomainRegister_GetDomainFields
* Get Additional Domain Fields
* @param array $params
* @return array $return
*/
function DomainRegister_GetDomainFields(){
    global $additionaldomainfields;
    $query = PdoWrapper::query("SELECT `setting`,`value` FROM `tblregistrars` WHERE `registrar`='DomainRegister'");
    $params = array();
    
    while($r = PdoWrapper::fetchAssoc($query)){
        $params[$r['setting']] = decrypt($r['value']);
    }
    
    if(empty($params))
        return false;
    
    $API  = new DomainRegister_API($params['api_email'], $params['api_key']);
    $vars =  array(
        'action' => 'GetDomainFields'
    );
    $data = $API->simpleCall('POST', $vars);
    if(is_array($data)){
       $merge = array_merge($additionaldomainfields,$data);
           return $merge;
    }

}


/**
* FUNCTION DomainRegister_getRegistrarLock
* Get Lock Status
* @param array $params
* @return array $return
*/
function DomainRegister_GetRegistrarLock($params){
    $API  = new DomainRegister_API($params['api_email'], $params['api_key']);
    $data = $API->simpleCall('POST', array(
            'action'	=> 'domaingetlockingstatus',
            'sld'		=> $params["sld"],
            'tld'		=> $params["tld"],
    ));


    if($data['result']=='success'){
        if($data['lockstatus']=='Unknown')  
            return "";
        return $data['lockstatus'];
    }    
    else
        return array('error'=>$API->getError());
}


/**
* FUNCTION DomainRegister_SaveRegistrarLock
* Update Lock Status
* @param array $params
* @return array $return
*/
function DomainRegister_SaveRegistrarLock($params){
    $API  = new DomainRegister_API($params['api_email'], $params['api_key']);
    $data = $API->simpleCall('POST', array(
            'action'		=> 'domainupdatelockingstatus',
            'sld'			=> $params["sld"],
            'tld'			=> $params["tld"],
            'lockenabled'   => $params['lockenabled']
    ));


    if($data['result']=='success'){
        return true;
    }else if($data['result']=='empty')  
        return;
    else 
        return array('error'=>$API->getError());
}

/**
* FUNCTION DomainRegister_GetDNS
* Get DNS Records
* @param array $params
* @return array $return
*/
function DomainRegister_GetDNS($params){
    $API  = new DomainRegister_API($params['api_email'], $params['api_key']);
    $data = $API->simpleCall('POST', array(
            'action'	=> 'GetDNS',
            'sld'		=> $params["sld"],
            'tld'		=> $params["tld"],
            'regperiod' => $params['regperiod'],
            'regtype'   => $params['regtype'],
    ));

    if($data['result']=='success'){
        unset($data['result']);
        return $data;
    } else 
        return array(
           'error' => $API->getError()
       );
}

/**
* FUNCTION DomainRegister_SaveDNS
* Save DNS Records
* @param array $params
* @return array $return
*/
function DomainRegister_SaveDNS($params){
    $API  = new DomainRegister_API($params['api_email'], $params['api_key']);
    $data = $API->simpleCall('POST', array(
            'action'		=> 'SaveDNS',
            'sld'			=> $params["sld"],
            'tld'			=> $params["tld"],
            'regperiod'     => $params['regperiod'],
            'regtype'       => $params['regtype'],
            'dnsrecords'    => base64_encode(serialize($params['dnsrecords']))
    ));

    if($data['result']=='success'){
        return 'success';
    } else {
       return array(
           'error' => $API->getError()
       );
    }
}

/**
* FUNCTION DomainRegister_RegisterNameserver
* Register Name Server
* @param array $params
* @return array $return
*/
function DomainRegister_RegisterNameserver($params){
    $API  = new DomainRegister_API($params['api_email'], $params['api_key']);
    $data = $API->simpleCall('POST', array(
            'action'		=> 'RegisterNameserver',
            'sld'			=> $params["sld"],
            'tld'			=> $params["tld"],
            'regperiod'     => $params['regperiod'],
            'nameserver'    => $params['nameserver'],
            'ipaddress'     => $params['ipaddress'],
            'regtype'       => $params['regtype']
    ));

    if($data['result']=='success'){
        return 'success';
    } else {
       return array(
           'error' => $API->getError()
       );
    }
}

/**
* FUNCTION DomainRegister_ModifyNameserver
* Update Name Server
* @param array $params
* @return array $return
*/
function DomainRegister_ModifyNameserver($params){
    $API  = new DomainRegister_API($params['api_email'], $params['api_key']);
    $data = $API->simpleCall('POST', array(
            'action'			=> 'ModifyNameserver',
            'sld'				=> $params["sld"],
            'tld'				=> $params["tld"],
            'regperiod'         => $params['regperiod'],
            'nameserver'        => $params['nameserver'],
            'currentipaddress'  => $params['currentipaddress'],
            'newipaddress'      => $params['newipaddress'],
            'regtype'           => $params['regtype']
    ));

    if($data['result']=='success'){
        return 'success';
    } else {
       return array(
           'error' => $API->getError()
       );
    }
    
}

/**
* FUNCTION DomainRegister_DeleteNameserver
* Delete Name Server
* @param array $params
* @return array $return
*/
function DomainRegister_DeleteNameserver($params){
    $API  = new DomainRegister_API($params['api_email'], $params['api_key']);
    $data = $API->simpleCall('POST', array(
            'action'		=> 'DeleteNameserver',
            'sld'			=> $params["sld"],
            'tld'			=> $params["tld"],
            'regperiod'     => $params['regperiod'],
            'nameserver'    => $params['nameserver'],
            'regtype'       => $params['regtype']
    ));

    if($data['result']=='success'){
        return 'success';
    } else {
       return array(
           'error' => $API->getError()
       );
    }
    
}

/**
* FUNCTION DomainRegister_RequestDelete
* Delete Domain
* @param array $params
* @return array $return
*/
function DomainRegister_RequestDelete($params){
    $API  = new DomainRegister_API($params['api_email'], $params['api_key']);
    $data = $API->simpleCall('POST', array(
            'action'		=> 'RequestDelete',
            'sld'			=> $params["sld"],
            'tld'			=> $params["tld"],
            'regperiod'     => $params['regperiod'],
            'regtype'       => $params['regtype']
    ));
    $values = array();
    if($data['result']=='success'){
        return 'success';
    } else {
        $values['error'] = $API->getError();
    }
    
    return $values;
}
 

/**
* FUNCTION DomainRegister_TransferSync
* Synchronize transfer domain
* @param array $params
* @return array $return
*/
function DomainRegister_TransferSync($params) {
    $API  = new DomainRegister_API($params['api_email'], $params['api_key']);
    $data = $API->simpleCall('POST', array(
            'action'		=> 'TransferSync',
            'sld'			=> $params["sld"],
            'tld'			=> $params["tld"],
            'regperiod'     => $params['regperiod'],
            'domain'        => $params['sld'].'.'.$params['tld']
    ));
    $values = array();
    if($data['result']=='success'){
        unset($data['result']);
        return $data;
    } else {
        $values['error'] = $API->getError();
    }
    
    return $values;
}


/**
* FUNCTION DomainRegister_Sync
* Synchronize Registered Domains
* @param array $params
* @return array $return
*/
function DomainRegister_Sync($params) {
    $API  = new DomainRegister_API($params['api_email'], $params['api_key']);
    $data = $API->simpleCall('POST', array(
            'action'		=> 'Sync',
            'sld'		=> $params["sld"],
            'tld'		=> $params["tld"],
            'domain'            => $params['sld'].'.'.$params['tld']
    ));
    $values = array();
    if($data['result']=='success' ){
          unset($data['result']);
          if($data['status']=='Active')
          {
              $values['active']       = true;
          } else {
              
              if (strtotime(date( "Ymd" )) <= strtotime( $data['expirydate'] )) {
                   $values['expirydate'] = $data['expirydate'];
                   $values["active"]  = true;
              }
              else {
                   $values['expirydate'] = $data['expirydate'];
                   $values["expired"] = true;
              }
          }
          return $values;
    } else {
        $values['error'] = $API->getError();
    }
  
    return $values;
}


/**
* FUNCTION DomainRegister_GetEmailForwarding
* Get list of emails aliases
* @param array $params
* @return array $return
*/
function DomainRegister_GetEmailForwarding($params)
  {
    $API  = new DomainRegister_API($params['api_email'], $params['api_key']);
    $data = $API->simpleCall('POST', array(
            'action'		=> 'GetEmailForwarding',
            'sld'			=> $params["sld"],
            'tld'			=> $params["tld"],
            'regperiod'     => $params['regperiod'],
            'regtype'       => $params['regtype']
    ));
    if($data['result']=='success'){
        unset($data['result']);
        return $data;
    } 
}
  

/**
* FUNCTION DomainRegister_SaveEmailForwarding
* Save list of emails aliases
* @param array $params
* @return array $return
*/
function DomainRegister_SaveEmailForwarding($params)
{
    $API  = new DomainRegister_API($params['api_email'], $params['api_key']);
    $data = $API->simpleCall('POST', array(
            'action'		=> 'SaveEmailForwarding',
            'sld'			=> $params["sld"],
            'tld'			=> $params["tld"],
            'regperiod'     => $params['regperiod'],
            'regtype'       => $params['regtype'],
            'prefix'        => base64_encode(serialize($params['prefix'])),
            'forwardto'     => base64_encode(serialize($params['forwardto']))
    ));
    if($data['result']=='success'){
        return $data;
    } else 
        return array(
           'error' => $API->getError()
       );
}

/**
* FUNCTION DomainRegister_IDProtectToggle
* This function is called when the ID Protection setting is toggled on or off
* @param array $params
* @return array $return
*/
function DomainRegister_IDProtectToggle($params)
{
    $API  = new DomainRegister_API($params['api_email'], $params['api_key']);
    $data = $API->simpleCall('POST', array(
            'action'		=> 'IDProtectToggle',
            'sld'			=> $params["sld"],
            'tld'			=> $params["tld"],
            "domainname"    => $params["domainname"],
            "regperiod"     => $params["regperiod"],
            'protectenable' => $params["protectenable"]
    ));
    if($data['result']=='success'){
        return $data;
    } else 
        return array(
           'error' => $API->getError()
       );
}




/**
* FUNCTION DomainRegister_CreditAmount
* This function gets the value of credit amount available to the Reseller
* @param array $params
* @return array $return
*/
function DomainRegister_CreditAmount($params)
  {
    $API  = new DomainRegister_API($params['api_email'], $params['api_key']);
    $data = $API->simpleCall('POST', array(
            'action'		=> 'CreditAmount'
    ));
    return $params;
    return $data;
    if($data['result']=='success'){
        unset($data['result']);
        return $data;
    } 
}

use WHMCS\Domain\TopLevel\ImportItem;
use WHMCS\Results\ResultsList;

function DomainRegister_GetTldPricing(array $params)
{
    // Perform API call to retrieve extension information
    // A connection error should return a simple array with error key and message
    // return ['error' => 'This error occurred',];

    $results = new ResultsList;
  
    $data = array(
         "action"		=> "GetPricing",
         "token"        => $params['api_key'],
         "authemail"    => trim($params['api_email'])
    );
  
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://domainregister.international/domainsResellerAPI/api.php");
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
    $result = curl_exec($ch);

    $headerlenght=strpos($result,'{"result"');
    $result2 = substr($result,$headerlenght);
    $res    = json_decode($result2, true);
    $domains=$res['pricing'];
    $tlds=array_keys($domains);

    foreach ($tlds as $tld) {
         $item = (new ImportItem)
                ->setExtension('.'.$tld)
                ->setMinYears('1')
                ->setMaxYears(max(array_keys($domains[$tld]['renew'])))
                ->setRegisterPrice($domains[$tld]['register']['1'])
                ->setRenewPrice($domains[$tld]['renew']['1'])
                ->setTransferPrice($domains[$tld]['transfer']['1'])
                ->setGraceFeeDays($domains[$tld]['grace_period']['days'])
                ->setGraceFeePrice($domains[$tld]['gracefee'])       
                ->setRedemptionFeeDays($domains[$tld]['redemption_period']['days'])
                ->setRedemptionFeePrice($domains[$tld]['redemptionfee'])
                ->setCurrency('EUR')
                ->setEppRequired($domains[$tld]['EPP']);
         $results[] = $item;
    }  
  
    return $results;
}



