<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PaymentsSale $paymentsSale
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Payments Sale'), ['action' => 'edit', $paymentsSale->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Payments Sale'), ['action' => 'delete', $paymentsSale->id], ['confirm' => __('Are you sure you want to delete # {0}?', $paymentsSale->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Payments Sales'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Payments Sale'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sales'), ['controller' => 'Sales', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sale'), ['controller' => 'Sales', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Payments'), ['controller' => 'Payments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Payment'), ['controller' => 'Payments', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="paymentsSales view large-9 medium-8 columns content">
    <h3><?= h($paymentsSale->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Sale') ?></th>
            <td><?= $paymentsSale->has('sale') ? $this->Html->link($paymentsSale->sale->id, ['controller' => 'Sales', 'action' => 'view', $paymentsSale->sale->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payment') ?></th>
            <td><?= $paymentsSale->has('payment') ? $this->Html->link($paymentsSale->payment->id, ['controller' => 'Payments', 'action' => 'view', $paymentsSale->payment->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($paymentsSale->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount') ?></th>
            <td><?= $this->Number->format($paymentsSale->amount) ?></td>
        </tr>
    </table>
</div>
