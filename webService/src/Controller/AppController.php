<?php
namespace App\Controller;

use Cake\Datasource\ConnectionManager;
use Cake\Controller\Controller;
use Cake\Event\Event;

class AppController extends Controller
{
    public $errors = array();
    public $pageTitle;
    public $scripts;
    public $styles;
    public $pagRef;
    public $user;
    public $connection;
    public $retorno;

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');

        $this->connection = ConnectionManager::get('default');
        
        $this->user = $this->isLogado();
        
        $this->retorno = $this->request->getData('retorno');

        $this->scripts = array();
        $this->styles = array();

        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');

        $this->set('scripts', $this->scripts);
        $this->set('styles', $this->styles);
    }
    public function addTableClass(){
        array_push($this->styles, '/js/advanced-datatable/css/demo_page.css', '/js/advanced-datatable/css/demo_table.css', '/js/data-tables/DT_bootstrap.css');
        array_push($this->scripts, '/js/advanced-datatable/js/jquery.dataTables.js', '/js/data-tables/DT_bootstrap.js','/js/dynamic_table_init.js');
        $this->set('scripts', $this->scripts);
        $this->set('styles', $this->styles);
    }
    public function addFormsClass(){
        array_push($this->styles, '/js/jquery-tags-input/jquery.tagsinput.css', '/css/bootstrap-fileupload.min.css', '/js/jquery-multi-select/css/multi-select.css');
        array_push($this->scripts, '/js/ios-switch/switchery.js', '/js/ios-switch/ios-init.js','/js/jquery-multi-select/js/jquery.multi-select.js', '/js/jquery-multi-select/js/jquery.quicksearch.js', '/js/fuelux/js/spinner.min.js', '/js/spinner-init.js', '/js/bootstrap-fileupload.min.js', '/js/jquery-tags-input/jquery.tagsinput.js', '/js/tagsinput-init.js', '/js/bootstrap-inputmask/bootstrap-inputmask.min.js');
        $this->set('scripts', $this->scripts);
        $this->set('styles', $this->styles);
    }
    public function corrigeNum($num){
        return str_replace(',', '.', $num);
    }
    public function start_session(){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    public function isLogado(){
        $this->start_session();
        if (isset($_SESSION['thisUser'])){
            return json_decode($_SESSION['thisUser'], true);
        }
        else{
            return false;
        }
    }
    public function setLogin($array){
        if ($this->retorno != 'json'){
            $this->start_session();
            $_SESSION['thisUser'] = json_encode($array);
        }
        $res = $this->connection->insert('logins', ['usuario_id' => $array[0]['id'], 'ip_acesso' => $this->userIP()]);
        return $res->lastInsertId('logins');
    }
    public function logout(){
        $this->start_session();
        unset($_SESSION['thisUser']);
    }
    public function userIP() {
        $ipaddress = null;
        if (isset($_SERVER['HTTP_CLIENT_IP'])){
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        }
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else if(isset($_SERVER['HTTP_X_FORWARDED'])){
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        }
        else if(isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])){
            $ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        }
        else if(isset($_SERVER['HTTP_FORWARDED_FOR'])){
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        }
        else if(isset($_SERVER['HTTP_FORWARDED'])){
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        }
        else if(isset($_SERVER['REMOTE_ADDR'])){
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        }
        else{
            $ipaddress = null;
        }
        if ($ipaddress){
            $res = $this->connection->newQuery()
            ->select('id')
            ->from('ips')
            ->where('ip = "'.$ipaddress.'"')
            ->execute()
            ->fetchAll('assoc');

            if (count($res)){
                $this->connection->update('ips',['ultimo_acesso'=>$this->getCurrentTimeStamp()], ['id'=>$res[0]['id']]);
                return $res[0]['id'];
            }
            else{
                $res = $this->connection->insert('ips', ['ip'=>$ipaddress]);
                return $res->lastInsertId('ips');
            }
        }
        else{
            return null;
        }
    }
    public function getLink($page){
        return "http://sisgspp.esy.es/".$page;
    }
    public function redireciona($pagina){
        if ($this->retorno != 'json'){
            header('location: '.$this->getLink($pagina));
            exit;
        }
    }
    public function upload($file, $extensao, $substitui = false){
        if (!empty($file['name'])){
            $nome = $file['name'];
            $ext = pathinfo($nome, PATHINFO_EXTENSION);
            if (in_array($ext, $extensao)){
                $destinoPath = '../data_uploads/';
                $nomeFinal = md5(microtime().rand()).$nome;
                $pathFinal = $destinoPath.$nomeFinal;
                if (move_uploaded_file($file['tmp_name'], $pathFinal)){
                    if ($substitui){
                        $this->deleteFile($substitui);
                    }
                    return $nomeFinal;
                }
                else{
                    return ['error' => 2];
                }
            }
            else{
                return ['error' => 1];
            }
        }
        else{
            return ['error' => 0];
        }
    }
    public function deleteFile($nome){
        $destinoPath = '../data_uploads/';
        if (file_exists($destinoPath.$nome)){
            return unlink($destinoPath.$nome);
        }
        else{
            return false;
        }
    }
    public function getCurrentTimeStamp(){
        $res = $this->connection->newQuery()
        ->select('CURRENT_TIMESTAMP() as time')
        ->execute()
        ->fetchAll('assoc');

        return $res[0]['time'];
    }
}
