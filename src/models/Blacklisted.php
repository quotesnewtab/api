<?php 

use Illuminate\Database\Eloquent\Model as Model;

class Blacklisted extends Model {
  // Disable timestamps
  public $timestamps = false;

  // Define table name in database
  protected $table = 'blacklisted';

  // Define primary key in database
  protected $primaryKey = 'id';

  // Define what fields are fillable
  protected $fillable = [
    'id',
    'ip', 
    'reason', 
    'date_of_ban'
  ];
}