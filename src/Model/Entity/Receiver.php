<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Receiver Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $phone
 * @property string|null $email
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property string|null $address
 *
 * @property \App\Model\Entity\Sale[] $sales
 */
class Receiver extends Entity
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
        'name' => true,
        'phone' => true,
        'email' => true,
        'created' => true,
        'modified' => true,
        'address' => true,
        'sales' => true
    ];
}
