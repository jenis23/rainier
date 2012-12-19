import socket
import os

HOST = 'localhost'                 # Symbolic name meaning all available interfaces
PORT = 60009              # Arbitrary non-privileged port
s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
s.bind((HOST, PORT))
s.listen(1)
#conn, addr = s.accept()
#print 'Connected by', addr
while 1:
   conn, addr = s.accept() 
   data = conn.recv(1024)
   if not data:break
   os.system("java LoadPrograms");
   conn.sendall(data+"\n")
  # os.system("java DateDemo");


   conn.close()
#os.system("java DateDemo");
