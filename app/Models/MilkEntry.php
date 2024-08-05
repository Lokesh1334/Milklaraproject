<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilkEntry extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'quantity', 'date', 'price_per_liter'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
