<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Chest $chest
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Chests'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Currencies'), ['controller' => 'Currencies', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Currency'), ['controller' => 'Currencies', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Notes'), ['controller' => 'Notes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Note'), ['controller' => 'Notes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="chests form large-9 medium-8 columns content">
    <?= $this->Form->create($chest) ?>
    <fieldset>
        <legend><?= __('Add Chest') ?></legend>
        <?php
            echo $this->Form->control('balance');
            echo $this->Form->control('currency_id', ['options' => $currencies]);
            echo $this->Form->control('deleted_at');
            echo $this->Form->control('notes._ids', ['options' => $notes]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
