<?php 
 namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Eloquent class to describe the invoices table
 *
 * automatically generated by ModelGenerator.php
 */
class Invoice extends Model
{
 /**
 * The table associated with the model Invoice
 *
 * @var string
 */
    protected $table = 'invoices';

 /**
 * The attributes that are mass assignable.
 *
 * @var array
 */
    protected $fillable = ['invoice', 'description', 'xml_url', 'pdf_url'];

    /**
    * Relationship with the App\Models\InvoiceStatus model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\belongsTo
    */ 
    public function invoiceStatus()
    {
        return $this->belongsTo('App\Models\InvoiceStatus', 'invoice_status_id', 'id');
    }

    /**
    * Relationship with the App\Models\Order model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\belongsTo
    */ 
    public function orders()
    {
        return $this->belongsTo('App\Models\Order', 'orders_id', 'id');
    }

}
