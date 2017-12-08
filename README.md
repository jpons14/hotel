# Installation
- in the index.php you have to edit $GLOBALS['formAction'] and the define FORM_ACTION, this is route from the domain: example, if you have to access to this webpage http://localhost/hotel, you'll have to put in the value of the variable /hotel
- in the index.php you have to edit $GLOBALS['systemRoot'] and the define SYSTEM_ROOT you'll have to put the path of the system, such as C:/wamp64/www/hotel and then concatenen ABSOLUTE_PATH and in the define of IMG_USERS the same
- To edit the connection of the database you'll have to edit private/settings/database.php