<?php

/*
 * RahaSlim MVC mini framework Command Line Utility helper class
 *
 * @author:     Rodrick Kazembe <a-team@kode-blog.com>
 * @copyright:  2015 Rodrick Kazembe
 * @version:    1.3
  * @license:    Dont Be A Dick (DBAD)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class RahaMVCHelper {

    /**
     * @var string program version number
     */
    var $version = '1.3';

    /**
     * @var string RahaSlim MVC mini framework app directorys
     */
    var $path = './app/MyApp/';

    /**
     * @var string Namespace for RahaSlim MVC mini framework
     */
    var $namespace = 'MyApp';

    /**
     * Constructor for RahaMVC
     *
     */
    public function __construct() {
        
    }

    /**
     * Returns the directory path for RahaSlim MVC mini framework
     *
     */
    private function getPath() {
        return $this->path;
    }

    /**
     * Returns the namespace for RahaSlim MVC mini framework
     *
     */
    private function getNamespace() {
        return $this->namespace;
    }

    /**
     * Checks if file already exists or not
     *
     * @param string $path
     */
    private function fileExists($path) {
        return file_exists($path);
    }

    /**
     * Displays the version number of RahaSlim MVC mini framework
     *
     * @param string $path
     */
    public function getVersion() {
        $result = "You are using version " . $this->version . " of RahaSlim MVC mini framework\n";

        return $result;
    }

    /**
     * Displays the command line help menu for RahaSlim MVC mini framework
     *
     * @param string $path
     */
    public function gethelp() {
        $result = "The following are the available commands in RahaSlim MVC mini framework\n";
        $result .= "php raha version            Display the version number of RahaSlim MVC mini framework\n";
        $result .= "php raha help               Display the available commands in RahaSlim MVC mini framework\n";
        $result .= "php raha config             Create base files and directories for RahaSlim MVC mini framework.\n";
        $result .= "                            config command should only be run once on every project\n";
        $result .= "php raha controller name    Creates a controller in src/MyApp/controllers/name\n";
        $result .= "php raha model name         Creates a controller in src/MyApp/controllers/name\n";

        return $result;
    }

    /**
     * Creates a controller template for RahaSlim MVC mini framework
     *
     * @param string $name the name of the controller to be created.
     */
    public function createController($name) {
        $path = $this->getPath() . "controllers/$name.php";
        $namespace = $this->getNamespace();
        if ($this->fileExists($path)) {
            return "$path controller already exists";
        }

        $my_controller = fopen($path, "w") or die("Unable to create controller!");

        $controller_template = "<?php

namespace $namespace\Controllers;

class $name extends \SlimController\SlimController {

    public function indexAction() {
        global \$base_url, \$twig;
        \$params = array('base_url' => \$base_url,
            'title' => 'Page meta title',
            'description' => 'Page meta description',
            'page' => ''
        );
        echo \$twig->render('index.html', \$params);
    }

    public function detailsAction(\$id) {
        global \$base_url, \$twig;
        \$params = array('base_url' => \$base_url,
            'title' => 'Page meta title',
            'description' => 'Page meta description',
            'page' => ''
        );
        echo \$twig->render('index.html', \$params);
    }

    public function addAction() {
        global \$base_url, \$twig;
        \$params = array('base_url' => \$base_url,
            'title' => 'Page meta title',
            'description' => 'Page meta description',
            'page' => ''
        );
        echo \$twig->render('editor.html', \$params);
    }

    public function updateAction(\$id) {
        global \$base_url, \$twig;
        \$params = array('base_url' => \$base_url,
            'title' => 'Page meta title',
            'description' => 'Page meta description',
            'page' => ''
        );
        echo \$twig->render('editor.html', \$params);
    }

    public function deleteAction(\$id) {
        global \$base_url, \$twig;
        \$params = array('base_url' => \$base_url,
            'title' => 'Page meta title',
            'description' => 'Page meta description',
            'page' => ''
        );
        echo \$twig->render('index.html', \$params);
    }
}";

        fwrite($my_controller, $controller_template);

        fclose($my_controller);

        return "$path controller has successfully been created.\n";
    }

    /**
     * Creates a model template for RahaSlim MVC mini framework
     *
     * @param string $name the name of the model to be created.
     */
    public function createModel($name) {
        $path = $this->getPath() . "models/$name.php";
        $namespace = $this->getNamespace();
        if ($this->fileExists($path)) {
            return "$path model already exists";
        }

        $my_model = fopen($path, "w") or die("Unable to create model!");

        $model_template = "<?php

namespace $namespace\Models;

class $name extends BaseModel {

    protected \$primaryKey = '';
    protected  \$table = '';

    public function save(array \$options = array()) {
        parent::save();
    }
}";

        fwrite($my_model, $model_template);

        fclose($my_model);

        return "$path model has successfully been created.\n";
    }

    /**
     * Creates an autoload file in that loads slim and the database configuration
     *
     */
    private function createBootstrapAutoload() {
        $path = "bootstrap/autoload.php";
        if ($this->fileExists($path)) {
            return "$path already exists";
        }

        $my_autoload = fopen($path, "w") or die("Unable to create bootstrap.php file!");

        $template = "<?php
require_once './vendor/autoload.php';

require_once './app/MyApp/config/database.php';";

        fwrite($my_autoload, $template);

        fclose($my_autoload);

        return "$path file has successfully been created.\n";
    }

    /**
     * Creates a database config file
     *
     */
    private function createDBConfig() {
        //create app/MyApp/config
        $path = $this->getPath() . "config/database.php";
        if ($this->fileExists($path)) {
            return "$path model already exists";
        }

        $my_database = fopen($path, "w") or die("Unable to create database config file!");

        $config_template = "<?php
use Illuminate\Database\Capsule\Manager as Capsule;  

\$capsule = new Capsule; 

\$capsule->addConnection(array(
	'driver'    => 'mysql',
	'host'      => 'localhost',
	'database'  => '',
	'username'  => '',
	'password'  => '',
	'charset'   => 'utf8',
	'collation' => 'utf8_unicode_ci',
	'prefix'    => ''
));

\$capsule->setAsGlobal();

\$capsule->bootEloquent();";

        fwrite($my_database, $config_template);

        fclose($my_database);

        return "$path database config file has successfully been created.\n";
    }

    /**
     * Creates all the directories required by RahaSlim MVC mini framework
     *
     */
    private function createDirectories() {
        if ($this->fileExists("bootstrap") == 0) {
            mkdir("bootstrap");
        }

        if ($this->fileExists("app") == 0) {
            mkdir("app");
        }

        if ($this->fileExists("app/MyApp") == 0) {
            mkdir("app/MyApp");
        }

        if ($this->fileExists("app/MyApp/config") == 0) {
            mkdir("app/MyApp/config");
        }

        if ($this->fileExists("app/MyApp/controllers") == 0) {
            mkdir("app/MyApp/controllers");
        }

        if ($this->fileExists("app/MyApp/models") == 0) {
            mkdir("app/MyApp/models");
        }

        if ($this->fileExists("app/MyApp/views") == 0) {
            mkdir("app/MyApp/views");
        }
    }

    /**
     * Creates the default home controller for RahaSlim MVC mini framework
     *
     */
    private function createHomeController() {
        $path = $this->getPath() . "controllers/home.php";
        $namespace = $this->getNamespace();
        if ($this->fileExists($path)) {
            return "$path home controller already exists";
        }

        $my_home = fopen($path, "w") or die("Unable to create home controller!");

        $home_template = "<?php

namespace $namespace\Controllers;

class home extends \SlimController\SlimController {

    public function indexAction() {
        global \$base_url, \$twig;
        \$params = array('base_url' => \$base_url,
            'title' => 'Page meta title',
            'description' => 'Page meta description'
        );
        echo \$twig->render('index.html', \$params);
    }
}";

        fwrite($my_home, $home_template);

        fclose($my_home);

        return "$path model has successfully been created.\n";
    }

    /**
     * Creates the base model RahaSlim MVC mini framework. All of the models in the app will be extending this one
     *
     */
    private function createBaseModel() {
        $path = $this->getPath() . "models/BaseModel.php";
        $namespace = $this->getNamespace();
        if ($this->fileExists($path)) {
            return "$path model already exists";
        }

        $my_model = fopen($path, "w") or die("Unable to create model!");

        $model_template = "<?php

namespace MyApp\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Capsule\Manager as Capsule;

class BaseModel extends Model {

    public \$timestamps = false;
    public \$update_record = false;
    protected \$data;

    public function userInput(\$data) {
        \$this->data = \$data;
    }

    protected function cleanInput(\$input) {

        \$search = array(
            '@<script[^>]*?>.*?</script>@si', // Strip out javascript
            '@<[\/\!]*?[^<>]*?>@si', // Strip out HTML tags
            '@<style[^>]*?>.*?</style>@siU', // Strip style tags properly
            '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
        );

        \$output = preg_replace(\$search, '', \$input);
        return \$output;
    }

    protected function sanitize(\$input) {
        if (is_array(\$input)) {
            foreach (\$input as \$var => \$val) {
                \$output[\$var] = sanitize(\$val);
            }
        } else {
            if (get_magic_quotes_gpc()) {
                \$input = stripslashes(\$input);
            }
            \$input = \$this->cleanInput(\$input);
            \$output = mysql_real_escape_string(\$input);
        }
        return \$output;
    }

    public static function executeSelectQuery(\$sql_stmt) {
        \$db = Capsule::connection();
        \$result = \$db->select(\$db->raw(\$sql_stmt));
        return \$result;
    }

    public static function executeDeleteQuery(\$sql_stmt) {
        \$db = Capsule::connection();
        \$result = \$db->delete(\$db->raw(\$sql_stmt));
        return \$result;
    }

    public static function executeInsertQuery(\$sql_stmt) {
        \$db = Capsule::connection();
        \$result = \$db->insert(\$db->raw(\$sql_stmt));
        return \$result;
    }

    public static function executeUpdateQuery(\$sql_stmt) {
        \$db = Capsule::connection();
        \$result = \$db->update(\$db->raw(\$sql_stmt));
        return \$result;
    }

    public function save(array \$options = array()) {
        \$this->date_updated = date('Y-m-d H:i:s');

        \$this->updated_from_ip = \$_SERVER['REMOTE_ADDR'];

        if (\$this->update_record == false) {
            \$this->date_created = \$this->date_updated;
            \$this->created_from_ip = \$this->updated_from_ip;
        }

        parent::save();
    }

}
";

        fwrite($my_model, $model_template);

        fclose($my_model);

        return "$path model has successfully been created.\n";
    }

    /**
     * Creates the default index view for RahaSlim MVC mini framework
     *
     */
    private function createIndexView() {
        $path = $this->getPath() . "views/index.html";
        if ($this->fileExists($path)) {
            return "$path model already exists";
        }

        $my_index = fopen($path, "w") or die("Unable to create model!");

        $index_template = "<!DOCTYPE html>
<html>
    <head>
        <title>RahaSlim MVC Mini Framework</title>
        <meta charset=\"UTF-8\">
        <meta name=\"viewport\" content=\"width=device-width\">
    </head>
    <body>
        <div style=\"text-align: center;\">
            <h3>Welcome to RahaSlim MVC Mini Framework | KODE-BLOG.COM</h3>
            <p>This is a mini MVC framework based on the following components</p>
            <p><a href=\"http://www.slimframework.com/\" target=\"_blank\">Slim framework</a></p>
            <p><a href=\"https://github.com/fortrabbit/slimcontroller\" target=\"_blank\">SlimController</a></p>
            <p><a href=\"https://github.com/illuminate/database\" target=\"_blank\">Eloquent ORM</a></p>
            <p><a href=\"http://twig.sensiolabs.org/\" target=\"_blank\">Twig Template</a></p>
            <p><strong>Disclaimer:</strong> <i>The above components were not created by me. Links have been included to the respective authors of the components</i></p>
            <p>RahaSlim MVC mini framework leverages the power of the above mentioned components and provides you with a command line utility that;<strong><i><br>1. setups up the project for you with all the base files and directories automatically created for you<br>2. command line utility that auto generates controllers<br>3. command line utility that auto generates models</i></strong></p>
            <p>Happy coding! : )</p>
            <h4><a href=\"http://www.kode-blog.com/\" target=\"_blank\">Click here to view RahaSlim MVC Mini Framework Userguide on KODE-BLOG.COM</a></h4>
        </div>
    </body>
</html>";

        fwrite($my_index, $index_template);

        fclose($my_index);

        return "$path index has successfully been created.\n";
    }

    /**
     * Creates the default index.php file in the project root
     *
     */
    private function createRootIndexPage() {
        $path = "index.php";
        if ($this->fileExists($path)) {
            return "$path already exists";
        }

        $my_index = fopen($path, "w") or die("Unable to create model!");

        $index_template = "<?php
require './bootstrap/autoload.php';

\$app = New \SlimController\Slim(array(
    'controller.class_prefix' => '\\MyApp\\Controllers',
    'controller.method_suffix' => 'Action'
        ));

\$base_url = '';

\$loader = new Twig_Loader_Filesystem('./app/MyApp/views');
\$twig = new Twig_Environment(\$loader, array(
    'cache' => './app/MyApp/views/cache'));

\$app->addRoutes(array(
    '/' => 'Home:index',
));

\$app->run();";

        fwrite($my_index, $index_template);

        fclose($my_index);

        return "$path has successfully been created.\n";
    }

    /**
     * Creates a .htaccess file that forces all http requests to pass through index.php
     *
     */
    private function createhtAccessFile() {
        $path = ".htaccess";
        if ($this->fileExists($path)) {
            return "$path already exists";
        }

        $my_autoload = fopen($path, "w") or die("Unable to create .htaccess file!");

        $template = "RewriteEngine on
RewriteCond $1 !^(assets|robots\.txt)
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1 [L,QSA]";

        fwrite($my_autoload, $template);

        fclose($my_autoload);

        return "$path file has successfully been created.\n";
    }

    /**
     * Creates the development infrastucture for RahaSlim MVC mini framework
     *
     */
    public function setRahaMVCStructure() {
        $this->createDirectories();
        echo $this->createDBConfig();
        echo $this->createHomeController();
        echo $this->createBaseModel();
        echo $this->createIndexView();
        echo $this->createBootstrapAutoload();
        echo $this->createRootIndexPage();
        echo $this->createhtAccessFile();
    }

}
