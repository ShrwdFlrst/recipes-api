<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipeCollection;
use App\Recipe;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;

class RecipeController extends Controller
{
    const DEFAULT_PER_PAGE = 5;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cuisine = $request->get('cuisine', null);

        /** @var LengthAwarePaginator $paginator */
        if (!empty($cuisine)) {
            $paginator = Recipe::where('recipe_cuisine', '=', $cuisine)->paginate(self::DEFAULT_PER_PAGE);
            $paginator->appends(['cuisine' => $cuisine])->links();
        } else {
            $paginator = Recipe::paginate(self::DEFAULT_PER_PAGE);
        }


        $collection = new RecipeCollection($paginator);

        return $collection;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $recipe = Recipe::create($request->all());

        return response()->json($recipe->toArray(), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Recipe::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /** @var Recipe $recipe */
        $recipe = Recipe::findOrFail($id);

        $recipe->update($request->all());

        return response()->json($recipe->toArray());
    }
}
