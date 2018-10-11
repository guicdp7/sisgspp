<?php
namespace App\Controller;

class ClientesController extends AppController
{    
    public function initialize()
    {
        parent::initialize();

        if (!$this->user){
            $this->redireciona('login');
        }
        $this->pageTitle = "Clientes";
        $this->pagRef[0] = "clientes";
        $this->pagRef[1] = "lista de clientes";
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
    public function novo(){
        $pessoa = $this->request->getData('pessoa');
        $cliente = $this->request->getData('cliente');
        $end = $this->request->getData('end');
        if (!empty($pessoa) && !empty($cliente) && !empty($end)){

        }

        $this->pageTitle = "Novo Cliente";
        $this->pagRef[1] = "novo cliente";
        $this->set('title', $this->pageTitle);
        $this->set('ref', $this->pagRef);

        $this->addFormsClass();
    }
}