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