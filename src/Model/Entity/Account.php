<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Account Entity
 *
 * @property int $id
 * @property int $customer_id
 * @property int $user_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $rate_id
 * @property string $account_number
 * @property float $balance
 *
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Rate $rate
 * @property \App\Model\Entity\Transaction[] $transactions
 */
class Account extends Entity
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
        'customer_id' => true,
        "name" => true,
        'user_id' => true,
        'created' => true,
        'modified' => true,
        'rate_id' => true,
        'account_number' => true,
        'balance' => true,
        'customer' => true,
        'user' => true,
        'rate' => true,
        'transactions' => true
    ];
}
