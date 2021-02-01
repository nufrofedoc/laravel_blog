<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\BlogCategoryCreateRequest;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepository;

class CategoryController extends BaseController
{
    /**
     * @param BlogCategoryRepository
     */
    private $blogCategoryRepository;

    public function __construct()
    {
        parent::__construct();

        $this->blogCategoryRepository = app(BlogCategoryRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $paginator = BlogCategory::paginate(5);
        $paginator = $this->blogCategoryRepository->getAllWithPaginate(5);

        return view('blog.admin.categories.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = new BlogCategory();
        $categoryList
            = $this->blogCategoryRepository->getForComboBox();

        return view('blog.admin.categories.edit',
                    compact('item', 'categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BlogCategoryCreateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogCategoryCreateRequest $request)
    {
        $data = $request->input();

        $item = new BlogCategory($data);
        $item->save();

        if ($item) {
            return redirect()->route('blog.admin.categories.edit', [$item->id])
                ->with(['success' => 'Success']);
        } else {
            return back()->withErrors(['msg' => 'Error'])
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @param  BlogCategoryRepository $categoryRepository
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = $this->blogCategoryRepository->getEdit($id);

        if (empty($item)) {
            abort(404);
        }

        $categoryList
            = $this->blogCategoryRepository->getForComboBox();

        return view('blog.admin.categories.edit',
                    compact('item', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BlogCategoryUpdateRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogCategoryUpdateRequest $request, $id)
    {
        $item = $this->blogCategoryRepository->getEdit($id);

        if (empty($item)) {
            return back()
                ->withErrors(['msg' => "Record id=[{$id}] haven't foud"])
                ->withInput();
        }

        $data = $request->all();

        $result = $item
                ->fill($data)
                ->save();

        if ($result) {
            return redirect()
                ->route('blog.admin.categories.edit', $item->id)
                ->with(['success' => 'Success']);
        } else {
            return back()
                ->withErrors(['msg' => 'Error'])
                ->withInput();
        }
    }
}
