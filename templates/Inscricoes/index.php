<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Inscricao> $inscricoes
 */

declare(strict_types=1);

$user_data = ['administrador_id'=>0,'aluno_id'=>0,'professor_id'=>0,'supervisor_id'=>0];
$user_session = $this->request->getAttribute('identity');
if ($user_session) { $user_data = $user_session->getOriginalData(); }
    
// pr($inscricoes);
// die();
?>
<div class="inscricoes index content">
	<aside>
		<div class="nav">
            <?= $this->Html->link(__('Nova Inscrição'), ['action' => 'add'], ['class' => 'button']) ?>
			<?php if ($user_data['administrador_id']): ?>
				<?= $this->Html->link(__('Buscar Inscrição'), ['action' => 'buscar'], ['class' => 'button']) ?>
			<?php endif; ?>
		</div>
	</aside>
    
    <h3><?= __('Lista de inscrições') ?></h3>
	
    <div class="paginator">
        <?= $this->element('paginator'); ?>
    </div>
    <div class="table_wrap">
        <table>
            <thead>
                <tr>
                    <th class="actions"><?= __('Actions') ?></th>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('aluno_id') ?></th>
                    <th><?= $this->Paginator->sort('muralestagio_id', 'Estágio') ?></th>
                    <th><?= $this->Paginator->sort('periodo', 'Período') ?></th>
                    <th><?= $this->Paginator->sort('timestamp', 'Criação') ?></th>
                    <th><?= $this->Paginator->sort('data', 'Alteração') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inscricoes as $inscricao): ?>

    
<?php
//pr($inscricao);
//die();
?>
                <tr>
                    <td class="actions">
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $inscricao->id]) ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $inscricao->id]) ?>
                        <?= $this->Form->postLink(__('Deletar'), ['action' => 'delete', $inscricao->id], ['confirm' => __('Are you sure you want to delete # {0}?', $inscricao->id)]) ?>
                    </td>
                    <td><?= $this->Html->link((string)$inscricao->id, ['action' => 'view', $inscricao->id]) ?></td>
                    <td><?= $inscricao->aluno ? $this->Html->link($inscricao->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $inscricao->aluno->id]) : '' ?></td>
					<td><?= $inscricao->muralestagio ? $this->Html->link($inscricao->muralestagio->instituicao ? 'Vaga para '.$inscricao->muralestagio->instituicao->instituicao . ' (' . $inscricao->muralestagio->data_selecao . ')' : $inscricao->muralestagio->id , ['controller' => 'Muralestagios', 'action' => 'view', $inscricao->muralestagio->id]) : $inscricao->muralestagio_id ?></td>
                    <td><?= h($inscricao->periodo) ?></td>
					<td><?= h($inscricao->data) ?></td>
                    <td><?= $inscricao->timestamp ? h($inscricao->timestamp) : '' ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <?= $this->element('paginator'); ?>
        <?= $this->element('paginator_count'); ?>
    </div>
</div>
