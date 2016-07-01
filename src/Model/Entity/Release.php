<?php
namespace Attribute\Model\Entity;

use Cake\ORM\Entity;

/**
 * Release Entity.
 *
 * @property int $id
 * @property string $idp
 * @property string $persistentid
 * @property string $attribute_name
 * @property string $validated
 * @property \Cake\I18n\Time $modified
 */
class Release extends Entity
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
        '*' => true,
        'id' => false,
    ];
}
