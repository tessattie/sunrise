<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Spayment $spayment
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $spayment->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $spayment->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Spayments'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Suppliers'), ['controller' => 'Suppliers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Supplier'), ['controller' => 'Suppliers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Rates'), ['controller' => 'Rates', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Rate'), ['controller' => 'Rates', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="spayments form large-9 medium-8 columns content">
    <?= $this->Form->create($spayment) ?>
    <fieldset>
        <legend><?= __('Edit Spayment') ?></legend>
        <?php
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('supplier_id', ['options' => $suppliers]);
            echo $this->Form->control('amount');
            echo $this->Form->control('rate_id', ['options' => $rates]);
            echo $this->Form->control('requisition_number');
            echo $this->Form->control('type');
            echo $this->Form->control('daily_rate');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
