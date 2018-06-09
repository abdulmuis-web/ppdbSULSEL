from termcolor import colored
from pathlib import Path
import pymysql

path = Path(__file__).resolve().parent

import sys
sys.path.append(path)
from get_config import Get_config
from messages import SYS_ERR_MSG

dbconfig = Get_config('db_config.ini')

class DB_connection:

	def __init__(self,mode='production'):
		global dbconfig
		self.host = dbconfig.get_config('host')
		self.user = dbconfig.get_config('user')
		self.password = dbconfig.get_config('password')
		self.db_name = dbconfig.get_config('db_name')
		self.port = dbconfig.get_config('port')
		self.mode = mode

	def connect(self):
		h,pt,u,ps,d = self.host,self.port,self.user,self.password,self.db_name
		conn = False
		try:			
			conn = pymysql.connect(host=h,user=u,passwd=ps,db=d)
		except pymysql.InternalError as err:
			if self.mode=='production':
				return False
			else:
				sys.exit(colored(SYS_ERR_MSG['E001']+'\n'+str(err),'red'))

		return conn