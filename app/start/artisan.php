<?php

/*
|--------------------------------------------------------------------------
| Register The Artisan Commands
|--------------------------------------------------------------------------
|
| Each available Artisan command must be registered with the console so
| that it is available to be called. We'll register every command so
| the console gets access to each of the command object instances.
|
*/

// cron command (local): */5 * * * * /home/vagrant/Sites/kickapoo/artisan kickapoo:importsocial
Artisan::resolve('ImportSocialCommand');
Artisan::resolve('EmptyTrashCommand');
Artisan::resolve('CleanOldPostsCommand');
Artisan::resolve('AdminNotification');
Artisan::resolve('CleanImportsTableCommand');