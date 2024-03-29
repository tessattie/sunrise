<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Truck Entity
 *
 * @property int $id
 * @property string $immatriculation
 * @property string $photo
 * @property float $volume
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $status
 * @property int $user_id
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Sale[] $sales
 */
class Truck extends Entity
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
        'immatriculation' => true,
        'volume' => true,
        'created' => true,
        'modified' => true,
        'barcode' => true, 
        'type' => true,
        'status' => true,
        'user_id' => true,
        'user' => true,
        'sales' => true,
        'name' => true,
        'min_weight' => true, 
        'max_weight' => true
    ];
}
