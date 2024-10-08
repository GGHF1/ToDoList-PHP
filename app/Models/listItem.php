<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class listItem extends Model
{
    use HasFactory;
    protected $table = 'list_items';
    protected $primaryKey = 'item_id';

    protected $fillable = ['name', 'is_complete', 'user_id'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
