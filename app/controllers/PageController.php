<?php
use Kickapoo\Repositories\PostRepository;
use Kickapoo\Repositories\PageRepository;
use Kickapoo\Factories\PageFactory;
use Kickapoo\Factories\CustomFieldFactory as CFFactory;

class PageController extends BaseController {

	/**
	* Posts Repository
	*/
	protected $posts_repo;

	/**
	* Page Repository
	*/
	protected $page_repo;

	/**
	* Page Factory
	*/
	protected $page_factory;

	/**
	* Custom Field Factory
	*/
	protected $field_factory;


	public function __construct(PostRepository $posts_repo, PageRepository $page_repo, PageFactory $page_factory, CFFactory $field_factory)
	{
		$this->posts_repo = $posts_repo;
		$this->page_repo = $page_repo;
		$this->page_factory = $page_factory;
		$this->field_factory = $field_factory;
	}


	/**
	* Homepage
	*/
	public function home()
	{	
		$page = $this->page_repo->getPage('home');
		$posts = $this->posts_repo->getApproved();
		
		return View::make('pages.home')
			->with('page_slug', 'home')
			->with('posts', $posts)
			->with('page', $page);
	}


	/**
	* Admin Homepage
	*/
	public function getAdmin()
	{
		return Redirect::route('admin.post.index');
	}


	/**
	* Get Page
	*/
	public function getPage($slug)
	{
		$page = $this->page_repo->getPage($slug);
		$view = 'pages.' . $page->template;

		return View::make($view)
			->with('page_slug', $slug)
			->with('page', $page);
	}


	/**
	* List all pages
	*/
	public function index()
	{
		$pages = $this->page_repo->getAllPages();
		return View::make('admin.pages.index')
			->with('pages', $pages);
	}


	/**
	* Show the form to add a new page
	*/
	public function create()
	{
		$templates = $this->page_repo->getPageTemplates();
		return View::make('admin.pages.create')
			->with('templates', $templates);
	}

	/**
	* Store the new page
	*/
	public function store()
	{
		//dd(Input::all());
		if ( Input::get('newcustomfield') ){
			$cfields = Input::get('newcustomfield');
			foreach($cfields as $field){
				if ( $field['fieldname'] == "" ) return Redirect::back()->withInput()->withErrors('custom_field', 'All Custom Fields require titles');
			}
		}
		$validation = Validator::make(Input::all(), [
			'title' => 'required|unique:pages,title',
			'status' => 'required',
			'template' => 'required',
			'content' => 'required'
		]);
		if ( $validation->fails() ) return Redirect::back()->withInput()->withErrors($validation);
		$page = $this->page_factory->createPage(Input::all());
		return Redirect::route('edit_page', ['slug'=>$page->slug])
			->with('success', 'Page created successfully!');
	}


	/**
	* Edit Page
	* @todo include custom fields as needed
	*/
	public function edit($slug)
	{
		$templates = $this->page_repo->getPageTemplates();
		$page = $this->page_repo->getPage($slug);
		return View::make('admin.pages.edit')
			->with('page', $page)
			->with('templates', $templates);
	}


	/**
	* Update Page
	*/
	public function update($id)
	{
		$page = Page::findOrFail($id);
		$validation = Validator::make(Input::all(), [
			'title' => 'required',
			'slug' => 'required',
			'status' => 'required',
			'template' => 'required',
			'content' => 'required'
		]);
		$validation->sometimes('slug', 'unique:pages,slug', function($input) use ($page) {
			return $input->slug !== $page->slug;
		});
		if ( $validation->fails() ){
			return Redirect::back()->withErrors($validation)->withInput();	
		}
		$updated = $this->page_factory->updatePage($id, Input::all());
		return Redirect::route('edit_page', ['slug'=>$updated->slug])->with('success', 'Page successfully updated!');
	}


	/**
	* Delete a Page
	*/
	public function destroy($slug)
	{
		$page = $this->page_repo->getPage($slug);
		$this->field_factory->deleteFields($page->customfields);
		$page->delete();
		return Redirect::route('page_index')
			->with('success', $page->title . ' Page Successfully Deleted');
	}


	/**
	* Set the menu order of pages
	*/
	public function setOrder()
	{
		$pages = explode(',', Input::get('order'));
		$this->page_factory->updateOrder($pages);
		return Response::json(['status'=>'success']);
	}


	/**
	* Toggle the Page's menu visibility
	*/
	public function menuToggle()
	{
		$page = $this->page_repo->getPage(Input::get('slug'));
		$page->show_in_menu = ( Input::get('show') == '1' ) ? 1 : 0;
		$page->save();
		return Response::json(['status'=>'success']);
	}


}