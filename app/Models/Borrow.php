<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Borrow extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'borrow_id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'location_id',
        'item_id',
        'user_id',
        'lend_date',
        'return_date',
        'lend_quantity',
        'lend_detail',
        'lend_photo',
        'lend_status',
    ];

    // Get the location of the borrow
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    // Get the item of the borrow
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    // Get the user of the borrow
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
