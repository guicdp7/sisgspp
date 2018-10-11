<?php
namespace App\Controller;

class LoginController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        if ($this->user){
            $this->redireciona('tarefas');
        }
        $this->viewBuilder()->enableAutoLayout(false);
        
        $this->pageTitle = "Acesse Sua Conta";
        $this->set('title', $this->pageTitle);
    }
    public function index(){
        $username = $this->request->getData('username');
        $senha = $this->request->getData('senha');

        if (!empty($username) && !empty($senha)){
            $ip = $this->userIP();

            $res = $this->connection->newQuery()
            ->select('usuarios.id, usuarios.pessoa_id, login, nome, sobrenome, email, tipo, acesso, ips.status as status_ip, usuarios.status as status_user')
            ->from('usuarios')
            ->join(
                [
                    'table' => 'emails',
                    'type' => 'LEFT',
                    'conditions' => 'emails.pessoa_id = usuarios.pessoa_id'
                ]
            )
            ->join(
                [
                    'table' => 'pessoas',
                    'type' => 'LEFT',
                    'conditions' => 'usuarios.pessoa_id = pessoas.id'                    
                ]
            )
            ->join(
                [
                    'table' => 'ips',
                    'type' => 'LEFT',
                    'conditions' => 'ips.id = '.$ip
                ]
            )
            ->where('(login = "'.$username.'" or email = "'.$username.'") and senha = "'.md5($senha).'"')
            ->execute()
            ->fetchAll('assoc');

            if (count($res) > 0){
                if ($res[0]['status_ip'] == 1){
                    if ($res[0]['status_user'] == 1){
                        $this->setLogin($res);
                        if ($this->retorno == 'json'){
                            echo json_encode($res);
                            exit;
                        }
                        else{
                            $this->redireciona('tarefas');
                        }
                    }
                    else{
                        $this->errors['login'] = "Parece que esse usuário foi bloqueado :/<br/>Entre em contato conosco para saber o motivo.";
                    }
                }
                else{
                    $this->errors['login'] = "Parece que o seu IP foi bloqueado :/<br/>Entre em contato conosco para saber o motivo.";
                }
            }
            else{
                $this->errors['login'] = "E-mail, Nome de Usuário ou Senha Inválido!";
            }
        }
        else{
            $this->errors['msg'] = "Dados Incompletos!";
        }
        if ($this->retorno == 'json'){
            echo json_encode(['error' => $this->errors]);
            exit;
        }
        else{
            $this->set('errors', $this->errors);
        }
    }
}