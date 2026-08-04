<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inscricao $inscricao
 */

declare(strict_types=1);

$user_data = ['administrador_id'=>0,'aluno_id'=>0,'professor_id'=>0,'supervisor_id'=>0];
$user_session = $this->request->getAttribute('identity');
if ($user_session) { $user_data = $user_session->getOriginalData(); }
    
?>
<div class="inscricoes form content">
    <aside>
        <div class="nav">
            <?= $this->Html->link(__('Listar Inscricoes'), ['action' => 'index'], ['class' => 'button']) ?>
        </div>
    </aside>
    <?= $this->Form->create($inscricao) ?>
    <fieldset>
        <h3><?= __('Adicionar Inscrição') ?></h3>
        <?php if ($user_data['administrador_id']): ?>
            <label for="aluno-id">ID do aluno</label>
            <?= $this->Form->number('aluno_id', ['id' => 'aluno-id', 'value' => empty($aluno_id) ? '' : $aluno_id]); ?>
            <label for="mural-estagio-id">ID do estagio</label>
            <?= $this->Form->number('mural_estagio_id', ['id' => 'mural-estagio-id', 'value' => empty($mural_estagio_id) ? '' : $mural_estagio_id]); ?>
        <?php else: ?>
            <?= $this->Form->hidden('aluno_id', ['value' => empty($aluno_id) ? '' : $aluno_id]); ?>
            <?= $this->Form->hidden('mural_estagio_id', ['value' => empty($mural_estagio_id) ? '' : $mural_estagio_id]); ?>
        <?php endif; ?>
        <?= $this->Form->control('periodo', ['disabled' => !$user_data['administrador_id']]); ?>
        <?= $this->Form->control('data', ['disabled' => !$user_data['administrador_id']]); ?>
    </fieldset>
    <?= $this->Form->button(__('Confirmar Inscrição'), ['class' => 'button btn-primary']) ?>
    <?= $this->Form->end() ?>
</div>
