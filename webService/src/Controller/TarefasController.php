<?php
namespace App\Controller;

class TarefasController extends AppController
{    
    public function initialize()
    {
        parent::initialize();

        if (!$this->user){
            $this->redireciona('login');
        }
        $this->pageTitle = "Tarefas";
        $this->pagRef[0] = "tarefas";
        $this->pagRef[1] = "lista de tarefas";
        $this->set('ref', $this->pagRef);
        $this->set('thisUser', $this->user);
    }
    public function index(){
        
        if ($this->retorno == 'json'){
            exit;
        }
        else{
            $this->set('title', $this->pageTitle);
            
            $this->addTableClass();
        }
    }
    public function tipos(){
        $a = $this->request->getQuery("a");
        $id = $this->request->getQuery("id");
        $tipo = $this->request->getData("tipo");

        $res = $this->connection->newQuery()
        ->select("*")
        ->from("tipos_alteracao");
        if (!empty($id)){
            $res = $res->where("id = " . $id);
        }
        $res = $res->execute()
        ->fetchAll("assoc");

        $this->set("tipos", $res);

        $this->addTableClass();

        if (empty($a) || $a == "visualizacao"){
            $a = "visualizacao";
        }
        else if ($a == "novo"){
            if (!empty($tipo)){
                $arrayTipo = array(
                    "nome" => $tipo['nome'],
                    "prazo" => $tipo['prazo']
                );
                $this->connection->insert("tipos_alteracao", $arrayTipo);
                $this->redirect("tarefas/tipos");
            }
        }
        else if (!empty($id)){
            $tipo = $this->request->getData("tipo");
            
            if ($a == "editar"){
                if (!empty($tipo)){
                    $arrayTipo = array(
                        "nome" => $tipo['nome'],
                        "prazo" => $tipo['prazo']
                    );
                    $this->connection->update("tipos_alteracao", $arrayTipo, array("id"=>$id));
                    $this->redirect("tarefas/tipos");
                }
            }
            else if ($a == "excluir"){
                $this->connection->delete("tipos_alteracao", array("id"=>$id));
                $this->redirect("tarefas/tipos");
            }
        }
        else{
            $this->redireciona("tarefas/tipos");
        }

        $this->pageTitle = "Tipos de Tarefas";
        $this->pagRef[1] = "tipos de tarefas";
        $this->set('title', $this->pageTitle);
        $this->set('ref', $this->pagRef);
        $this->set("a", $a);
    }
    public function nova(){
        $tarefa = $this->request->getData('tarefa');
        if (!empty($tarefa)){
            

            $arrayTarefa = array(
                "pessoa_id" => $this->user[0]["pessoa_id"],
                "projeto_id" => $tarefa["projeto_id"],
                "tipo_alteracao_id" => $tarefa["tipo_id"],
                "descricao" => $tarefa["descricao"],
                "ocorrencias" => $tarefa["ocorrencias"],
                "status" => 1,
                "ip_cadastro" => $this->userIP()
            );
        }
        else{
            $projs = $this->connection->newQuery()
            ->select("*")
            ->from("projetos")
            ->order("nome")
            ->execute()
            ->fetchAll("assoc");
            
            $tipos = $this->connection->newQuery()
            ->select("*")
            ->from("tipos_alteracao")
            ->order("nome")
            ->execute()
            ->fetchAll("assoc");

            $this->set("projetos", $projs);
            $this->set("tipos", $tipos);
        }

        $this->pageTitle = "Nova Tarefa";
        $this->pagRef[1] = "nova tarefa";
        $this->set('title', $this->pageTitle);
        $this->set('ref', $this->pagRef);

        $this->addFormsClass();
    }
}