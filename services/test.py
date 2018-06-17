import os,sys,time,datetime
import pymysql.cursors as pcur
from pathlib import Path
import pymysql.cursors as pcur

main_path = Path(__file__).resolve().parent
path1 = str(main_path)+str(os.path.sep)+'configs'

sys.path.append(path1)

from db_connection import DB_connection as db

db = db()

def test():	

	conn = db.connect()

	cursor = conn.cursor(pcur.DictCursor)

	sql = "SELECT kuota_domisili FROM pengaturan_kuota_sma WHERE pengaturan_kuota_id=%s" %('1')
	cursor.execute(sql)
	row = cursor.fetchone()

	print(row['kuota_domisili'])

	sql = "UPDATE pengaturan_kuota_sma SET kuota_domisili=%s WHERE pengaturan_kuota_id=%s" %('4','1')
	result = cursor.execute(sql)

	conn.commit()

	sql = "SELECT kuota_domisili FROM pengaturan_kuota_sma WHERE pengaturan_kuota_id=%s" %('1')
	cursor.execute(sql)
	row = cursor.fetchone()


	print(row['kuota_domisili'])


if __name__=='__main__':
	test()

