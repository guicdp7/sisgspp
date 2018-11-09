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
        $clientesObj = $this->connection->newQuery()
        ->select('*')
        ->from('usuarios')
        ->where('acesso = 0')
        ->execute()
        ->fetchAll('assoc');

        foreach($clientesObj as $key => $cliObj){
            $pessoa = $this->connection->newQuery()
            ->select('*')
            ->from('pessoas')
            ->where('id = '.$cliObj['pessoa_id'])
            ->execute()
            ->fetchAll('assoc');

            $clientesObj[$key]['pessoas'] = $pessoa;
            
            $email = $this->connection->newQuery()
            ->select('*')
            ->from('emails')
            ->where('pessoa_id = '.$cliObj['pessoa_id'])
            ->execute()
            ->fetchAll('assoc');

            $clientesObj[$key]['emails'] = $email;
            
            $telefone = $this->connection->newQuery()
            ->select('*')
            ->from('telefones')
            ->where('pessoa_id = '.$cliObj['pessoa_id'])
            ->execute()
            ->fetchAll('assoc');

            $telefone = $this->addTelFormatado($telefone);

            $clientesObj[$key]['telefones'] = $telefone;
            
            $empresa = $this->connection->newQuery()
            ->select('*')
            ->from('empresas')
            ->where('pessoa_id = '.$cliObj['pessoa_id'])
            ->execute()
            ->fetchAll('assoc');

            $clientesObj[$key]['empresas'] = $empresa;
            
            $endereco = $this->connection->newQuery()
            ->select('*')
            ->from('enderecos')
            ->where('pessoa_id = '.$cliObj['pessoa_id'])
            ->execute()
            ->fetchAll('assoc');

            $clientesObj[$key]['enderecos'] = $endereco;
        }

        if ($this->retorno == 'json'){
            echo json_encode($clientesObj);
            exit;
        }

        $this->set('title', $this->pageTitle);
        $this->set('clientes', $clientesObj);
        
        $this->addTableClass();
    }
    public function novo(){
        $pessoa = $this->request->getData('pessoa');
        $cliente = $this->request->getData('cliente');
        $end = $this->request->getData('end');
        if (!empty($pessoa) && !empty($cliente) && !empty($end)){
            $arrayPessoa = array(
                'nome' => $pessoa['nome'],
                'sobrenome' => $pessoa['sobrenome'],
                'tipo' => $pessoa['tipo'],
                'ip_cadastro' => $this->userIP()
            );
            
            $res = $this->connection->insert('pessoas', $arrayPessoa);
            $pessoa_id = $res->lastInsertId('pessoas');

            if (!empty($pessoa['cnpj'])){
                $arrayEmpresa = array(
                    'pessoa_id' => $pessoa_id,
                    'cnpj' => $pessoa['cnpj']            
                );
                if (!empty($pessoa['ie'])){
                    $arrayEmpresa['ie'] = $pessoa['ie'];
                }
                $res = $this->connection->insert('empresas', $arrayEmpresa);
            }
            
            $arrayEmail = array(
                'email' => $cliente['email'],
                'pessoa_id' => $pessoa_id,
                'ip_atualizado' => $this->userIP()
            );
            $this->connection->insert('emails', $arrayEmail);
            
            if (!empty($cliente['telefone'])){
                $tele = $this->configTel($cliente['telefone']);
                $arrayTel = array(
                    'ddd' => $tele[0],
                    'numero' => $tele[1],
                    'pessoa_id' => $pessoa_id,
                    'ip_atualizado' => $this->userIP()
                );
                $this->connection->insert('telefones', $arrayTel);
            }
            if (!empty($end['cidade']) && !empty($end['uf'])){
                $arrayEnd = array(
                    'pessoa_id' => $pessoa_id,
                    'cep' => $end['cep'],
                    'logradouro' => $end['logradouro'],
                    'numero' => $end['numero'],
                    'complemento' => $end['complemento'],
                    'bairro' => $end['bairro'],
                    'cidade' => $end['cidade'],
                    'uf' => $end['uf'],
                    'ip_atualizado' => $this->userIP()
                );
                $this->connection->insert('enderecos', $arrayEnd);
            }
            $arrayUser = array(
                'pessoa_id' => $pessoa_id,
                'login' => $cliente['login'],
                'acesso'=>'0',
                'status'=>'1',
                'senha' => md5($cliente['senha']),
                'ip_atualizado' => $this->userIP()
            );
            $this->connection->insert('usuarios', $arrayUser);
            
            if ($this->retorno == 'json'){
                echo json_encode(array('cliente_id' => $pessoa_id));
                exit;
            }
            else{
                $this->redireciona('clientes');
            }
        }

        $this->pageTitle = "Novo Cliente";
        $this->pagRef[1] = "novo cliente";
        $this->set('title', $this->pageTitle);
        $this->set('ref', $this->pagRef);

        $this->addFormsClass();
    }
    public function editar(){
        $id = $this->request->getQuery('id');

        if (!empty($id)){
            $pessoa = $this->request->getData('pessoa');
            $cliente = $this->request->getData('cliente');
            $end = $this->request->getData('end');
            if (!empty($pessoa) && !empty($cliente) && !empty($end)){
                $pessoa_id = $this->getPessoaId("usuarios", $id);

                $arrayPessoa = array(
                    'nome' => $pessoa['nome'],
                    'sobrenome' => $pessoa['sobrenome'],
                    'tipo' => $pessoa['tipo'],
                    'ip_cadastro' => $this->userIP()
                );
                $res = $this->connection->update('pessoas', $arrayPessoa, array("id" => $pessoa_id));

                if (!empty($pessoa['cnpj'])){
                    $res = $this->connection->newQuery()
                    ->select("*")
                    ->from("empresas")
                    ->where("pessoa_id = ".$pessoa_id)
                    ->execute()
                    ->fetchAll("assoc");

                    $arrayEmpresa = array(
                        'cnpj' => $pessoa['cnpj']            
                    );
                    if (!empty($pessoa['ie'])){
                        $arrayEmpresa['ie'] = $pessoa['ie'];
                    }

                    if (count($res)){
                        $res = $this->connection->update('empresas', $arrayEmpresa, array("pessoa_id" => $pessoa_id));
                    }
                    else{
                        $arrayEmpresa["pessoa_id"] = $pessoa_id;
                        $res = $this->connection->insert('empresas', $arrayEmpresa);
                    }
                }

                $arrayEmail = array(
                    'email' => $cliente['email'],
                    'ip_atualizado' => $this->userIP()
                );
                $this->connection->update('emails', $arrayEmail, array("pessoa_id" => $pessoa_id));

                if (!empty($cliente['telefone'])){
                    $res = $this->connection->newQuery()
                    ->select("*")
                    ->from("empresas")
                    ->where("pessoa_id = ".$pessoa_id)
                    ->execute()
                    ->fetchAll("assoc");

                    $tele = $this->configTel($cliente['telefone']);
                    $arrayTel = array(
                        'ddd' => $tele[0],
                        'numero' => $tele[1],
                        'ip_atualizado' => $this->userIP()
                    );

                    if (count($res)){
                        $this->connection->update('telefones', $arrayTel, array("pessoa_id" => $pessoa_id));
                    }
                    else{
                        $arrayTel["pessoa_id"] = $pessoa_id;
                        $this->connection->insert('telefones', $arrayTel);
                    }

                    if (!empty($end['cidade']) && !empty($end['uf'])){
                        $res = $this->connection->newQuery()
                        ->select("*")
                        ->from("enderecos")
                        ->where("pessoa_id = ".$pessoa_id)
                        ->execute()
                        ->fetchAll("assoc");

                        $arrayEnd = array(
                            'cep' => $end['cep'],
                            'logradouro' => $end['logradouro'],
                            'numero' => $end['numero'],
                            'complemento' => $end['complemento'],
                            'bairro' => $end['bairro'],
                            'cidade' => $end['cidade'],
                            'uf' => $end['uf'],
                            'ip_atualizado' => $this->userIP()
                        );
                        if (count($res)){
                            $this->connection->update('enderecos', $arrayEnd, array("pessoa_id" => $pessoa_id));
                        }
                        else{
                            $arrayEnd["pessoa_id"] = $pessoa_id;
                            $this->connection->insert('enderecos', $arrayEnd);
                        }
                    }
                    /*$arrayUser = array(
                        'login' => $cliente['login'],
                        'senha' => md5($cliente['senha']),
                        'ip_atualizado' => $this->userIP()
                    );
                    $this->connection->update('usuarios', $arrayUser, array('pessoa_id' => $pessoa_id));*/
            
                    if ($this->retorno == 'json'){
                        echo json_encode(array('cliente_id' => $id));
                        exit;
                    }
                    else{
                        $this->redireciona('clientes');
                    }
                }
            }
            else{
                $this->set('cliente', $this->getThisJsonData('clientes?id='.$id)[0]);
            }
            $this->pageTitle = "Editar Cliente ID " . $id;
            $this->set('title', $this->pageTitle);

            $this->addFormsClass();
        }
        else{
            $this->redireciona('clientes');
        }
    }
    public function desativar(){
        $id = $this->request->getQuery("id");

        if (!empty($id)){
            $this->connection->update("usuarios", array("status"=>0), array("id"=>$id));
        }
        $this->redireciona('clientes');
    }
    public function ativar(){
        $id = $this->request->getQuery("id");

        if (!empty($id)){
            $this->connection->update("usuarios", array("status"=>1), array("id"=>$id));
        }
        $this->redireciona('clientes');
    }
    public function excluir(){
        $id = $this->request->getQuery("id");

        if (!empty($id)){
            $pessoa_id = $this->getPessoaId("usuarios", $id);

            $res = $this->connection->newQuery()
            ->select("id")
            ->from("projetos")
            ->where("empresa_id = ".$pessoa_id)
            ->execute()
            ->fetchAll("assoc");

            if (!count($res)){
                $res = $this->connection->newQuery()
                ->select("pessoa_id")
                ->from("usuarios_empresa")
                ->where("empresa_id = ".$pessoa_id)
                ->execute()
                ->fetchAll("assoc");

                foreach ($res as $re){
                    $this->connection->delete("pessoas", array("id"=>$re['pessoa_id']));
                }
                
                $this->connection->delete("pessoas", array("id"=>$pessoa_id));
            }
            else{
                $this->errors['msg'] = "O Cliente Possui Projetos!";
                $this->setSessaoErro();
            }
            if ($this->retorno == 'json'){
                echo json_encode(['error' => $this->errors]);
                exit;
            }
        }
        $this->redireciona('clientes');
    }
}