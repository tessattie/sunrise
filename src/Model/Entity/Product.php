<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Product Entity
 *
 * @property int $id
 * @property string $name
 * @property int $category_id
 * @property float $cash_price
 * @property float $credit_price
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $status
 *
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\Sale[] $sales
 */
class Product extends Entity
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
        'abbreviation' => true,
        'category_id' => true,
        'cash_price' => true,
        'credit_price' => true,
        'created' => true,
        'modified' => true,
        'status' => true,
        'favori' => true,
        'category' => true,
        'sales' => true, 
        'position' => true,
        'percentage' => true
    ];


    protected function _getDetail()
    {
        return strtoupper($this->_properties['name']) . ' - [ ' . $this->_properties['cash_price'] . " HTG  / " . $this->_properties['credit_price'] . " USD ]";
    }
}
