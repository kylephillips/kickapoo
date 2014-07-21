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
	public function importSingle()
	{
		$type = Input::get('type');

		if ( $type == 'twitter' ){
			if ( $this->single_import->importTweet(Input::get('id')) ){
				return Response::json(['status'=>'success', 'message'=>'Tweet has been imported successfully. Refresh the page to approve the tweet.']);
			} else {
				return Response::json(['status'=>'error','message'=>$this->single_import->error]);
			}
		} else {
			if ( $this->single_import->importGram(Input::get('id')) ){
				return Response::json(['status'=>'success', 'message'=>'Instagram post has been imported successfully. Refresh the page to approve the post.']);
			} else {
				return Response::json(['status'=>'error','message'=>$this->single_import->error]);
			}
		}
	}


}