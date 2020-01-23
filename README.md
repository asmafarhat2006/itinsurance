# Developed the code in CodeIgniter 4 Framework

[development repository](https://github.com/codeigniter4/CodeIgniter4).
Used WAMP server (with MARIADB) and php 7.2 
To Install :

Place the code under "itinsurance" folder in www directory.
the page can be accessed by this url "http://localhost/itinsurance/products"


----run phpunit-----
go to cmd->go to root project-> run this command

phpunit vendor\bin\phpunit tests\Controllers\TestProductController.php
(It simply test if response doesnt contain any exception and data source error)
