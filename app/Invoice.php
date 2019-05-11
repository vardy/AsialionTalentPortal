<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use Uuids;
    use SoftDeletes;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

    protected $softCascade = ['file', 'purchase_orders'];

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
        'total', 'invoice_number', 'num_of_pos'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function file() {
        return $this->hasOne(File::class);
    }

    public function purchase_orders() {
        return $this->hasMany(PurchaseOrder::class);
    }
}
