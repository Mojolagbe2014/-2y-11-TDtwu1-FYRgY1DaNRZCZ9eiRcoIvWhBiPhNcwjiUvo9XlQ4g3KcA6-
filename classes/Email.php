<?php
/**
 * Description of Email
 *
 * @author Kaiste
 */
class Email {
    
    public function Email(){
        //class constructor
    }
    
    /**
     * verify method verifies if an email address actually exists not syntax checking
     * @param string $toEmail Email address of the reciever
     * @param string $fromEmail Sender email address
     * @param boolean $getDetails Wether to return additional information apart from valid|invalid
     * @return mixed String valid|invalid or Array of valid|invalid with detail if $getDetails=true
     */
    public static function verify($toEmail, $fromEmail, $getDetails = false){
	$emailArr = explode("@", $toEmail);
	$domain = array_slice($emailArr, -1);
	$domain = $domain[0];

	// Trim [ and ] from beginning and end of domain string, respectively
	$domain = ltrim($domain, "[");
	$domain = rtrim($domain, "]");

	if( "IPv6:" == substr($domain, 0, strlen("IPv6:")) ) { $domain = substr($domain, strlen("IPv6") + 1); }

	$mxhosts = array();
	if( filter_var($domain, FILTER_VALIDATE_IP) ) $mx_ip = $domain;
	else getmxrr($domain, $mxhosts, $mxweight);

	if(!empty($mxhosts) ) $mx_ip = $mxhosts[array_search(min($mxweight), $mxhosts)];
	else {
            if( filter_var($domain, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ) { $record_a = dns_get_record($domain, DNS_A); }
            elseif( filter_var($domain, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) ) { $record_a = dns_get_record($domain, DNS_AAAA); }

            if( !empty($record_a) )
                    $mx_ip = $record_a[0]['ip'];
            else {
                $result   = "invalid";
                $details .= "No suitable MX records found.";
                return ( (true == $getDetails) ? array($result, $details) : $result );
            }
	}
	
	$connect = @fsockopen($mx_ip, 25); 
	if($connect){ 
            if(preg_match("/^220/i", $out = fgets($connect, 1024))){
                fputs ($connect , "HELO $mx_ip\r\n"); 
                $out = fgets ($connect, 1024);
                $details .= $out."\n";

                fputs ($connect , "MAIL FROM: <$fromEmail>\r\n"); 
                $from = fgets ($connect, 1024); 
                $details .= $from."\n";

                fputs ($connect , "RCPT TO: <$toEmail>\r\n"); 
                $to = fgets ($connect, 1024);
                $details .= $to."\n";

                fputs ($connect , "QUIT"); 
                fclose($connect);

                if(!preg_match("/^250/i", $from) || !preg_match("/^250/i", $to)){ $result = "invalid";  }
                else{ $result = "valid"; }
            } 
	}
	else{ $result = "invalid"; $details .= "Could not connect to server"; }
	if($getDetails){ return array($result, $details); }
	else{ return $result; }
    }
}