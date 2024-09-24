<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Area $area
 */
?>
<div>
    <div class="column-responsive column-80">
        <div class="areas view content">
            <aside>
                <div class="nav">
                    <?= $this->Html->link(__('Listar Areas'), ['action' => 'index'], ['class' => 'button']) ?>
                    <?= $this->Html->link(__('Editar Area'), ['action' => 'edit', $area->id], ['class' => 'button']) ?>
                    <?= $this->Form->postLink(__('Deletar Area'), ['action' => 'delete', $area->id], ['confirm' => __('Are you sure you want to delete {0}?', $area->area), 'class' => 'button']) ?>
                    <?= $this->Html->link(__('Nova Area'), ['action' => 'add'], ['class' => 'button']) ?>
                </div>
            </aside>
            <h3>area_<?= h($area->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($area->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Area') ?></th>
                    <td><?= h($area->area) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Estagiarios') ?></h4>
                <?php if (!empty($area->estagiarios)) : ?>
                <div>
                    <table>
                        <tr>
                            <th class="actions"><?= __('Actions') ?></th>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Aluno Id') ?></th>
                            <th><?= __('Nome') ?></th>
                            <th><?= __('Registro') ?></th>
                            <th><?= __('Ajustecurricular2020') ?></th>
                            <th><?= __('Turno') ?></th>
                            <th><?= __('Nivel') ?></th>
                            <th><?= __('Tc') ?></th>
                            <th><?= __('Tc Solicitacao') ?></th>
                            <th><?= __('Instituicao Id') ?></th>
                            <th><?= __('Supervisor Id') ?></th>
                            <th><?= __('Professor Id') ?></th>
                            <th><?= __('Periodo') ?></th>
                            <th><?= __('Nota') ?></th>
                            <th><?= __('Ch') ?></th>
                            <th><?= __('Observacoes') ?></th>
                        </tr>
                        <?php foreach ($area->estagiarios as $estagiarios) : ?>
                        <tr>
                            <td class="actions">
                                <?= $this->Html->link(__('Ver'), ['controller' => 'Estagiarios', 'action' => 'view', $estagiarios->id]) ?>
                                <?= $this->Html->link(__('Editar'), ['controller' => 'Estagiarios', 'action' => 'edit', $estagiarios->id]) ?>
                                <?= $this->Form->postLink(__('Deletar'), ['controller' => 'Estagiarios', 'action' => 'delete', $estagiarios->id], ['confirm' => __('Are you sure you want to delete # {0}?', $estagiarios->id)]) ?>
                            </td>
                            <td><?= h($estagiarios->id) ?></td>
                            <td><?= h($estagiarios->aluno_id) ?></td>
                            <td><?= $estagiarios->aluno ? $this->Html->link(h($estagiarios->aluno->nome), ['controller' => 'alunos', 'action' => 'view', $estagiarios->alunonovo_id]) : '' ?></td>
                            <td><?= h($estagiarios->registro) ?></td>
                            <td><?= h($estagiarios->ajustecurricular2020) ?></td>
                            <td><?= h($estagiarios->turno) ?></td>
                            <td><?= h($estagiarios->nivel) ?></td>
                            <td><?= h($estagiarios->tc) ?></td>
                            <td><?= h($estagiarios->tc_solicitacao) ?></td>
                            <td><?= $estagiarios->instituicao ? $this->Html->link(h($estagiarios->instituicao->instituicao), ['controller' => 'instituicaoestagios', 'action' => 'view', $estagiarios->instituicao->id]) : '' ?></td>
                            <td><?= $estagiarios->supervisor ? $this->Html->link(h($estagiarios->supervisor->nome), ['controller' => 'supervisores', 'action' => 'view', $estagiarios->supervisor->id]) : '' ?></td>
                            <td><?= $estagiarios->professor ? $this->Html->link(h($estagiarios->professor->nome), ['controller' => 'professores',  'action' => 'view', $estagiarios->professor->id]) : '' ?></td>
                            <td><?= h($estagiarios->periodo) ?></td>
                            <td><?= h($estagiarios->nota) ?></td>
                            <td><?= h($estagiarios->ch) ?></td>
                            <td><?= h($estagiarios->observacoes) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Muralestagios') ?></h4>
                <?php if (!empty($area->muralestagios)) : ?>
                <div>
                    <table>
                        <tr>
                            <th class="actions"><?= __('Actions') ?></th>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Instituicao') ?></th>
                            <th><?= __('Convenio') ?></th>
                            <th><?= __('Vagas') ?></th>
                            <th><?= __('Beneficios') ?></th>
                            <th><?= __('Final De Semana') ?></th>
                            <th><?= __('CargaHoraria') ?></th>
                            <th><?= __('Requisitos') ?></th>
                            <th><?= __('Horario') ?></th>
                            <th><?= __('Professor') ?></th>
                            <th><?= __('DataSelecao') ?></th>
                            <th><?= __('DataInscricao') ?></th>
                            <th><?= __('HorarioSelecao') ?></th>
                            <th><?= __('LocalSelecao') ?></th>
                            <th><?= __('FormaSelecao') ?></th>
                            <th><?= __('Contato') ?></th>
                            <th><?= __('Outras') ?></th>
                            <th><?= __('Periodo') ?></th>
                            <th><?= __('LocalInscricao') ?></th>
                            <th><?= __('Email') ?></th>
                        </tr>
                        <?php foreach ($area->muralestagios as $muralestagios) : ?>
                        <tr>
                            <td class="actions">
                                <?= $this->Html->link(__('Ver'), ['controller' => 'Muralestagios', 'action' => 'view', $muralestagios->id]) ?>
                                <?= $this->Html->link(__('Editar'), ['controller' => 'Muralestagios', 'action' => 'edit', $muralestagios->id]) ?>
                                <?= $this->Form->postLink(__('Deletar'), ['controller' => 'Muralestagios', 'action' => 'delete', $muralestagios->id], ['confirm' => __('Are you sure you want to delete # {0}?', $muralestagios->id)]) ?>
                            </td>
                            <td><?= h($muralestagios->id) ?></td>
                            <td><?= $muralestagios->instituicao ? $this->Html->link(h($muralestagios->instituicao->instituicao), ['controller' => 'instituicoes', 'action' => 'view', $muralestagios->instituicao->id]) : '' ?></td>
                            <td><?= h($muralestagios->convenio) ?></td>
                            <td><?= h($muralestagios->vagas) ?></td>
                            <td><?= h($muralestagios->beneficios) ?></td>
                            <td><?= h($muralestagios->final_de_semana) ?></td>
                            <td><?= h($muralestagios->cargaHoraria) ?></td>
                            <td><?= h($muralestagios->requisitos) ?></td>
                            <td><?= h($muralestagios->horario) ?></td>
                            <td><?= $muralestagios->professor ? $this->Html->link(h($muralestagios->professor->nome), ['controller' => 'professores', 'action' => 'view', $muralestagios->professor->id]) : '' ?></td>
                            <td><?= h($muralestagios->dataSelecao) ?></td>
                            <td><?= h($muralestagios->dataInscricao) ?></td>
                            <td><?= h($muralestagios->horarioSelecao) ?></td>
                            <td><?= h($muralestagios->localSelecao) ?></td>
                            <td><?= h($muralestagios->formaSelecao) ?></td>
                            <td><?= h($muralestagios->contato) ?></td>
                            <td><?= h($muralestagios->outras) ?></td>
                            <td><?= h($muralestagios->periodo) ?></td>
                            <td><?= h($muralestagios->localInscricao) ?></td>
                            <td><?= h($muralestagios->email) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
