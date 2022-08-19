<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Supplies
 *
 * @property int $id
 * @property int $quantity
 * @property int $received
 * @property int $equipment_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Supplies newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Supplies newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Supplies query()
 * @method static \Illuminate\Database\Eloquent\Builder|Supplies whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplies whereEquipmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplies whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplies whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplies whereReceived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplies whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Supplies extends Model
{
    use HasFactory;
}
