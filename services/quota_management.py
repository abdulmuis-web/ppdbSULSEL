import os,sys,time,datetime
import pymysql.cursors as pcur
from pathlib import Path
import pymysql.cursors as pcur

main_path = Path(__file__).resolve().parent
path1 = str(main_path)+str(os.path.sep)+'configs'
sys.path.append(path1)

from db_connection import DB_connection as db

db = db();

def get_sys_params(conn):
	cursor = conn.cursor()
	cursor.execute("SELECT * FROM system_params")
	sys_params = []

	for row in cursor.fetchall():
		sys_params.append(row[2])

	cursor.close()	

	return sys_params


def new_sequence(conn,type,id,year):
	cursor = conn.cursor(pcur.DictCursor)
	table = ('his_pengaturan_kuota_jalur' if type=='1' else 'his_pengaturan_kuota_sma')
	field = ('jalur_id' if type=='1' else 'sekolah_id')

	sql = "SELECT seq FROM "+table+" WHERE thn_pelajaran='"+year+"' AND "+field+"='"+str(id)+"' ORDER BY seq DESC"
	cursor.execute(sql)
	row = cursor.fetchone()
	new_seq = 1
	if len(row)>0:
		new_seq += row['seq']

	return new_seq

def transmit_schoolQuota(conn,receive_quota,transmit_quota,old_data,path):
	cursor = conn.cursor(pcur.DictCursor)

	switcher = {
		2:'kuota_afirmasi',
		3:'kuota_akademik',
		4:'kuota_prestasi',
		5:'kuota_khusus',
	}

	sql = "UPDATE pengaturan_kuota_sma SET kuota_domisili='"+str(receive_quota)+"',"+switcher.get(path)+"='"+str(transmit_quota)+"' "\
		  "WHERE sekolah_id='"+str(old_data['sekolah_id'])+"' AND thn_pelajaran='"+old_data['thn_pelajaran']+"'"
	
	result = execute_sqlManipulating(sql,cursor)

	seq = new_sequence(conn,'2',old_data['sekolah_id'],old_data['thn_pelajaran'])
	sql = "INSERT INTO his_pengaturan_kuota_sma (seq,sekolah_id,thn_pelajaran,jml_rombel,jml_siswa_rombel,kuota_domisili, "\
		  "kuota_afirmasi,kuota_akademik,kuota_prestasi,kuota_khusus,jml_kuota) VALUES('"+str(seq)+"','"+str(old_data['sekolah_id']+"','"+old_data['thn_pelajaran']+"', "\
		  "'"+str(old_data['jml_rombel'])+"','"+str(old_data['jml_siswa_rombel'])+"','"+str(old_data['kuota_domisili'])+"','"+str(old_data['kuota_afirmasi'])+"', "\
		  "'"+str(old_data['kuota_akademik'])+"','"+str(old_data['kuota_prestasi'])+"','"+str(old_data['kuota_khusus'])+"','"+str(old_data['jml_kuota'])+"')"
	
	result = execute_sqlManipulating(sql,cursor)


def execute_sqlManipulating(sql,cursor):
	try:
		cursor.execute(sql)
		result = cursor.rowcount
	except:
		result = False
	
	return result


def calculate_quota_toTransmit(conn,item,year):
	
	cursor = conn.cursor(pcur.DictCursor)
	diff_path = item['kuota']-item['pendaftar_jalur']

	sql = "SELECT * FROM pengaturan_kuota_sma WHERE thn_pelajaran='"+year+"'"
	cursor.execute(sql)
	rows = cursor.fetchall()
	
	switcher = {
					2:'kuota_afirmasi',
					3:'kuota_akademik',
					4:'kuota_prestasi',
					5:'kuota_khusus',
				}

	for row in rows:		
		
		school_quota = row[switcher.get(item['jalur_id'])]
		sql = "SELECT COUNT(1) pendaftar_sekolah FROM pendaftaran_sekolah_pilihan WHERE sekolah_id='"+str(row['sekolah_id']+"' AND jalur_id='"+str(item['jalur_id'])+"'"
		cursor.execute(sql)
		row = cursor.fetchone()

		dif_school = school_quota-row['pendaftar_sekolah']
		
		if dif_school>0:
			receive_quota = row['kuota_domisili']+dif_school
			transmit_quota = row['pendaftar_sekolah']
			
			old_data = {'sekolah_id':row['sekolah_id'],'thn_pelajaran':row['thn_pelajaran'],'jml_rombel':row['jml_rombel'],
					    'jml_siswa_rombel':row['jml_siswa_rombel'],'kuota_domisili':row['kuota_domisili'],'kuota_afirmasi':row['kuota_afirmasi'],
					    'kuota_akademik':row['kuota_akademik'],'kuota_prestasi':row['kuota_prestasi'],'kuota_khusus':row['kuota_khusus'],
					    'jml_kuota':row['jml_kuota']}

			transmit_schoolQuota(conn,receive_quota,transmit_quota,old_data,item['jalur_id'])

	conn.commit()

	cursor.close()

def recalculate_path_quota(conn,path,transmit_quota,tot_capacity):
	cursor = conn.cursor(pcur.DictCursor)
	percent = (100/tot_capacity*transmit_quota)
	sql = "UPDATE pengaturan_kuota_jalur SET jumlah_kuota='"+str(transmit_quota)+"',persen_kuota='"+str(percent)+"' "\
	 	  "WHERE jalur_id='"+path+"' AND tipe_sekolah_id='1'"
	result = execute_sqlManipulating(sql,cursor)


def main_method():
	global db
	
	conn = db.conn()
	cursor1 = conn.cursor(pcur.DictCursor)
	cursor2 = conn.cursor(pcur.DictCursor)

	sys_params = get_sys_params()

	sql = "SELECT SUM(jml_rombel*jml_siswa_rombel) as tot FROM pengaturan_kuota_sma";
	cursor1.execute(sql)
	row = cursor1.fetchone()
	tot_capacity = row['tot']

	receiver = {}
	transmitter = []

	sql = "SELECT a.jalur_id,a.persen_kuota,a.jumlah_kuota, " \
		  "(SELECT COUNT(1) FROM pendaftaran_jalur_pilihan as x WHERE x.jalur_id=a.jalur_id AND x.tipe_sekolah_id=a.tipe_sekolah_id) as pendaftar_jalur " \
		  "FROM pengaturan_kuota_jalur as a WHERE a.tipe_sekolah_id='1'"

	cursor1.execute(sql)
	
	tot_path_receiver =	0

	for row in cursor1.fetchall():
		if row['jalur_id']=='1':
			receiver['persen'] = row['persen_kuota']
			receiver['kuota'] = row['jumlah_kuota']
		else:
			transmitter.append({'jalur_id':row['jalur_id'],'persen':row['persen_kuota'],'kuota':row['jumlah_kuota'],'pendaftar':row['pendaftar_jalur']})

			dif_path = row['jumlah_kuota']-row['pendaftar_jalur']
			tot_path_receiver += dif_path

			transmit_quota = row['pendaftar_jalur']

			recalculate_path_quota(conn,row['jalur_id'],transmit_quota,tot_capacity)

	tot_path_receiver += receiver['kuota']
	percent = (100/tot_capacity*tot_path_receiver)
	sql = "UPDATE pengaturan_kuota_jalur SET jumlah_kuota='"+str(tot_path_receiver)+"',persen_kuota='"+str(percent)+"' WHERE jalur_id='1' AND tipe_sekolah_id='1'"
	result = execute_sqlManipulating(sql,cursor2)

	conn.commit()

	for item in transmitter:
		result = calculate_quota_toTransmit(conn,item,sys_params[0])

if __name__=='__main__':	
	test_dateCompare()