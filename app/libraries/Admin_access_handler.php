<?php
	
	
	class admin_access_handler
	{
		protected $_dao;
		private $_ci;

		function __construct(){
			$this->_ci =& get_instance();
		}

		function initialize_dao($dao){
			$this->_dao = $dao;
		}		

		function login_process($username,$password,$ip)
		{
			$sql = "SELECT a.*,b.name as type_name FROM admins a LEFT JOIN user_types b ON (a.type_fk=b.type_id)
					WHERE(username='".$username."' and password='".$password."')";


	        $row = $this->_dao->execute(0,$sql)->row_array();			
			
			if(!empty($row['admin_id']))
			{

				if($row['status']=='0')
					return 'failed2';

				$admin_id = $row['admin_id'];

				$sec1 = microtime();
			    mt_srand((double)microtime()*1000000);
			    $sec2 = mt_rand(1000,9999);

			    $session_id = md5($sec2.$sec2);

			    $user_agent = $_SERVER['HTTP_USER_AGENT'];			    
			    $login_time = date('Y-m-d H:i:s');
			    $session_content = "{\"admin_id\":\"".$admin_id."\",
		    						 \"username\":\"".$row['username']."\"}";
				
				try
				{
					//delete session data for current username
					$sql = "DELETE FROM user_logins WHERE user_id='".$admin_id."'";
		    		$result = $this->_dao->execute(0,$sql);
		    		if(!$result){
		    			return 'failed1';
		    		}

			  		// ===== //

				  	//save new session data for current username
		    		$sql = "INSERT INTO user_sessions 
		    			(session_id,user_id,user_type,user_agent,ip,login_time,session_content) 
		    			VALUES('".$session_id."','".$admin_id."','admin','".$user_agent."','".$ip."','".$login_time."','".$session_content."')";
		    		$result = $this->_dao->execute(0,$sql);
		    		if(!$result){
		    			return 'failed1';
		    		}
				  	// ===== //

				  	//save new login history for current username
		    		$time= explode(" ", microtime());
			    	$last_access= (double) $time[1];

			    	$sql = "INSERT INTO user_logins 
			    			(session_id,user_id,user_type,ip,last_access,user_agent,login_time) 
			    			VALUES('".$session_id."','".$admin_id."','admin','".$ip."','".$last_access."','".$user_agent."','".$login_time."')";
			    	$result = $this->_dao->execute(0,$sql);
			    	if(!$result){
			    		return 'failed1';
			    	}
					// ===== //


					$dt_session = array(
								'admin_id'=>$admin_id,
							    'username'=>$row['username'],
							    'admin_type'=>$row['type_name'],
							    'admin_type_id'=>$row['type_fk'],
							    'login_time'=>$login_time,
							    'session_id'=>$session_id,
							  );


					if($row['type_fk']=='3' or $row['type_fk']=='4'){
						
						$row2 = $this->_dao->execute(0,"SELECT tipe_sekolah_id,latitude,longitude,nama_sekolah FROM sekolah WHERE sekolah_id='".$row['sekolah_id']."'")->row_array();

						$dt_session['sekolah_id'] = $row['sekolah_id'];
						$dt_session['nama_sekolah'] = $row2['nama_sekolah'];
						$dt_session['tipe_sekolah'] = $row2['tipe_sekolah_id'];
						$dt_session['latitude'] = $row2['latitude'];
						$dt_session['longitude'] = $row2['longitude'];

					}

					$this->_ci->session->set_userdata($dt_session);	

				}
			    catch(Exception $e)
			    {
			    	return 'failed1';
			    }
				return 'success';
			}
			else
			{
				return 'failed1';
			}
			
		}

		function logout_process()
		{			
			//delete session data for current username
			$sql = "DELETE FROM user_logins WHERE user_id='".$this->_ci->session->userdata('admin_id')."'";
    		$result = $this->_dao->execute(0,$sql);
	  		// ===== //
				   
			$this->_ci->session->sess_destroy();
			redirect('backoffice');
		}


		function check_access()
		{
			if(is_null($this->session->userdata('admin_id')))
			{
				redirect('backoffice');
			}
			
			//Execute the SQL Statement (Get Username)
			$sql = "SELECT user_id,last_access from user_logins WHERE session_id='".$this->_ci->session->userdata('session_id')."'";			
			$row = $this->_dao->execute(0,$sql)->row_array();
			
			if(!isset($row['user_id']))
			{
				echo "
					<script type='text/javascript'>
						alert('Ada pengguna lain yang menggunakan login anda atau session anda telah expired, silahkan login kembali');						
					</script>";
				redirect('backoffice');
				
			}
			
			$user_id = $data['user_id'];
			$last_access = $data['last_access'];

			/*=====================================================
			AUTO LOG-OFF 15 MINUTES
			======================================================*/

			//Update last access!
			$time= explode(" ", microtime());
			$usersec= (double) $time[1];
			
			$diff   = $usersec-$last_access;
			$limit  = 60*30;
			
			if($diff>$limit)
			{				
	      		echo "
					<script type='text/javascript'>
						alert('Maaf status anda idle (tidak beraktifitas selama lebih dari 30 menit) dan session Anda telah expired, silahkan login kembali');
					</script>";
				redirect('backoffice');	      		
			}
			else
			{
			    $sql="UPDATE user_logins SET last_access='".$usersec."' WHERE user_id='".$user_id."'";
			    $result = $this->_dao->Execute(0,$sql);			    
			}
		}

		function check_privilege($restriction="all",$nav_id)
		{			
			$access_granted=false;
			$type_fk = $this->_ci->session->userdata('admin_type_id');

			if($restriction != 'all')
			{
				$_restriction=strtolower($restriction."_priv");

				$sql = "SELECT ".$_restriction." AS check_access FROM admin_privileges WHERE type_fk='".$type_fk."' AND nav_fk='".$type_fk."'";
				$stmt = $this->_db->prepare($sql);
				$stmt->Execute(array('type_fk'=>$type_fk,'nav_id'=>$nav_id));
				$check_access = $stmt->fetchColumn();
				
				$access_granted=($check_access==1?true:false);
			}
			else
			{
				$access_granted=true;
			}
			

			return $access_granted;
		}

		function get_menu_number($value)
		{	
			try{
				$sql = "SELECT nav_id,folder_number FROM navigations WHERE(url=:val)";
				$stmt = $this->_db->prepare($sql);
				
				$stmt->Execute(array('val'=>$value));
				$data = $stmt->fetch();
				$result = array($data['NAV_ID'],$data['FOLDER_NUMBER']);
				
			}catch(Exception $e){
				$result = array();
			}
			return $result;
		}
	}
?>