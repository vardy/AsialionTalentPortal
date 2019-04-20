<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use Uuids;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'total', 'invoice_number', 'num_of_pos', 'num_of_files'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function files() {
        return $this->hasMany(File::class);
    }

    public function purchase_orders() {
        return $this->hasMany(PurchaseOrder::class);
    }
}
