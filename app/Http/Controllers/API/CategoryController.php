<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\ApiTrait;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ApiTrait;


    public function index() {

        $categories = Category::all();
        return $this -> returnData('categories',$categories,"");
    }



    public function categoryById(Request $request) {

        try {
            $category = Category::findorfail($request -> id);
          return  $this -> returnData('category',$category,'');
        }

        catch (\Exception $ex) {
            return $this -> returnError(456,"");
        }

    }



    public function listCategories(Request $request) {
        $categories_query = Category::select('id','name_ar','name_en','date');

        /** Case Filter (Search) */
        if($request -> keyword) {
            $categories_query -> where('name_ar','LIKE','%'.$request->keyword.'%');
        }

       /** Sorting by id or date */
         if($request -> sortBy && in_array($request -> sortBy,['id','date'])) {
             $sortBy = $request -> sortBy;
         }

         else {
             $sortBy = 'id';
         }

       /** Sorting whether ascending or descending */
        if($request -> sortOrder && in_array($request -> sortOrder,['asc','desc'])) {

            $sortOrder = $request -> sortOrder;
        }

        else {
            $sortOrder = "desc";
        }


        /** Pagination */
        if($request -> per_Page) {
            $per_Page = $request -> per_page;
        }

        else {
            $per_Page = 5;
        }

        if($request -> pagination) {
            $categories = $categories_query -> orderBY($sortBy,$sortOrder) -> paginate($per_Page);
        }

        else {
            $categories = $categories_query -> orderBY($sortBy,$sortOrder) -> get();
        }



        return $this -> returnData("categories",$categories,"NONE");
    }

}
