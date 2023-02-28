<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Request Log model class
 *
 * @package App\Models
 *
 * @property string $request_method
 * @property string $request_url
 * @property string $response_code
 * @property string $response_body
 * @property integer $response_time
 */
class RequestLog extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
}
