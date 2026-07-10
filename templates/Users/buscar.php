<?php 

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\User> $users
 */


declare(strict_types=1);

$id = $this->getRequest()->getQuery('id');
$email = $this->getRequest()->getQuery('email');
     
?>

<div class="users buscar content">

    <div class="tabset">
        
        <input type="radio" name="tabs" id="tab_id" <?= ($id or !$email) ? 'checked' : '' ?> >
        <label for="tab_id">Busca por ID</label>
        <div class="tab-content">
            <?php echo $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query', 'context']]) ?>
            <?php echo $this->Form->control('id', ['label' => ['text' => 'Digite o ID do usuário'], 'class' => 'form-control']); ?>
            <?php echo $this->Form->submit('Buscar', ['type' => 'Submit', 'class' => 'button']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
        
        <input type="radio" name="tabs" id="tab_email" <?= ($email) ? 'checked' : '' ?> >
        <label for="tab_email">Busca por email</label>
        <div class="tab-content">
            <?php echo $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query', 'context']]) ?>
            <?php echo $this->Form->control('email', ['label' => ['text' => 'Digite o email do usuário'], 'class' => 'form-control']); ?>
            <?php echo $this->Form->submit('Buscar', ['type' => 'Submit', 'class' => 'button']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
    
    <?php if (isset($users)): ?>
    
        <?php if (iterator_count($users)): ?>
    
        
            <?php if ($id):  ?><h3>Resultado da busca para o ID <?= $id ?></h3><?php endif; ?>
            <?php if ($email):  ?><h3>Resultado da busca para o email <?= $email ?></h3><?php endif; ?>
    
            <div class="paginator">
                <?= $this->element('paginator'); ?>
            </div>
            <div class="table_wrap">
                <table>
                    <thead class='thead-light'>
                        <tr>
                            <th><?= $this->Paginator->sort('id', 'ID'); ?></th>
                            <th><?= $this->Paginator->sort('email', 'E-mail'); ?></th>
                        </tr>
                    </thead>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $this->Html->link((string)$user->id, ['action' => 'view', $user->id]); ?></td>
                            <td><?= $this->Html->link($user->email, ['action' => 'view', $user->id]); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <div class="paginator">
                <?= $this->element('paginator'); ?>
                <?= $this->element('paginator_count'); ?>
            </div>
        
        <?php else: ?>
            <?php if ($id):  ?><h3>Nenhum resultado encontrado para o ID <?= $id ?></h3><?php endif; ?>
            <?php if ($email):  ?><h3>Nenhum resultado encontrado para o email <?= $email ?></h3><?php endif; ?>
        <?php endif; ?>
    
    <?php endif; ?>
</div>
