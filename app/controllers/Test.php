<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class test extends CI_Controller{

		function __construct(){
			parent::__construct();
		}

		function index(){
			echo "there is no any activity here";
		}

		function ppdb_ranking1(){

			$this->load->library('PPDB_ranking','','rank');
			$this->load->library('dao');

			$this->load->model(array('global_model'));

			$dao = $this->global_model->get_dao();

			$this->rank->set_school('1');
			$this->rank->set_regid('18.008');
			$this->rank->set_path('1');
			$this->rank->set_year('2018/2019');
			$this->rank->set_dao($dao);

			/*structure => [score,
						  sekolah_pilihan_ke,
						  nil_matematika,
						  nil_bhs_inggris,
						  nil_bhs_indonesia,
						  tot_nilai,
						  waktu_pendaftaran*/

			$opponents[0] = array(
								  'id_pendaftaran'=>'18.002',
								  'score'=>'1500',
								  'sekolah_pilihan_ke'=>'1',
								  'nil_matematika'=>'65',
								   'nil_bhs_inggris'=>'70',
								   'nil_bhs_indonesia'=>'65',
								   'tot_nilai'=>'200',
								  'waktu_pendaftaran'=>'2018-05-29 08:30:00'
								  );
			$opponents[1] = array(
								  'id_pendaftaran'=>'18.001',
								  'score'=>'1550',
								  'sekolah_pilihan_ke'=>'1',
								  'nil_matematika'=>'70',
								  'nil_bhs_inggris'=>'50',
								  'nil_bhs_indonesia'=>'60',
								  'tot_nilai'=>'180',
								  'waktu_pendaftaran'=>'2018-05-30 08:29:00'
								  );
			$opponents[2] = array('id_pendaftaran'=>'18.004',
								  'score'=>'1600',
								  'sekolah_pilihan_ke'=>'1',
								  'nil_matematika'=>'60',
								  'nil_bhs_inggris'=>'60',
								  'nil_bhs_indonesia'=>'65',
								  'tot_nilai'=>'185',
								  'waktu_pendaftaran'=>'2018-05-30 09:30:23'
								  );
			$opponents[3] = array('id_pendaftaran'=>'18.003',
								  'score'=>'1620',
								  'sekolah_pilihan_ke'=>'1',
								  'nil_matematika'=>'70',
								  'nil_bhs_inggris'=>'55',
								  'nil_bhs_indonesia'=>'60',
								  'tot_nilai'=>'185',
								  'waktu_pendaftaran'=>'2018-05-29 09:00:23'
								  );
			$opponents[4] = array('id_pendaftaran'=>'18.005',
								  'score'=>'1650',
								  'sekolah_pilihan_ke'=>'1',
								  'nil_matematika'=>'65',
								  'nil_bhs_inggris'=>'60',
								  'nil_bhs_indonesia'=>'70',
								  'tot_nilai'=>'195',
								  'waktu_pendaftaran'=>'2018-05-29 10:00:23'
								  );
			
			$this->rank->set_opponents(2,$opponents);

			/** 
			structure => [sekolah_pilihan_ke,
						  nil_matematika,
						  nil_bhs_inggris,
						  nil_bhs_indonesia,
						  tot_nilai,
						  waktu_pendaftaran,
						  jarak_sekolah,
						  mode_un
			*/
			$myReg = array(
						   'id_pendaftaran'=>'18.008',
						   'sekolah_pilihan_ke'=>'1',
						   'nil_matematika'=>'65',
						   'nil_bhs_inggris'=>'70',
						   'nil_bhs_indonesia'=>'65',
						   'tot_nilai'=>'200',
						   'jarak_sekolah'=>'2000',
						   'waktu_pendaftaran'=>'2018-05-30 10:45:23',
						   'mode_un'=>'unbk'
						  );
			$this->rank->set_myReg(2,$myReg);

			$this->rank->process();
			
			$this->print_result($this->rank->get_rankList(),0);
		}

		private function print_result($rankList,$path){
			$pathNames = array('Domisili','Afirmasi','Akademik','Prestasi','Khusus');

			echo "== Hasil test penentuan ranking Jalur ".$pathNames[$path]." ==<br />";
			echo "<table border=1 width='100%'>
			<tr><th>Peringkat</th><th>ID Pendaftaran</th><th>Tot. Nilai</th><th>Score</th><th>Waktu Pendaftaran</th></tr>";
			foreach($rankList as $row){
				echo "<tr>
					<td align='center'>".$row['peringkat']."</td>
					<td align='center'>".$row['id_pendaftaran']."</td>
					<td align='right'>".$row['tot_nilai']."</td>
					<td align='right'>".$row['score']."</td>
					<td align='center'>".$row['waktu_pendaftaran']."</td>
				</tr>";
			}
			echo "</table>";
		}

		function ppdb_ranking2(){

			$this->load->library('PPDB_ranking','','rank');
			$this->load->library('dao');

			$this->load->model(array('global_model'));

			$dao = $this->global_model->get_dao();

			$this->rank->set_school('1');
			$this->rank->set_regid('18.008');
			$this->rank->set_path('2');
			$this->rank->set_year('2018/2019');
			$this->rank->set_dao($dao);

			/*structure => [score,
						  sekolah_pilihan_ke,
						  nil_matematika,
						  nil_bhs_inggris,
						  nil_bhs_indonesia,
						  tot_nilai,
						  waktu_pendaftaran*/

			$opponents[0] = array(
								  'id_pendaftaran'=>'18.002',
								  'score'=>'1500',
								  'sekolah_pilihan_ke'=>'1',
								  'nil_matematika'=>'65',
								   'nil_bhs_inggris'=>'70',
								   'nil_bhs_indonesia'=>'65',
								   'tot_nilai'=>'200',
								  'waktu_pendaftaran'=>'2018-05-29 08:30:00'
								  );
			$opponents[1] = array(
								  'id_pendaftaran'=>'18.001',
								  'score'=>'1550',
								  'sekolah_pilihan_ke'=>'1',
								  'nil_matematika'=>'70',
								  'nil_bhs_inggris'=>'50',
								  'nil_bhs_indonesia'=>'60',
								  'tot_nilai'=>'180',
								  'waktu_pendaftaran'=>'2018-05-30 08:29:00'
								  );
			$opponents[2] = array('id_pendaftaran'=>'18.004',
								  'score'=>'1600',
								  'sekolah_pilihan_ke'=>'1',
								  'nil_matematika'=>'60',
								  'nil_bhs_inggris'=>'60',
								  'nil_bhs_indonesia'=>'65',
								  'tot_nilai'=>'185',
								  'waktu_pendaftaran'=>'2018-05-30 09:30:23'
								  );
			$opponents[3] = array('id_pendaftaran'=>'18.003',
								  'score'=>'1620',
								  'sekolah_pilihan_ke'=>'1',
								  'nil_matematika'=>'70',
								  'nil_bhs_inggris'=>'55',
								  'nil_bhs_indonesia'=>'60',
								  'tot_nilai'=>'185',
								  'waktu_pendaftaran'=>'2018-05-29 09:00:23'
								  );
			$opponents[4] = array('id_pendaftaran'=>'18.005',
								  'score'=>'1650',
								  'sekolah_pilihan_ke'=>'1',
								  'nil_matematika'=>'65',
								  'nil_bhs_inggris'=>'60',
								  'nil_bhs_indonesia'=>'70',
								  'tot_nilai'=>'195',
								  'waktu_pendaftaran'=>'2018-05-29 10:00:23'
								  );

			$this->rank->set_opponents(2,$opponents);

			/** 
			structure => [sekolah_pilihan_ke,
						  nil_matematika,
						  nil_bhs_inggris,
						  nil_bhs_indonesia,
						  tot_nilai,
						  waktu_pendaftaran,
						  jarak_sekolah,
						  mode_un
			*/
			$myReg = array(
						   'id_pendaftaran'=>'18.008',
						   'sekolah_pilihan_ke'=>'1',
						   'nil_matematika'=>'65',
						   'nil_bhs_inggris'=>'70',
						   'nil_bhs_indonesia'=>'65',
						   'tot_nilai'=>'200',
						   'jarak_sekolah'=>'1500',
						   'waktu_pendaftaran'=>'2018-05-30 10:45:23',
						   'mode_un'=>'unbk'
						  );
			$this->rank->set_myReg(2,$myReg);

			$this->rank->process();

			$this->print_result($this->rank->get_rankList(),1);
			
		}

		function ppdb_ranking3(){

			$this->load->library('PPDB_ranking','','rank');
			$this->load->library('dao');

			$this->load->model(array('global_model'));

			$dao = $this->global_model->get_dao();

			$this->rank->set_school('1');
			$this->rank->set_regid('18.008');
			$this->rank->set_path('3');
			$this->rank->set_year('2018/2019');
			$this->rank->set_dao($dao);

			/*structure => [score,
						  sekolah_pilihan_ke,
						  nil_matematika,
						  nil_bhs_inggris,
						  nil_bhs_indonesia,
						  tot_nilai,
						  waktu_pendaftaran*/

			$opponents[0] = array('id_pendaftaran'=>'18.003',
								  'score'=>'282',
								  'sekolah_pilihan_ke'=>'1',
								  'nil_matematika'=>'70',
								  'nil_bhs_inggris'=>'55',
								  'nil_bhs_indonesia'=>'60',
								  'tot_nilai'=>'185',
								  'waktu_pendaftaran'=>'2018-05-29 09:00:23'
								  );

			$opponents[1] = array(
								  'id_pendaftaran'=>'18.002',
								  'score'=>'280',
								  'sekolah_pilihan_ke'=>'1',
								  'nil_matematika'=>'60',
								   'nil_bhs_inggris'=>'75',
								   'nil_bhs_indonesia'=>'65',
								   'tot_nilai'=>'200',
								  'waktu_pendaftaran'=>'2018-05-29 08:30:00'
								  );
			$opponents[2] = array(
								  'id_pendaftaran'=>'18.001',
								  'score'=>'276',
								  'sekolah_pilihan_ke'=>'1',
								  'nil_matematika'=>'70',
								  'nil_bhs_inggris'=>'50',
								  'nil_bhs_indonesia'=>'60',
								  'tot_nilai'=>'180',
								  'waktu_pendaftaran'=>'2018-05-30 08:29:00'
								  );

			$opponents[3] = array('id_pendaftaran'=>'18.005',
								  'score'=>'274',
								  'sekolah_pilihan_ke'=>'1',
								  'nil_matematika'=>'65',
								  'nil_bhs_inggris'=>'60',
								  'nil_bhs_indonesia'=>'70',
								  'tot_nilai'=>'195',
								  'waktu_pendaftaran'=>'2018-05-29 10:00:23'
								  );

			$opponents[4] = array('id_pendaftaran'=>'18.004',
								  'score'=>'262',
								  'sekolah_pilihan_ke'=>'1',
								  'nil_matematika'=>'60',
								  'nil_bhs_inggris'=>'60',
								  'nil_bhs_indonesia'=>'65',
								  'tot_nilai'=>'185',
								  'waktu_pendaftaran'=>'2018-05-30 09:30:23'
								  );
			
			

			$this->rank->set_opponents(2,$opponents);

			/** 
			structure => [sekolah_pilihan_ke,
						  nil_matematika,
						  nil_bhs_inggris,
						  nil_bhs_indonesia,
						  tot_nilai,
						  waktu_pendaftaran,
						  jarak_sekolah,
						  mode_un
			*/
			$myReg = array(
						   'id_pendaftaran'=>'18.008',
						   'sekolah_pilihan_ke'=>'1',
						   'nil_matematika'=>'65',
						   'nil_bhs_inggris'=>'70',
						   'nil_bhs_indonesia'=>'65',
						   'tot_nilai'=>'200',
						   'jarak_sekolah'=>'2200',
						   'waktu_pendaftaran'=>'2018-05-30 10:45:23',
						   'mode_un'=>'unbk'
						  );
			$this->rank->set_myReg(2,$myReg);

			$this->rank->process();

			$this->print_result($this->rank->get_rankList(),1);
			
		}

		function ppdb_ranking4(){

			$this->load->library('PPDB_ranking','','rank');
			$this->load->library('dao');

			$this->load->model(array('global_model'));

			$dao = $this->global_model->get_dao();

			$this->rank->set_school('1');
			$this->rank->set_regid('18.008');
			$this->rank->set_path('4');
			$this->rank->set_year('2018/2019');
			$this->rank->set_dao($dao);

			/*structure => [score,
						  sekolah_pilihan_ke,
						  nil_matematika,
						  nil_bhs_inggris,
						  nil_bhs_indonesia,
						  tot_nilai,
						  waktu_pendaftaran*/

			$opponents[0] = array(
								  'id_pendaftaran'=>'18.002',
								  'score'=>'70',
								  'sekolah_pilihan_ke'=>'1',
								  'nil_matematika'=>'65',
								   'nil_bhs_inggris'=>'70',
								   'nil_bhs_indonesia'=>'65',
								   'tot_nilai'=>'200',
								  'waktu_pendaftaran'=>'2018-05-29 08:30:00'
								  );
			$opponents[1] = array(
								  'id_pendaftaran'=>'18.001',
								  'score'=>'70',
								  'sekolah_pilihan_ke'=>'1',
								  'nil_matematika'=>'70',
								  'nil_bhs_inggris'=>'50',
								  'nil_bhs_indonesia'=>'60',
								  'tot_nilai'=>'180',
								  'waktu_pendaftaran'=>'2018-05-30 08:29:00'
								  );
			$opponents[2] = array('id_pendaftaran'=>'18.004',
								  'score'=>'60',
								  'sekolah_pilihan_ke'=>'1',
								  'nil_matematika'=>'60',
								  'nil_bhs_inggris'=>'60',
								  'nil_bhs_indonesia'=>'65',
								  'tot_nilai'=>'185',
								  'waktu_pendaftaran'=>'2018-05-30 09:30:23'
								  );
			$opponents[3] = array('id_pendaftaran'=>'18.003',
								  'score'=>'50',
								  'sekolah_pilihan_ke'=>'1',
								  'nil_matematika'=>'70',
								  'nil_bhs_inggris'=>'55',
								  'nil_bhs_indonesia'=>'60',
								  'tot_nilai'=>'185',
								  'waktu_pendaftaran'=>'2018-05-29 09:00:23'
								  );
			$opponents[4] = array('id_pendaftaran'=>'18.005',
								  'score'=>'40',
								  'sekolah_pilihan_ke'=>'1',
								  'nil_matematika'=>'65',
								  'nil_bhs_inggris'=>'60',
								  'nil_bhs_indonesia'=>'70',
								  'tot_nilai'=>'195',
								  'waktu_pendaftaran'=>'2018-05-29 10:00:23'
								  );

			$this->rank->set_opponents(2,$opponents);

			/** 
			structure => [sekolah_pilihan_ke,
						  nil_matematika,
						  nil_bhs_inggris,
						  nil_bhs_indonesia,
						  tot_nilai,
						  waktu_pendaftaran,
						  jarak_sekolah,
						  mode_un
			*/
			$myReg = array(
						   'id_pendaftaran'=>'18.008',
						   'sekolah_pilihan_ke'=>'1',
						   'nil_matematika'=>'65',
						   'nil_bhs_inggris'=>'70',
						   'nil_bhs_indonesia'=>'65',
						   'tot_nilai'=>'180',
						   'jarak_sekolah'=>'1500',
						   'waktu_pendaftaran'=>'2018-05-30 10:45:23',
						   'mode_un'=>'unbk'
						  );
			$this->rank->set_myReg(2,$myReg);
			$this->rank->set_levelAchievement(2);
			$this->rank->set_rateAchievement(1);

			$this->rank->process();

			$this->print_result($this->rank->get_rankList(),1);
			
		}


		function ppdb_ranking5(){

			$this->load->library('PPDB_ranking','','rank');
			$this->load->library('dao');

			$this->load->model(array('global_model'));

			$dao = $this->global_model->get_dao();

			$this->rank->set_school('1');
			$this->rank->set_regid('18.008');
			$this->rank->set_path('5');
			$this->rank->set_year('2018/2019');
			$this->rank->set_dao($dao);

			/*structure => [score,
						  sekolah_pilihan_ke,
						  nil_matematika,
						  nil_bhs_inggris,
						  nil_bhs_indonesia,
						  tot_nilai,
						  waktu_pendaftaran*/

			$opponents[0] = array(
								  'id_pendaftaran'=>'18.002',
								  'score'=>'200',
								  'sekolah_pilihan_ke'=>'1',
								  'nil_matematika'=>'65',
								   'nil_bhs_inggris'=>'70',
								   'nil_bhs_indonesia'=>'65',
								   'tot_nilai'=>'200',
								  'waktu_pendaftaran'=>'2018-05-29 08:30:00'
								  );
			
			$opponents[1] = array('id_pendaftaran'=>'18.005',
								  'score'=>'195',
								  'sekolah_pilihan_ke'=>'1',
								  'nil_matematika'=>'65',
								  'nil_bhs_inggris'=>'60',
								  'nil_bhs_indonesia'=>'70',
								  'tot_nilai'=>'195',
								  'waktu_pendaftaran'=>'2018-05-29 10:00:23'
								  );

			$opponents[2] = array('id_pendaftaran'=>'18.003',
								  'score'=>'185',
								  'sekolah_pilihan_ke'=>'1',
								  'nil_matematika'=>'70',
								  'nil_bhs_inggris'=>'55',
								  'nil_bhs_indonesia'=>'60',
								  'tot_nilai'=>'185',
								  'waktu_pendaftaran'=>'2018-05-29 09:00:23'
								  );

			$opponents[3] = array('id_pendaftaran'=>'18.004',
								  'score'=>'185',
								  'sekolah_pilihan_ke'=>'1',
								  'nil_matematika'=>'60',
								  'nil_bhs_inggris'=>'60',
								  'nil_bhs_indonesia'=>'65',
								  'tot_nilai'=>'185',
								  'waktu_pendaftaran'=>'2018-05-30 09:30:23'
								  );

			$opponents[4] = array(
								  'id_pendaftaran'=>'18.001',
								  'score'=>'180',
								  'sekolah_pilihan_ke'=>'1',
								  'nil_matematika'=>'70',
								  'nil_bhs_inggris'=>'50',
								  'nil_bhs_indonesia'=>'60',
								  'tot_nilai'=>'180',
								  'waktu_pendaftaran'=>'2018-05-30 08:29:00'
								  );
			
			
			

			$this->rank->set_opponents(2,$opponents);

			/** 
			structure => [sekolah_pilihan_ke,
						  nil_matematika,
						  nil_bhs_inggris,
						  nil_bhs_indonesia,
						  tot_nilai,
						  waktu_pendaftaran,
						  jarak_sekolah,
						  mode_un
			*/
			$myReg = array(
						   'id_pendaftaran'=>'18.008',
						   'sekolah_pilihan_ke'=>'1',
						   'nil_matematika'=>'65',
						   'nil_bhs_inggris'=>'70',
						   'nil_bhs_indonesia'=>'65',
						   'tot_nilai'=>'200',
						   'jarak_sekolah'=>'1500',
						   'waktu_pendaftaran'=>'2018-05-30 10:45:23',
						   'mode_un'=>'unbk'
						  );
			$this->rank->set_myReg(2,$myReg);

			$this->rank->process();

			$this->print_result($this->rank->get_rankList(),4);
			
		}

		function check_status_dateRange(){

			$this->load->helper('date_helper');

			$date1 = '2018-06-08';
			$date2 = '2018-06-10';

			$status = check_status_dateRange($date1,$date2);
			echo $status;
		}

	}
?>