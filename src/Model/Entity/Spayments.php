<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Spayment Entity
 *
 * @property int $id
 * @property int $customer_id
 * @property float $amount
 * @property int $rate_id
 * @property float $daily_rate
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $user_id
 *
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\Rate $rate
 * @property \App\Model\Entity\User $user
 */
class Spayment extends Entity
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
        'supplier_id' => true,
        'amount' => true,
        'rate_id' => true,
        'daily_rate' => true,
        'created' => true,
        'modified' => true,
        'user_id' => true,
        'requisition_number' => true,
        'type' => true,
    ];
}
