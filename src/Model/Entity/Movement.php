<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Movement Entity
 *
 * @property int $id
 * @property string $name
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $user_id
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Tracking[] $trackings
 */
class Movement extends Entity
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
        'with_flight' => true, 
        'customer_validation' => true,
        'created' => true,
        'modified' => true,
        'user_id' => true,
        'user' => true,
        'trackings' => true
    ];
}
