<?php 
 namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Eloquent class to describe the langs table
 *
 * automatically generated by ModelGenerator.php
 */
class UserLang extends Model
{

    protected $table = 'user_lang';
    public $timestamps = false;
    protected $fillable = ['langs_id', 'users_id'];


}

