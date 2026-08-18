<?php
declare(strict_types=1);

namespace App\Controller;

use Authorization\Exception\ForbiddenException;
use Cake\Event\EventInterface;

/**
 * Estagiarios Controller
 *
 * @property \App\Model\Table\EstagiariosTable $Estagiarios
 * @method \App\Model\Entity\Estagiario[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EstagiariosController extends AppController
{
    /**
     * beforeFilter method
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        
    }

    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $periodo_atual = $this->fetchTable("Configuracoes")->find()->first()['mural_periodo_atual'];
        $periodo = $this->getRequest()->getParam('pass') ? $this->request->getParam('pass')[0] : $periodo_atual;
        $this->set('periodo', $periodo);

        $contained = ['Alunos', 'Professores', 'Supervisores', 'Instituicoes', 'Turnos', 'Turmas'];

        $conditions = ['conditions' => ['Estagiarios.periodo' => $periodo] ];

        try {
            $this->Authorization->authorize($this->Estagiarios);
            if ($periodo == 'all') {
                $estagiarios = $this->Estagiarios->find('all')->contain($contained);
            } else {
                $estagiarios = $this->Estagiarios->find('all', $conditions)->contain($contained);
            }
        } catch (ForbiddenException $error) {
            if ($periodo == 'all') {
                $estagiarios = $this->Authorization->applyScope($this->Estagiarios->find('all')->contain($contained));
            } else {
                $estagiarios = $this->Authorization->applyScope($this->Estagiarios->find('all', $conditions)->contain($contained));
            }
        }
        
        $this->set('estagiarios', $this->paginate($estagiarios));

        
        $periodototal = $this->Estagiarios->find('list', [ 'keyField' => 'periodo', 'valueField' => 'periodo']);
        $periodos = $periodototal->toArray();
        $periodos = array_merge($periodos, array($periodo_atual => $periodo_atual));
        $periodos = array_merge($periodos, array('all' => 'Todos'));
        $periodos = array_reverse($periodos);
        
        $this->set('periodos', $periodos);
    }

    /**
     * View method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $estagiario = $this->Estagiarios->get($id, [
            'contain' => ['Alunos', 'Instituicoes', 'Supervisores', 'Professores', 'Inscricoes', 'Turmas', 'Turnos', 'Complementos'],
        ]);

        try {
            $this->Authorization->authorize($estagiario);
        } catch (ForbiddenException $error) {
            $this->Flash->error('Authorization error: ' . $error->getMessage());
            return $this->redirect('/');
        }
        
        //$folhadeatividades = $this->Estagiarios->Folhadeatividades->find()
        //    ->where(['estagiario_id' => $id])
        //    ->all();
        
        $this->set(compact('estagiario'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $estagiario = $this->Estagiarios->newEmptyEntity();

        try {
            $this->Authorization->authorize($estagiario);
        } catch (ForbiddenException $error) {
            $this->Flash->error('Authorization error: ' . $error->getMessage());
            return $this->redirect('/');
        }

        $configuracao = $this->fetchTable('Configuracoes')->find()->select(['mural_periodo_atual'])->first();
        $periodo = $configuracao->mural_periodo_atual;
        
        if ($this->request->is('post')) {
            $estagiario = $this->Estagiarios->patchEntity($estagiario, $this->request->getData());
            if ($this->Estagiarios->save($estagiario)) {
                $this->Flash->success(__('The estagiario has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The estagiario could not be saved. Please, try again.'));
        }
        
        $alunos = $this->Estagiarios->Alunos->find('list');
        $instituicoes = $this->Estagiarios->Instituicoes->find('list');
        $supervisores = $this->Estagiarios->Supervisores->find('list');
        $professores = $this->Estagiarios->Professores->find('list');
        $turmas = $this->Estagiarios->Turmas->find('list');
        $turnos = $this->Estagiarios->Turnos->find('list');
        
        $this->set(compact('periodo', 'estagiario', 'alunos', 'instituicoes', 'supervisores', 'professores', 'turmas', 'turnos'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $estagiario = $this->Estagiarios->get($id);
        
        try {
            $this->Authorization->authorize($estagiario);
        } catch (ForbiddenException $error) {
            $this->Flash->error('Authorization error: ' . $error->getMessage());
            return $this->redirect('/');
        }
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $estagiario = $this->Estagiarios->patchEntity($estagiario, $this->request->getData());
            if ($this->Estagiarios->save($estagiario)) {
                $this->Flash->success(__('The estagiario has been saved.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('The estagiario could not be saved. Please, try again.'));
        }
        
        $alunos = $this->Estagiarios->Alunos->find('list');
        $instituicoes = $this->Estagiarios->Instituicoes->find('list');
        $supervisores = $this->Estagiarios->Supervisores->find('list');
        $professores = $this->Estagiarios->Professores->find('list');
        $turmas = $this->Estagiarios->Turmas->find('list');
        $turnos = $this->Estagiarios->Turnos->find('list');
        
        $this->set(compact('estagiario', 'alunos', 'instituicoes', 'supervisores', 'professores', 'turmas', 'turnos'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        
        $estagiario = $this->Estagiarios->get($id);

        try {
            $this->Authorization->authorize($estagiario);
            if ($this->Estagiarios->delete($estagiario)) {
                $this->Flash->success(__('The estagiario has been deleted.'));
            } else {
                $this->Flash->error(__('The estagiario could not be deleted. Please, try again.'));
            }
        } catch (ForbiddenException $error) {
            $this->Flash->error(__( 'Authorization error: ' . $error->getMessage() ));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    /**
     * pdf test
     *
     *
    public function pdf($id = null)
    {
        $this->viewBuilder()->enableAutoLayout(false); 
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        //$this->viewBuilder()->setOption('pdfConfig',[
            //'orientation' => 'portrait',
            //'download' => false,
            //'filename' => 'Filename_' . $id . '.pdf'
        //]);
        
        $estagiario = $this->Estagiarios->get($id);
        $this->set('estagiario', $estagiario);
    }
    */
    
    /**
     * Termodecompromisso method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     *
     */
    public function termodecompromisso($id = null)
    {        
        try {
            $this->Authorization->authorize($this->Estagiarios->newEmptyEntity());
        } catch (ForbiddenException $error) {
            $this->Flash->error('Authorization error: ' . $error->getMessage());
            return $this->redirect('/');
        }
        
        $user_data = ['administrador_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0];
        $user_session = $this->request->getAttribute('identity');
        if ($user_session) { $user_data = $user_session->getOriginalData(); }

        $aluno_id = $this->request->getQuery('aluno_id');

        if (!$aluno_id && $user_data['aluno_id']) {
            $aluno_id = $user_data['aluno_id'];
        }

        $estagiario = $this->Estagiarios->find()->where(['aluno_id' => $aluno_id])->contain(['Alunos'])->first();
        if ($estagiario) { 
            $this->set('estagiario', $estagiario);
            $aluno = $estagiario->aluno;
        }
        
        if (empty($aluno)) {
            $inscricao = $this->fetchTable('Inscricoes')->find()->where(['aluno_id' => $aluno_id])->contain(['Alunos'])->first();
            $aluno = $inscricao->aluno;
        } 
        
        if (empty($aluno)) {
            $aluno = $this->fetchTable("Alunos")->find()->where(['id' => $aluno_id])->first();
        }
        
        if (empty($aluno)) {
            $this->Flash->error(__('Usuário(a) não está registrado como aluno(a)'));
            return $this->redirect(['controller' => 'Users', 'action' => 'view', $user_data->id]);
        } else {
            $this->set('aluno', $aluno);
        }

        $configuracao = $this->fetchTable('Configuracoes')->find()->select(['mural_periodo_atual'])->first();
        $periodo_atual = $configuracao->mural_periodo_atual;
        $this->set('periodo', $periodo_atual);

        if ($estagiario) {
            $compare = $this->comparePeriodo((string)$periodo_atual, (string)$estagiario->periodo);
           
            if ($compare === -1) {
                // Período atual anterior ao último estágio: configurações desatualizadas / dados inconsistentes
                $this->Flash->error(__('Período atual ({0}) não pode ser anterior ao último período de estágio ({1}).', (string)$periodo_atual, (string)$estagiario->periodo));
                return $this->redirect(['action' => 'edit', $estagiario->id]);
            } 
            
            if ($compare === 0) {
                $this->Flash->error( __('Período atual não pode ser o mesmo período ({0}) editar o período do estágiario.', (string)$periodo_atual));
                return $this->redirect(['action' => 'edit', $estagiario->id]);
            }
    
            // Período atual (configurações) posterior ao último estágio: criar novo estágio
            // if ($compare === 1) {
            //     return $this->redirect(['action' => 'add']);
            // }
        }
        
        $instituicoes = $this->Estagiarios->Instituicoes->find('list');
        $this->set('instituicoes', $instituicoes);
    }


    /**
     * Converte um período no formato YYYY-1/2 para uma chave numérica comparável.
     *
     * @param string $periodo Ex.: "2025-1" ou "2025-2"
     * @return int Chave comparável (ano * 10 + semestre). Retorna 0 se inválido.
     */
    private function periodoKey(string $periodo): int
    {
        $periodo = trim($periodo);
        if ($periodo === '') {
            return 0;
        }

        $parts = explode('-', $periodo, 2);
        if (count($parts) !== 2) {
            return 0;
        }

        $year = (int)trim($parts[0]);
        $half = (int)trim($parts[1]);

        if ($year <= 0 || ($half !== 1 && $half !== 2)) {
            return 0;
        }

        return ($year * 10) + $half;
    }
    
    /**
     * Compara dois períodos no formato YYYY-1/2.
     *
     * @param string $a Primeiro período
     * @param string $b Segundo período
     * @return int Retorna 1 se $a > $b, 0 se $a == $b, -1 se $a < $b
     */
    private function comparePeriodo(string $a, string $b): int
    {
        $ka = $this->periodoKey($a);
        $kb = $this->periodoKey($b);

        if ($ka === 0 || $kb === 0) {
            return strcmp(trim($a), trim($b)) <=> 0;
        }

        return $ka <=> $kb;
    }
    
    /**
     * Nivelestagio method
     *
     * Compara o periodoautal com o periodo de estagio do estagiario para definiar o nivel de estagio
     *
     */
    private function nivelestagio($periodo_atual, $ultimoestagio)
    {
        /* Se o periodo atual é o mesmo do periodo cadastrado no estagiário deixa o nivel como está */
        if ($periodo_atual == $ultimoestagio->periodo) {
            $nivel = $ultimoestagio->nivel;
            /** Se o periodo atual é maior que o cadastrado então passa para o próximo nivel e insere um novo registro */
        } elseif ($periodo_atual > $ultimoestagio->periodo) {
            $nivel = $ultimoestagio->nivel + 1;
            /** Calculo o ultimo nível de estágio possível a partir do ajuste curricular. */
            /** Se nivel é maior que o ultimo nivel curricular então está realizando estagio extracurricular e o nivel é 9. */
            if ($nivel > 4) {
                // Estágio não curricular
                $nivel = 9;
            }
        } else {
            $this->Flash->error(__("Período de estágio atual não pode ser menor que o último período cursado."));
            return $this->redirect(['action' => 'termodecompromisso', $ultimoestagio->id]);
        }
        return $nivel;
    }


    /**
     * Termodecompromissopdf method
     *
     * Compara o periodoautal com o periodo de estagio do estagiario para definiar o nivel de estagio
     *
     * @param string|null $id Estagiario id.
     */   
    public function termodecompromissopdf($id = null)
    {

        $this->layout = false;
        if (is_null($id)) {
            $this->cakeError('error404');
        } else {
            $estagiario = $this->Estagiarios->find()
                ->contain(['Alunos', 'Supervisores', 'Instituicoes'])
                ->where(['Estagiarios.id IS' => $id]);
        }
        // pr($estagiario->first());
        // die();
        $configuracaotabela = $this->fetchTable('Configuracoes');
        $configuracao = $configuracaotabela->get(1);
        // pr($configuracao);
        // die();

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption(
            'pdfConfig',
            [
                'orientation' => 'portrait',
                //'download' => true, // This can be omitted if "filename" is specified.
                //'filename' => 'termo_de_compromisso_' . $id . '.pdf' //// This can be omitted if you want file name based on URL.
            ]
        );
        $this->set('configuracao', $configuracao);
        $this->set('estagiario', $estagiario->first());
    }

    /**
     * Declaracaodeestagiopdf method
     *
     * @param string|null $id Estagiario id.
     */   
    public function declaracaodeestagiopdf($id = null)
    {

        $estagiarioquery = $this->Estagiarios->find()
            ->contain(['Alunos', 'Supervisores', 'Instituicoes'])
            ->where(['Estagiarios.id IS' => $id])
            ->first();
        // pr($estagioquery);
        // die('estagioquery');

        if (!$estagiarioquery) {
            $this->Flash->error(__('Sem estagio cadastrado.'));
            return $this->redirect(['controller' => 'estagiarios', 'action' => 'view', $id]);
        }

        if (empty($estagiarioquery->aluno->identidade)) {
            $this->Flash->error(__("Aluno sem RG"));
            return $this->redirect('/alunos/view/' . $estagiarioquery->aluno->id);
        }

        if (empty($estagiarioquery->aluno->orgao)) {
            $this->Flash->error(__("Aluno não especifica o orgão emisor do documento"));
            return $this->redirect('/alunos/view/' . $estagiarioquery->aluno->id);
        }
        if (empty($estagiarioquery->aluno->cpf)) {
            $this->Flash->error(__("Aluno sem CPF"));
            return $this->redirect('/alunos/view/' . $estagiarioquery->aluno->id);
        }

        if (empty($estagiarioquery->supervisor->id)) {
            $this->Flash->error(__("Falta o supervisor de estágio"));
            return $this->redirect('/estagiarios/view/' . $estagiarioquery->id);
        }

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption(
            'pdfConfig',
            [
                'orientation' => 'portrait',
                //'download' => true, // This can be omitted if "filename" is specified.
                //'filename' => 'declaracao_de_estagio_' . $id . '.pdf' //// This can be omitted if you want file name based on URL.
            ]
        );
        $this->set('estagiario', $estagiarioquery);
    }
    
    
    /**
     * Lancanota method
     *
     * @param string|null $id Estagiario id.
     */  
    public function lancanota($id = null)
    {
        $siape = $this->getRequest()->getQuery('siape');
          
        $periodo = $this->getRequest()->getParam('pass') ? $this->request->getParam('pass')[0] : $this->fetchTable("Configuracoes")->find()->first()['mural_periodo_atual'];
        $this->set('periodo', $periodo);
        
        $periodo_total = $this->Estagiarios->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo'
        ]);
        $periodos = $periodo_total->toArray();
        $periodos = array_merge($periodos, array('all' => 'Todos'));
        $periodos = array_reverse($periodos);
        
        $this->set('periodos', $periodos);
        
        $contained = ['Alunos', 'Professores', 'Supervisores', 'Instituicoes', 'Turnos', 'Turmas'];
        
        $conditions = ['conditions' => ['Estagiarios.periodo' => $periodo] ];
        
        $estagiarios = $this->Estagiarios
            ->find('all', $conditions)
            ->contain($contained);
        //    ->where(['siape IS' => $siape])
        //    ->first();

        // pr($estagiarios);
        //foreach ($estagiarios as $estagio):
            //$folhadeatividadestabela = $this->fetchTable('Folhadeatividades');
            //$folha = $folhadeatividadestabela->find()
            //    ->where(['Folhadeatividades.estagiario_id' => $estagio->id])
            //    ->first();
            //if (isset($folha)):
            //    // pr($folha);
            //    $estagiarioslancanota[$i]['folha_id'] = $folha->id;
            //else:
            //    $estagiarioslancanota[$i]['folha_id'] = null;
            //endif;
            //if (isset($estagio->avaliacao->id)):
            //    $estagiarioslancanota[$i]['avaliacao_id'] = $estagio->avaliacao->id;
            //else:
             //   $estagiarioslancanota[$i]['avaliacao_id'] = null;
            //endif;
        // endforeach;
        // pr($estagiarioslancanota);
        // die();
        
        $this->set('estagiarios',  $this->paginate($estagiarios));

    }

    
    /**
     * Buscar method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function buscar () 
    {
        try {
            $this->Authorization->authorize($this->Estagiarios);
        } catch (ForbiddenException $error) {
            $this->Flash->error('Erro de authorização: ' . $error->getMessage());
            return $this->redirect('/');
        }
        
        $condition = ['Estagiarios.id' => ''];
        
        $nome = $this->getRequest()->getQuery('nome');
        if ($nome) { $condition = ['Alunos.nome LIKE' => '%' . $nome . '%']; }
        
        $instituicao = $this->getRequest()->getQuery('instituicao');
        if ($instituicao) { $condition = ['Instituicoes.instituicao LIKE' => '%' . $instituicao . '%']; }

        $dre = $this->getRequest()->getQuery('dre');
        if ($dre) { $condition = ['Alunos.registro' => $dre]; }
                
        $cpf = $this->getRequest()->getQuery('cpf');
        if ($cpf) { $condition = ['Alunos.cpf' => $cpf]; }
        
        $email = $this->getRequest()->getQuery('email');
        if ($email) { $condition = ['Users.email' => $email]; }
        
        $contained = ['Alunos' => ['Users'], 'Instituicoes'];
        
        $busca = $this->Estagiarios->find('all',  ['conditions' => $condition ])->contain($contained);
        $estagiarios = $this->paginate($busca);
        $this->set(compact('estagiarios'));
    }
        
    
}
