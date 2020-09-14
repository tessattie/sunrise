<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NotesMovement $notesMovement
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Notes Movements'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Notes'), ['controller' => 'Notes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Note'), ['controller' => 'Notes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Movements'), ['controller' => 'Movements', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Movement'), ['controller' => 'Movements', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="notesMovements form large-9 medium-8 columns content">
    <?= $this->Form->create($notesMovement) ?>
    <fieldset>
        <legend><?= __('Add Notes Movement') ?></legend>
        <?php
            echo $this->Form->control('note_id', ['options' => $notes]);
            echo $this->Form->control('movement_id', ['options' => $movements]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
