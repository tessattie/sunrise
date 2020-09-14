<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NotesMovement $notesMovement
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Notes Movement'), ['action' => 'edit', $notesMovement->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Notes Movement'), ['action' => 'delete', $notesMovement->id], ['confirm' => __('Are you sure you want to delete # {0}?', $notesMovement->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Notes Movements'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Notes Movement'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Notes'), ['controller' => 'Notes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Note'), ['controller' => 'Notes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Movements'), ['controller' => 'Movements', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Movement'), ['controller' => 'Movements', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="notesMovements view large-9 medium-8 columns content">
    <h3><?= h($notesMovement->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Note') ?></th>
            <td><?= $notesMovement->has('note') ? $this->Html->link($notesMovement->note->name, ['controller' => 'Notes', 'action' => 'view', $notesMovement->note->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Movement') ?></th>
            <td><?= $notesMovement->has('movement') ? $this->Html->link($notesMovement->movement->id, ['controller' => 'Movements', 'action' => 'view', $notesMovement->movement->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($notesMovement->id) ?></td>
        </tr>
    </table>
</div>
