import os,sys,time,datetime
import pymysql.cursors as pcur
from pathlib import Path

main_path = Path(__file__).resolve().parent

path1 = str(main_path)+str(os.path.sep)+'configs'

sys.path.append(path1)

from db_connection import DB_connection as db
import PPDB_ranking

db = db();

def get_sys_params(conn):
	cursor = conn.cursor()
	cursor.execute("SELECT * FROM system_params")
	sys_params = []

	for row in cursor.fetchall():
		sys_params.append(row[2])

	cursor.close()

	return sys_params

def compare_operands(val1,val2,operator):

	switcher = {
		'>':(val1>val2),
		'==':(val1==val2),
		'<':(val1<val2),
	}

	return switcher.get(operator)

def check_reRating(regid,type,path,conn):
	
	cursor = conn.cursor(pcur.DictCursor)
	jointable = ('pendaftaran_sekolah_pilihan' if type==1 else 'pendaftaran_kompetensi_pilihan')
	onjointable = 'ON a.id_pendaftaran=b.id_pendaftaran AND '+('(a.sekolah_id=b.sekolah_id)' if type==1 else 'ON (a.kompetensi_id=b.kompetensi_id')
	field = ('sekolah_id' if type==1 else 'kompetensi_id')
	
	sql = "SELECT a."+field+" as pilihan_id,a.score,b.status FROM hasil_seleksi as a " \
		  "LEFT JOIN "+jointable+" as b " +onjointable+" " \
		  "WHERE a.id_pendaftaran=%s" %(regid)

	cursor.execute(sql)
	rows = cursor.fetchall()

	chosenList = []
	chosenId = ''	
	chosenScore = 0

	if path==1 or path==2:
		operator = ('<' if type==1 else '>')		
	else:
		operator = '>'

	for row in rows:
		if row['pilihan_id'] not in chosenList:
			if chosenId=='' or compare_operands(row['score'],chosenScore,operator):
				chosenId = row['pilihan_id']
				chosenScore = row['score']

			chosenList.append(row['pilihan_id'])

	cursor.close()

	return {'chosenId':chosenId,'chosenList':chosenList}
	



def delete_useless_chosen(chosenId,chosenList,regId,schoolType_id,conn):
	
	cursor = conn.cursor(pcur.DictCursor)

	field = ('sekolah_id' if schoolType_id==1 else 'kompetensi_id')	

	updateTable = ('pendaftaran_sekolah_pilihan' if schoolType_id==1 else 'pendaftaran_kompetensi_pilihan')
	updateField = ('sekolah_id' if schoolType_id==1 else 'kompetensi_id')

	for item in chosenList:
		if item!=chosenId:
			sql = "DELETE FROM hasil_seleksi WHERE id_pendaftaran='"+str(regId)+"' AND "+field+"='"+str(item)+"'"
			result = execute_sqlManipulating(sql,cursor)

			sql = "UPDATE "+updateTable+" SET status='6' WHERE id_pendaftaran='"+str(regId)+"' AND "+updateField+"='"+str(item)+"'"
			result = execute_sqlManipulating(sql,cursor)

	conn.commit()
	cursor.close()

def get_quota(path,schoolType,school,field,year,conn):
	cursor = conn.cursor(pcur.DictCursor)

	if schoolType==1:	
		sql = "SELECT * FROM pengaturan_kuota_sma " \
			  "WHERE sekolah_id='"+str(school)+"' AND thn_pelajaran='"+year+"'"
	else:
		sql = "SELECT * FROM pengaturan_kuota_smk "\
			  "WHERE sekolah_id='"+str(school)+"' AND kompetensi_id='"+str(field)+"' AND thn_pelajaran='"+year+"'"
	
	cursor.execute(sql)
	row = cursor.fetchone()

	switcher = {
		1:row['kuota_domisili'],
		2:row['kuota_afirmasi'],
		3:row['kuota_akademik'],
		4:row['kuota_prestasi'],
		5:row['kuota_khusus'],		
	}

	cursor.close()

	return switcher.get(path)

def re_rating(chosenList,regId,schoolType_id,path,year,conn):

	cursor = conn.cursor(pcur.DictCursor)

	ppdb = PPDB_ranking.PPDB_ranking()
	ppdb.set_conn(conn)
	ppdb.set_school_type(schoolType_id)
	ppdb.set_path(path)
	ppdb.set_year(year)
	
	# print('== new rank list ==')

	updateTable = ('pendaftaran_sekolah_pilihan' if schoolType_id==1 else 'pendaftaran_kompetensi_pilihan')
	updateField = ('sekolah_id' if schoolType_id==1 else 'kompetensi_id')

	for item in chosenList:
		ppdb.reset_rankList()
		quota = get_quota(path,schoolType_id,item,item,year,conn)

		if schoolType_id==1:
			ppdb.set_school(item)
		else:
			ppdb.set_field(item)

		ppdb.set_opponents(1)
		ppdb.re_arrange()
		rankList=ppdb.get_rankList()

		for rank in rankList:
			status = ('3' if int(rank['peringkat'])<=quota else '4')			

			sql = "UPDATE "+updateTable+" SET status='"+status+"' WHERE id_pendaftaran='"+rank['id_pendaftaran']+"' AND "+updateField+"='"+str(item)+"'"
			result = execute_sqlManipulating(sql,cursor)

			sql = "UPDATE hasil_seleksi SET peringkat='"+str(rank['peringkat'])+"' WHERE id_pendaftaran='"+rank['id_pendaftaran']+"' AND "+updateField+"='"+str(item)+"'"			
			result = execute_sqlManipulating(sql,cursor)


		# print('==item:'+str(item)+'==')
		# print(rankList)
		# print('====')

	# print('====\n\n')

	conn.commit()

	cursor.close()	
		


def execute_sqlManipulating(sql,cursor):		
	try:
		cursor.execute(sql)
		result = cursor.rowcount
	except:
		result = False
	
	return result
			
	
def main_method():
	global db

	conn = db.connect()

	cursor1 = conn.cursor(pcur.DictCursor)
	cursor2 = conn.cursor(pcur.DictCursor)
	
	sql = "SELECT a.id_pendaftaran,b.jalur_id,b.tipe_sekolah_id FROM pendaftaran as a LEFT JOIN pendaftaran_jalur_pilihan as b " \
		  "ON (a.id_pendaftaran=b.id_pendaftaran) WHERE a.status=%s" %('1')

	cursor1.execute(sql)
	rows = cursor1.fetchall()
	sys_params = get_sys_params(conn)

	start_time = datetime.datetime.now()
	print('==== Rating Regeneration ====')

	for i,row in enumerate(rows,1):		

		reRating = check_reRating(row['id_pendaftaran'],row['tipe_sekolah_id'],row['jalur_id'],conn)
		delete_useless_chosen(reRating['chosenId'],reRating['chosenList'],row['id_pendaftaran'],row['tipe_sekolah_id'],conn)
		re_rating(reRating['chosenList'],row['id_pendaftaran'],row['tipe_sekolah_id'],row['jalur_id'],sys_params[0],conn)

		sql = "SELECT nama_sekolah FROM sekolah WHERE sekolah_id=%s" %(reRating['chosenId'])
		cursor2.execute(sql)
		row2 = cursor2.fetchone()

		print('RegId: '+row['id_pendaftaran']+' => '+row2['nama_sekolah'])


	cursor1.close()
	conn.close()

	end_time = datetime.datetime.now()
	print('Duration: {}'.format(end_time - start_time))

if __name__=='__main__':
	main_method()