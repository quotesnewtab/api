<?php

use Illuminate\Database\Eloquent\Model as Model;

class Login extends Model {
  // Disable timestamps
  public $timestamps = false;

  // Define primary key in database
  protected $primaryKey = "id";

  // Define what fields are fillable
  protected $fillable = [
    'username',
    'password'
  ];
}