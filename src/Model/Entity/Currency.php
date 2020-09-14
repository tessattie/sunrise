<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Currency Entity
 *
 * @property int $id
 * @property string $abbr
 * @property string $name
 * @property float $rate_buy
 * @property float $rate_sale
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Cake\I18n\FrozenTime|null $deleted_at
 *
 * @property \App\Model\Entity\Chest[] $chests
 * @property \App\Model\Entity\Movement[] $movements
 */
class Currency extends Entity
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
        'abbr' => true,
        'name' => true,
        'rate_buy' => true,
        'rate_sale' => true,
        'created' => true,
        'modified' => true,
        'deleted_at' => true,
        'chests' => true,
        'movements' => true
    ];
}
