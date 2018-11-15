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
        $id = $this->request->getQuery("id");
        
        $tarefasObj = $this->connection->newQuery()
        ->select("*")
        ->from("alteracoes");
        if (!empty($id)){
            $tarefasObj = $tarefasObj->where("id = " . $id);
        }
        $tarefasObj = $tarefasObj->execute()
        ->fetchAll("assoc");

        foreach ($tarefasObj as $key => $tar){
            $proj = $this->connection->newQuery()
            ->select("*")
            ->from("projetos")
            ->where("id = " . $tar["projeto_id"])
            ->execute()
            ->fetchAll("assoc");

            $tarefasObj[$key]["projeto"] = $proj[0];

            $tipo = $this->connection->newQuery()
            ->select("*")
            ->from("tipos_alteracao")
            ->where("id = " . $tar["tipo_alteracao_id"])
            ->execute()
            ->fetchAll("assoc");

            $tarefasObj[$key]["tipo"] = $tipo[0];
        }

        if ($this->retorno == 'json'){
            echo json_encode($tarefasObj);
            exit;
        }
        else{
            $this->set("tarefas", $tarefasObj);
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
                $res = $this->connection->insert("tipos_alteracao", $arrayTipo);
                $tipo_id = $res->lastInsertId('tipos_alteracao');
                if ($this->retorno == 'json'){
                    echo json_encode(array('tipo_id' => $tipo_id));
                    exit;
                }
                $this->redireciona('tarefas/tipos');
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
                    if ($this->retorno == 'json'){
                        echo json_encode(array('tipo_id' => $id));
                        exit;
                    }
                    $this->redireciona("tarefas/tipos");
                }
            }
            else if ($a == "excluir"){
                $this->connection->delete("tipos_alteracao", array("id"=>$id));
                if ($this->retorno == 'json'){
                    echo json_encode(array('tipo_id' => $id));
                    exit;
                }
                $this->redireciona("tarefas/tipos");
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
            $res = $this->connection->newQuery()
            ->select("*")
            ->from("alteracoes")
            ->where("status = 1")
            ->execute()
            ->fetchAll("assoc");

            $prazo = 0;

            foreach($res as $tar){
                $prazo += $tar['prazo'];
            }

            $res = $this->connection->newQuery()
            ->select("*")
            ->from("tipos_alteracao")
            ->where("id = " . $tarefa["tipo_id"])
            ->execute()
            ->fetchAll("assoc");

            $prazo += $res[0]["prazo"];

            $arrayTarefa = array(
                "pessoa_id" => $this->user[0]["pessoa_id"],
                "projeto_id" => $tarefa["projeto_id"],
                "tipo_alteracao_id" => $tarefa["tipo_id"],
                "descricao" => $tarefa["descricao"],
                "ocorrencias" => $tarefa["ocorrencias"],
                "prazo" => $prazo,
                "status" => 1,
                "ip_cadastro" => $this->userIP()
            );

            $res = $this->connection->insert("alteracoes", $arrayTarefa);
            $tarefa_id = $res->lastInsertId('alteracoes');

            if ($this->retorno == 'json'){
                echo json_encode(array('tarefa_id' => $tarefa_id));
                exit;
            }
            $this->redireciona('tarefas');
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
    public function editar(){
        $id = $this->request->getQuery("id");

        if (!empty($id)){
            $tarefaOld = $this->getThisJsonData('tarefas?id='.$id)[0];

            $tarefa = $this->request->getData("tarefa");
            if (!empty($tarefa)){
                $arrayTarefa = array(
                    "descricao" => $tarefa["descricao"],
                    "ocorrencias" => $tarefa["ocorrencias"],
                    "status" => $tarefa["status"]
                );
            }
            else{
                $this->set('tarefa', $tarefaOld);
            }
            $this->pageTitle = "Editar Tarefa ID " . $id;
            $this->set('title', $this->pageTitle);

            $this->addFormsClass();
        }
        else{
            $this->redireciona("tarefas");
        }
    }
}