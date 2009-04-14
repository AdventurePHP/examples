~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
~                                     INSTALLATION                                                 ~
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Um die Beispiel-Applikation des Frameworks ausf�hren zu k�nnen muss ein Webserver mit PHP
Version 4.4.x oder h�her installiert sein. Ist noch kein Webserver installiert kann das
bereits vorkonfigurierte Webserver-Paket XAMPP unter

   http://www.apachefriends.org/de/xampp-windows.html

heruntergeladen und entpackt werden. Das mitgelieferte Paket muss daraufhin innerhalb des Document-
Root des Webservers oder innerhalb des Document-Root eines lokalen Webservers entpackt werden.
Anschlie�end kann die Beispiel-Webseite im Browser aufgerufen werden.


Hinweise:
~~~~~~~~~
1. Zum Betrieb des Beispiels muss die Code-Basis des Frameworks bezogen werden. Das f�r die 
entsprechenden PHP-Versionen passende codepack-Paket ist unter 
http://adventure-php-framework.org/Seite/008-Downloads erh�ltlich. Die Dateien des codepack-Archivs
muss im apps-Ordner des aktuellen Beispiels entpackt werden.

2. Auf LINUX-/UNIX-Systemen sollten nach dem Entpacken folgendes ausgef�hrt werden, damit die Rechte
der Dateien korrekt gesetzt werden:

   cd /pfad/in/dem/das/package/entpackt/wurde
   for DIR in $(find -type d); do chmod a+x,o-w $DIR; done
   for DIR in $(find -type f); do chmod a-x $DIR; done
   chown -R apache:apache /pfad/in/dem/das/package/entpackt/wurde

Grund daf�r ist, dass die Pakete auf einem Windows-Build-Server erstellt werden, der die LINUX-/
UNIX-Rechte in den Archiven nicht korrekt setzt.

3. Sollten Probleme bei der Installation auftreten, so verfassen Sie bitte einen Thread im
Forum unter http://forum.adventure-php-framework.org/de/viewforum.php?f=2.

4. Das Demo-Paket enth�lt nicht alle auf der Dokumentationsseite dargestellten Module. Um diese mit
der Beispielwebseite nutzen zu k�nnen muss eine adventure-codepack-*-Release-Datei von der
Downloadseite unter http://adventure-php-framework.org/Seite/008-Downloads bezogen werden.

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~