<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PaymentsSale $paymentsSale
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $paymentsSale->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $paymentsSale->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Payments Sales'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Sales'), ['controller' => 'Sales', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sale'), ['controller' => 'Sales', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Payments'), ['controller' => 'Payments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Payment'), ['controller' => 'Payments', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="paymentsSales form large-9 medium-8 columns content">
    <?= $this->Form->create($paymentsSale) ?>
    <fieldset>
        <legend><?= __('Edit Payments Sale') ?></legend>
        <?php
            echo $this->Form->control('sale_id', ['options' => $sales]);
            echo $this->Form->control('payment_id', ['options' => $payments]);
            echo $this->Form->control('amount');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
