<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Paste extends Model 
{
	protected $fillable = [
		'author', 
		'text'
	];
}