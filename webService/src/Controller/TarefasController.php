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

        if (empty($a) || $a == "visualizacao"){
            $a = "visualizacao";

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
        }
        else if ($a == "novo"){
            if (!empty($tipo)){
                
            }
        }
        else if (!empty($id)){
            $tipo = $this->request->getData("tipo");
            
            if ($a == "editar"){
                if (!empty($tipo)){

                }
            }
            else if ($a == "excluir"){

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

        }

        $this->pageTitle = "Nova Tarefa";
        $this->pagRef[1] = "nova tarefa";
        $this->set('title', $this->pageTitle);
        $this->set('ref', $this->pagRef);

        $this->addFormsClass();
    }
}