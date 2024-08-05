<?php
// app/Models/Member.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'mobile_number']; // Adjust based on your schema

    public function milkEntries()
    {
        return $this->hasMany(MilkEntry::class);
    }
}

