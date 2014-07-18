<?php
class AppLog extends Eloquent {

	protected $table = 'logs';

	protected $fillable = ['type', 'description'];

}