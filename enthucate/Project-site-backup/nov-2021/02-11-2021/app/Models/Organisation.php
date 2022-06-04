<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organisation extends Model
{
	use SoftDeletes;
    protected $table = 'organisation';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
 //    protected $fillable = [
	// 	'contact_group_id', 'description', 'status', 'pay_rate_include_type', 'pay_rate_include', 'employee_time_sheet', 'annual_leave_accrual', 'created_by', 'updated_by', 'deleted_by'
	// ];
}
