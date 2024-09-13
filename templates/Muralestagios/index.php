<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralestagio[]|\Cake\Collection\CollectionInterface $muralestagios
 */
 
?>

<script type="text/javascript">
	$(document).ready(function () {
        var url = "<?= $this->Html->Url->build(['controller' => 'muralestagios']); ?>";
        var muralestagioperiodo = $("#MuralestagioPeriodo");
		var pathname = location.pathname.split('/').filter(Boolean);
		if (pathname[pathname.length - 2] == 'index') muralestagioperiodo.val(pathname[pathname.length - 1]);
		muralestagioperiodo.on('change', function () {
            var periodo = $(this).val();
            window.location = url + '/index/' + periodo;
        });
    });
</script>

<?php

$session = $this->request->getSession();
$session->write('id_categoria', 1);
// echo $session->read('id_categoria');
?>

<div class="row justify-content-center">
    <div class="col-auto">
        <?php if ($session->read('id_categoria') == 1): ?>
            <?= $this->Form->create($muralestagios, ['class' => 'form-inline']); ?>
				<?= $this->Form->label('Periodo'); ?>
				<?= $this->Form->input('periodo', [
						'default'=> $periodo->periodo,
						'id' => 'MuralestagioPeriodo', 
						'type' => 'select', 
						'options' => $periodos,
						'class' => 'form-control'
					]); 
				?>
            <?= $this->Form->end(); ?>
        <?php else: ?>
            <h1 style="text-align: center;">Mural de estágios da ESS/UFRJ. Período: <?= '2020-1'; ?></h1>
        <?php endif; ?>
    </div>
</div>

<div class="muralestagios index content">
    <?= $this->Html->link(__('Novo mural'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Mural de estagios') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('instituicao', 'Instituição') ?></th>
                    <th><?= $this->Paginator->sort('vagas') ?></th>
                    <th><?= $this->Paginator->sort('beneficios') ?></th>
                    <th><?= $this->Paginator->sort('final_de_semana', 'Final de semana') ?></th>
                    <th><?= $this->Paginator->sort('cargaHoraria', 'CH') ?></th>
                    <th><?= $this->Paginator->sort('dataSelecao', 'Seleção') ?></th>
                    <th><?= $this->Paginator->sort('dataInscricao', 'Inscrição') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($muralestagios as $muralestagio): ?>
                    <tr>
                        <td><?= $this->Number->format($muralestagio->id) ?></td>
                        <td><?= $muralestagio->has('instituicaoestagio') ? $this->Html->link($muralestagio->instituicao, ['controller' => 'Muralestagios', 'action' => 'view', $muralestagio->id]) : $this->Html->link($muralestagio->instituicao, ['controller' => 'Muralestagios', 'action' => 'view', $muralestagio->id]); ?></td>
                        <td><?= $this->Number->format($muralestagio->vagas) ?></td>
                        <td><?= h($muralestagio->beneficios) ?></td>
                        <td><?= h($muralestagio->final_de_semana) ?></td>
                        <td><?= $this->Number->format($muralestagio->cargaHoraria) ?></td>
                        <td><?= h($muralestagio->dataSelecao) ?></td>
                        <td><?= h($muralestagio->dataInscricao) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $muralestagio->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $muralestagio->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $muralestagio->id], ['confirm' => __('Are you sure you want to delete # {0}?', $muralestagio->id)]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
