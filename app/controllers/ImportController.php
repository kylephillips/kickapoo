<?php
use Kickapoo\SocialImport\Import;
use Kickapoo\SocialImport\SingleImport;
use Kickapoo\SocialImport\TwitterImport;
use Kickapoo\SocialImport\InstagramImport;

class ImportController extends BaseController {


	/**
	* Single Import Object
	* @var object
	*/
	protected $single_import;


	public function __construct(SingleImport $single_import)
	{
		$this->single_import = $single_import;
	}


	/**
	* Manually run an import
	*/
	public function doImport()
	{
		if ( Request::ajax() ){
			new Import;
			return Response::json(['status' => 'success']);
		}
	}


	/**
	* Import a single post
	*/
	public function importPost()
	{
		$type = Input::get('type');

		if ( $type == 'twitter' ){
			if ( $this->single_import->importTweet(Input::get('id')) ){
				return Response::json([
					'status'=>'success', 
					'message'=>'Tweet imported successfully.', 
					'post'=>$this->single_import->imported_item, 
					'post_id'=>Input::get('id')
				]);
			} else {
				return Response::json(['status'=>'error','message'=>$this->single_import->error]);
			}
		} else {
			if ( $this->single_import->importGram(Input::get('id')) ){
				return Response::json([
					'status'=>'success', 
					'message'=>'Instagram post imported successfully.',
					'post' => $this->single_import->imported_item,
					'post_id' => Input::get('id')
				]);
			} else {
				return Response::json(['status'=>'error','message'=>$this->single_import->error]);
			}
		}
	}



}