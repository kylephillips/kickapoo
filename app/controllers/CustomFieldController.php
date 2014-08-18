<?php

use Kickapoo\Factories\CustomFieldFactory;
use Kickapoo\Repositories\CustomFieldRepository;

class CustomFieldController extends \BaseController {


	/**
	* Custom Field Factory
	*/
	protected $field_factory;

	/**
	* Custom Field Respository
	*/
	protected $field_repo;


	public function __construct(CustomFieldFactory $field_factory, CustomFieldRepository $field_repo)
	{
		$this->field_factory = $field_factory;
		$this->field_repo = $field_repo;
	}


	/**
	 * Validate custom field names before saving page data
	 * @return Response
	 */
	public function validate()
	{
		if ( Input::get('newcustomfield') ){
			$customfields = Input::get('newcustomfield');
			foreach ( $customfields as $cfield ){
				if ( !$cfield['fieldname'] ) return Response::json(['status' => 'error', 'message' => 'All custom fields require a name.']);
				if ( CustomField::where('name', $cfield['fieldname'])->where('page_id',$cfield['page_id'])->first() ) return Response::json(['status' => 'error', 'message' => 'The custom field name "' . $cfield['fieldname'] . '"" has been taken.']);
			}
		}
		return Response::json(['status'=>'success']);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$field = $this->field_repo->getField($id);
		$field->delete();
		return Response::json(['status'=>'success']);
	}


}
