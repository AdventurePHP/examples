~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
~                                     INSTALLATION                                                 ~
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Um die Beispiel-Applikation des Frameworks ausführen zu können muss ein Webserver mit PHP
Version 4.4.x oder höher installiert sein. Ist noch kein Webserver installiert kann das
bereits vorkonfigurierte Webserver-Paket XAMPP unter

   http://www.apachefriends.org/de/xampp-windows.html

heruntergeladen und entpackt werden. Das mitgelieferte Paket muss daraufhin innerhalb des Document-
Root des Webservers oder innerhalb des Document-Root eines lokalen Webservers entpackt werden.
Anschließend kann die Beispiel-Webseite im Browser aufgerufen werden.


Hinweise:
~~~~~~~~~
1. Zum Betrieb des Beispiels muss die Code-Basis des Frameworks bezogen werden. Das für die 
entsprechenden PHP-Versionen passende codepack-Paket ist unter 
http://adventure-php-framework.org/Seite/008-Downloads erhältlich. Die Dateien des codepack-Archivs
muss im apps-Ordner des aktuellen Beispiels entpackt werden.

2. Auf LINUX-/UNIX-Systemen sollten nach dem Entpacken folgendes ausgeführt werden, damit die Rechte
der Dateien korrekt gesetzt werden:

   cd /pfad/in/dem/das/package/entpackt/wurde
   for DIR in $(find -type d); do chmod a+x,o-w $DIR; done
   for DIR in $(find -type f); do chmod a-x $DIR; done
   chown -R apache:apache /pfad/in/dem/das/package/entpackt/wurde

Grund dafür ist, dass die Pakete auf einem Windows-Build-Server erstellt werden, der die LINUX-/
UNIX-Rechte in den Archiven nicht korrekt setzt.

3. Sollten Probleme bei der Installation auftreten, so verfassen Sie bitte einen Thread im
Forum unter http://forum.adventure-php-framework.org/de/viewforum.php?f=2.

4. Das Demo-Paket enthält nicht alle auf der Dokumentationsseite dargestellten Module. Um diese mit
der Beispielwebseite nutzen zu können muss eine adventure-codepack-*-Release-Datei von der
Downloadseite unter http://adventure-php-framework.org/Seite/008-Downloads bezogen werden.

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~