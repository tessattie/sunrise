<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PaymentsSale[]|\Cake\Collection\CollectionInterface $paymentsSales
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Payments Sale'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sales'), ['controller' => 'Sales', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sale'), ['controller' => 'Sales', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Payments'), ['controller' => 'Payments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Payment'), ['controller' => 'Payments', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="paymentsSales index large-9 medium-8 columns content">
    <h3><?= __('Payments Sales') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sale_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('payment_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('amount') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($paymentsSales as $paymentsSale): ?>
            <tr>
                <td><?= $this->Number->format($paymentsSale->id) ?></td>
                <td><?= $paymentsSale->has('sale') ? $this->Html->link($paymentsSale->sale->id, ['controller' => 'Sales', 'action' => 'view', $paymentsSale->sale->id]) : '' ?></td>
                <td><?= $paymentsSale->has('payment') ? $this->Html->link($paymentsSale->payment->id, ['controller' => 'Payments', 'action' => 'view', $paymentsSale->payment->id]) : '' ?></td>
                <td><?= $this->Number->format($paymentsSale->amount) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $paymentsSale->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $paymentsSale->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $paymentsSale->id], ['confirm' => __('Are you sure you want to delete # {0}?', $paymentsSale->id)]) ?>
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
