<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Transaction Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $customer_id
 * @property int $account_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property float $amount
 * @property int $type
 * @property int|null $sale_id
 * @property int|null $deposit_id
 * @property string|null $description
 * @property int|null $transaction_id
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\Account $account
 * @property \App\Model\Entity\Sale $sale
 * @property \App\Model\Entity\Deposit $deposit
 * @property \App\Model\Entity\Transaction[] $transactions
 */
class Transaction extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'user_id' => true,
        'customer_id' => true,
        'account_id' => true,
        'created' => true,
        'modified' => true,
        'amount' => true,
        'type' => true,
        'sale_id' => true,
        'deposit_id' => true,
        'description' => true,
        'transaction_id' => true,
        'user' => true,
        "daily_rate" => true,
        'customer' => true,
        'transaction_number' => true,
        'account' => true,
        'sale' => true,
        'deposit' => true,
        'transactions' => true
    ];
}
