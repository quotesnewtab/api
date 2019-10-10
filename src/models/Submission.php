<?php 

use Illuminate\Database\Eloquent\Model as Model;

class Submission extends Model {
  // Disable timestamps
  public $timestamps = false;

  // Define primary key in database
  protected $primaryKey = "id";

  // Define what fields are fillable
  protected $fillable = [
    'author', 
    'quote', 
    'submitted_by',
    'ip',
    'accepted'
  ];

  // Define hidden fields not to be returned when querying database
  protected $hidden = [
    'updated_at'
  ];
}