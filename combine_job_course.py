# -*- coding: utf8 -*-
#比對職缺與課程是否屬於同一個職業類別。透過職缺內容以及職能課程內容做比對，相似度高的即為同一職業類別。
import requests
from bs4 import BeautifulSoup
import re
import jiebatw
import jiebatw.analyse

#回傳dict: {課程代碼: 訓練概要+課程內容}
def class_content():

	need_content = {}

	url = 'https://apiservice.mol.gov.tw/OdService/download/A17000000J-000007-yrg'
	req = requests.get(url)
	req.encoding = 'utf8'
	soup = BeautifulSoup(req.text)

	bs_all_table = soup.findAll('table1')

	for bs_table in bs_all_table:
		#將bs物件轉成字串
		table = str(bs_table)
		#將table標籤拿掉
		table = re.sub("<.*>","",table)
		#根據&gt分割
		table = table.split('&gt')
		#print(table)
		
		#辦理單位，在最後的標籤要清除
		a = table[0].strip().replace('辦理單位','')
		#print(a)
		#開班單位
		b = table[1].replace(';\r\n','').strip().replace('開班單位','')
		#print(b)
		#訓練期間
		c = table[2].replace(';\r\n','').strip().replace('訓練期間','')
		#print(c)
		#訓練時段
		d = table[3].replace(';\r\n','').strip().replace('訓練時段','')
		#print(d)
		#訓練時數
		e = table[4].replace(';\r\n','').strip().replace('訓練時數','')
		#print(e)
		#訓練地點
		f = table[5].replace(';\r\n','').strip().replace('訓練地點','')
		#print(f)
		#訓練位置
		g = table[6].replace(';\r\n','').strip().replace('訓練位置','')
		#print(g)
		#報名日期
		h = table[7].replace(';\r\n','').strip().replace('報名日期','')
		#print(h)
		#甄試日期
		i = table[8].replace(';\r\n','').strip().replace('甄試日期','')
		#print(i)
		#負擔費用
		j = table[9].replace(';\r\n','').strip().replace('負擔費用','')
		#print(j)
		#聯絡人
		k = table[10].replace(';\r\n','').strip().replace('聯絡人','')
		#print(k)
		#聯絡電話
		l = table[11].replace(';\r\n','').strip().replace('聯絡電話','')
		#print(l)
		#課程名稱
		m = table[12].replace(';\r\n','').strip().replace('課程名稱','')
		#print(m)
		#期別
		n = table[13].replace(';\r\n','').strip().replace('期別','')
		#print(n)
		#課程代碼
		o = table[14].replace(';\r\n','').strip().replace('課程代碼','')
		#print(o)
		#訓練概要
		p = table[15].replace(';\r\n','').strip().replace('訓練概要','')
		#print(p)
		#課程內容
		q = table[16].replace(';\r\n','').strip().replace('課程內容','')
		#print(q)

		need_content[o]=p + q
	
	return need_content

#回傳dict: {職業類別: 所有職務內容}
def wkType_jobDetail():

	type_content = {}

	url = 'https://apiservice.mol.gov.tw/OdService/download/A17000000J-030144-pME'
	req = requests.get(url)
	req.encoding = 'utf8'
	req = req.text

	#把特殊標籤拿掉，不然會讀不到裡面的值
	req = re.sub("<!\[CDATA\[","",req)
	req = re.sub("\]\]>","",req)
	soup = BeautifulSoup(req)

	job_data_list = soup.findAll('data')

	bigJob_Type_Name ={}
	for job_data in job_data_list:

		#職務名稱
		occu_desc = job_data.select('occu_desc')[0].text
		#print(occu_desc)

		#職務性質
		wk_type = job_data.select('wk_type')[0].text
		#print(wk_type)

		#職務大類別代碼
		cjob_type = job_data.select('cjob_type')[0].text
		#print(cjob_type)

		#職務大類別名稱
		cjob_name1 = job_data.select('cjob_name1')[0].text
		#print(cjob_name1)
		#取得大類別代碼及名稱
		bigJob_Type_Name[cjob_type] = cjob_name1

		#職務小類別代碼
		cjob_no = job_data.select('cjob_no')[0].text
		#print(cjob_no)

		#職務小類別名稱
		cjob_name2 = job_data.select('cjob_name2')[0].text
		#print(cjob_name2)

		#雇用人數
		availreqnum = job_data.select('availreqnum')[0].text
		#print(availreqnum)

		#應徵截止日期
		stop_date = job_data.select('stop_date')[0].text
		#print(stop_date)

		#工作內容
		job_detail = job_data.select('job_detail')[0].text
		#print(job_detail)

		#工作地點
		cityname = job_data.select('cityname')[0].text
		#print(cityname)

		#工作經驗
		experience = job_data.select('experience')[0].text
		#print(experience)

		#工作時間
		wktime = job_data.select('wktime')[0].text
		#print(wktime)

		#核薪方式
		salarycd = job_data.select('salarycd')[0].text
		#print(salarycd)

		#最低學歷要求
		edgrdesc = job_data.select('edgrdesc')[0].text
		#print(edgrdesc)

		#職缺資料URL
		url_query = job_data.select('url_query')[0].text
		#print(url_query)

		#公司名稱
		compname = job_data.select('compname')[0].text
		#print(compname)

		#職缺更新日期
		trandate = job_data.select('trandate')[0].text
		#print(trandate)


		if(cjob_name1 in type_content.keys()):
			type_content[cjob_name1] = type_content[cjob_name1] + job_detail
		else:
			type_content[cjob_name1] = job_detail

	sort_bigJob_Type_Name =sorted(bigJob_Type_Name.items(), key=lambda d: d[0])
	print(sort_bigJob_Type_Name)
	return type_content

wkType_jobDetail()

#回傳dict:{職業類別: 所有關鍵字}
def wkType_wordlist():

	type_joblist = {}
	#職務所有內容斷詞，key為職業類別
	for job_type in wkType_jobDetail().keys():

		jobdetail = wkType_jobDetail()[job_type]

		#全部中文字
		word_cut = jiebatw.cut(jobdetail, cut_all=False)
		
		chinese_word = ''
		for word in word_cut:
			word = re.sub("[^\u4e00-\u9fa5]",",",word)
			chinese_word = chinese_word + word + ','
		chinese_word = re.sub("[,]+",",",chinese_word)

		#全部英文字
		english_content = re.sub("[^a-zA-Z]"," ",jobdetail)
		english_word = re.sub("  *",",",english_content)

		#全部的字都放到dict裡
		all_word = english_word + chinese_word

		type_joblist[job_type] = all_word

	return type_joblist

