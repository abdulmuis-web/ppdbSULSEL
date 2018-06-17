<?php
	class PPDB_ranking{

		private $regid,$school,$school_type,$field,$path,$year,$dao,$achievements;
		private $rankList,$rank,$score,$levelAchievement,$rateAchievement;
		public $opponents,$myReg;

		function __construct(){
			$this->rank=1;
			$this->rankList = array();
		}

		function set_dbAccess_needs($regid,$school,$school_type,$field,$path,$year,$dao){
			$this->regid=$regid;
			$this->school=$school;
			$this->school_type=$school_type;
			$this->field=$field;
			$this->path=$path;
			$this->year=$year;
			$this->dao=$dao;
		}

		function set_regid($regid){
			$this->regid = $regid;
		}

		function set_school($school){
			$this->school = $school;
		}

		function set_field($field){
			$this->field = $field;
		}

		function set_school_type($school_type){
			$this->school_type = $school_type;
		}

		function set_path($path){
			$this->path = $path;
		}

		function set_year($year){
			$this->year = $year;
		}

		function set_dao($dao){
			$this->dao = $dao;
		}

		function set_achievements($achievements){
			$this->achievements = $achievements;
		}

		/**
			structure => [score,
						  pilihan_ke,
						  nil_matematika,
						  nil_bhs_inggris,
						  nil_bhs_indonesia,
						  tot_nilai,
						  waktu_pendaftaran
		*/
		public function set_opponents($type=1,$opponents=array()){
			if($type==1)
				$this->opponents = $this->fetch_opponents();
			else
				$this->opponents = $opponents;

			if(count($this->opponents)!=0 && !$this->opponents){
				return false;
			}
			return true;
				
		}

		/** 
			structure => [pilihan_ke,
						  nil_matematika,
						  nil_bhs_inggris,
						  nil_bhs_indonesia,
						  tot_nilai,
						  waktu_pendaftaran,
						  jarak_sekolah,
						  mode_un
		*/
		public function set_myReg($type=1,$myReg=array()){
			if($type==1)
				$this->myReg = $this->fetch_myReg();
			else
				$this->myReg = $myReg;	

			if(count($this->myReg)!=0 && !$this->myReg){
				return false;
			}
			return true;
		}


		private function fill_rankList($row){
			$this->rankList[] = array(
									'id_pendaftaran'=>$row[0],
									'pilihan_ke'=>$row[1],
									'tot_nilai'=>$row[2],
									'score'=>$row[3],
									'waktu_pendaftaran'=>$row[4],
									'peringkat'=>$row[5]
								);
		}

		function re_arrange(){
			if(count($this->opponents)>0){
				$opponents = $this->opponents;
				$i = 0;
				foreach($opponents as $row){
					$i++;
					$inputRankList = array($row['id_pendaftaran'],$row['pilihan_ke'],$row['tot_nilai'],$row['score'],$row['waktu_pendaftaran'],$i);
					$this->fill_rankList($inputRankList);
				}
			}
		}

		function set_levelAchievement($levelAchievement){
			$this->levelAchievement = $levelAchievement;
		}

		function set_rateAchievement($rateAchievement){
			$this->rateAchievement = $rateAchievement;
		}

		private function compare_levelOne($val1,$val2,$operator){
			
			switch($operator){
				case '>':$result = $val1>$val2;break;
				case '==':$result = $val1==$val2;break;
				case '<':$result = $val1<$val2;break;
			}
			return $result;
		}

		function process(){
			
			$i = 0;
			$j = 0;
			$opponents = $this->opponents;

			$step1Operator_1 = '';
			$step1Operator_2 = '';
			$compVal1_2 = '';
			$compVal2_2 = '';

			if($this->path=='1' || $this->path=='2'){

				if($this->school_type=='1')
				{
					$compVal1_2 = $this->myReg['jarak_sekolah'];
					$compVal2_2 = $this->myReg['tot_nilai'];
					$step1Operator_1 = '<';
					$step1Operator_2 = '>';
				}else{
					$compVal1_2 = $this->myReg['tot_nilai'];
					$step1Operator_1 = '>';
					$step1Operator_2 = '<';
				}


			}else if($this->path=='3'){

				if($this->school_type=='1')
					$radiusWeight = $this->get_distanceWeight($this->myReg['jarak_sekolah']);
				else
					$radiusWeight = 0;

				$compVal1_2 = $this->myReg['tot_nilai'] + (strtolower($this->myReg['mode_un'])=='unbk'? (20*$this->myReg['tot_nilai'])/100 :0) + $radiusWeight;

				$compVal2_2 = array($this->myReg['nil_matematika'],$this->myReg['nil_bhs_inggris'],$this->myReg['nil_bhs_indonesia']);

				$step1Operator_1 = '>';
				$step1Operator_2 = '<';

			}else if($this->path=='4'){
				$compVal1_2 = $this->get_achievementWeight($this->levelAchievement,$this->rateAchievement);
				$compVal2_2 = $this->myReg['tot_nilai'];

				$step1Operator_1 = '>';
				$step1Operator_2 = '<';
			}else{
				$compVal1_2 = $this->myReg['tot_nilai'];
				$step1Operator_1 = '>';
				$step1Operator_2 = '<';
			}

			if(count($opponents)>0)
			{

				foreach($opponents as $row)
				{

					$i++;

					$compVal1_1 = $row['score'];

					if($this->path=='1' || $this->path=='2'){
						$compVal2_1 = $row['tot_nilai'];

					}else if($this->path=='3'){
						$compVal2_1 = array($row['nil_matematika'],$row['nil_bhs_inggris'],$row['nil_bhs_indonesia']);

					}else if($this->path=='4'){
						$compVal2_1 = $row['tot_nilai'];	
					}
					
					$inputRankList1 = array($row['id_pendaftaran'],$row['pilihan_ke'],$row['tot_nilai'],$compVal1_1,$row['waktu_pendaftaran'],$i);
					$inputRankList2 = array($this->myReg['id_pendaftaran'],$this->myReg['pilihan_ke'],$this->myReg['tot_nilai'],$compVal1_2,$this->myReg['waktu_pendaftaran'],$i);

					if($this->compare_levelOne($compVal1_1,$compVal1_2,$step1Operator_1)){
						$this->rank++;
						$this->fill_rankList($inputRankList1);						
					}else if($compVal1_1==$compVal1_2){
						
						if($this->path=='3')
						{
							
							$win=0;
							$draw=0;
							$lose=0;
							
							for($k=0;$k<count($compVal2_1);$k++)
							{
								if($compVal2_2[$k]>$compVal2_1[$k]){
									$win++;
									break;
								}else if($compVal2_2[$k]==$compVal2_1[$k]){
									$draw++;
								}else{
									$lose++;
								}
							}

							$status = '';
							if($win>0) $status='1';
							else if($lose==count($compVal2_1)) $status='0';
							else if($draw==count($compVal2_1)) $status='2';

							if($status=='0'){
								$this->rank++;
								$this->fill_rankList($inputRankList1);
							}else if($status=='2'){
								if(strtotime($row['waktu_pendaftaran'])<strtotime($this->myReg['waktu_pendaftaran'])){
									$this->rank++;
									$this->fill_rankList($inputRankList1);
								}else{
									$this->score = $compVal1_2;
									$this->fill_rankList($inputRankList2);
									break;
								}
							}else{
								$this->score = $compVal1_2;
								$this->fill_rankList($inputRankList2);
								break;
							}


						}else if($this->path=='5'){
							if(strtotime($row['waktu_pendaftaran'])<strtotime($this->myReg['waktu_pendaftaran'])){
								$this->rank++;
								$this->fill_rankList($inputRankList1);
							}else{
								$this->score = $compVal1_2;
								$this->fill_rankList($inputRankList2);
								break;
							}
						}else{

							if($this->school_type=='1')
							{
								if($row['tot_nilai']>$this->myReg['tot_nilai']){
									$this->rank++;
									$this->fill_rankList($inputRankList1);
								}else if($row['tot_nilai']==$this->myReg['tot_nilai']){
									if(strtotime($row['waktu_pendaftaran'])<strtotime($this->myReg['waktu_pendaftaran'])){
										$this->rank++;
										$this->fill_rankList($inputRankList1);
									}else{
										$this->score = $compVal1_2;
										$this->fill_rankList($inputRankList2);
										break;
									}
								}else{
									$this->score = $compVal1_2;
									$this->fill_rankList($inputRankList2);
									break;
								}	
							}else{
								if(strtotime($row['waktu_pendaftaran'])<strtotime($this->myReg['waktu_pendaftaran'])){
									$this->rank++;
									$this->fill_rankList($inputRankList1);
								}else{
									$this->score = $compVal1_2;
									$this->fill_rankList($inputRankList2);
									break;
								}
							}
						}

					}else if($this->compare_levelOne($compVal1_1,$compVal1_2,$step1Operator_2)){
						$this->score = $compVal1_2;
						$this->fill_rankList($inputRankList2);
						break;
					}

					unset($this->opponents[$j]);

					$j++;
				}

				array_values($this->opponents);

				$i = $this->rank;
				foreach($this->opponents as $row){
					$inputRankList = array($row['id_pendaftaran'],$row['pilihan_ke'],$row['tot_nilai'],$row['score'],$row['waktu_pendaftaran'],++$i);
					$this->fill_rankList($inputRankList);
				}

				if(count($this->rankList)==count($opponents)){
					$inputRankList = array($this->myReg['id_pendaftaran'],$this->myReg['pilihan_ke'],$this->myReg['tot_nilai'],$compVal1_2,$this->myReg['waktu_pendaftaran'],$this->rank);
					$this->score = $compVal1_2;
					$this->fill_rankList($inputRankList);
				}

			}else{

				$inputRankList = array($this->myReg['id_pendaftaran'],$this->myReg['pilihan_ke'],$this->myReg['tot_nilai'],$compVal1_2,$this->myReg['waktu_pendaftaran'],1);
				$this->score = $compVal1_2;
				$this->fill_rankList($inputRankList);
			}
			
		}

		function get_rankList(){
			return $this->rankList;
		}

		function get_myRank(){
			return array($this->rank,$this->score);
		}

		private function get_distanceWeight($distance){
			$sql = "SELECT bobot FROM pengaturan_bobot_jarak WHERE thn_pelajaran='".$this->year."' 
					AND (jarak_min<='".$distance."' AND jarak_max>='".$distance."')";
			
			$distance_weight_row = $this->dao->execute(0,$sql)->row_array();
			return (!is_null($distance_weight_row['bobot'])?$distance_weight_row['bobot']:0);
		}

		private function get_achievementWeight($level,$rate){
			
			$sql = "SELECT bobot_juara1,bobot_juara2,bobot_juara3 FROM pengaturan_bobot_prestasi WHERE thn_pelajaran='".$this->year."'
					AND tkt_kejuaraan_id='".$level."'";
			$row = $this->dao->execute(0,$sql)->row_array();
			switch($rate){
				case 1:
					$weight = $row['bobot_juara1'];break;
				case 2:
					$weight = $row['bobot_juara2'];break;
				case 3:
					$weight = $row['bobot_juara3'];break;
				default:$weight = 0;
			}
			return $weight;
		}

		private function fetch_myReg(){

			if($this->school_type=='1')
			{
				$sql = "SELECT a.id_pendaftaran,b.pilihan_ke,a.nil_matematika,a.nil_bhs_inggris,a.nil_bhs_indonesia,a.tot_nilai,b.jarak_sekolah,
						c.waktu_pendaftaran,c.mode_un FROM pendaftaran_nilai_un as a 
						LEFT JOIN (SELECT id_pendaftaran,jarak_sekolah,pilihan_ke FROM pendaftaran_sekolah_pilihan WHERE sekolah_id='".$this->school."') as b 
						ON (a.id_pendaftaran=b.id_pendaftaran)
						LEFT JOIN (SELECT id_pendaftaran,waktu_pendaftaran,mode_un FROM pendaftaran) as c ON (a.id_pendaftaran=c.id_pendaftaran) 
						WHERE a.id_pendaftaran='".$this->regid."'";
			}else{
				$sql = "SELECT a.id_pendaftaran,b.pilihan_ke,a.nil_matematika,a.nil_bhs_inggris,a.nil_bhs_indonesia,a.tot_nilai,'' as jarak_sekolah,
						c.waktu_pendaftaran,c.mode_un FROM pendaftaran_nilai_un as a 
						LEFT JOIN (SELECT id_pendaftaran,pilihan_ke FROM pendaftaran_kompetensi_pilihan WHERE kompetensi_id='".$this->field."') as b 
						ON (a.id_pendaftaran=b.id_pendaftaran)
						LEFT JOIN (SELECT id_pendaftaran,waktu_pendaftaran,mode_un FROM pendaftaran) as c ON (a.id_pendaftaran=c.id_pendaftaran) 
						WHERE a.id_pendaftaran='".$this->regid."'";
			}
            
			
			$result = $this->dao->execute(0,$sql);
			if(!$result){				
				return false;
			}
			return $result->row_array();

		}

		private function fetch_opponents(){
			
			if($this->school_type=='1')
			{
				$sql = "SELECT a.id_pendaftaran,a.score,a.pilihan_ke,b.nil_matematika,b.nil_bhs_inggris,b.nil_bhs_indonesia,b.tot_nilai,c.waktu_pendaftaran
						FROM hasil_seleksi as a 
						LEFT JOIN pendaftaran_nilai_un as b ON (a.id_pendaftaran=b.id_pendaftaran) 
						LEFT JOIN (SELECT id_pendaftaran,waktu_pendaftaran FROM pendaftaran) as c ON (a.id_pendaftaran=c.id_pendaftaran)
						WHERE a.thn_pelajaran='".$this->year."' AND a.sekolah_id='".$this->school."' AND
						a.jalur_id='".$this->path."' ORDER BY peringkat";
			}else{
				$sql = "SELECT a.id_pendaftaran,a.score,a.pilihan_ke,b.nil_matematika,b.nil_bhs_inggris,
						b.nil_bhs_indonesia,b.tot_nilai,c.waktu_pendaftaran
						FROM hasil_seleksi as a 
						LEFT JOIN pendaftaran_nilai_un as b ON (a.id_pendaftaran=b.id_pendaftaran) 
						LEFT JOIN (SELECT id_pendaftaran,waktu_pendaftaran FROM pendaftaran) as c ON (a.id_pendaftaran=c.id_pendaftaran)
						WHERE a.thn_pelajaran='".$this->year."' AND a.kompetensi_id='".$this->field."' AND
						a.jalur_id='".$this->path."' ORDER BY peringkat";
			}
			
			
			$result = $this->dao->execute(0,$sql);
			if(!$result){		
				return false;
			}
			$rows = $result->result_array(); 

			return $rows;

		}		

	}
?>