<?php

namespace App\Http\Controllers;

use App\Filters\CategoryFilter;
use App\Http\Resources\CategoryCollection;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        try {
            $filter = new CategoryFilter();
            $queryItems = $filter->transform($request);

            $categories = Category::where($queryItems);
            return new CategoryCollection($categories->paginate($categories->count())->appends($request->query()));
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        // Recoger datos POST
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if (!empty($params_array)) {
            // Validar datos
            $validator = Validator::make($params_array, [
                'name' => 'required',
                'slug' => 'required',
                'description' => 'required',
            ]);

            if ($validator->fails()) {
                // Devolver error de validación
                return response()->json($validator->errors(), 400);
            }

            // Crear y guardar la categoría
            $category = Category::create($params_array);

            // Devolver respuesta
            return response()->json([
                'status' =>
                    'success',
                'category' => $category
            ], 201);
        } else {
            return response()->json([
                'status' =>
                    'error',
                'message' => 'No se envió ninguna categoría'
            ], 400);
        }
    }

    public function show($id)
    {
        $category = Category::find($id);

        if ($category) {
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'category' => $category
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'status' => 'error',
                'message' => 'Categoría no encontrada'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $params_array = json_decode($request->input('json', null), true);

        if (!empty($params_array)) {
            $validator = Validator::make($params_array, [
                'name' => 'required',
                'description' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $box = Category::find($id);

            if ($box) {
                $box->update($params_array);
                return response()->json([
                    'status' => 'success',
                    'box' => $box
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Caja no encontrada'
                ], 404);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No se envió ninguna caja'
            ], 400);
        }
    }

}
