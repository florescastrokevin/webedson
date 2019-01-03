<?php

class UserAgent{
    
    
    private $_user_agent;
    private $_browser_name;
    private $_browser_version;
    private $_operating_system;
    private $_engine;
    
    public function __construct(){
        
        $this->_user_agent = $_SERVER['HTTP_USER_AGENT'];
        $this->_browser_name = "Unknown";
        $this->_operating_system = "Unknown";
        $this->_browser_version = "";
    }
    
    public function getBrowserName() {
          
        // Next get the name of the useragent yes seperately and for good reason
        if(preg_match('/MSIE/i',$this->_user_agent) && !preg_match('/Opera/i',$this->_user_agent)){
            $this->_browser_name = 'Internet Explorer'; 
        }elseif(preg_match('/Firefox/i',$this->_user_agent)){
            $this->_browser_name = 'Mozilla Firefox'; 
        }elseif(preg_match('/Chrome/i',$this->_user_agent)){
            $this->_browser_name = 'Google Chrome'; 
        }elseif(preg_match('/Safari/i',$this->_user_agent)){
            $this->_browser_name = 'Apple Safari'; 
        }elseif(preg_match('/Opera/i',$this->_user_agent)){
            $this->_browser_name = 'Opera'; 
        }elseif(preg_match('/Netscape/i',$this->_user_agent)){
            $this->_browser_name = 'Netscape'; 
        }
        
        
        return $this->_browser_name;
        
        
    }
    
    public function getUserAgentString(){
        
        return $this->_user_agent;
    }
    
    
    public function getBrowserVersion(){
        
        // Next get the name of the useragent yes seperately and for good reason
        if(preg_match('/MSIE/i',$this->_user_agent) && !preg_match('/Opera/i',$this->_user_agent)){
            $ub = "MSIE";
        }elseif(preg_match('/Firefox/i',$this->_user_agent)){
            $ub = "Firefox";
        }elseif(preg_match('/Chrome/i',$this->_user_agent)){
            $ub = "Chrome";
        }elseif(preg_match('/Safari/i',$this->_user_agent)){
            $ub = "Safari";
        }elseif(preg_match('/Opera/i',$this->_user_agent)){ 
            $ub = "Opera";
        }elseif(preg_match('/Netscape/i',$this->_user_agent)){ 
            $ub = "Netscape";
        }
        
        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $this->_user_agent, $matches)) {
        // we have no matching number just continue
        }

        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($this->_user_agent,"Version") < strripos($this->_user_agent,$ub)){
                $this->_browser_version= $matches['version'][0];
            }else {
                $this->_browser_version= $matches['version'][1];
            }
        }else {
            $this->_browser_version= $matches['version'][0];
        }

        // check if we have a number
        if ($this->_browser_version==null || $this->_browser_version=="") {$this->_browser_version="?";}
        
        return $this->_browser_version;
        
    }
    
    public function getOs(){
        
        $useragent= strtolower($this->_user_agent);
        //winxp
        if (strpos($useragent, 'windows nt 5.1') !== FALSE) {
            $this->_operating_system = 'Windows XP';
        }elseif (strpos($useragent, 'windows nt 6.1') !== FALSE) {
            $this->_operating_system = 'Windows 7';
        }elseif (strpos($useragent, 'windows nt 6.0') !== FALSE) {
            $this->_operating_system = 'Windows Vista';
        }elseif (strpos($useragent, 'windows 98') !== FALSE) {
            $this->_operating_system = 'Windows 98';
        }elseif (strpos($useragent, 'windows nt 5.0') !== FALSE) {
            $this->_operating_system = 'Windows 2000';
        }elseif (strpos($useragent, 'windows nt 5.2') !== FALSE) {
            $this->_operating_system = 'Windows 2003 Server';
        }elseif (strpos($useragent, 'windows nt') !== FALSE) {
            $this->_operating_system = 'Windows NT';
        }elseif (strpos($useragent, 'win 9x 4.90') !== FALSE && strpos($useragent, 'win me')) {
            $this->_operating_system = 'Windows ME';
        }elseif (strpos($useragent, 'win ce') !== FALSE) {
            $this->_operating_system = 'Windows CE';
        }elseif (strpos($useragent, 'win 9x 4.90') !== FALSE) {
            $this->_operating_system = 'Windows ME';
        }elseif (strpos($useragent, 'windows phone') !== FALSE) {
            $this->_operating_system = 'Windows Phone';
        }elseif (strpos($useragent, 'iphone') !== FALSE) {
            $this->_operating_system = 'iPhone';
        }
        // experimental
        elseif (strpos($useragent, 'ipad') !== FALSE) {
            $this->_operating_system = 'iPad';
        }elseif (strpos($useragent, 'webos') !== FALSE) {
            $this->_operating_system = 'webOS';
        }elseif (strpos($useragent, 'symbian') !== FALSE) {
            $this->_operating_system = 'Symbian';
        }elseif (strpos($useragent, 'android') !== FALSE) {
            $this->_operating_system = 'Android';
        }elseif (strpos($useragent, 'blackberry') !== FALSE) {
            $this->_operating_system = 'Blackberry';
        }elseif (strpos($useragent, 'mac os x') !== FALSE) {
            $this->_operating_system = 'Mac OS X'; 
        }elseif (strpos($useragent, 'macintosh') !== FALSE) {
            $this->_operating_system = 'Macintosh';
        }elseif (strpos($useragent, 'linux') !== FALSE) {
            $this->_operating_system = 'Linux';
        }elseif (strpos($useragent, 'freebsd') !== FALSE) {
            $this->_operating_system = 'Free BSD';
        }elseif (strpos($useragent, 'symbian') !== FALSE) {
            $this->_operating_system = 'Symbian';
        }else{
            $this->_operating_system = 'Desconocido';
        }
         
        return $this->_operating_system;
    }
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.

$objeto_user_agent = new UserAgent();
echo "Sistema Operativo: ".$objeto_user_agent->getOs();  
echo "<br> Navegador: ".$objeto_user_agent->getBrowserName() ;
echo "<br> Version: ".$objeto_user_agent->getBrowserVersion();
echo "<br > Agente Completo: " .$_SERVER['HTTP_USER_AGENT'];
 */
?>