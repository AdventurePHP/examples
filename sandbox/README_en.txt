~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
~                                     INSTALLATION                                                 ~
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

In order to run the example application contained in this package a webserver with the PHP module
greater than 4.4.x must be installed on your local machine. If you don't have expertise in
administration of a webserver, please refer to

   http://www.apachefriends.org/en/xampp-windows.html

and download XAMPP. The present package must them be extracted into the DOCUMENT_ROOT of the
webserver or a VHOST created for the archive. This is necessary to run the package with
URL_REWRITING enabled. After installing the server and extracting the package the example
application can be viewed by the browser of your choice.


Please note:
~~~~~~~~~~~~
1. In order to run the example, the framework code base must be obtained from
http://adventure-php-framework.org/Page/008-Downloads/~/sites_demosite_biz-action/setLanguage/lang/en.
Please download one of the codepack files and extract them into the apps directory shipped with this
package.

2. On LINUX or UNIX systemen the following commands should be executed after extracting the
package so that the filesystem permissions are correctly set:

   cd /path/to/extracted/package
   for DIR in $(find -type d); do chmod a+x,o-w $DIR; done
   for DIR in $(find -type f); do chmod a-x $DIR; done
   chown -R apache:apache /path/to/extracted/package

The cause is here, that the packages are created on a windows build server on which the LINUX
and/or UNIX filesystem rights are not set correctly.

3. For problems during the installation, please create a thread in the forum under
http://forum.adventure-php-framework.org/en/viewforum.php?f=3.

4. The adventure-demopack-* release file does not contain all of the modules described on the
documentation page. In order to use them in combination with the example page, please obtain a copy
of the adventure-codepack-* release file under
http://adventure-php-framework.org/Page/008-Downloads/~/sites_demosite_biz-action/setLanguage/lang/en.

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~