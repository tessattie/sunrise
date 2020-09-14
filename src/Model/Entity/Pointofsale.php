<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Pointofsale Entity
 *
 * @property int $id
 * @property string $imei
 * @property string $serial_number
 * @property string $name
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $status
 *
 * @property \App\Model\Entity\Sale[] $sales
 */
class Pointofsale extends Entity
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
        'imei' => true,
        'serial_number' => true,
        'name' => true,
        'created' => true,
        'modified' => true,
        'status' => true,
        'sales' => true
    ];
}
