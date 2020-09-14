<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CardsUser[]|\Cake\Collection\CollectionInterface $cardsUsers
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Cards User'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cards'), ['controller' => 'Cards', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Card'), ['controller' => 'Cards', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="cardsUsers index large-9 medium-8 columns content">
    <h3><?= __('Cards Users') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('card_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cardsUsers as $cardsUser): ?>
            <tr>
                <td><?= $this->Number->format($cardsUser->id) ?></td>
                <td><?= $cardsUser->has('user') ? $this->Html->link($cardsUser->user->id, ['controller' => 'Users', 'action' => 'view', $cardsUser->user->id]) : '' ?></td>
                <td><?= $cardsUser->has('card') ? $this->Html->link($cardsUser->card->name, ['controller' => 'Cards', 'action' => 'view', $cardsUser->card->id]) : '' ?></td>
                <td><?= h($cardsUser->created) ?></td>
                <td><?= h($cardsUser->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $cardsUser->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $cardsUser->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $cardsUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cardsUser->id)]) ?>
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
