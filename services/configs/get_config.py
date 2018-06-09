from pathlib import Path
path = Path(__file__).resolve().parent

import os

class Get_config:

	def __init__(self,file=''):
		global path
		self._config = {}
		self.path = path
		self.file = file
	
	def set_file(self,file):
		self.file = file

	def get_config(self,key):
		if key not in self._config.keys():
			self.init_config()

		return self._config[key]
	
	def init_config(self):
		conf = open(str(self.path)+str(os.path.sep)+self.file,'r')

		lines = conf.readlines()
		
		for line in lines:
			if line[0]!=';':
				x_line = line.split('=')	
				self._config[x_line[0]]=x_line[1].strip()
			
		conf.close()


