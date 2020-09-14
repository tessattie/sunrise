<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Customer Entity
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $email
 * @property int $credit_limit
 * @property string $phone
 * @property int $discount
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $discount_type
 * @property int $user_id
 * @property int $customer_number
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Invoice[] $invoices
 * @property \App\Model\Entity\Sale[] $sales
 */
class Customer extends Entity
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
        'first_name' => true,
        'last_name' => true,
        'email' => true,
        'credit_limit' => true,
        'phone' => true,
        'discount' => true,
        'rate_id' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'discount_type' => true,
        'user_id' => true,
        'customer_number' => true,
        'user' => true,
        'invoices' => true,
        'sales' => true,
        'type' => true
    ];

    protected function _getDetails()
    {
        $rates = array(1 => "HTG", 2 => "USD");
        return strtoupper($this->_properties['last_name']) . " [ " . $rates[$this->_properties['rate_id']] . " ]" ;
    }


    protected function _getName()
    {
        return strtoupper($this->_properties['last_name']) . ' ' . ucfirst(strtolower($this->_properties['first_name']));
    }
}
