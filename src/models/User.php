<?php 

use Illuminate\Database\Eloquent\Model as Model;

class User extends Model {
  // Define primary key in database
  protected $primaryKey = "id";

  // Define what fields are fillable
  protected $fillable = [];
}