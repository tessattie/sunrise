<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Movement $movement
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Movement'), ['action' => 'edit', $movement->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Movement'), ['action' => 'delete', $movement->id], ['confirm' => __('Are you sure you want to delete # {0}?', $movement->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Movements'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Movement'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Methods'), ['controller' => 'Methods', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Method'), ['controller' => 'Methods', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Currencies'), ['controller' => 'Currencies', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Currency'), ['controller' => 'Currencies', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Notes Chests'), ['controller' => 'NotesChests', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Notes Chest'), ['controller' => 'NotesChests', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="movements view large-9 medium-8 columns content">
    <h3><?= h($movement->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $movement->has('user') ? $this->Html->link($movement->user->id, ['controller' => 'Users', 'action' => 'view', $movement->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Method') ?></th>
            <td><?= $movement->has('method') ? $this->Html->link($movement->method->name, ['controller' => 'Methods', 'action' => 'view', $movement->method->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Currency') ?></th>
            <td><?= $movement->has('currency') ? $this->Html->link($movement->currency->name, ['controller' => 'Currencies', 'action' => 'view', $movement->currency->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Type') ?></th>
            <td><?= h($movement->type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td><?= h($movement->description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Comment') ?></th>
            <td><?= h($movement->comment) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($movement->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Montant') ?></th>
            <td><?= $this->Number->format($movement->montant) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Balance') ?></th>
            <td><?= $this->Number->format($movement->balance) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date') ?></th>
            <td><?= h($movement->date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($movement->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($movement->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Deleted At') ?></th>
            <td><?= h($movement->deleted_at) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Notes Chests') ?></h4>
        <?php if (!empty($movement->notes_chests)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Note Id') ?></th>
                <th scope="col"><?= __('Movement Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($movement->notes_chests as $notesChests): ?>
            <tr>
                <td><?= h($notesChests->note_id) ?></td>
                <td><?= h($notesChests->movement_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'NotesChests', 'action' => 'view', $notesChests->]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'NotesChests', 'action' => 'edit', $notesChests->]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'NotesChests', 'action' => 'delete', $notesChests->], ['confirm' => __('Are you sure you want to delete # {0}?', $notesChests->)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
