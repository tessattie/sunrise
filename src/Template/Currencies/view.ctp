<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Currency $currency
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Currency'), ['action' => 'edit', $currency->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Currency'), ['action' => 'delete', $currency->id], ['confirm' => __('Are you sure you want to delete # {0}?', $currency->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Currencies'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Currency'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Chests'), ['controller' => 'Chests', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Chest'), ['controller' => 'Chests', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Movements'), ['controller' => 'Movements', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Movement'), ['controller' => 'Movements', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="currencies view large-9 medium-8 columns content">
    <h3><?= h($currency->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Abbr') ?></th>
            <td><?= h($currency->abbr) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($currency->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($currency->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rate Buy') ?></th>
            <td><?= $this->Number->format($currency->rate_buy) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rate Sale') ?></th>
            <td><?= $this->Number->format($currency->rate_sale) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($currency->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($currency->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Deleted At') ?></th>
            <td><?= h($currency->deleted_at) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Chests') ?></h4>
        <?php if (!empty($currency->chests)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Balance') ?></th>
                <th scope="col"><?= __('Currency Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Deleted At') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($currency->chests as $chests): ?>
            <tr>
                <td><?= h($chests->id) ?></td>
                <td><?= h($chests->balance) ?></td>
                <td><?= h($chests->currency_id) ?></td>
                <td><?= h($chests->created) ?></td>
                <td><?= h($chests->modified) ?></td>
                <td><?= h($chests->deleted_at) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Chests', 'action' => 'view', $chests->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Chests', 'action' => 'edit', $chests->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Chests', 'action' => 'delete', $chests->id], ['confirm' => __('Are you sure you want to delete # {0}?', $chests->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Movements') ?></h4>
        <?php if (!empty($currency->movements)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Montant') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Method Id') ?></th>
                <th scope="col"><?= __('Currency Id') ?></th>
                <th scope="col"><?= __('Type') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col"><?= __('Date') ?></th>
                <th scope="col"><?= __('Balance') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Deleted At') ?></th>
                <th scope="col"><?= __('Comment') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($currency->movements as $movements): ?>
            <tr>
                <td><?= h($movements->id) ?></td>
                <td><?= h($movements->montant) ?></td>
                <td><?= h($movements->user_id) ?></td>
                <td><?= h($movements->method_id) ?></td>
                <td><?= h($movements->currency_id) ?></td>
                <td><?= h($movements->type) ?></td>
                <td><?= h($movements->description) ?></td>
                <td><?= h($movements->date) ?></td>
                <td><?= h($movements->balance) ?></td>
                <td><?= h($movements->created) ?></td>
                <td><?= h($movements->modified) ?></td>
                <td><?= h($movements->deleted_at) ?></td>
                <td><?= h($movements->comment) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Movements', 'action' => 'view', $movements->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Movements', 'action' => 'edit', $movements->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Movements', 'action' => 'delete', $movements->id], ['confirm' => __('Are you sure you want to delete # {0}?', $movements->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
