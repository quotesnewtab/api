<?php 

use Illuminate\Database\Eloquent\Model as Model;

class Quote extends Model {
  // Disable timestamps
  public $timestamps = false;

  // Define primary key in database
  protected $primaryKey = "id";

  // Define what fields are fillable
  protected $fillable = [
    'author', 
    'quote', 
    'submitter',
    'views'
  ];

  // Define hidden fields not to be returned when querying database
  protected $hidden = [
    'views'
  ];
}