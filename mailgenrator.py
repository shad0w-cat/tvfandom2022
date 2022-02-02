import itertools
from random import randrange
from matplotlib.style import use
import mysql.connector
import re
import pandas as pd
import random
import string
import smtplib

dfs = pd.read_csv('TVFANDOM.csv')


# def passwordGenerator():
#     length = randrange(8, 13)
#     # define data
#     lower = string.ascii_lowercase
#     upper = string.ascii_uppercase
#     num = string.digits
#     #symbols = string.punctuation
#     # string.ascii_letters
#     # combine the data
#     all = lower + upper + num
#     # use random
#     temp = random.sample(all, length)
#     # create the password
#     password = "".join(temp)
#     # print the password
#     return password


def sendMails(emails: dict):
    SenderAddress = ""
    password = "password of sender"
    server = smtplib.SMTP("smtp.gmail.com", 587)
    server.starttls()
    server.login(SenderAddress, password)
    for email in emails:
        msg = ""
        subject = "Hello world"
        body = "Subject: {}\n\nUsername: {}\n\nPassword: {} ".format(
            subject, emails[email][0], emails[email][1])
        server.sendmail(SenderAddress, email, body)
    server.quit()


# print(dfs)
# emails = {}
# usernameList = []
# passwordList = []
# totalrows = dfs.count(0)[0]
# print(dfs['Email Address'][0][0:1])
# for row, rowdata in dfs.iterrows():
#     username = ""
#     name = rowdata[1].split()
#     for i in name:
#         username += i
#     username = re.sub('[\W_]+', '', username[:12].lower())
#     username += str(randrange(1000, 10000))
#     passwd = passwordGenerator()
#     usernameList.append(username)
#     passwordList.append(passwd)
#     #print(username, passwd)

# dfs['Username'] = usernameList
# dfs['Password'] = passwordList

# dfs.to_csv("final.csv")

#print(dfs)
# print(len(emails))


mydb = mysql.connector.connect(
    host="159.223.156.104",
    user="tvfandomadmin",
    password="tvFandompass123@",
    database="tvfandom"
)

print(mydb)

mycursor = mydb.cursor()
i = 0
for row, rowdata in dfs.iterrows():
    sql = "INSERT INTO `users` (`username`, `mailid`, `fullName`, `passwd`) VALUES (%s, %s, %s, %s);"
    val = (rowdata['Username'], rowdata['Email Address'], rowdata['Name:'], rowdata['Password'])
    mycursor.execute(sql, val)
    i+=1
    mydb.commit()

    print(mycursor.rowcount, "record inserted.")
    print(i)
