<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Movement $movement
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Movements'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Methods'), ['controller' => 'Methods', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Method'), ['controller' => 'Methods', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Currencies'), ['controller' => 'Currencies', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Currency'), ['controller' => 'Currencies', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Notes Chests'), ['controller' => 'NotesChests', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Notes Chest'), ['controller' => 'NotesChests', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="movements form large-9 medium-8 columns content">
    <?= $this->Form->create($movement) ?>
    <fieldset>
        <legend><?= __('Add Movement') ?></legend>
        <?php
            echo $this->Form->control('montant');
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('method_id', ['options' => $methods]);
            echo $this->Form->control('currency_id', ['options' => $currencies]);
            echo $this->Form->control('type');
            echo $this->Form->control('description');
            echo $this->Form->control('date');
            echo $this->Form->control('balance');
            echo $this->Form->control('deleted_at');
            echo $this->Form->control('comment');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
