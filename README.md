yii2-advanced-template-custom
=============================

Yii2-advanced-template-custom is based on [yii2-advanced-template](https://github.com/nenad-zivkovic/yii2-advanced-template).
There are several upgrades made to this template.

1. This template has additional features listed in the next section of this guide.
2. Application structure has been changed to be 'shared hosting friendly'.

Features
-------------------

- Signup with/without account activation
    - You can chose whether or not new users need to activate their account using email account activation system before they can log in. (see: common/config/params.php).
- Login using email/password or username/password combo.
    - You can chose how users will login into system. They can log in either by using their username|password combo or email|password. (see: common/config/params.php).
- Rbac tables are installed with other migrations when you run ```yii migrate``` command.
    - RbacController's init() action will insert 5 roles and 2 permissions in our rbac tables created by migration.
    - Roles can be easily assigned to users by administrators of the site (see: backend/user).
    - Nice example of how to use rbac in your code is given in this application. See: BackendController.
- Users with editor+ roles can create articles.
- Session data is stored in database out of box.
- System setting are stored in config/params.php file ( changes from v2 ).
- Theming is supported out of the box.
- Translation is supported out of the box with [yii2-i18n-module](https://github.com/zelenin/yii2-i18n-module).
- Administrators and The Creator can manage users ( changes from v2 ).
- Password strength validation and strength meter.
- All functionalities of default advanced template are included in this template.
- Added [yii2-localeurls](https://github.com/codemix/yii2-localeurls) module with lang switcher in top navbar
- Code is heavily commented out.

Installation
-------------------
>I am assuming that you know how to: install and use Composer, and install additional packages/drivers that may be needed for you to run everything on your system. In case you are new to all of this, you can check my guides for installing default yii2 application templates, provided by yii2 developers, on Windows 8 and Ubuntu based Linux operating systems, posted on www.freetuts.org.

1. Create database that you are going to use for your application (you can use phpMyAdmin or any
other tool you like).

2. Now open up your console and ```cd``` to your web root directory,
for example: ``` cd /var/www/sites/ ```

3. Clone this repo:
 
``` git clone https://github.com/uran1980/yii2-advanced-template-custom.git advanced ```

4. ```cd``` to your project root directory, for example: ``` cd /var/www/sites/advanced ```

5. Run the Composer ```update``` command:

   ``` composer update ```

6. Once template is downloaded, you need to initialize it in one of three environments:
development (dev), staging (staging) or production (prod). Change your working directory to project root
and execute ```php init``` command.

   ```cd advanced/_application```

   ```php init ```

   Type __0__ for development, execute command, type __yes__ to confirm, and execute again.

7. Now you need to tell your application to use database that you have previously created.
Open up config files: ```advanced/_application/common/config/multidb/db.php``` and ```advanced/_application/common/config/multidb/dbLogger.php```
and adjust your connection credentials.

8. Back to the console. It is time to run yii migrations that will create necessary tables in our database.
While you are inside a project root folder execute ```php yii migrate command```:

   ``` php yii migrate ```

9. Execute _rbac_ controller _init_ action that will populate our rbac tables with default roles and
permissions:

   ``` php yii rbac/init ```

10. Configure your web server:

For apache2 web server on localhost developmen configure httpd-vhosts.conf:

```
<VirtualHost *:80>
    ServerName yii2-advanced-template.local
    DocumentRoot path/to/yii2-advanced-template/web
    <Directory path/to/yii2-advanced-template/web>
        DirectoryIndex index.php
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>
</VirtualHost>
```

Then restart web server. Also in hosts file add this string:

``` 127.0.0.1 yii2-advanced-template.local www.yii2-advanced-template.local ```

You are done, you can start your application in your browser by enter this url:

For frontend:

``` http://yii2-advanced-template.local ```

For backend:

``` http://yii2-advanced-template.local/backend ```

> Note: First user that signs up will get 'root' (super admin) role. This is supposed to be you. This role have all possible super powers :) . Every other user that signs up after the first one will get 'user' role. Member is just normal authenticated user.

Testing
-------------------

If you want to run tests you should create additional database that will be used to store
your testing data. Usually testing database will have the same structure like the production one.
I am assuming that you have Codeception installed globally, and that you know how to use it.
Here is how you can set up everything easily:

1. Let's say that you have created database called ```advanced```. Go create the testing one called    ```advanced_tests```.

2. Inside your ```main-local.php``` config file change database you are going to use to ```advanced_tests```.

3. Open up your console and ```cd``` to the ``` _application ``` folder.

4. Run the migrations again: ``` php yii migrate ```

5. Run rbac/init again: ``` php yii rbac/init ```

6. Now you can tell your application to use your ```advanced``` database again instead of ```advanced_tests```.
Adjust your ```main-local.php``` config file again.

7. Now you are ready to tell Codeception to use ```advanced_tests``` database.

   Inside: ``` _application/tests/codeception/config/config.php ``` file tell your ```db``` to use
   ```advanced_tests``` database.

8. Start your php server inside the root of your application: ``` php -S localhost:8080 ```
(if the name of your application is advanced, then root is ```advanced``` folder)

9. To run tests written for frontend side of your application
   ```cd``` to ```_application/tests/codeception/frontend``` , run ```codecept build``` and then run your tests.

10. Take similar steps like in step 9 for backend and common tests.

Directory structure
-------------------

```
|-- _application
|    |-- backend
|    |    |
|    |    |-- assets/                  contains backend assets definition
|    |    |
|    |    |-- config/                  contains backend configurations
|    |    |
|    |    |-- layouts/                 contain backend layouts
|    |    |
|    |    |-- modules                  contain backend modules
|    |    |    |
|    |    |    |-- backend
|    |    |    |     |
|    |    |    .     |-- controllers/  contains Web controller classes
|    |    |    .     |
|    |    |    .     |-- models/       contains backend-specific model classes
|    |    |          |
|    |    |          |-- views/        contains view files for the Web application
|    |    |
|    |    |-- runtime/                 contains files generated during runtime
|    |
|    |-- common
|    |    |
|    |    |-- config/                  contains shared configurations
|    |    |
|    |    |-- helpers/                 contains helper classes
|    |    |
|    |    |-- layouts/                 contains shared layouts
|    |    |
|    |    |-- mail/                    contains view files for e-mails
|    |    |
|    |    |-- models/                  contains model classes used in both backend and frontend
|    |    |
|    |    |-- rbac/                    contains role based access control classes
|    |
|    |-- console
|    |    |
|    |    |-- config/                  contains console configurations
|    |    |
|    |    |-- controllers/             contains console controllers (commands)
|    |    |
|    |    |-- migrations/              contains database migrations
|    |    |
|    |    |-- models/                  contains console-specific model classes
|    |    |
|    |    |-- runtime/                 contains files generated during runtime
|    |
|    |-- environments/                 contains environment-based overrides
|    |
|    |-- frontend
|    |    |
|    .    |-- assets/                  contains frontend assets definition
|    .    |
|    .    |-- config/                  contains frontend configurations
|         |
|         |-- layouts/                 contain frontend layouts
|         |
|         |-- modules                  contain frontend modules
|         |    |
|         |    |-- profile/            client's profile module
|         |    |    |
|         |    |    |-- controllers/   contains Web controller classes
|         |    |    |
|         |    |    |-- models/        contains profile-specific model classes
|         |    |    |
|         |    |    |-- views/         contains view files for the profile
|         |    |
|         |    |-- site/               frontend site module
|         |    |    |
|         |    .    |-- controllers/   contains Web controller classes
|         |    .    |
|         |    .    |-- models/        contains site-specific model classes
|         |         |
|         |         |-- views/         contains view files for site module
|         |
|         |
|         |-- runtime/                 contains files generated during runtime
|         |
|         |-- widgets/                 contains frontend widgets
|
|-- web
|    |-- assets      contains application assets generated during runtime
.    |
.    |-- backend     contains the entry script and Web resources for backend side of application
.    |
     |-- themes      contains frontend themes

```

Version 2.1.0 changes
-------------------
1) option to CRUD articles ( posts ) has been added
2) translation support has been included and Serbian translation has been added
3) themes has been improved
4) new roles, permissions and rules are added
5) other code refactoring has been done

Version 2.0 changes
-------------------

1) settings are stored in config/params.php configuration file to reduce database load
2) account update is merged with user management and user management is more powerful now
3) User model has been separated on UserIdentity and User (for easier understanding and use)
4) 4 beautiful bootstrap responsive themes are included out of the box
5) comment style is changed according to yii2 official style
6) tests has been rewritten according to the changes that has been made
7) a lot of other polishing has been done

Password strength guide
-----------------------

Since 1.1.1 version has been released, password strength extension has been included as a core part of improved templates. Usage is very simple:

In our signup, user create/update and password reset forms password strength meter is always displayed when users are entering their password. This will give them visual representation of their password strength.
But this is not all. As The Creator you have option in your settings "Force Strong Password" that you can use. If you turn it on, users will be forced to use strong passwords according to preset you chose. For example if you use normal preset, users will be forced to use at least 8 characters long password, with at least one upper-case and one lower-case letter, plus at least one digit.

> Since version 2 settings are stored in config/params.php file!

Choosing presets:

By default normal preset is used for signup and user create/update forms. For password reset we are using 'reset' preset if you want to customize which presets is used, see SignupForm model, User model and ResetPasswordForm model. You will see rules declared for using strong passwords. Presets are located in ```vendor/nenad/yii2-password-strength/presets.php```. You can chose some other preset declared in presets.php, or create new ones.
