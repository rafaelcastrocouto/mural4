<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario $estagiario
 */

// pr($periodo);
// die();
?>

<script type="text/javascript">
    $(document).ready(function () {

        var url = "<?= $this->Html->Url->build(['controller' => 'estagiarios', 'action' => 'termodecompromisso', '?' => ['aluno_id' => $aluno->id]]); ?>";
        // alert(url);
        $("#instituicao-id").change(function () {
            var instituicao = $(this).val();
            // alert(url + '&instituicao_id=' +instituicao);
            window.location = url + '&instituicao_id=' + instituicao;
        })

    })
</script>

<?php
$submit = [
    "button" => "<div class='d-flex justify-content-center'><button type ='submit' class= 'btn btn-danger' {{attrs}}>{{text}}</button></div>"
]
    ?>

<div class="row">
    <div class="container">
        <?= $this->Form->create(null, ['type' => 'post']) ?>
        <fieldset>
            <h3><?= __('Solicitação de termo de compromisso') ?></h3>
            <?php
            if (isset($atualiza) && $atualiza == 1) {
                echo $this->Form->control('id', ['value' => $estagiario->id, 'type' => 'hidden', 'readonly']);
            }
            echo $this->Form->control('registro', ['value' => $aluno->registro, 'readonly']);
            echo $this->Form->control('aluno_id', ['label' => ['text' => 'Aluno'], 'options' => [$aluno->id => $aluno->nome], 'empty' => false, 'readonly']);
            echo $this->Form->control('aprovado', ['label' => ['text' => 'Termo de compromisso'], 'options' => ['0' => 'Não', '1' => 'Sim'], 'value' => 1, 'readonly']);
            echo $this->Form->control('ingresso', ['label' => ['text' => 'Ingresso'], 'value' => $aluno->ingresso, 'readonly']);
            echo $this->Form->control('turno', ['options' => ['D' => 'Diurno', 'N' => 'Noturno', 'I' => 'Sem informação'], 'value' => substr($aluno->turno, 0, 1)]);
            echo $this->Form->control('nivel', ['value' => 1, 'readonly']);
            echo $this->Form->control('periodo', ['label' => ['text' => 'Período'], 'value' => $periodo, 'readonly']);
            echo $this->Form->control('tc_solicitacao', ['label' => ['text' => 'Data de solicitação do TC'], 'value' => date('d-m-Y'), 'readonly']);
            echo $this->Form->control('tipo_de_estagio', ['label' => ['text' => 'Tipo de estágio'], 'options' => ['1' => 'Presencial', '2' => 'Remoto'], 'default' => '1']);

            if (isset($instituicao_id)) {
                echo $this->Form->control('instituicao_id', ['label' => ['text' => 'Instituição'], 'options' => $instituicoes, 'value' => $instituicao_id, 'required']);
            } elseif (isset($estagiario) && $estagiario->hasValue('instituicao')) {
                echo $this->Form->control('instituicao_id', ['label' => ['text' => 'Instituição'], 'options' => $instituicoes, 'empty' => [$estagiario->instituicao->id => $estagiario->instituicao->instituicao], 'required']);
            } else {
                echo $this->Form->control('instituicao_id', ['label' => ['text' => 'Instituição'], 'options' => $instituicoes, 'empty' => ['Seleciona instituição de estágio'], 'required']);
            }

            if (isset($estagiario) && $estagiario->hasValue('supervisor')):
                if (isset($supervisoresdainstituicao) && ($supervisoresdainstituicao)) {
                    echo $this->Form->control('supervisor_id', ['label' => ['text' => 'Supervisor(a)'], 'options' => $supervisoresdainstituicao, 'value' => $estagiario->supervisor->id]);
                } else {
                    echo $this->Form->control('supervisor_id', ['label' => ['text' => 'Supervisor(a)'], 'options' => ['Sem informação'], 'value' => $estagiario->supervisor->id]);
                }
            else:
                if (isset($supervisoresdainstituicao)):
                    echo $this->Form->control('supervisor_id', ['label' => ['text' => 'Supervisor(a)'], 'options' => $supervisoresdainstituicao, 'empty' => "Selecione supervisor(a)"]);
                else:
                    echo $this->Form->control('supervisor_id', ['label' => ['text' => 'Supervisor(a)'], 'options' => ['Sem informação'], 'empty' => ['0' => 'Sem informação']]);
                endif;
            endif;
            ?>
        </fieldset>

        <div class="d-flex justify-content-center">
            <div class="btn-group" role="group" aria-label="Confirma">
                <?php if (isset($estagiario) && $estagiario->id): ?>
                    <?= $this->Html->link('Imprime PDF', ['action' => 'termodecompromissopdf', $estagiario->id], ['class' => 'btn btn-lg btn-primary', 'rule' => 'button', 'style' => 'width: 200px']); ?>
                <?php endif; ?>
                <?php $this->Form->setTemplates($submit); ?>
                <?= $this->Form->button(__('Confirmar alteraçoes antes de imprimir'), ['type' => 'submit', 'class' => 'btn btn-lg btn-danger btn-xs col-lg-3', 'style' => "max-width:200px; word-wrap:break-word;"]) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
