<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class DAO
	{
		protected $_tablename;
		protected $_db;
		protected $_sql,$_sql_without_params;
		protected $_params;
		

		public function __construct($tablename='',$db=null)
		{			
			$this->_db=$db;
			$this->_tablename=$tablename;
			$this->_sql = "";
			$this->_sql_without_params = "";
			$this->_params = array();			
		}		
		
		
		function set_sql_with_params($sql){
			$this->_sql = $sql;
		}

		function set_sql_without_params($sql){
			$this->_sql_without_params = $sql;
		}

		function set_sql_params(array $sql_params){
			$this->_params = $sql_params;
		}

		function execute($exec_type=0,$_sql='',$_params=array())
		{
			$type = $exec_type;
			
			if($exec_type==0){
				$sql = (empty($_sql)?$this->_sql_without_params:$_sql);
			}else{
				$sql = (empty($_sql)?$this->_sql:$_sql);
			}

			$params = (count($_params)==0?$this->_params:$_params);
			
			try{				
				if($type==1)
					$result=$this->_db->query($sql,$params);
				else
				{					

					$result = $this->_db->query($sql);

				}				

			}catch(Exception $e){
				return false;
			}
			return $result;
		}		

		function insert($model,$exec_type = 0)
		{
			if(is_object($model))
				$data = $model->get_property_collection();
			else if(is_array($model))
				$data = $model;
			else
				die('First argument must be an Array or Object');


			$sql = "INSERT INTO ".$model->get_tbl_name()." (";			

			$fields = "";
			$values = "";
			$s = false;

			foreach($data as $field => $value)
			{
				$fields .= ($s?",":"").$field;

				if($exec_type==1)
				{
					$values .= ($s?",":"").":".$field;
					$this->_params[$field] = $value;
				}
				else
				{
					if(is_array($value)){
						$val = $value['val'];
						$type = $value['type'];
					}else
					{
						$val = $value;
						$type = 'string';
					}
					
					$values .= ($s?",":"");
					
					if($type=='string')
						$values .= "'".$value."'";						
					else
						$values .= $value['val'];
						
				}
				
				$s = true;
			}
			$sql .= $fields.") VALUES (".$values.")";

			if($exec_type=='0'){
				$this->_sql_without_params = $sql;
			}else{
				$this->_sql = $sql;
			}
	
			return $this->execute($exec_type);
		}

		function update($model,array $cond,$exec_type=0)
		{
			if(is_object($model))
				$data = $model->get_property_collection();
			else if(is_array($model))
				$data = $model;
			else
				die('First argument must be an Array or Object');

			$sql = "UPDATE ".$model->get_tbl_name()." SET";
			$s = false;

			foreach($data as $field => $value)
			{	
				$sql.= ($s?",":"")." ".$field."=";
				if($exec_type==1){
					$sql.= ":".$field;
					$this->_params[$field] = $value;
				}else{
					
					if(is_array($value)){
						$val = $value['val'];
						$type = $value['type'];
					}else{
						$val = $value;
						$type = 'string';
					}

					if($type=='string')
					{
						$sql .= ($value==''?null:"'".$value."'");
					}
					else
					{						
						$sql .= ($value['val']==''?null:$value['val']);
					}
					
				}
				
				$s = true;
			}
			
			$sql .= " WHERE ";
			$s = false;
			foreach($cond as $field=>$value){
				$sql .= ($s?" AND ":"").$field."=";

				if($exec_type==1){
					$sql .= ":".$field;
					$this->_params[$field] = $value;
				}else{
					$sql .= "'".$value."'";
				}
				
			}
			
			if($exec_type=='0'){
				$this->_sql_without_params = $sql;
			}else{
				$this->_sql = $sql;
			}

			return $this->execute($exec_type);
		}		

		function delete(array $cond_dt,$exec_type=0)
		{
			$sql = "";
			$cond = "";

			$this->_sql ="DELETE FROM ".$this->_tablename;
			
			$s = false;
			$cond = " WHERE ";
			foreach($cond_dt as $field=>$value){

				if($exec_type==1)
				{
					$cond .= ($s?" AND ":"").$field."=:".$field;
					$this->_params[$field] = $value;
				}
				else
					$cond = ($s?" AND ":"").$field."='".$field."'";
			}

			$this->_sql .= $cond;			

			return $this->execute($exec_type);
		}
		

		function get_data_by_id($act,$model,$id_value){
			$result = array();
			$fields = $model->get_field_list();
			$data = $fields;

			$pk = $model->get_pkey();

			if($act=='edit')
			{
				$sql = "SELECT ";
				$s = false;
				foreach($fields as $key=>$val){
					$sql .= ($s?",":"").$key;
					$s = true;
				}

				$sql .= " FROM ".$this->_tablename." WHERE ".$pk."=:id";
								
				$this->set_sql_with_params($sql);
				$this->set_sql_params(array($id_value));				
				$query = $this->execute();

				$data = $query->row_array();

				if(!is_null($data[$pk]) and !empty($data[$pk])){
					foreach($fields as $key=>$val){
						$model->{'set_'.$key}($data[$key]);
					}
				}

				$data = $model->get_field_list();
			}			

			return $data;
			
		}


		function debug(){
			
			$sql = ($this->_sql!=''?$this->_sql:$this->_sql_without_params);
			echo "<pre>".$sql."</pre><br />";
			echo "<pre>";
			print_r($this->_params);
			echo "</pre>";
		}
	}

?>