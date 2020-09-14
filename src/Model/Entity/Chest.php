<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Chest Entity
 *
 * @property int $id
 * @property float $balance
 * @property int $currency_id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Cake\I18n\FrozenTime|null $deleted_at
 *
 * @property \App\Model\Entity\Currency $currency
 * @property \App\Model\Entity\Note[] $notes
 */
class Chest extends Entity
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
        'balance' => true,
        'currency_id' => true,
        'created' => true,
        'modified' => true,
        'deleted_at' => true,
        'currency' => true,
        'notes' => true
    ];
}
