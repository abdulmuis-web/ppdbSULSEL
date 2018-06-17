import os,sys,time,datetime
import pymysql.cursors as pcur
from pathlib import Path
main_path = Path(__file__).resolve().parent
path1 = str(main_path)+str(os.path.sep)+'configs'
sys.path.append(path1)

class PPDB_ranking:

	def __init__(self):
		self.conn = ''
		self.rank=1
		self.regid=''
		self.school=''
		self.school_type=''
		self.field=''
		self.path=''
		self.year=''
		self.opponents=[]
		self.rankList=[]
		self.levelAchievement=''
		self.rateAchievement=''

	def set_dbAccess_needs(self,conn,regid,school,school_type,field,path,year):
		self.conn = conn
		self.regid=regid
		self.school=school
		self.school_type=school_type
		self.field=field
		self.path=path
		self.year=year

	def set_conn(self,conn):
		self.conn=conn

	def set_regid(self,regid):
		self.regid=regid

	def set_school(self,school):
		self.school=school

	def set_field(self,field):
		self.field=field

	def set_school_type(self,school_type):
		self.school_type=school_type

	def set_path(self,path):
		self.path=path

	def set_year(self,year):
		self.year=year

	def set_achievements(self,achievements):
		self.achievements=achievements

	def set_opponents(self,type=1,opponents=[]):
		if type==1:
			self.opponents=self.__fetch_opponents()
		else:
			self.opponents

		if len(self.opponents)!=0 and not self.opponents:
			return False;

		return True;

	def set_myReg(self,type=1,myReg=[]):
		if type==1:
			self.myReg=self.__fetch_myReg()
		else:
			self.myReg=myReg

		if len(self.myReg)!=0 and not self.myReg:
			return False

		return True

	def re_arrange(self):
		if len(self.opponents)>0:
			opponents = self.opponents
			for i,row in enumerate(opponents,1):
				inputRankList = [row['id_pendaftaran'],row['pilihan_ke'],row['tot_nilai'],row['score'],row['waktu_pendaftaran'],i];
				self.__fill_rankList(inputRankList)


	def __fill_rankList(self,row):
		self.rankList.append({'id_pendaftaran':row[0],
							  'pilihan_ke':row[1],
							  'tot_nilai':row[2],
							  'score':row[3],
							  'waktu_pendaftaran':row[4],
							  'peringkat':row[5],
							  })

	def reset_rankList(self):
		self.rankList = []

	def set_levelAchievement(self,levelAchievement):
		self.levelAchievement = levelAchievement

	def set_rateAchievement(self,rateAchievement):
		self.rateAchievement = rateAchievement

	def __compare_levelOne(self,val1,val2,operator):

		switcher = {
			'>':(val1>val2),
			'==':(val1==val2),
			'<':(val1<val2),
		}

		return switcher.get(operator)

	

	def process(self):
		i=0
		j=0

		opponents = self.opponents

		step1Operator_1 = ''
		step1Operator_2 = ''
		compVal1_2 = ''
		compVal2_2 = ''

		if self.path=='1' or self.path=='2':

			if self.school_type=='1':
				compVal1_2 = self.myReg['jarak_sekolah']
				compVal2_2 = self.myReg['tot_nilai']
				step1Operator_1 = '<'
				step1Operator_2 = '>'
			else:
				compVal1_2 = self.myReg['tot_nilai']
				step1Operator_1 = '>'
				step1Operator_2 = '<'

		elif self.path=='3':
			if self.school_type=='1':
				radiusWeight = self.__get_distancWeight(self.myReg['jarak_sekolah'])
			else:
				radiusWeight = 0

			tot_nilai = int(self.myReg['tot_nilai'])

			compVal1_2 = tot_nilai+(20 * tot_nilai / 100 if lower(self.myReg['mode_un']) else 0) + int(radiusWeight)

			compVal2_2 = [self.myReg['nil_matematika'],self.myReg['nil_bhs_inggris'],self.myReg['nil_bhs_indonesia']]

			step1Operator_1 = '>'
			step1Operator_2 = '<'

		elif self.path=='4':
			compVal1_2 = self.get_achievementWeight(self.levelAchievement,self.rateAchievement)
			compVal2_2 = self.myReg['tot_nilai']

			step1Operator_1 = '>'
			step1Operator_2 = '<'

		else:
			compVal1_2 = self.myReg['tot_nilai']
			step1Operator_1 = '>'
			step1Operator_2 = '<'
		

		if len(opponents)>0:

			for i,row in enumerate(opponents,1):

				compVal1_1 = row['score']

				if self.path=='1' or self.path=='2':
					compVal2_1 = row['tot_nilai']
				elif self.path=='3':
					compVal2_1 = [row['nil_matematika'],row['nil_bhs_inggris'],row['nil_bhs_indonesia']]
				elif self.path=='4':
					compVal2_1 = row['tot_nilai']

				inputRankList1 = [row['id_pendaftaran'],row['pilihan_ke'],row['tot_nilai'],compVal1_1,row['waktu_pendaftaran'],i];
				inputRankList2 = [self.myReg['id_pendaftaran'],self.myReg['pilihan_ke'],self.myReg['tot_nilai'],compVal1_2,self.myReg['waktu_pendaftaran'],i]

				if self.__compare_levelOne(compVal1_1,compVal1_2,step1Operator_1):
					self.rank += 1
					self.__fill_rankList(inputRankList1)
				elif compVal1_1==compVal1_2:

					if self.path=='3':
						win=0
						draw=0
						lose=0
						for k in range(len(compVal2_1)):
							if compVal2_2[k]>compVal2_1[k]:
								win+=1
								break
							elif compVal2_2[k]==compVal2_1[k]:
								draw+=1
							else:
								lose+=1

						status = ''
						if win>0:status='1'
						elif lose==len(compVal2_1):status='0'
						elif draw==len(compVal2_1):status='2'

						if status=='0':
							self.rank+=1
							self.__fill_rankList(inputRankList1)
						elif status=='2':
							if row['waktu_pendaftaran'] < self.myReg['waktu_pendaftaran']:
								self.rank+=1
								self.__fill_rankList(inputRankList1)
							else:
								self.score = compVal1_2
								self.__fill_rankList(inputRankList2)
								break
						else:
							self.score = compVal1_2
							self.__fill_rankList(inputRankList2)

					elif self.path=='5':
						if row['waktu_pendaftaran']<self.myReg['waktu_pendaftaran']:
							self.rank+=1
							self.__fill_rankList(inputRankList1)
						else:
							self.score=compVal1_2
							self.__fill_rankList(inputRankList2)
					else:
						if self.school_type=='1':
							if row['tot_nilai'] > self.myReg['tot_nilai']:
								self.rank+=1
								self.__fill_rankList(inputRankList1)
							elif row['tot_nilai']==self.myReg['tot_nilai']:
								if row['waktu_pendaftaran']<self.myReg['waktu_pendaftaran']:
									self.rank+=1
									self.__fill_rankList(inputRankList1)
								else:
									self.rank+=1
									self.__fill_rankList(inputRankList2)
									break
							else:
								self.score = compVal1_2
								self.__fill_rankList(inputRankList2)
								break
						else:
							if row['waktu_pendaftaran']<self.myReg['waktu_pendaftaran']:
								self.rank+=1
								self.__fill_rankList(inputRankList1)
							else:
								self.score = compVal1_2
								self.__fill_rankList(inputRankList2)
								break
				elif self.__compare_levelOne(compVal1_1,compVal1_2,step1Operator_2):
					self.score = compVal1_2
					self.__fill_rankList(inputRankList2)
					break

				del self.opponents[j]

				j+=1

			i = self.rank

			for row in self.opponents:
				inputRankList = [row['id_pendaftaran'],row['pilihan_ke'],row['tot_nilai'],row['score'],row['waktu_pendaftaran'],++i]
				self.__fill_rankList(inputRankList)

			if len(self.rankList)==len(opponents):
				inputRankList = [self.myReg['id_pendaftaran'],self.myReg['pilihan_ke'],self.myReg['tot_nilai'],compVal1_2,self.myReg['waktu_pendaftaran'],self.rank]
				self.score = compVal1_2
				self.__fill_rankList(inputRankList)

		else:
			inputRankList = [self.myReg['id_pendaftaran'],self.myReg['pilihan_ke'],self.myReg['tot_nilai'],compVal1_2,self.myReg['waktu_pendaftaran'],1]
			self.score = compVal1_2
			self.__fill_rankList(inputRankList)

	def get_rankList(self):
		return self.rankList

	def get_myRank(self):
		return [self.rank,self.score]

	def __get_distanceWeight(self,distance):		
				
		cursor = self.conn.cursor(pcur.DictCursor)
		sql = "SELECT bobot FROM pengaturan_bobot_jarak WHERE thn_pelajaran='"+self.year+"'" \
			  "AND (jarak_min<=%s AND jarak_max>=%s)" %(distance,distance);
		cursor.execute(sql)
		row = cursor.fetchone()

		cursor.close()

		return (row['bobot'] if not not row else 0)

	def __get_achievementWeight(self,level,rate):		
		cursor = self.conn.cursor(pcur.DictCursor)

		sql = "SELECT bobot_juara1,bobot_juara2,bobot_juara3 FROM pengaturan_bobot_prestasi WHERE thn_pelajaran='"+self.year+"'" \
			   "AND tkt_kejuaraan_id=%s" %(level);
		cursor.execute(sql)
		row = cursor.fetchone()
		switcher = {
			1:row['bobot_juara1'],
			2:row['bobot_juara2'],
			3:row['bobot_juara3'],
		}

		cursor.close()

		return switcher.get(rate,0)

	def __fetch_myReg(self):
		
		cursor = self.conn.cursor(pcur.DictCursor)

		if self.school_type=='1':
			sql = "SELECT a.id_pendaftaran,b.pilihan_ke,a.nil_matematika,a.nil_bhs_inggris,a.nil_bhs_indonesia,a.tot_nilai,b.jarak_sekolah, " \
				  "c.waktu_pendaftaran,c.mode_un FROM pendaftaran_nilai_un as a " \
				  "LEFT JOIN (SELECT id_pendaftaran,jarak_sekolah,pilihan_ke FROM pendaftaran_sekolah_pilihan WHERE sekolah_id=%s) as b " \
				  "ON (a.id_pendaftaran=b.id_pendaftaran) " \
				  "LEFT JOIN (SELECT id_pendaftaran,waktu_pendaftaran,mode_un FROM pendaftaran) as c ON (a.id_pendaftaran=c.id_pendaftaran) " \
				  "WHERE a.id_pendaftaran=%s" %(self.school,self.regid)
		else:
			sql = "SELECT a.id_pendaftaran,b.pilihan_ke,a.nil_matematika,a.nil_bhs_inggris,a.nil_bhs_indonesia,a.tot_nilai,'' as jarak_sekolah, " \
				  "c.waktu_pendaftaran,c.mode_un FROM pendaftaran_nilai_un as a " \
				  "LEFT JOIN (SELECT id_pendaftaran,pilihan_ke FROM pendaftaran_kompetensi_pilihan WHERE kompetensi_id=%s) as b " \
				  "ON (a.id_pendaftaran=b.id_pendaftaran) " \
				  "LEFT JOIN (SELECT id_pendaftaran,waktu_pendaftaran,mode_un FROM pendaftaran) as c ON (a.id_pendaftaran=c.id_pendaftaran) " \
				  "WHERE a.id_pendaftaran=%s" %(self.school,self.regid)

		

		cursor.execute(sql)
		
		row = cursor.fetchone()

		return row

	def __fetch_opponents(self):
		
		cursor = self.conn.cursor(pcur.DictCursor)

		if self.school_type==1:
			sql = "SELECT a.id_pendaftaran,a.score,a.pilihan_ke,b.nil_matematika,b.nil_bhs_inggris,b.nil_bhs_indonesia,b.tot_nilai,c.waktu_pendaftaran " \
				  "FROM hasil_seleksi as a " \
				  "LEFT JOIN pendaftaran_nilai_un as b ON (a.id_pendaftaran=b.id_pendaftaran) " \
				  "LEFT JOIN (SELECT id_pendaftaran,waktu_pendaftaran FROM pendaftaran) as c ON (a.id_pendaftaran=c.id_pendaftaran) " \
				  "WHERE a.thn_pelajaran='"+self.year+"' AND a.sekolah_id=%s AND " \
				  "a.jalur_id=%s ORDER BY peringkat" %(self.school,self.path)
		else:
			sql = "SELECT a.id_pendaftaran,a.score,a.pilihan_ke,b.nil_matematika,b.nil_bhs_inggris, " \
				  "b.nil_bhs_indonesia,b.tot_nilai,c.waktu_pendaftaran " \
				  "FROM hasil_seleksi as a " \
				  "LEFT JOIN pendaftaran_nilai_un as b ON (a.id_pendaftaran=b.id_pendaftaran) " \
				  "LEFT JOIN (SELECT id_pendaftaran,waktu_pendaftaran FROM pendaftaran) as c ON (a.id_pendaftaran=c.id_pendaftaran) " \
				  "WHERE a.thn_pelajaran='"+self.year+"' AND a.kompetensi_id=%s AND " \
				  "a.jalur_id=%s ORDER BY peringkat" %(self.school,self.path)
				

		cursor.execute(sql)
		rows = cursor.fetchall()
		return rows
