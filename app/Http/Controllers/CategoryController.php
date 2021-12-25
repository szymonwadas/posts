<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\UpsertCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view('categories.index',[
            'categories' => Category::paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UpsertCategoryRequest  $request
     * @return Redirect
     */
    public function store(UpsertCategoryRequest $request)
    {
        $category = new Category($request->validated());
        $category->save();
        return redirect(route('categories.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return View
     */
    public function edit(Category $category)
    {
        return view('categories.edit',[
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpsertCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return Redirect
     */
    public function update(UpsertCategoryRequest $request, Category $category)
    {
        $category->fill($request->validated());
        $category->save();
        return redirect(route('categories.index'));
    }

}
