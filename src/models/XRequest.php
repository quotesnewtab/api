<?php 

use Illuminate\Database\Eloquent\Model as Model;

class XRequest extends Model {
  // Disable timestamps
  public $timestamps = false;

  // Define primary key in database
  protected $primaryKey = "ip";

  // Define what fields are fillable
  protected $fillable = [
    'ip', 
    'requests'
  ];
}