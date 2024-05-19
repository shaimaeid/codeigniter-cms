<?php
class users_model extends CI_Model
{
	// return all the data from users table
	function get_users($start=0, $limit=10,$filters=null){
		$where="";
		if($filters){
			$and=false;
			$where=" where ";
			foreach($filters as $key=>$value)
			{
				if($and)
				{
					$where.=" and ";
				}
				if(is_numeric($value))
				{
					$where.=" ".$key." = '".$value."' ";
				}
				else
				{
					$where.=" ".$key." like '%".$value."%' ";
				}
				$and=true;
			}
		}
		global $arrusers;
		$sql = "SELECT * FROM users ".$where." LIMIT ".$start." , ".$limit;
		$resultsql = $this->db->query($sql)->result_array();
		//echo $sql ;
		foreach ($resultsql as $row) 
		{
			$arrusers[] = array(
				'user_id' => $row['user_id'],
				'username' => $row['username'],
				'email' => $row['email'],
				'role' => $row['role'],
				'contact_person' => $row['contact_person'],
				'address' => $row['address'],
				'phone_number' => $row['phone_number'],
				'block' => $row['block'],
				'active' => $row['active']
				); 
		}
		return $arrusers;
	}
	// return one users according to the selected id
	function get_users_id($id){
		$sql = "SELECT * FROM users WHERE user_id = ".$id;
		$query = $this->db->query($sql);
		return $query->result();
	}
	// count all registered users
	function all_users_count(){
		$sql = "SELECT count(users.user_id) AS total_users FROM users";
		$data=$this->db->query($sql)->result_array();
		return $data[0]['total_users'];
	}
	//login function
	function user_login($user,$pwd){
		$result="";
		$sql = "SELECT * FROM users WHERE username = '{$user}'";
		$resultsql = $this->db->query($sql)->result_array();
		if($resultsql){
			$pass=$resultsql[0]['password'];
			$user=$resultsql[0]['username'];
			if($pwd==$pass){
			//session already started in controller constructor : session_start();
			$_SESSION['username'] = $resultsql[0]['username'];
			$_SESSION['user_id'] = $resultsql[0]['user_id'];
			$_SESSION['email'] = $resultsql[0]['email'];
			$_SESSION['role'] = $resultsql[0]['role'];
			$_SESSION['block'] = $resultsql[0]['block'];
			$_SESSION['active'] = $resultsql[0]['active'];
			$result= "true";
			}
			else{
				$result.=  "wrong password. ";
			}
		}
		else{
			$result.=  " user name not exist.";
		}
		return $result;
	}
	function admin_login($user,$pwd){
		$result="";
		$sql = "SELECT * FROM users WHERE role = 'admin' AND username = '{$user}'";
		$resultsql = $this->db->query($sql)->result_array();
		if($resultsql){
			$pass=$resultsql[0]['password'];
			$user=$resultsql[0]['username'];
			if($pwd==$pass){
			//session already started in controller constructor : session_start();
			$_SESSION['username'] = $resultsql[0]['username'];
			$_SESSION['user_id'] = $resultsql[0]['user_id'];
			$_SESSION['email'] = $resultsql[0]['email'];
			$_SESSION['role'] = $resultsql[0]['role'];
			$_SESSION['block'] = $resultsql[0]['block'];
			$_SESSION['active'] = $resultsql[0]['active'];
			$result= "true";
			}
			else if ($resultsql[0]['role'] != 'admin'){
				$result.=  "No admin with this data. ";
			}
			else{
				$result.=  "wrong password. ";
			}
		}
		else{
			$result.=  "No admin with this data.";
		}
		return $result;
	}
	// get the count of the returned users
	function count_users($filters=null){
	$where="";
		if($filters){
			$and=false;
			$where=" where ";
			foreach($filters as $key=>$value)
			{
				if($and)
				{
					$where.=" and ";
				}
				if(is_numeric($value))
				{
					$where.=" ".$key." = '".$value."' ";
				}
				else
				{
					$where.=" ".$key." like '%".$value."%' ";
				}
				$and=true;
			}
		}
		$sql = "SELECT * FROM users ".$where;
		$query = $this->db->query($sql);
        return $query->num_rows();
	}
	
	// add new users 
	function insert_users($username,$password,$email,$role='user',$phone,$address,$contact_person){
	//function not complete - dont change anything
		$inserted=false;
		$data = array(	
        				'username' => $username,
        				'email' => $email,
        				'role' => $role,
						'address' => $address,
						'contact_person' => $contact_person,
						'password' => $password,
						'block' => 0 ,
						'active' => 0
						);
        $inserted= $this->db->insert('users', $data);
		$id= $this->db->insert_id()  ;
		self::emailer($email,'admin@mysite.com','Tarbeet.com:verify your account','Tarbeet.com: click the linke below: <br /> <a href="http://www.rawaci.com/mogeeb/verify/details/'.$id.'">verify your account</a>');
		return $inserted;
		
	}
	// update users data
	function update_users($user_id,$username,$email,$contact_person,$phone_number,$address){
		$data = array(	
						'username' => $username,
        				'email' => $email,
						'address' => $address,
						'contact_person' => $contact_person,
						'phone_number' => $phone_number,
						'address' => $address
						);
        $this->db->where('user_id',$user_id);
        $this->db->update('users', $data);
	}
	// delete selected record
	function delete_users($id){
		$this->db->where('user_id',$id);
        $this->db->delete('users');
	}
    // block a user
    function block_user($id){
        $data = array('block'=>1);
        $this->db->where('user_id',$id);
        $this->db->update('users',$data);
    }
    // unblock a user
    function unblock_user($id){
        $data = array('block'=>0);
        $this->db->where('user_id',$id);
        $this->db->update('users',$data);
    }
    // reset a user function 
    function reset_password($id){
        $sql = "SELECT email FROM users WHERE user_id = ".$id;
        $data = $this->db->query($sql)->result_array();
        // now get the mail and aply sneding message for it 
		$new_password = $this->randomPassword();
        $email = $data[0]['email'];
			
		$data_pass = array('password'=>md5($new_password));
        $this->db->where('user_id',$id);
        $this->db->update('users',$data_pass);
			
		self::emailer($email,'admin@mysite.com','Tarbeet.com:new password','Your new password is '.$new_password.'<br/>Tarbeet.com: click the link below: <br /> <a href="http://www.rawaci.com/mogeeb/signin">activate your new password</a><br/>');
    }
	// get the ads for each user
	function get_user_adv($user_id=0){
		$UserAds = '';
		$where = '';
		if ($user_id>0)
			$where = ' WHERE user_id ='.$user_id;
		$sql = "SELECT * FROM users_ads ".$where;
		$resultsql = $this->db->query($sql)->result_array();
		foreach ($resultsql as $row) 
		{
			$UserAds = $UserAds .'<a href="../mogeeb/user/'.$row['username'].'">'.$row['username'].'</a>'.'    ('.$row['ads_count'].') <br/>';
		}
		return $UserAds;
	}
	//function to validate emails
	function validate_email($email){
		$sql = "SELECT * FROM users WHERE email = '{$email}' ;";
		$query = $this->db->query($sql);
		$num=$query->num_rows();
		//echo $num;
		if($num>0){
		return false;
		}
		else{
		//valid name (not in database)
		return true;
		}
	}
	// function validate email in profile
	function validate_profile_email($email,$id){
		$sql = "SELECT * FROM users WHERE email = '{$email}' AND user_id <> '{$id}' ;";
		$query = $this->db->query($sql);
		$num=$query->num_rows();
		//echo $num;
		if($num>0){
		return false;
		}
		else{
		//valid name (not in database)
		return true;
		}
	}
	//function to validate  username
	function validate_username($username){
		$sql = "SELECT * FROM users WHERE username = '{$username}';";
		$query = $this->db->query($sql);
		$num=$query->num_rows();
		//echo $num;
		if($num>0){
			return false;
		}
		else{
		//valid name (not in database)
			return true;
		}
	}
	// function to validate user in the profile view
	function validate_profile_username($username,$id){
		$sql = "SELECT * FROM users WHERE username = '{$username}' AND user_id <> '{$id}' ;";
		$query = $this->db->query($sql);
		$num=$query->num_rows();
		//echo $num;
		if($num>0){
		return false;
		}
		else{
		//valid name (not in database)
		return true;
		}
	}
	// function to validate the passord before saving the changes 
	function validate_profile_password($password,$id)
	{
		$sql = "SELECT password FROM users WHERE user_id = '{$id}';";
		$resultsql = $this->db->query($sql)->result_array();
		if($resultsql){
			$pass=$resultsql[0]['password'];
			if ($pass == $password)
			{
				return true;
			}
			else 
				return false;
		}
	}
	//function to verify user
	function verify_user($id){
		$data = array('active'=>1);
        $this->db->where('user_id',$id);
        $this->db->update('users',$data);
	}
	//emailer
	function emailer($to,$sendermail,$title,$body)
	{
		$subject = $title;
		$message = $body;
		$headers = 'From: admin@mysite.com' . "\r\n" .
			'Reply-To: '.$sendermail . "\r\n" .
			'MIME-Version: 1.0' . "\r\n".
			'Content-type: text/html; charset=utf-8' . "\r\n".
			'X-Mailer: PHP/' . phpversion();

		return mail($to, $subject, $message, $headers);

	}
	// update profile user 
	function update_user_profile($user_id,$username,$password,$email,$role,$contact_person,$address,$phone_number)
	{
		$data = array(	'username' => $username,
						'password' => $password,
						'email' => $email,
						'role' => $role,
						'contact_person' => $contact_person,
						'address' => $address,
						'phone_number' => $phone_number
					);
		$this->db->where('user_id',$user_id);
		$this->db->update('users', $data);
		$message = "Your account has been successfully updated.";
		return $message;
	}
	// upgrade user
	function upgrade_user($id){
		$data = array('role' => 'admin');
        $this->db->where('user_id',$id);
        $this->db->update('users', $data);
	}
	//downgrade_admin
	function downgrade_admin($id){
		$data = array('role' => 'user');
        $this->db->where('user_id',$id);
        $this->db->update('users', $data);
	}
	// blocl or unblock the user 
	function change_block_user($id,$block){
		$data = array('block' => $block);
        $this->db->where('user_id',$id);
        $this->db->update('users', $data);
	}
	
	// verify the user 
	function active_user($id,$active){
		$data = array('active' => $active);
        $this->db->where('user_id',$id);
        $this->db->update('users', $data);
	}
	
	// generate password function 
	function randomPassword() {
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}	
}
?>