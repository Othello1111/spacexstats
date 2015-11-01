<?php
namespace SpaceXStats\Models;
use Illuminate\Database\Eloquent\Model;

class LiveUpdate extends Model {

    protected $table = 'live_updates';
    protected $primaryKey = 'message_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    public function user() {
        return $this->belongsTo('SpaceXStats\Models\User');
    }
}