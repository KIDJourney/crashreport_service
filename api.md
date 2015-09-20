#API DOC FOR CRASH REPORT

##INTRO
    
    All the api is under url/api/{$API_NAME}

    All the response is json type

##API LIST

###COMMON


####logoff

method : GET

response : ['status';'successed|failed'[, 'error':'error if exsit']]

***************************************

###USER

####user_login

method : POST

arugment : ['username':'','password':'']

response : ['status';'successed|failed'[, 'error':'error if exsit']]


####user_register

method : POST

arugment : ['user_login':'','user_passwd':'','user_nickname':'','user_tel':'']

response : response : ['status';'successed|failed'[, 'error':'error if exsit']]

####create_report()

method : POST

arugment :['report_pos':'','report_info':'','report_type':'','picture':'']

response : status


####list_my_report()

description : get all the unaccept and unfinished report of logging in user

method : GET

response = same as above


####add_comment()

description : add a comment to a finished report 

method : POST

arugment : ['report_id':'','comment_content':'']

response : status json or error message


####check_user

description : check a user

method : GET

arugment : ['id':'']

example : url/api/check_user/1

response : status json and info

***************************************************

###REPAIRER

####repairer_login

method : POST

arugment : ['username':'','password':'']

response : ['status';'successed|failed'[, 'error':'error if exsit']]


####accept_report()

description : accpet a report in the name of logging in repairer

method : GET

arugment : ['report_id':'']

example : url/api/accept_report/1

response : status json or error message

####finish_report()

description : finish a report in the name of logging in repairer

method : GET

arugment : ['report_id':'']

example : url/api/finish_report/1

response : status json or error message

####check_repairer

description : check a repairer

method : GET

arugment : ['id':'']

example : url/api/repairer/1

response : status json and info

####get_report_repairer()

description : get the tel of repairer of report

arugment : ['id':'']

example : url/api/get_report_repairer/3

response : result or error message

*************************************************

###REPORT

####list_report

description : get a list of ALL reports with page number

method : GET

example : url/api/list_report/1

arugment : ['page':'']

response = [
{"id": "1","report_pos": "0","report_info": "zxcvasdf","report_type": "0","report_picurl": "ff1dc5df7e67e223032ddc65cd8317a2.jpg","report_status": "2","report_fixerid": "1","report_reporter": "1","report_comment": "0","report_createat": "2015-08-26 14:43:25","report_acceptat": "2015-09-09 15:43:06","report_endat": "2015-09-09 15:44:33"},
{"id": "2","report_pos": "0","report_info": "zxcvasdf","report_type": "0","report_picurl": "9aa48a0aa8ad6b69ce6be929d80fd756.jpg","report_status": "2","report_fixerid": "1","report_reporter": "1","report_comment": "0","report_createat": "2015-08-26 14:44:17","report_acceptat": "2015-09-09 16:10:33","report_endat": "2015-09-09 16:11:00"}
]

####list_unaccept_report()

description : get all the unaccept report 

method : GET

response : same as report 


####list_repairer_accept()

description : get all report accepted by the logging in repairer

method : GET

response = same as above

####list_type()

description : get the map from id to type

method : GET

response = {['id':'','type':]}

####list_position

description : get the map from id to position

method : GET

response = {['id':'','position':'']}