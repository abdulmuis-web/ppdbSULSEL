import os,sys,time,datetime
from pathlib import Path

main_path = Path(__file__).resolve().parent

path1 = str(main_path)+str(os.path.sep)+'configs'

sys.path.append(path1)

from db_connection import DB_connection as db

db = db();

def get_sys_params():
	conn = db.connect()
	cursor = conn.cursor()
	cursor.execute("SELECT * FROM system_params")
	sys_params = []

	for row in cursor.fetchall():
		sys_params.append(row[2])

	cursor.close()
	conn.close()

	return sys_params

def get_trigger(school_type):
	conn = db.connect()
	curr_time = datetime.datetime.now().strftime('%Y-%m-%d')
	cursor = conn.cursor()
	sys_params = get_sys_params()

	sql = "SELECT tgl_buka FROM jadwal_jalur_pendaftaran WHERE thn_pelajaran='"+sys_params[0]+"' AND " \
		  "tipe_sklh_id=%s AND jalur_id=%s" %(str(school_type),'1')
	cursor.execute(sql)
	row=cursor.fetchone();
	
	cursor.close()
	conn.close()

	return (str(curr_time)==str(row[0]))
	
def get_paths():
	conn = db.connect()	
	cursor = conn.cursor()

	sql = "SELECT ref_jalur_id FROM ref_jalur_pendaftaran"
	cursor.execute(sql)
	paths = []
	for row in cursor.fetchall():
		paths.append(row[0])

	cursor.close()
	conn.close()

	return paths

def execute(school_type):
	conn = db.connect()
	cursor1 = conn.cursor()	

	sys_params = get_sys_params()
	
	sql = "SELECT SUM(jumlah_kuota) as n_kuota FROM pengaturan_kuota_jalur WHERE thn_pelajaran='"+sys_params[0]+"' AND tipe_sekolah_id=%s"%(school_type)

	cursor1.execute(sql)
	tot_quota = cursor1.fetchone()[0]	
	paths = get_paths()

	tot_pathAdd = 0
	tot_pathAddSchool = {}
	
	first_path_quota = 0
	for path in paths:

		#sum of path quota
		sql = "SELECT * FROM pengaturan_kuota_jalur WHERE thn_pelajaran='"+sys_params[0]+"' AND "\
			  "tipe_sekolah_id=%s AND jalur_id=%s" %(school_type,path)

		cursor1.execute(sql)
		row1 = cursor1.fetchone()
		path_quota1 = row1[7]		

		if path==1:
			first_path_quota = path_quota1

		if path!=1:

			#sum of path registrant
			sql = "SELECT SUM(1) n_terdaftar FROM pendaftaran_jalur_pilihan as a "\
				  "INNER JOIN (SELECT id_pendaftaran FROM pendaftaran WHERE status='2') as b ON (a.id_pendaftaran=b.id_pendaftaran) "\
				  "WHERE tipe_sekolah_id=%s AND jalur_id=%s" %(school_type,path)
			
			cursor1.execute(sql)
			row2 = cursor1.fetchone()
			path_quota2 = float(row2[0] if not row2[0] is None else 0)
			
			cursor2 = conn.cursor()

			conds = [{'key':'thn_pelajaran','val':sys_params[0]},{'key':'jalur_id','val':str(path)},{'key':'tipe_sekolah_id','val':str(school_type)}]

			seq = get_increment_value('seq','his_pengaturan_kuota_jalur',conds)
			data = {'seq':"'"+str(seq)+"'",'jalur_id':"'"+str(row1[1])+"'",'ktg_jalur_id':"'"+str(row1[2])+"'",'thn_pelajaran':"'"+row1[3]+"'",
					'tipe_sekolah_id':"'"+str(row1[4])+"'",'persen_kuota':"'"+str(row1[6])+"'",'jumlah_kuota':"'"+str(path_quota1)+"'"}
			result = insert_data('his_pengaturan_kuota_jalur',data,cursor2)
			if result==False:
				conn.rollback()

			percent_quota = path_quota2*100/tot_quota

			cursor2 = conn.cursor()
			data = {'persen_kuota':"'"+str(percent_quota)+"'",'jumlah_kuota':"'"+str(path_quota2)+"'"}
			result = update_data('pengaturan_kuota_jalur',data,conds,cursor2)
			if result==False:
				conn.rollback()

			#sum of additional quota to delegate to "Jalur Domisili"
			tot_pathAdd += (path_quota1-path_quota2)

			if school_type=='1'
				sql = "SELECT * FROM pengaturan_kuota_sma WHERE thn_pelajaran='"+sys_params[0]+"'"
				cursor1.execute(sql)
				for row in cursor1.fetchall():
					sql = "SELECT SUM(1) n_terdaftar FROM pendaftaran_sekolah_pilihan as a "\
						  "INNER JOIN (SELECT id_pendaftaran FROM pendaftaran WHERE status='2') as b ON (a.id_pendaftaran=b.id_pendaftaran) "\
						  "WHERE jalur_id=%s AND sekolah_id=%s" %(path,row[1])
					
	

	first_path_quota += tot_pathAdd
	percent_quota = first_path_quota*100/tot_quota

	print('tot_pathAdd:',tot_pathAdd)
	print('first_path_quota:',first_path_quota)
	print('percent_quota:',percent_quota)
	

	cursor2 = conn.cursor()

	conds = [{'key':'thn_pelajaran','val':sys_params[0]},{'key':'jalur_id','val':'1'},{'key':'tipe_sekolah_id','val':str(school_type)}]
	data = {'persen_kuota':"'"+str(percent_quota)+"'",'jumlah_kuota':"'"+str(first_path_quota)+"'"}
	result = update_data('pengaturan_kuota_jalur',data,conds,cursor2)
	if result==False:
		conn.rollback()

	conn.commit()


def insert_data(tbl,data,cursor):
	fields = '('
	values = '('
	s = False
	for key,val in data.items():
		comma = (',' if s else '')
		fields += comma+key
		values += comma+val
		s = True

	fields += ')'
	values += ')'

	sql_manipulating = "INSERT INTO "+tbl+" "+fields+" VALUES "+values

	# try:
	# 	cursor.execute(sql_manipulating)
	# 	result = cursor.rowcount
	# except:		
	# 	result = False
	# finally:
	# 	cursor.close()

	result = True
	# print(sql_manipulating)
	# print('\n')
	# print('hasil eksekusi : ',result)
	# print('\n')

	return result


def update_data(tbl,data,conds,cursor):

	sql_manipulating = "UPDATE "+tbl+" SET "
	s = False
	for key,val in data.items():
		comma = (',' if s else '')
		sql_manipulating += comma+key+"="+val
		s = True

	str_cond = "WHERE "
	s = False
	for cond in conds:
		str_cond += (' AND ' if s else '')+cond['key']+"='"+cond['val']+"'"
		s = True

	sql_manipulating += " " + str_cond

	# try:
	# 	cursor.execute(sql_manipulating)
	# 	result = cursor.rowcount
	# except:
	# 	result = False
	# finally:
	# 	cursor.close()	

	result = True
	# print(sql_manipulating)
	# print('\n')
	# print('hasil eksekusi : ',result)
	# print('\n')
	
	return result

def get_increment_value(key,table,conds=[]):
	conn = db.connect()
	cursor = conn.cursor()
	sql = "SELECT "+key+" FROM "+table+" "

	if(len(conds)>0):
		sql += "WHERE "
		s = False
		for cond in conds:			
			sql += (' AND ' if s else '')+cond['key']+"='"+cond['val']+"'"
			s = True

	sql += " ORDER BY "+key+" DESC"
	
	cursor.execute(sql)
	new_value = 1
	if(cursor.rowcount>0):
		row = cursor.fetchone()
		new_value += row[0]

	return new_value


def get_school_types():
	conn = db.connect()
	cursor = conn.cursor()
	cursor.execute("SELECT ref_tipe_sklh_id FROM ref_tipe_sekolah")
	rows = cursor.fetchall()
	types = []
	for row in rows:
		types.append(row[0])

	cursor.close()
	conn.close()

	return types

def main_method():
	alive = True	

	while alive:

		school_types = get_school_types()

		for type in school_types:
			trigger = get_trigger(type)
			
			if(trigger):
				execute(type)


if __name__=='__main__':
	#main_method()

	execute('1')

	
		