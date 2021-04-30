<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductsSale Entity
 *
 * @property int $id
 * @property int $product_id
 * @property int $sale_id
 * @property float $price
 * @property float $quantity
 *
 * @property \App\Model\Entity\Product $product
 * @property \App\Model\Entity\Sale $sale
 */
class ProductsSale extends Entity
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
        'product_id' => true,
        'sale_id' => true,
        'price' => true,
        'list_price' => true,
        'quantity' => true,
        'product' => true,
        'sale' => true, 
        'taxe' => true, 
        'image_path' => true, 
        'barcode' => true, 
        'flight_id' => true, 
        'tag' => true, 
        'comment' => true, 
        'created' => true, 
        'modified' => true, 
        'loaded' => true, 
        'loaded_user_id' => true, 
        'landed' => true, 
        'landed_user_id' => true, 
        'delivered' => true, 
        'delivered_user_id' => true, 
        'truck_id' => true
    ];
}
