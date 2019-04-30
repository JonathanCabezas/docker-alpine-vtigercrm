<?php
    function vtws_generateRandomAccessKey($length=10){
        $source = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $accesskey = "";
        $maxIndex = strlen($source);
        for($i=0;$i<$length;++$i){
            $accesskey = $accesskey.substr($source,rand(null,$maxIndex),1);
        }
        return $accesskey;
    }

	function get_user_hash($input) {
		return strtolower(md5($input));
    }
    
    function encrypt_password($user_name, $user_password, $crypt_type='') {
		// encrypt the password.
		$salt = substr($user_name, 0, 2);
		//TODO : remove untill here in the next udpate

		// Fix for: http://trac.vtiger.com/cgi-bin/trac.cgi/ticket/4923
		if($crypt_type == '') {
			// Try to get the crypt_type which is in database for the user
			//$crypt_type = $this->get_user_crypt_type();
		}

		// For more details on salt format look at: http://in.php.net/crypt
		if($crypt_type == 'MD5') {
			$salt = '$1$' . $salt . '$';
		} elseif($crypt_type == 'BLOWFISH') {
			$salt = '$2$' . $salt . '$';
		} elseif($crypt_type == 'PHP5.3MD5') {
			//only change salt for php 5.3 or higher version for backward
			//compactibility.
			//crypt API is lot stricter in taking the value for salt.
			$salt = '$1$' . str_pad($salt, 9, '0');
		}

		$encrypted_password = crypt($user_password, $salt);
		return $encrypted_password;
    }

    // this function was based on the function change_password in Users.php
	function get_query_to_change_admin($username, $password, $email) {
		$user_hash = get_user_hash($password);
        $encrypted_password = encrypt_password($username, $password, 'PHP5.3MD5');
        $accesskey = vtws_generateRandomAccessKey(16);

        $query = 
        "UPDATE vtiger_users SET user_name='$username',user_password='$encrypted_password', " . "confirm_password='$encrypted_password',user_hash='$user_hash',first_name='Administrator'," . "accesskey='$accesskey', email1='$email' WHERE id=1;";

        print($query);
	}
    
    // based on modules/Install/models/ConfigFileUtils.php 
    // change this key in config.inc.php
    function generate_unique_application_key() {
        print(md5(time() + rand(1,9999999)));
    }
    
    // based on modules/WSAPP/modules/WSAPP/WSAPP.php
    function get_query_appkey() {
        $appkey = uniqid();

        $query = "UPDATE vtiger_wsapp SET appkey='$appkey' WHERE appid=1;";

        print($query);
    }
?>