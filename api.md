###API DOC FOR CRASH REPORT

##INTRO
    
    All the api is under url/api/{$API_NAME}

    All the response is json type

##API LIST
-------

#repairer_login

URL : url/api/repairer_login

method : POST

arugment : ['username':'','password':'']

response : ['status';'successed|failed'[, 'error':'error if exsit']]


#user_login

URL : url/api/user_login

method : POST

arugment : ['username':'','password':'']

response : ['status';'successed|failed'[, 'error':'error if exsit']]


#user_register

URL : url/api/usre_register

method : POST

arugment : ['user_login':'','user_passwd':'','user_nickname':'','user_tel':'']

response : response : ['status';'successed|failed'[, 'error':'error if exsit']]

#

