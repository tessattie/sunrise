<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NotesMovement[]|\Cake\Collection\CollectionInterface $notesMovements
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Notes Movement'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Notes'), ['controller' => 'Notes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Note'), ['controller' => 'Notes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Movements'), ['controller' => 'Movements', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Movement'), ['controller' => 'Movements', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="notesMovements index large-9 medium-8 columns content">
    <h3><?= __('Notes Movements') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('note_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('movement_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($notesMovements as $notesMovement): ?>
            <tr>
                <td><?= $notesMovement->has('note') ? $this->Html->link($notesMovement->note->name, ['controller' => 'Notes', 'action' => 'view', $notesMovement->note->id]) : '' ?></td>
                <td><?= $notesMovement->has('movement') ? $this->Html->link($notesMovement->movement->id, ['controller' => 'Movements', 'action' => 'view', $notesMovement->movement->id]) : '' ?></td>
                <td><?= $this->Number->format($notesMovement->id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $notesMovement->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $notesMovement->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $notesMovement->id], ['confirm' => __('Are you sure you want to delete # {0}?', $notesMovement->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
