<?php namespace Kickapoo\Factories;

use \ContactForm;
use \Response;

class ContactFormFactory {

	/**
	* Store a new form entry
	*/
	public function store($input)
	{
		$opt_in = ( isset($input['email_opt_in']) ) ? 1 : 0;
		ContactForm::create([
			'name' => $input['name'],
			'email' => $input['email'],
			'message' => $input['message'],
			'email_opt_in' => $opt_in
		]);
	}

	/**
	* Generate a CSV File
	*/
	public function downloadCSV()
	{
		$entries = ContactForm::get();
		$output = "ID,Name,Email,Message,,Entry Date,,Newsletter Opt-In\n";
  		foreach ($entries as $row) {
			$output .= implode(',', $row->toArray());
			$output .= "\n";
  		}
		$headers = array(
			'Content-Type' => 'text/csv',
			'Content-Disposition' => 'attachment; filename="KickapooEntries.csv"',
		);
		return Response::make(rtrim($output, "\n"), 200, $headers);
	}

}