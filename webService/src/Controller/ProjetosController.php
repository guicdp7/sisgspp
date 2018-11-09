<?php
namespace App\Controller;

class ProjetosController extends AppController
{    
    public function initialize()
    {
        parent::initialize();

        if (!$this->user){
            $this->redireciona('login');
        }
        $this->pageTitle = "Projetos";
        $this->pagRef[0] = "projetos";
        $this->pagRef[1] = "lista de projetos";
        $this->set('ref', $this->pagRef);
        $this->set('thisUser', $this->user);
    }
    public function index(){
        $projetosObj = $this->connection->newQuery()
        ->select("*")
        ->from("projetos")
        ->execute()
        ->fetchAll("assoc");
        
        foreach($projetosObj as $key => $proObj){
            $pessoa = $this->connection->newQuery()
            ->select('*')
            ->from('pessoas')
            ->where('id = '.$proObj['empresa_id'])
            ->execute()
            ->fetchAll('assoc');

            $projetosObj[$key]['pessoas'] = $pessoa;
        }
        
        if ($this->retorno == 'json'){
            echo json_encode($projetosObj);
            exit;
        }
        $this->set('title', $this->pageTitle);
        $this->set('projetos', $projetosObj);

        $this->addTableClass();
    }
    public function novo(){
        $projeto = $this->request->getData('projeto');
        if (!empty($projeto)){
            $arrayProj = array(
                "empresa_id" => $projeto["empresa_id"],
                "nome" => $projeto["nome"],
                "ip_atualizado" => $this->userIP()
            );

            $res = $this->connection->insert("projetos", $arrayProj);
            $projeto_id = $res->lastInsertId('projetos');
            
            if ($this->retorno == 'json'){
                echo json_encode(array('projeto_id' => $projeto_id));
                exit;
            }
            else{
                $this->redireciona('projetos');
            }
        }
        else{
            $res = $this->connection->newQuery()
            ->select("pessoas.id, nome, sobrenome, tipo")
            ->from("usuarios")
            ->join(
                [
                    "table" => "pessoas",
                    "type" => "LEFT",
                    "conditions" => "pessoas.id = pessoa_id"
                ]
            )
            ->where("acesso = 0")
            ->execute()
            ->fetchAll("assoc");

            $this->set("empresas", $res);
        }

        $this->pageTitle = "Novo Projeto";
        $this->pagRef[1] = "novo projeto";
        $this->set('title', $this->pageTitle);
        $this->set('ref', $this->pagRef);

        $this->addFormsClass();
    }
}