<?php

namespace App\Http\Controllers\Front;

use Hash;
use Illuminate\Http\Request;
use App\Http\Requests;
use URL;
use App\Http\Controllers\Controller;
use App\User;
use App\Product;
use App\Pincode;
use App\Color;
use App\Productcolor;
use App\Cart;
use App\Review;
use App\Wishlist;
use App\Country;
use App\Reviews;
use App\Orderdetail;
use App\Order;
use App\Category;
use App\Productimage;
use App\EmailTemplate;
use App\Helpers\EmailHelper;
use App\Helpers\CommonHelpers;
use Intervention\Image\ImageManagerStatic as Image;
Use DB;
use Validator;
use Config;
use Input;
use App\Helpers\BasicFunction;
use Mail;
use Crypt;
use Illuminate\Support\Facades\Auth;
use Session;
use File;

class ProductsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        /* $data = json_encode(['Text 1','Text 2','Text 3','Text 4','Text 5']);
          $file = time() . '_file.txt';
          File::put('public/'.$file,$data);
          exit; */
        if (!Auth::check()) {
            return redirect()->action('Front\HomesController@index');
        } else {
            $auth = LoginUser();
            //$products = Product::where('seller_id', $auth->id)->get();
            $products = DB::table('products')
                            ->leftjoin('height', 'products.height', '=', 'height.id')
                            ->leftjoin('bodytype', 'products.bodytype', '=', 'bodytype.id')
                            ->leftjoin('breast_size', 'products.breastsize', '=', 'breast_size.id')->where('products.seller_id', $auth->id)
                            ->orderby('products.created_at', 'desc')
                            ->select('products.*', 'height.height', 'bodytype.type as bodytype', 'breast_size.size as breastsize')->get();
        }
        //pr($products);exit;
        return view('front.products.index', compact('products'));
    }

    public function show($id) {
        //$user = User::find($id);
    }

    function productList(Request $request,$slug = null, $subCatSlug = null, $subsubCatSlug = null) {
        $input = $request->all(); 
       
        //pr($slug);exit;
        $search = trim(Input::get('search'));
        $colorArr = array(); 
        $sizeArr = array(); 
        $catArr = array();
        $cat_id = array();
        $sub_cat_id = array();
        $subs_sub_cat_id = array();
        $category_lists = array();
        $minArr = "";
        $maxArr = "999";
        $ratingArr = array();
        $title = "";
        $URL = $request->url();
        /*if(isset($input['rating']) && !empty($input['rating'])){
        $ratingArr = $input['rating'];
        }*/
       //echo $request->url();
        //echo request()->segment(count(request()->segments()));
        //exit;
        //pr($input);exit;
       if(request()->segment(count(request()->segments())) == 'search'){
           if(!Session::has('search')){
             Session::put('search', trim($input['search']));  
           }           
       }else{
          Session::forget('search'); 
       }
        
        $products2 = Product::select('products.*','productcolors.size_id as size_id','productcolors.color_id as color_id')
                            ->join('productcolors', 'products.id', '=', 'productcolors.product_id');
        if(empty(Session::get('search')) && empty($input['search'])){  //pr($input);echo "adfe";exit;
        if (isset($subsubCatSlug) && !empty($subsubCatSlug)) {
            $subs_sub_cat_id = Category::select()
                            ->where('slug', $subsubCatSlug)->get();
            $sub_sub_cat_id = $subs_sub_cat_id[0]->id;
             $title = $subs_sub_cat_id[0]->cat_name;
            if(isset($input['rating']) && !empty($input['rating']) && !empty($input['colors'])  && !empty($input['sizes']) && !empty($input['max_price'])){
                $colorArr = $input['colors'];
                $ratingArr = $input['rating'];
                $sizeArr = $input['sizes'];
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $maxArr = $input['max_price'];
                $products2 = $products2->join('reviews', 'products.id', '=', 'reviews.product_id')
                            ->where(function($query) use ($ratingArr) {
                            return $query->where('reviews.rating', '>=', $ratingArr);
                            })->where('products.sub_sub_category_id', $sub_sub_cat_id)
                            ->where(function($query) use ($colorArr) {
                            return $query->whereIn('productcolors.color_id',  $colorArr);
                        })->where(function($query) use ($sizeArr) {
                            return $query->whereIn('productcolors.size_id',  $sizeArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['colors']) && !empty($input['colors'])  && !empty($input['sizes']) && !empty($input['max_price'])){
                $colorArr = $input['colors'];
                $sizeArr = $input['sizes'];
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $maxArr = $input['max_price'];
                $products2 = $products2->where('products.sub_sub_category_id', $sub_sub_cat_id)
                            ->where(function($query) use ($colorArr) {
                            return $query->whereIn('productcolors.color_id',  $colorArr);
                        })->where(function($query) use ($sizeArr) {
                            return $query->whereIn('productcolors.size_id',  $sizeArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['colors']) && !empty($input['colors'])  && !empty($input['sizes'])){
                $colorArr = $input['colors'];
                $sizeArr = $input['sizes'];
                $products2 = $products2->where('products.sub_sub_category_id', $sub_sub_cat_id)
                            ->where(function($query) use ($colorArr) {
                            return $query->whereIn('productcolors.color_id',  $colorArr);
                        })->where(function($query) use ($sizeArr) {
                            return $query->whereIn('productcolors.size_id',  $sizeArr);
                        });
            }else if(isset($input['rating']) && !empty($input['rating']) && !empty($input['sizes']) && !empty($input['max_price'])){
                $ratingArr = $input['rating'];
                $sizeArr = $input['sizes'];
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                } 
                $maxArr = $input['max_price'];
                $products2 = $products2->join('reviews', 'products.id', '=', 'reviews.product_id')
                            ->where(function($query) use ($ratingArr) {
                            return $query->where('reviews.rating', '>=', $ratingArr);
                            })->where('products.sub_sub_category_id', $sub_sub_cat_id)
                            ->where(function($query) use ($sizeArr) {
                            return $query->whereIn('productcolors.size_id',  $sizeArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['sizes']) && !empty($input['sizes']) && !empty($input['max_price'])){  
                $sizeArr = $input['sizes'];
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $maxArr = $input['max_price'];
                    $products2 = $products2->where('products.sub_sub_category_id', $sub_sub_cat_id)
                            ->where(function($query) use ($sizeArr) {
                            return $query->whereIn('productcolors.size_id',  $sizeArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['sizes']) && !empty($input['sizes'])){  
                $sizeArr = $input['sizes'];
                    $products2 = $products2->where('products.sub_sub_category_id', $sub_sub_cat_id)
                            ->where(function($query) use ($sizeArr) {
                            return $query->whereIn('productcolors.size_id',  $sizeArr);
                        });
            }else if(isset($input['rating']) && !empty($input['rating']) && !empty($input['colors']) && !empty($input['max_price'])){
                $ratingArr = $input['rating'];
                $colorArr = $input['colors'];
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $maxArr = $input['max_price'];
                $products2 = $products2->join('reviews', 'products.id', '=', 'reviews.product_id')
                            ->where(function($query) use ($ratingArr) {
                            return $query->where('reviews.rating', '>=', $ratingArr);
                            })->where('products.sub_sub_category_id', $sub_sub_cat_id)
                            ->where(function($query) use ($colorArr) {
                            return $query->whereIn('productcolors.color_id',  $colorArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['colors']) && !empty($input['colors']) && !empty($input['max_price'])){
                $colorArr = $input['colors'];
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $maxArr = $input['max_price'];
                $products2 = $products2->where('products.sub_sub_category_id', $sub_sub_cat_id)
                            ->where(function($query) use ($colorArr) {
                            return $query->whereIn('productcolors.color_id',  $colorArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['colors']) && !empty($input['colors'])){
                $colorArr = $input['colors'];
                $products2 = $products2->where('products.sub_sub_category_id', $sub_sub_cat_id)
                            ->where(function($query) use ($colorArr) {
                            return $query->whereIn('productcolors.color_id',  $colorArr);
                        });
            }else if(isset($input['rating']) && !empty($input['rating']) && !empty($input['max_price'])){
                $ratingArr = $input['rating'];
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $maxArr = $input['max_price'];
                $products2 = $products2->join('reviews', 'products.id', '=', 'reviews.product_id')
                            ->where(function($query) use ($ratingArr) {
                            return $query->where('reviews.rating', '>=', $ratingArr);
                            })->where('products.sub_sub_category_id', $sub_sub_cat_id)
                            ->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(!empty($input['min_price']) && !empty($input['max_price'])){
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                } 
                $maxArr = $input['max_price'];
                $products2 = $products2->where('products.sub_sub_category_id', $sub_sub_cat_id)
                            ->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(!empty($input['max_price'])){
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                } 
                $maxArr = $input['max_price'];
                $products2 = $products2->where('products.sub_sub_category_id', $sub_sub_cat_id)
                            ->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else{            
            $products2 = $products2->where('products.sub_sub_category_id', $sub_sub_cat_id);
            }         
            $category_lists = Category ::where('parent_id', $sub_sub_cat_id)->where('status', 1)->orderBy('id', 'asc')->get();
        } else if (isset($subCatSlug) && !empty($subCatSlug)) {
            $subs_cat_ids = Category::select()
                            ->where('slug', $subCatSlug)->get();
            $sub_cat_id = $subs_cat_ids[0]->id;
            //pr($subs_cat_id[0]);exit;
            $title = $subs_cat_ids[0]->cat_name;
            if(isset($input['rating']) && !empty($input['rating']) && !empty($input['colors'])  && !empty($input['sizes']) && !empty($input['cats']) && !empty($input['max_price'])){
                $colorArr = $input['colors'];
                $sizeArr = $input['sizes'];
                $catArr = $input['cats'];
                $ratingArr = $input['rating'];
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $maxArr = $input['max_price'];
                $products2 = $products2->join('reviews', 'products.id', '=', 'reviews.product_id')
                            ->where(function($query) use ($ratingArr) {
                            return $query->where('reviews.rating', '>=', $ratingArr);
                            })->where('products.sub_category_id', $sub_cat_id)
                            ->where(function($query) use ($colorArr) {
                            return $query->whereIn('productcolors.color_id',  $colorArr);
                        })->where(function($query) use ($sizeArr) {
                            return $query->whereIn('productcolors.size_id',  $sizeArr);
                        })->where(function($query) use ($catArr) {
                            return $query->whereIn('products.sub_sub_category_id',  $catArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['colors']) && !empty($input['colors'])  && !empty($input['sizes']) && !empty($input['cats']) && !empty($input['max_price'])){
                $colorArr = $input['colors'];
                $sizeArr = $input['sizes'];
                $catArr = $input['cats'];
               if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $maxArr = $input['max_price'];
                $products2 = $products2->where('products.sub_category_id', $sub_cat_id)
                            ->where(function($query) use ($colorArr) {
                            return $query->whereIn('productcolors.color_id',  $colorArr);
                        })->where(function($query) use ($sizeArr) {
                            return $query->whereIn('productcolors.size_id',  $sizeArr);
                        })->where(function($query) use ($catArr) {
                            return $query->whereIn('products.sub_sub_category_id',  $catArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['colors']) && !empty($input['colors'])  && !empty($input['sizes']) && !empty($input['cats'])){
                $colorArr = $input['colors'];
                $sizeArr = $input['sizes'];
                $catArr = $input['cats'];
                $products2 = $products2->where('products.sub_category_id', $sub_cat_id)
                            ->where(function($query) use ($colorArr) {
                            return $query->whereIn('productcolors.color_id',  $colorArr);
                        })->where(function($query) use ($sizeArr) {
                            return $query->whereIn('productcolors.size_id',  $sizeArr);
                        })->where(function($query) use ($catArr) {
                            return $query->whereIn('products.sub_sub_category_id',  $catArr);
                        });
            }else if(isset($input['rating']) && !empty($input['rating']) && !empty($input['colors'])  && !empty($input['cats']) && !empty($input['max_price'])){
                $colorArr = $input['colors'];
                $catArr = $input['cats'];
                $ratingArr = $input['rating'];
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                } 
                $maxArr = $input['max_price'];
                $products2 = $products2->join('reviews', 'products.id', '=', 'reviews.product_id')
                            ->where(function($query) use ($ratingArr) {
                            return $query->where('reviews.rating', '>=', $ratingArr);
                            })->where('products.sub_category_id', $sub_cat_id)
                            ->where(function($query) use ($colorArr) {
                            return $query->whereIn('productcolors.color_id',  $colorArr);
                        })->where(function($query) use ($catArr) {
                            return $query->whereIn('products.sub_sub_category_id',  $catArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['colors']) && !empty($input['colors'])  && !empty($input['cats']) && !empty($input['max_price'])){
                $colorArr = $input['colors'];
                $catArr = $input['cats'];
               if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $maxArr = $input['max_price'];
                $products2 = $products2->where('products.sub_category_id', $sub_cat_id)
                            ->where(function($query) use ($colorArr) {
                            return $query->whereIn('productcolors.color_id',  $colorArr);
                        })->where(function($query) use ($catArr) {
                            return $query->whereIn('products.sub_sub_category_id',  $catArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['colors']) && !empty($input['colors'])  && !empty($input['cats'])){
                $colorArr = $input['colors'];
                $catArr = $input['cats'];
                $products2 = $products2->where('products.sub_category_id', $sub_cat_id)
                            ->where(function($query) use ($colorArr) {
                            return $query->whereIn('productcolors.color_id',  $colorArr);
                        })->where(function($query) use ($catArr) {
                            return $query->whereIn('products.sub_sub_category_id',  $catArr);
                        });
            }else if(isset($input['rating']) && !empty($input['rating']) && !empty($input['sizes'])  && !empty($input['cats']) && !empty($input['max_price'])){
                $sizeArr = $input['sizes'];
                $catArr = $input['cats'];
                $ratingArr = $input['rating'];
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                
                $maxArr = $input['max_price'];
                $products2 = $products2->join('reviews', 'products.id', '=', 'reviews.product_id')
                            ->where(function($query) use ($ratingArr) {
                            return $query->where('reviews.rating', '>=', $ratingArr);
                            })->where('products.sub_category_id', $sub_cat_id)
                            ->where(function($query) use ($sizeArr) {
                            return $query->whereIn('productcolors.size_id',  $sizeArr);
                        })->where(function($query) use ($catArr) {
                            return $query->whereIn('products.sub_sub_category_id',  $catArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['sizes']) && !empty($input['sizes'])  && !empty($input['cats']) && !empty($input['min_price']) && !empty($input['max_price'])){
                $sizeArr = $input['sizes'];
                $catArr = $input['cats'];
               if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $maxArr = $input['max_price'];
                $products2 = $products2->where('products.sub_category_id', $sub_cat_id)
                            ->where(function($query) use ($sizeArr) {
                            return $query->whereIn('productcolors.size_id',  $sizeArr);
                        })->where(function($query) use ($catArr) {
                            return $query->whereIn('products.sub_sub_category_id',  $catArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['rating']) && !empty($input['rating']) && !empty($input['sizes'])  && !empty($input['colors']) && !empty($input['max_price'])){
                $sizeArr = $input['sizes'];
                $colorArr = $input['colors'];
                $ratingArr = $input['rating'];
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                } 
                
                $maxArr = $input['max_price'];
                $products2 = $products2->join('reviews', 'products.id', '=', 'reviews.product_id')
                            ->where(function($query) use ($ratingArr) {
                            return $query->where('reviews.rating', '>=', $ratingArr);
                            })->where('products.sub_category_id', $sub_cat_id)
                            ->where(function($query) use ($sizeArr) {
                            return $query->whereIn('productcolors.size_id',  $sizeArr);
                        })->where(function($query) use ($colorArr) {
                            return $query->whereIn('productcolors.color_id',  $colorArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['colors']) && !empty($input['colors'])  && !empty($input['sizes'])  && !empty($input['max_price'])){
                $colorArr = $input['colors'];
                $sizeArr = $input['sizes'];
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                } 
                $maxArr = $input['max_price'];
                $products2 = $products2->where('products.sub_category_id', $sub_cat_id)
                            ->where(function($query) use ($colorArr) {
                            return $query->whereIn('productcolors.color_id',  $colorArr);
                        })->where(function($query) use ($sizeArr) {
                            return $query->whereIn('productcolors.size_id',  $sizeArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['rating']) && !empty($input['rating']) && !empty($input['sizes']) && !empty($input['max_price'])){
                $sizeArr = $input['sizes'];
                $ratingArr = $input['rating'];
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                
                $maxArr = $input['max_price'];
                $products2 = $products2->join('reviews', 'products.id', '=', 'reviews.product_id')
                            ->where(function($query) use ($ratingArr) {
                            return $query->where('reviews.rating', '>=', $ratingArr);
                            })->where('products.sub_category_id', $sub_cat_id)
                            ->where(function($query) use ($sizeArr) {
                            return $query->whereIn('productcolors.size_id',  $sizeArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['sizes']) && !empty($input['sizes']) && !empty($input['max_price'])){  
                $sizeArr = $input['sizes'];
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $maxArr = $input['max_price'];
                    $products2 = $products2->where('products.sub_category_id', $sub_cat_id)
                            ->where(function($query) use ($sizeArr) {
                            return $query->whereIn('productcolors.size_id',  $sizeArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['rating']) && !empty($input['rating']) && !empty($input['colors']) && !empty($input['max_price'])){
                $colorArr = $input['colors'];
                $ratingArr = $input['rating'];
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                
                $maxArr = $input['max_price'];
                $products2 = $products2->join('reviews', 'products.id', '=', 'reviews.product_id')
                            ->where(function($query) use ($ratingArr) {
                            return $query->where('reviews.rating', '>=', $ratingArr);
                            })->where('products.sub_category_id', $sub_cat_id)
                            ->where(function($query) use ($colorArr) {
                            return $query->whereIn('productcolors.color_id',  $colorArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['colors']) && !empty($input['colors'])  && !empty($input['max_price'])){
                $colorArr = $input['colors']; 
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                } 
                $maxArr = $input['max_price'];
                $products2 = $products2->where('products.sub_category_id', $sub_cat_id)
                            ->where(function($query) use ($colorArr) {
                            return $query->whereIn('productcolors.color_id',  $colorArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['rating']) && !empty($input['rating']) && !empty($input['cats']) && !empty($input['max_price'])){
                $catArr = $input['cats'];
                $ratingArr = $input['rating'];
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                } 
                
                $maxArr = $input['max_price'];
                $products2 = $products2->join('reviews', 'products.id', '=', 'reviews.product_id')
                            ->where(function($query) use ($ratingArr) {
                            return $query->where('reviews.rating', '>=', $ratingArr);
                            })->where('products.sub_category_id', $sub_cat_id)
                            ->where(function($query) use ($catArr) {
                            return $query->whereIn('products.sub_sub_category_id',  $catArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['rating']) && !empty($input['rating']) && !empty($input['max_price'])){
                $ratingArr = $input['rating'];
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }              
                $maxArr = $input['max_price'];
                $products2 = $products2->join('reviews', 'products.id', '=', 'reviews.product_id')
                            ->where(function($query) use ($ratingArr) {
                            return $query->where('reviews.rating', '>=', $ratingArr);
                            })->where('products.sub_category_id', $sub_cat_id)
                            ->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['cats']) && !empty($input['cats']) && !empty($input['max_price'])){ 
                $catArr = $input['cats'];  
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                } 
                $maxArr = $input['max_price'];
                $products2 = $products2->where('products.sub_category_id', $sub_cat_id)
                            ->where(function($query) use ($catArr) {
                            return $query->whereIn('products.sub_sub_category_id',  $catArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else{ 
            $products2 = $products2->where('products.sub_category_id', $sub_cat_id);
             }
            $category_lists = Category ::where('parent_id', $sub_cat_id)->where('status', 1)->orderBy('id', 'asc')->get();
           
        } else if (isset($slug) && !empty($slug)){ 
            $cat_ids = Category::select()
                            ->where('slug', $slug)->get();
            $cat_id = $cat_ids[0]->id;
            $title = $cat_ids[0]->cat_name;
            if(isset($input['rating']) && !empty($input['rating']) && !empty($input['cats']) && !empty($input['colors']) && !empty($input['sizes']) && !empty($input['max_price'])){
                $colorArr = $input['colors'];
                $ratingArr = $input['rating'];
                $sizeArr = $input['sizes'];
                $catArr = $input['cats'];
               if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $maxArr = $input['max_price'];
                $products2 = $products2->join('reviews', 'products.id', '=', 'reviews.product_id')
                                ->where('products.category_id', $cat_id)
                            ->where(function($query) use ($ratingArr) {
                            return $query->where('reviews.rating', '>=', $ratingArr);
                            })
                            ->where('products.category_id', $cat_id)
                            ->where(function($query) use ($ratingArr) {
                            return $query->whereIn('productcolors.color_id',  $ratingArr);
                        })->where(function($query) use ($colorArr) {
                            return $query->whereIn('productcolors.color_id',  $colorArr);
                        })->where(function($query) use ($sizeArr) {
                            return $query->whereIn('productcolors.size_id',  $sizeArr);
                        })->where(function($query) use ($catArr) {
                            return $query->whereIn('products.sub_category_id',  $catArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['colors']) && !empty($input['colors'])  && !empty($input['sizes']) && !empty($input['cats'])  && !empty($input['max_price'])){
                $colorArr = $input['colors'];
                $sizeArr = $input['sizes'];
                $catArr = $input['cats'];
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $maxArr = $input['max_price'];
                $products2 = $products2->where('products.category_id', $cat_id)
                            ->where(function($query) use ($colorArr) {
                            return $query->whereIn('productcolors.color_id',  $colorArr);
                        })->where(function($query) use ($sizeArr) {
                            return $query->whereIn('productcolors.size_id',  $sizeArr);
                        })->where(function($query) use ($catArr) {
                            return $query->whereIn('products.sub_category_id',  $catArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['rating']) && !empty($input['rating']) && !empty($input['colors']) && !empty($input['sizes']) && !empty($input['max_price'])){
                $colorArr = $input['colors'];
                $ratingArr = $input['rating'];
                $sizeArr = $input['sizes'];
               if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $maxArr = $input['max_price'];
                $products2 = $products2->join('reviews', 'products.id', '=', 'reviews.product_id')
                                ->where('products.category_id', $cat_id)
                            ->where(function($query) use ($ratingArr) {
                            return $query->where('reviews.rating', '>=', $ratingArr);
                            })
                            ->where('products.category_id', $cat_id)
                            ->where(function($query) use ($ratingArr) {
                            return $query->whereIn('productcolors.color_id',  $ratingArr);
                        })->where(function($query) use ($colorArr) {
                            return $query->whereIn('productcolors.color_id',  $colorArr);
                        })->where(function($query) use ($sizeArr) {
                            return $query->whereIn('productcolors.size_id',  $sizeArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['rating']) && !empty($input['rating']) && !empty($input['colors']) && !empty($input['cats']) && !empty($input['max_price'])){
                $colorArr = $input['colors'];
                $ratingArr = $input['rating'];
                $catArr = $input['cats'];
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $maxArr = $input['max_price'];
                $products2 = $products2->join('reviews', 'products.id', '=', 'reviews.product_id')
                                ->where('products.category_id', $cat_id)
                            ->where(function($query) use ($ratingArr) {
                            return $query->where('reviews.rating', '>=', $ratingArr);
                            })
                            ->where('products.category_id', $cat_id)
                            ->where(function($query) use ($ratingArr) {
                            return $query->whereIn('productcolors.color_id',  $ratingArr);
                        })->where(function($query) use ($colorArr) {
                            return $query->whereIn('productcolors.color_id',  $colorArr);
                        })->where(function($query) use ($catArr) {
                            return $query->whereIn('products.sub_category_id',  $catArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['colors']) && !empty($input['colors'])  && !empty($input['cats']) && !empty($input['max_price'])){
                $colorArr = $input['colors'];
                $catArr = $input['cats'];
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $maxArr = $input['max_price'];
                //pr($input);exit;
                $products2 = $products2->orderby('products.created_at', 'desc')
                            ->where('products.category_id', $cat_id)
                            ->where(function($query) use ($colorArr) {
                            return $query->whereIn('productcolors.color_id',  $colorArr);
                        })->where(function($query) use ($catArr) {
                            return $query->whereIn('products.sub_category_id',  $catArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['colors']) && !empty($input['colors'])  && !empty($input['sizes']) && !empty($input['min_price']) && !empty($input['max_price'])){
                $colorArr = $input['colors'];
                $sizeArr = $input['sizes'];
               if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                } 
                $maxArr = $input['max_price'];
               
                $products2 = $products2->where('products.category_id', $cat_id)
                            ->where(function($query) use ($colorArr) {
                            return $query->whereIn('productcolors.color_id',  $colorArr);
                        })->where(function($query) use ($sizeArr) {
                            return $query->whereIn('productcolors.size_id',  $sizeArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['rating']) && !empty($input['rating'])  && !empty($input['colors']) && !empty($input['sizes']) && !empty($input['cats']) && !empty($input['max_price'])){
                $maxArr = $input['max_price'];
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $ratingArr = $input['rating'];
                $catArr = $input['cats'];
                $colorArr = $input['colors'];
                $sizeArr = $input['sizes']; //echo "adsf";exit;
                $products2 = $products2->join('reviews', 'products.id', '=', 'reviews.product_id')
                                ->where('products.category_id', $cat_id)
                            ->where(function($query) use ($ratingArr) {
                            return $query->where('reviews.rating', '>=', $ratingArr);
                            })->where(function($query) use ($sizeArr) {
                            return $query->whereIn('productcolors.size_id',  $sizeArr);
                        })->where(function($query) use ($colorArr) {
                            return $query->whereIn('productcolors.color_id',  $colorArr);
                        })->where(function($query) use ($catArr) {
                            return $query->whereIn('products.sub_category_id',  $catArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['rating']) && !empty($input['rating'])  && !empty($input['colors']) && !empty($input['sizes']) && !empty($input['max_price'])){
                $maxArr = $input['max_price'];
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $colorArr = $input['colors'];
                $ratingArr = $input['rating'];
                $sizeArr = $input['sizes']; //echo "adsf";exit;
                $products2 = $products2->join('reviews', 'products.id', '=', 'reviews.product_id')
                                ->where('products.category_id', $cat_id)
                            ->where(function($query) use ($ratingArr) {
                            return $query->where('reviews.rating', '>=', $ratingArr);
                            })->where(function($query) use ($sizeArr) {
                            return $query->whereIn('productcolors.size_id',  $sizeArr);
                        })->where(function($query) use ($colorArr) {
                            return $query->whereIn('productcolors.color_id',  $colorArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['rating']) && !empty($input['rating'])  && !empty($input['sizes']) && !empty($input['cats']) && !empty($input['max_price'])){
                $maxArr = $input['max_price'];
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $ratingArr = $input['rating'];
                 $catArr = $input['cats'];
                $sizeArr = $input['sizes']; //echo "adsf";exit;
                $products2 = $products2->join('reviews', 'products.id', '=', 'reviews.product_id')
                                ->where('products.category_id', $cat_id)
                            ->where(function($query) use ($ratingArr) {
                            return $query->where('reviews.rating', '>=', $ratingArr);
                            })->where(function($query) use ($sizeArr) {
                            return $query->whereIn('productcolors.size_id',  $sizeArr);
                        })->where(function($query) use ($catArr) {
                            return $query->whereIn('products.sub_category_id',  $catArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['rating']) && !empty($input['rating'])  && !empty($input['sizes']) && !empty($input['max_price'])){
                $maxArr = $input['max_price'];
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $ratingArr = $input['rating'];
                $sizeArr = $input['sizes']; //echo "adsf";exit;
                $products2 = $products2->join('reviews', 'products.id', '=', 'reviews.product_id')
                                ->where('products.category_id', $cat_id)
                            ->where(function($query) use ($ratingArr) {
                            return $query->where('reviews.rating', '>=', $ratingArr);
                            })->where(function($query) use ($sizeArr) {
                            return $query->whereIn('productcolors.size_id',  $sizeArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['sizes']) && !empty($input['sizes'])  && !empty($input['cats']) && !empty($input['max_price'])){
                $sizeArr = $input['sizes'];
                $catArr = $input['cats'];
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $maxArr = $input['max_price'];
                //pr($input);exit;
                $products2 = $products2->where('products.category_id', $cat_id)
                            ->where(function($query) use ($sizeArr) {
                            return $query->whereIn('productcolors.size_id',  $sizeArr);
                        })->where(function($query) use ($catArr) {
                            return $query->whereIn('products.sub_category_id',  $catArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['rating']) && !empty($input['rating'])  && !empty($input['cats']) && !empty($input['max_price'])){
                $maxArr = $input['max_price'];
                $ratingArr = $input['rating'];
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $catArr = $input['cats']; //echo "adsf";exit;
                $products2 = $products2->join('reviews', 'products.id', '=', 'reviews.product_id')
                                ->where('products.category_id', $cat_id)
                            ->where(function($query) use ($ratingArr) {
                            return $query->where('reviews.rating', '>=', $ratingArr);
                            })->where(function($query) use ($catArr) {
                            return $query->whereIn('products.sub_category_id',  $catArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['rating']) && !empty($input['rating'])  && !empty($input['sizes']) && !empty($input['cats']) && !empty($input['max_price'])){
                $maxArr = $input['max_price'];
                $ratingArr = $input['rating'];
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $catArr = $input['cats'];
                $sizeArr = $input['sizes']; //echo "adsf";exit;
                $products2 = $products2->join('reviews', 'products.id', '=', 'reviews.product_id')
                                ->where('products.category_id', $cat_id)
                            ->where(function($query) use ($ratingArr) {
                            return $query->where('reviews.rating', '>=', $ratingArr);
                            })->where(function($query) use ($sizeArr) {
                            return $query->whereIn('productcolors.size_id',  $sizeArr);
                        })->where(function($query) use ($catArr) {
                            return $query->whereIn('products.sub_category_id',  $catArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['rating']) && !empty($input['rating'])  && !empty($input['sizes']) && !empty($input['max_price'])){
                $maxArr = $input['max_price'];
                $ratingArr = $input['rating'];
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $sizeArr = $input['sizes']; //echo "adsf";exit;
                $products2 = $products2->join('reviews', 'products.id', '=', 'reviews.product_id')
                                ->where('products.category_id', $cat_id)
                            ->where(function($query) use ($ratingArr) {
                            return $query->where('reviews.rating', '>=', $ratingArr);
                            })->where(function($query) use ($sizeArr) {
                            return $query->whereIn('productcolors.size_id',  $sizeArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['rating']) && !empty($input['rating'])  && !empty($input['colors']) && !empty($input['max_price'])){
                $maxArr = $input['max_price'];
                $ratingArr = $input['rating'];
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $colorArr = $input['colors']; //echo "adf";exit;
                $products2 = $products2->join('reviews', 'products.id', '=', 'reviews.product_id')
                                ->where('products.category_id', $cat_id)
                            ->where(function($query) use ($ratingArr) {
                            return $query->where('reviews.rating', '>=', $ratingArr);
                            })->where(function($query) use ($colorArr) {
                            return $query->whereIn('productcolors.color_id',  $colorArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['colors']) && !empty($input['colors'])  && !empty($input['max_price'])){
                $colorArr = $input['colors'];
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                } 
                $maxArr = $input['max_price'];
               //echo "adffff";exit;
                $products2 = $products2->where('products.category_id', $cat_id)
                            ->where(function($query) use ($colorArr) {
                            return $query->whereIn('productcolors.color_id',  $colorArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(!empty($input['sizes']) && !empty($input['max_price'])){
                $sizeArr = $input['sizes'];
               if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                } 
                $maxArr = $input['max_price'];
                $products2 = $products2->where('products.category_id', $cat_id)
                            ->where(function($query) use ($sizeArr) {
                            return $query->whereIn('productcolors.size_id',  $sizeArr);
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['colors']) && !empty($input['colors'])  && !empty($input['cats'])){
                $colorArr = $input['colors'];
                $catArr = $input['cats'];
                $products2 = $products2->where('products.category_id', $cat_id)
                            ->where(function($query) use ($colorArr) {
                            return $query->whereIn('productcolors.color_id',  $colorArr);
                        })->where(function($query) use ($catArr) {
                            return $query->whereIn('products.sub_category_id',  $catArr);
                        });
            }else if(isset($input['sizes']) && !empty($input['sizes'])  && !empty($input['cats'])){
                $sizeArr = $input['sizes'];
                $catArr = $input['cats'];
                $products2 = $products2->where('products.category_id', $cat_id)
                            ->where(function($query) use ($sizeArr) {
                            return $query->whereIn('productcolors.size_id',  $sizeArr);
                        })->where(function($query) use ($catArr) {
                            return $query->whereIn('products.sub_category_id',  $catArr);
                        });
            }else if(isset($input['colors']) && !empty($input['colors'])  && !empty($input['sizes'])){
                $colorArr = $input['colors'];
                $sizeArr = $input['sizes'];
                $products2 = $products2->where('products.category_id', $cat_id)
                            ->where(function($query) use ($colorArr) {
                            return $query->whereIn('productcolors.color_id',  $colorArr);
                        })->where(function($query) use ($sizeArr) {
                            return $query->whereIn('productcolors.size_id',  $sizeArr);
                        });
            }else if(isset($input['cats']) && !empty($input['cats']) && !empty($input['max_price'])){
                $catArr = $input['cats']; 
                //$minArr = $input['min_price']; 
                $maxArr = $input['max_price'];
                $products2 = $products2->where('products.category_id', $cat_id)
                            ->where(function($query) use ($catArr) {
                            return $query->whereIn('products.sub_category_id',  $catArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['sizes']) && !empty($input['sizes'])){  
                $sizeArr = $input['sizes'];
                    $products2 = $products2->where('products.category_id', $cat_id)
                            ->where(function($query) use ($sizeArr) {
                            return $query->whereIn('productcolors.size_id',  $sizeArr);
                        });
            }else if(isset($input['colors']) && !empty($input['colors'])){
                $colorArr = $input['colors'];  
                $products2 = $products2->where('products.category_id', $cat_id)
                            ->where(function($query) use ($colorArr) {
                            return $query->whereIn('productcolors.color_id',  $colorArr);
                        });
            }else if(isset($input['rating']) && !empty($input['rating']) && !empty($input['max_price'])){
                $maxArr = $input['max_price'];
                $ratingArr = $input['rating'];
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $products2 = $products2->join('reviews', 'products.id', '=', 'reviews.product_id')
                                ->where('products.category_id', $cat_id)
                            ->where(function($query) use ($ratingArr) {
                            return $query->where('reviews.rating', '>=', $ratingArr);
                            })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['min_price']) && !empty($input['min_price'])){
               if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $maxArr = $input['max_price'];
                $products2 = $products2->where('products.category_id', $cat_id)
                            ->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['max_price']) && !empty($input['max_price'])){
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $maxArr = $input['max_price'];  
                $products2 = $products2->where('products.category_id', $cat_id)
                            ->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['min_price']) && !empty($input['min_price']) && !empty($input['max_price'])){
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $maxArr = $input['max_price'];  
                $products2 = $products2->where('products.category_id', $cat_id)
                            ->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                            }) 
                             ->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else{            
                $reviewArr = 5;
                $products2 = $products2->where('products.category_id', $cat_id);
            }
            $category_lists = Category ::where('parent_id', $cat_id)->where('status', 1)->orderBy('id', 'asc')->get();
        }//pr(Session::get('search'));
        //pr($input);exit;
        
    }else{ //pr($input);exit;
        if (isset($input['search']) && !empty($input['search'])) {//pr(Session::get('search')); 
            //\Session::put('search', $input['search']);
            $products2 = $products2->where(function($query) use ($search) {
                        return $query->where('products.product_title', 'LIKE', "%$search%");
                    });
                 //pr($input);exit;   
        }else if(isset($input['rating']) && !empty($input['rating']) && !empty($input['colors'])  && !empty($input['sizes']) && !empty(Session::get('search'))  && !empty($input['max_price'])){
                $colorArr = $input['colors'];
                $ratingArr = $input['rating'];
                $sizeArr = $input['sizes'];
                $search = Session::get('search');
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                } 
                $maxArr = $input['max_price'];
                //pr(Session::get('search'));exit;
                $products2 = $products2->join('reviews', 'products.id', '=', 'reviews.product_id')
                            ->where(function($query) use ($ratingArr) {
                            return $query->where('reviews.rating', '>=', $ratingArr);
                            })->where(function($query) use ($colorArr) {
                            return $query->whereIn('productcolors.color_id',  $colorArr);
                        })->where(function($query) use ($sizeArr) {
                            return $query->whereIn('productcolors.size_id',  $sizeArr);
                        })->where(function($query) use ($search) {
                            return $query->where('products.product_title', 'LIKE', "%$search%");
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['colors']) && !empty($input['colors'])  && !empty($input['sizes']) && !empty(Session::get('search'))  && !empty($input['max_price'])){
                $colorArr = $input['colors'];
                $sizeArr = $input['sizes'];
                $search = Session::get('search');
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $maxArr = $input['max_price'];
                //pr(Session::get('search'));exit;
                $products2 = $products2->where(function($query) use ($colorArr) {
                            return $query->whereIn('productcolors.color_id',  $colorArr);
                        })->where(function($query) use ($sizeArr) {
                            return $query->whereIn('productcolors.size_id',  $sizeArr);
                        })->where(function($query) use ($search) {
                            return $query->where('products.product_title', 'LIKE', "%$search%");
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['rating']) && !empty($input['rating']) && !empty($input['colors'])  && !empty(Session::get('search'))  && !empty($input['max_price'])){
                $colorArr = $input['colors'];
                $ratingArr = $input['rating'];
                $search = Session::get('search');
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $maxArr = $input['max_price'];
                //pr(Session::get('search'));exit;
                $products2 = $products2->join('reviews', 'products.id', '=', 'reviews.product_id')
                            ->where(function($query) use ($ratingArr) {
                            return $query->where('reviews.rating', '>=', $ratingArr);
                            })->where(function($query) use ($colorArr) {
                            return $query->whereIn('productcolors.color_id',  $colorArr);
                        })->where(function($query) use ($search) {
                            return $query->where('products.product_title', 'LIKE', "%$search%");
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['colors']) && !empty($input['colors'])  && !empty(Session::get('search'))  && !empty($input['max_price'])){
                $colorArr = $input['colors'];
                $search = Session::get('search');
               if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $maxArr = $input['max_price'];
                //pr($input);exit;
                $products2 = $products2->where(function($query) use ($colorArr) {
                            return $query->whereIn('productcolors.color_id',  $colorArr);
                        })->where(function($query) use ($search) {
                            return $query->where('products.product_title', 'LIKE', "%$search%");
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['rating']) && !empty($input['rating']) && !empty($input['sizes']) && !empty(Session::get('search'))  && !empty($input['max_price'])){
                $ratingArr = $input['rating'];
                $sizeArr = $input['sizes'];
                $search = Session::get('search');
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $maxArr = $input['max_price'];
                //pr(Session::get('search'));exit;
                $products2 = $products2->join('reviews', 'products.id', '=', 'reviews.product_id')
                            ->where(function($query) use ($ratingArr) {
                            return $query->where('reviews.rating', '>=', $ratingArr);
                            })->where(function($query) use ($sizeArr) {
                            return $query->whereIn('productcolors.size_id',  $sizeArr);
                        })->where(function($query) use ($search) {
                            return $query->where('products.product_title', 'LIKE', "%$search%");
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['sizes']) && !empty($input['sizes'])  && !empty(Session::get('search')) && !empty($input['max_price'])){
                $sizeArr = $input['sizes'];
                $search = Session::get('search');
               if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $maxArr = $input['max_price'];
                $search_items = Session::get('search');
                //pr($search_items);
                //pr($input);exit;
                $products2 = $products2->where(function($query) use ($sizeArr) {
                            return $query->whereIn('productcolors.size_id',  $sizeArr);
                        })->where(function($query) use ($search) {
                            return $query->where('products.product_title', 'LIKE', "%$search%");
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(isset($input['rating']) && !empty($input['rating']) && !empty(Session::get('search'))  && !empty($input['max_price'])){
               $ratingArr = $input['rating'];
                $search = Session::get('search');
              if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                } 
                $maxArr = $input['max_price'];
                //pr(Session::get('search'));exit;
                $products2 = $products2->join('reviews', 'products.id', '=', 'reviews.product_id')
                            ->where(function($query) use ($ratingArr) {
                            return $query->where('reviews.rating', '>=', $ratingArr);
                            })->where(function($query) use ($search) {
                            return $query->where('products.product_title', 'LIKE', "%$search%");
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }else if(!empty(Session::get('search'))  && !empty($input['max_price'])){
                $search = Session::get('search'); //echo "adf0";exit;
                if(isset($input['min_price']) && !empty($input['min_price'])){
                $minArr = $input['min_price'];
                }else{
                    $minArr = "";
                }
                $maxArr = $input['max_price'];
                $products2 = $products2->where(function($query) use ($search) {
                            return $query->where('products.product_title', 'LIKE', "%$search%");
                        })->where(function($query) use ($minArr) {
                            return $query->where('products.price', '>=', $minArr);
                        })->where(function($query) use ($maxArr) {
                            return $query->where('products.price', '<=', $maxArr);
                        });
            }
            
    }//pr(Session::get('search'));
     //pr($input);exit;   
        if(!empty($input['sort']) && $input['sort'] == 'price'){
            if(CURRENCY == '<i class="fa fa-usd" aria-hidden="true"></i>'){
            $products2 = $products2->orderby('products.price_usd', $input['order']);
            }else{
               $products2 = $products2->orderby('products.price', $input['order']);  
            }
        }else if(!empty($input['sort']) && $input['sort'] == 'created_at'){
            $products2 = $products2->orderby('products.created_at', $input['order']);
        }
        
            $products2 = $products2->where('products.status', 1)->where('products.is_image', 1)
                        ->groupBy('products.id')
                    ->sortable(['created_at' => 'desc'])
                    ->paginate(Configure('CONFIG_FRONT_PAGE_LIMIT'));
       /* $products = $products->where('status', '1')
                ->sortable(['created_at' => 'desc'])
                ->paginate(Configure('CONFIG_FRONT_PAGE_LIMIT'));*/
        //pr($products2);exit;
        
        $colors = Color::where('status', '=', 1)->get();
        $sizeLists = CommonHelpers::getsizelist(); 
        
        return view('front.products.product_list', compact('URL','title','ratingArr','minArr','maxArr','products2','sizeArr','catArr','colorArr','sizeLists', 'products', 'cat_id', 'colors', 'category_lists','slug','subCatSlug','subsubCatSlug'));
    }

    
    public function allproductList() {
        
        $search = Input::get('search');
        pr($search);exit;
        if ($search) {
            $products = Product::select('id', 'product_name', 'product_location', 'profile_img1', 'dob')
                    ->where(function($query) use ($search) {
                        return $query->where('product_name', 'LIKE', "%$search%")
                                ->orwhere('product_location', 'LIKE', "%$search%")
                                ->orwhere('product_phone', 'LIKE', "%$search%")
                                ->orwhere('dob', 'LIKE', "%$search%");
                        //->orwhere('gender', 'LIKE', "%$gendersearch%")
                    })->where('status', '1')
                    ->sortable(['created_at' => 'desc'])
                    ->paginate(Configure('CONFIG_PAGE_LIMIT'));
        } else {

            $products = Product::select('id', 'product_name', 'product_location', 'profile_img1', 'dob')
                    ->where('status', '1')->where('is_image', '1')
                    ->sortable(['created_at' => 'desc'])
                    ->paginate(Configure('CONFIG_PAGE_LIMIT'));
        }
        return view('front.products.product_list', compact('products'));
    }
    
    
    public function productDetail($slug = null, $color = null) {
        $product_id = Product::select()
                        ->where('slug', $slug)->get();
        $product_id = $product_id[0]->id;

        
        $productDetail = Product::with('product_image', 'product_category', 'product_subcategory', 'product_color','product_sub_subcategory')
                        ->where('status', '1')->where('is_image', '1')
                        ->where('id', $product_id)
                        ->get()->toArray();
        
        
    
        
        $colorLists = CommonHelpers::getProductColor($color);
        if (isset($colorLists) && !empty($colorLists)) {
            $colorId = $colorLists->id;
        }
       //pr($productDetail);exit; 
        $check_stock = DB::table('productcolors')
                        ->where('product_id', $product_id)
                        ->where('color_id', $colorId)
                        ->where('quantity', '>', 0)->count();
        //pr($check_stock);exit;
        
        $pro_sub_cat = $productDetail[0]['sub_category_id'];
        $pro_sub_sub_cat = $productDetail[0]['sub_sub_category_id'];

        $relatedProducts = Product::with('product_image', 'product_category', 'product_subcategory')
                        ->where('sub_category_id', $pro_sub_cat)
                        ->Where('sub_sub_category_id', $pro_sub_sub_cat)
                        ->where('is_image', 1)->where('status', 1)
                        ->where('id', '!=', $productDetail[0]['id'])
                        ->get()->toArray();
//pr($relatedProducts);
        $productReviews = DB::table('reviews')
                        ->join('users', 'reviews.user_id', '=', 'users.id')
                        ->where('reviews.product_id', $product_id)
                        ->orderby('reviews.created_at', 'desc')
                        ->select('reviews.*', 'users.first_name as first_name', 'users.last_name as last_name', 'users.profile_img as profile_img')->take(3)->get();
        /*$auth = LoginUser();
        $session_id = session()->getId();
        $cartlists = Cart::select('size_id')->where('product_id', $product_id);
        if (!Auth::check()) {
            $cartlists->where('session_id', $session_id);
        }else{
            $cartlists->where('user_id', $auth->id);
        }        
        $cartlists = $cartlists->where('color_id', $colorId)->get()->toArray();
        $cartsize[] = "";
        foreach ($cartlists as $cartlist){
            $cartsize[]  = $cartlist['size_id'];
        }
        $cartsizes = array_filter($cartsize);*/
        //echo $colorId;exit;
        //pr($productDetail);exit;
        $title = $productDetail[0]['product_title'];
        
        return view('front.products.product_detail', compact('check_stock','title','productDetail', 'relatedProducts', 'productReviews', 'product_id', 'colorId', 'slug'));
    }

    public function create() {
        $auth = LoginUser();
        if (!Auth::check()) {
            return redirect()->action('Front\HomesController@index');
        } else if ($auth->payment_status == 0) {
            return redirect()->action('Front\UsersController@membershipplan');
        } else {

            $user = Auth::user();
        }

        $bodytype = DB::table('bodytype')->orderBy('type', 'asc')->pluck('type', 'id');
        $height = DB::table('height')->orderBy('height', 'asc')->pluck('height', 'id');
        $breastsize = DB::table('breast_size')->orderBy('size', 'asc')->pluck('size', 'id');
        //$breastsize .= '<option value="0">Select Breast Size</option>';
        return view('front.products.create', compact('bodytype', 'height', 'breastsize', 'user'));
    }

    public function store(Request $request) {
        $validator = validator::make($request->all(), [
                    'product_name' => 'required|max:255',
                    //'product_title' => 'required|max:255',
                    'product_description' => 'required',
                    'product_phone' => 'required|min:6|phone',
                    'product_location' => 'required',
                    'dob' => 'required',
                    'gender' => 'required|numeric|between:1,4',
                    'bodytype' => 'required',
                    'height' => 'required',
                    'breastsize' => 'required',
                    'profile_img1' => 'required|image|mimes:' . Config::get('global.image_mime_type') . '|max:' . Config::get('global.file_max_size'),
                    'profile_img2' => 'image|mimes:' . Config::get('global.image_mime_type') . '|max:' . Config::get('global.file_max_size'),
                    'profile_img3' => 'image|mimes:' . Config::get('global.image_mime_type') . '|max:' . Config::get('global.file_max_size'),
                    'profile_img4' => 'image|mimes:' . Config::get('global.image_mime_type') . '|max:' . Config::get('global.file_max_size'),
                    'profile_img5' => 'image|mimes:' . Config::get('global.image_mime_type') . '|max:' . Config::get('global.file_max_size'),
        ]);
        if ($validator->fails()) {
            return redirect()->action('Front\ProductsController@create')
                            ->withErrors($validator)
                            ->withInput();
        }

        $input = $request->all();
        $input['dob'] = date('Y-m-d', strtotime($input['dob']));
        //pr($input);exit;
        $file1 = $input['profile_img1'];

        if (!empty($file1)) {
            $fileName1 = time() . '_' . $file1->getClientOriginalName();
            $destinationPath = 'public/uploads/';

            //Upload Images One After the Order into folder
            $img = Image::make($file1->getRealPath());
            $watermark = Image::make('public/uploads/watermark.png');
            $img->insert($watermark, 'bottom-right', 10, 10);
            $img->save($destinationPath . '/' . $fileName1);
            $input['profile_img1'] = $fileName1;
        }


        if (Input::hasFile('profile_img2')) {
            $file2 = $input['profile_img2'];
            $fileName2 = time() . '_' . $file2->getClientOriginalName();
            $destinationPath = 'public/uploads/';

            $img = Image::make($file2->getRealPath());
            $watermark = Image::make('public/uploads/watermark.png');
            $img->insert($watermark, 'bottom-right', 10, 10);
            $img->save($destinationPath . '/' . $fileName2);
            $input['profile_img2'] = $fileName2;
        }

//pr($input);exit;
        if (Input::hasFile('profile_img3')) {
            $file3 = $input['profile_img3'];
            $fileName3 = time() . '_' . $file3->getClientOriginalName();
            $destinationPath = 'public/uploads/';

            $img = Image::make($file3->getRealPath());
            $watermark = Image::make('public/uploads/watermark.png');
            $img->insert($watermark, 'bottom-right', 10, 10);
            $img->save($destinationPath . '/' . $fileName3);
            $input['profile_img3'] = $fileName3;
        }


        if (Input::hasFile('profile_img4')) {
            $file4 = $input['profile_img4'];
            $fileName4 = time() . '_' . $file4->getClientOriginalName();
            $destinationPath = 'public/uploads/';

            $img = Image::make($file4->getRealPath());
            $watermark = Image::make('public/uploads/watermark.png');
            $img->insert($watermark, 'bottom-right', 10, 10);
            $img->save($destinationPath . '/' . $fileName4);
            $input['profile_img4'] = $fileName4;
        }


        if (Input::hasFile('profile_img5')) {
            $file5 = $input['profile_img5'];
            $fileName5 = time() . '_' . $file5->getClientOriginalName();
            $destinationPath = 'public/uploads/';

            $img = Image::make($file5->getRealPath());
            $watermark = Image::make('public/uploads/watermark.png');
            $img->insert($watermark, 'bottom-right', 10, 10);
            $img->save($destinationPath . '/' . $fileName5);
            $input['profile_img5'] = $fileName5;
        }
        //pr($input); exit;
        ini_set("upload_max_filesize", "10240M");
        $product = Product::create($input);
        $product->fill($input)->save();

        return redirect()->action('Front\ProductsController@index')->with('alert-sucess', trans('front.PRODUCT_ADDED'));
    }

    public function edit($id) {

        $auth = LoginUser();
        if (empty($auth)) {
            return redirect()->action('Front\HomesController@index');
        }

        $Auth_user = Auth::user();
        $product = Product::find($id);
        if (empty($product)) {
            return $this->InvalidUrl();
        }

        $bodytype = DB::table('bodytype')->orderBy('type', 'asc')->pluck('type', 'id');
        $height = DB::table('height')->orderBy('height', 'asc')->pluck('height', 'id');
        $breastsize = DB::table('breast_size')->orderBy('size', 'asc')->pluck('size', 'id');
        return view('front.products.edit', compact('bodytype', 'height', 'breastsize', 'product'));
    }

    public function update(Request $request, $id) {

        if ($id == '') {
            return $this->InvalidUrl();
        }
        $product = Product::findOrFail($id);
        if (empty($product)) {
            return $this->InvalidUrl();
        }
        $messages = array(
            'product_name.required' => 'Product Name is required.',
            'product_description.required' => 'Product description is required.',
            'product_phone.required' => 'Product Phone is required.',
            'dob.required' => 'dob is required',
            'product_location.required' => 'Product location is required',
            'gender.required' => 'Gender is required',
            'gender.between:1,4' => 'Gender is required',
            'bodytype.required' => 'Body type is required.',
            'height.required' => 'height is required.',
            'breastsize.required' => 'Breastsize is required.',
        );

        $rules = array(
            'product_name' => 'required|max:255',
            //'product_title' => 'required|max:255',
            'product_description' => 'required',
            'product_phone' => 'required|min:6|phone',
            'product_location' => 'required',
            'dob' => 'required',
            'gender' => 'required|numeric|between:1,4',
            'bodytype' => 'required',
            'height' => 'required',
            'breastsize' => 'required',
            //'breast_cup' => 'required',
            //'piercing' => 'required',
            //'tatoos' => 'required',
            //'profile_img2'=>'required|image|mimes:'. Config::get('global.image_mime_type'),
            'profile_img1' => 'image|mimes:' . Config::get('global.image_mime_type') . '|max:' . Config::get('global.file_max_size'),
            'profile_img2' => 'image|mimes:' . Config::get('global.image_mime_type') . '|max:' . Config::get('global.file_max_size'),
            'profile_img3' => 'image|mimes:' . Config::get('global.image_mime_type') . '|max:' . Config::get('global.file_max_size'),
            'profile_img4' => 'image|mimes:' . Config::get('global.image_mime_type') . '|max:' . Config::get('global.file_max_size'),
            'profile_img5' => 'image|mimes:' . Config::get('global.image_mime_type') . '|max:' . Config::get('global.file_max_size'),
        );
        $validator = Validator::make(Input::all(), $rules, $messages);
        /* $validator = validator::make($request->all(), [
          'product_name' => 'required|max:255',
          'product_title' => 'required|max:255',
          'product_description' => 'required',
          'product_phone' => 'required|phone',
          'product_location' => 'required',
          'dob' => 'required',
          'gender' => 'required|numeric|between:1,4',
          'bodytype' => 'required',
          'height' => 'required',
          'breastsize' => 'required',
          ]); */
        if ($validator->fails()) {
            return redirect()->action('Front\ProductsController@edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }
        $input = $request->all();
        if (Input::hasFile('profile_img1')) {
            $file1 = $input['profile_img1'];
            $fileName1 = time() . '_' . $file1->getClientOriginalName();
            $destinationPath = 'public/uploads/';
            $img = Image::make($file1->getRealPath());
            $watermark = Image::make('public/uploads/watermark.png');
            $img->insert($watermark, 'bottom-right', 5, 5);
            $img->save($destinationPath . '/' . $fileName1);
            $input['profile_img1'] = $fileName1;
        }


        if (Input::hasFile('profile_img2')) {
            $file2 = $input['profile_img2'];
            $fileName2 = time() . '_' . $file2->getClientOriginalName();
            $destinationPath = 'public/uploads/';

            $img = Image::make($file2->getRealPath());
            $watermark = Image::make('public/uploads/watermark.png');
            $img->insert($watermark, 'bottom-right', 10, 10);
            $img->save($destinationPath . '/' . $fileName2);
            $input['profile_img2'] = $fileName2;
        }


        if (Input::hasFile('profile_img3')) {
            $file3 = $input['profile_img3'];
            $fileName3 = time() . '_' . $file3->getClientOriginalName();
            $destinationPath = 'public/uploads/';

            $img = Image::make($file3->getRealPath());
            $watermark = Image::make('public/uploads/watermark.png');
            $img->insert($watermark, 'bottom-right', 10, 10);
            $img->save($destinationPath . '/' . $fileName3);
            $input['profile_img3'] = $fileName3;
        }


        if (Input::hasFile('profile_img4')) {
            $file4 = $input['profile_img4'];
            $fileName4 = time() . '_' . $file4->getClientOriginalName();
            $destinationPath = 'public/uploads/';

            $img = Image::make($file4->getRealPath());
            $watermark = Image::make('public/uploads/watermark.png');
            $img->insert($watermark, 'bottom-right', 10, 10);
            $img->save($destinationPath . '/' . $fileName4);
            $input['profile_img4'] = $fileName4;
        }


        if (Input::hasFile('profile_img5')) {
            $file5 = $input['profile_img5'];
            $fileName5 = time() . '_' . $file5->getClientOriginalName();
            $destinationPath = 'public/uploads/';

            $img = Image::make($file5->getRealPath());
            $watermark = Image::make('public/uploads/watermark.png');
            $img->insert($watermark, 'bottom-right', 10, 10);
            $img->save($destinationPath . '/' . $fileName5);
            $input['profile_img5'] = $fileName5;
        }
        $input['dob'] = date('Y-m-d', strtotime($input['dob']));
        $country_list = DB::table('country')->pluck('country_name');
        //echo array_search($country_list, $input['product_location'],true);
        /* if(array_search($input['product_location'],$country_list,true)){
          echo "success";
          }else{
          echo "fail";
          } */
//pr($input);exit;
//pr($country_list);exit;
        if (!empty($input['lat']) || !empty($input['lng'])) {
            if ($product->lat != $input['lat'] || $product->lng != $input['lng']) {
                $contacts = Contact::select('buyer_id')->where('product_id', $product->id)->groupBy('buyer_id')->get();
                foreach ($contacts as $contact) {
                    $notification_data['sender_id'] = $product->seller_id;
                    $notification_data['product_id'] = $product->id;
                    $notification_data['recevier_id'] = $contact->buyer_id;
                    $notification_data['message'] = $product->product_name . ' ' . trans('front.CHANGE_LOCATION') . ' ' . $input['product_location'];
                    $noti_data = Slidernotification::create($notification_data);
                    $noti_data->fill($notification_data)->save();

                    $users = User::select('first_name', 'device_token', 'id', 'profile_img')->where('id', $contact->buyer_id)->get()->toArray();
                    $title = "Update Product";
                    $name = $users['0']['first_name'];
                    $profile_img = $users['0']['profile_img'];
                    $userid = $users['0']['id'];
                    $message = $product->product_name . ' ' . trans('front.CHANGE_LOCATION') . ' ' . $input['product_location'];
                    EmailHelper::sendNotification($title, $message, $users['0']['device_token'], '1', $userid, $name, $profile_img);
                }
            }
        }
        //pr($input);exit;
        $product->fill($input)->save();
        return redirect()->back()->with('alert-sucess', trans('front.PRODUCT_UPDATE'));
    }

    public function destroy($id) {
        //echo $id;exit;
        $product = Product::find($id)->delete();
        return redirect()->action('Front\ProductsController@index');
    }

    public function addwishlist() {

        $product_id = Input::get('product_id');


        $auth = LoginUser();
        if (empty($auth)) {
            return redirect()->action('Front\HomesController@index');
        }
        if (empty(Input::get('product_id'))) {
            echo json_encode(['message' => 'Product Id is missing']);
            exit;
        } else if (empty(Input::get('color_id'))) {
            echo json_encode(['message' => 'Color Id not found.']);
            exit;
        } else {

            $wishlist = Wishlist::where('user_id', $auth->id)
                    ->where('product_id', Input::get('product_id'))
                    ->where('color_id', Input::get('color_id'))->get()->toArray();
            if (!empty($wishlist)) {
                echo json_encode(['message' => 'This product is already in wishlist']);
                exit;
            } else {
                $wishlistData['user_id'] = $auth->id;
                $wishlistData['product_id'] = Input::get('product_id');
                $wishlistData['color_id'] = Input::get('color_id');

                $data = Wishlist::create($wishlistData);
                $data->fill($wishlistData)->save();
                $count = CommonHelpers::count_wishlist($auth->id);
                $wishlistProduct = DB::table('products')
                                ->join('wishlist', 'products.id', '=', 'wishlist.product_id')
                                //->join('images', 'products.id', '=', 'images.product_id')
                                ->where('wishlist.user_id', $auth->id)
                                ->orderby('wishlist.created_at', 'desc')
                                //->groupBy('products.id')
                                ->select('wishlist.id as id','wishlist.product_id as product_id','wishlist.color_id as color_id','products.product_title as product_title', 'products.price as price','products.price_usd as price_usd', 'products.discount as discount', 'products.slug as slug')->get();
                
                $checkstatus = array();
                $i = 0;
            foreach ($wishlistProduct as $wishlistProducts){
                $images = Productimage ::where('product_id', '=', $wishlistProducts->product_id)->where('color_id', $wishlistProducts->color_id)->first();
                $colorLists = CommonHelpers::getProductColor($wishlistProducts->color_id); 
                //pr($images);exit;
                if(CURRENCY == '<i class="fa fa-usd" aria-hidden="true"></i>'){
                    $discount = ($wishlistProducts->discount/100)*$wishlistProducts->price_usd;
                    $discount_price = $wishlistProducts->price_usd-$discount;
                }else{
                 $discount = ($wishlistProducts->discount/100)*$wishlistProducts->price;
		 $discount_price = $wishlistProducts->price-$discount; 
                }
                
                $checkstatus[$i]['id'] = $wishlistProducts->id;
                $checkstatus[$i]['product_id'] = $wishlistProducts->product_id;
                $checkstatus[$i]['color_id'] = $wishlistProducts->color_id;
                $checkstatus[$i]['product_title'] = $wishlistProducts->product_title;
                $checkstatus[$i]['price'] = $discount_price;
                $checkstatus[$i]['discount'] = $discount;
                $checkstatus[$i]['slug'] = $wishlistProducts->slug;
                $checkstatus[$i]['image_name'] = $images->image_name;
                $checkstatus[$i]['color_slug'] = $colorLists->slug;
                $i++;
            }
            //pr($checkstatus);exit;
                //$count = Wishlist::where('buyer_id', $data->buyer_id)->count();
                /* $checkstatus['id'] = $data->id;
                  $checkstatus['buyer_id'] = $data->buyer_id;
                  $checkstatus['product_id'] = $data->product_id; */
                echo json_encode(['message' => 'Successfully added in wishlist', 'status' => 'success', 'count' => $count, 'data' => $checkstatus]);
                exit;
            }
        }
    }

    public function addtocart() {   
        //echo Input::get('wishlist');exit;
        $product_id = Input::get('product_id');
        $session_id = session()->getId();
       $count_wishlist = array();
      $wishlistProduct = array();
        $auth = LoginUser();

        if (empty(Input::get('product_id'))) {
            echo json_encode(['message' => 'Product Id is missing']);
            exit;
        } else {            
            $cartlist = Cart::where('product_id', Input::get('product_id'))
                            ->where('size_id', Input::get('size'))
                            ->where('color_id', Input::get('color_id'));
            if(Auth::check()){
              $cartlist = $cartlist->where('user_id', $auth->id);  
            }else{
              $cartlist = $cartlist->where('session_id', $session_id);  
            }
            $cartlist = $cartlist->get()->toArray();
            
            if (!empty($cartlist)) {
                echo json_encode(['message' => 'This product is already added in your cart']);
                exit;
            } else {
                $checkCountProduct = Productcolor::where('product_id', Input::get('product_id'))
                        ->where('color_id', Input::get('color_id'))
                        ->where('size_id', Input::get('size'))
                    ->where('quantity', '>=', Input::get('qty'))->count();
                $CountProduct = Productcolor::where('product_id', Input::get('product_id'))
                        ->where('color_id', Input::get('color_id'))
                        ->where('size_id', Input::get('size'))
                        ->select('quantity')
                        ->first();
                //pr($checkCountProduct);exit;
                //pr($CountProduct);exit;
                if($checkCountProduct == 0){
                    if($CountProduct->quantity == '0'){
                       echo json_encode(['message' => 'This product is out of stock']);
                   exit;  
                    }else{
                   echo json_encode(['message' => 'Only '.$CountProduct->quantity.' quantity has left in stock']);
                   exit; 
                    }
                }else if($checkCountProduct > 0){
                    if(Auth::check()){
                        if(Input::get('wishlist') == true){
                      $wishlists = Wishlist::where('product_id', Input::get('product_id'))
                        ->where('user_id', $auth->id)
                        ->where('color_id', Input::get('color_id'))->first();
                if(!empty($wishlists)){
                   $wishlist_delete = Wishlist::where('product_id', Input::get('product_id'))
                        ->where('user_id', $auth->id)
                        ->where('color_id', Input::get('color_id'))->delete();
                   //$status = '1';
                }else{
                   //$status = '0'; 
                }
                $status = '1';
                        }else{
                         $status = '0';    
                        }
                  }
                /*if(Input::get('wishlist') == true){
                   $wishlist_delete = Wishlist::where('product_id', Input::get('product_id'))
                        ->where('user_id', $auth->id)
                        ->where('color_id', Input::get('color_id'))->delete();
                   $status = '1';
                }else{
                   $status = '0'; 
                }*/
                
                $cartlistData['session_id'] = $session_id;
                if(Auth::check()){
                $cartlistData['user_id'] = $auth->id;
                }
                $cartlistData['product_id'] = Input::get('product_id');
                $cartlistData['qty'] = Input::get('qty');
                $cartlistData['size_id'] = Input::get('size');
                $cartlistData['color_id'] = Input::get('color_id');
                $cartlistData['price'] = Input::get('price');
                $cartlistData['price_usd'] = Input::get('price_usd');
                $cartlistData['product_name'] = Input::get('product_name');
                $cartlistData['cat_id'] = Input::get('cat_id');
                $cartlistData['sub_cat_id'] = Input::get('sub_cat_id');
                $cartlistData['sub_sub_cat_id'] = Input::get('sub_sub_cat_id');
                $cartlistData['discount'] = Input::get('discount');
                $cartlistData['discount_usd'] = Input::get('discount_usd');

                $data = Cart::create($cartlistData);
                $data->fill($cartlistData)->save();
                if(Auth::check()){
                    /*$count_wishlist = CommonHelpers::count_wishlist($auth->id);
                    $wishlistProduct = DB::table('products')
                                ->join('wishlist', 'products.id', '=', 'wishlist.product_id')
                                ->join('images', 'products.id', '=', 'images.product_id')
                                ->where('wishlist.user_id', $auth->id)
                                ->orderby('wishlist.created_at', 'desc')
                                ->groupBy('products.id')
                                ->select('products.id as id', 'products.product_title as product_title', 'products.price as price', 'products.discount as discount', 'products.slug as slug', 'images.image_name as image_name')->get();*/
                   $userId = $auth->id; 
                }  else {
                    $userId = 0;
                    
                }
                $count = CommonHelpers::count_cartlist($session_id, $userId);
                //$wishlistProduct = "";                
                echo json_encode(['message' => 'Successfully added in cart', 'status' => 'success', 'count' => $count,'count_wishlist' =>$count_wishlist,'data' => $wishlistProduct,'statuscount'=>$status]);
                exit;
                
            }
            }
        }
    }

    public function removewishlist() {
        $product_id = Input::get('product_id');
        $color_id = Input::get('color_id');
        $auth = LoginUser();
        if (empty($auth)) {
            return redirect()->action('Front\HomesController@index');
        }
        if (empty(Input::get('product_id'))) {
            echo json_encode(['message' => 'Product Id is missing']);
            exit;
        }else if (empty(Input::get('color_id'))) {
            echo json_encode(['message' => 'Color Id is missing']);
            exit;
        } else {
            $wishlist = Wishlist::where('user_id', $auth->id)
                    ->where('product_id', Input::get('product_id'))
                    ->where('color_id', Input::get('color_id'))->get()->toArray();

            if (!empty($wishlist)) {
                $wishlist_delete = Wishlist::where('product_id', $product_id)
                        ->where('user_id', $auth->id)
                        ->where('color_id', $color_id)->delete();
                $count = CommonHelpers::count_wishlist($auth->id);
                $wishlistProduct = DB::table('products')
                                ->join('wishlist', 'products.id', '=', 'wishlist.product_id')
                                ->join('images', 'products.id', '=', 'images.product_id')
                                ->where('wishlist.user_id', $auth->id)
                                ->orderby('wishlist.created_at', 'desc')
                                ->groupBy('products.id')
                                ->select('products.id as id', 'products.product_title as product_title', 'products.price as price', 'products.discount as discount', 'products.slug as slug', 'images.image_name as image_name')->get();
                echo json_encode(['message' => 'Successfully removed from wishlist', 'status' => 'success', 'count' => $count, 'data' => $wishlistProduct]);
                exit;
            }
        }
    }

    public function wishlist_detail() { 
        $auth = LoginUser();
        if (!Auth::check()) {
            return redirect()->action('Front\HomesController@index');
        } 

        //echo Input::get('delete');exit;
        /* if(!empty(Input::get('delete'))){
          $wishlist_delete = Wishlist::find(Input::get('delete'))->delete();
          } */
        $products = Product::select('wishlist.id', 'products.id as product_id', 'products.product_name', 'products.product_phone', 'products.product_description', 'products.product_location', 'products.profile_img1', 'products.dob')
                ->join('wishlist', 'wishlist.product_id', '=', 'products.id')
                ->where('wishlist.buyer_id', $auth->id)
                ->paginate(Configure('CONFIG_PAGE_LIMIT'));

        //pr($products);exit;
        return view('front.products.wishlist', compact('products'));
    }

    public function delete_wishlist(Request $request) {
        $input = $request->all();
        //pr($input);exit;
        $wishlist_delete = Wishlist::find($input['delete'])->delete();
        return redirect()->back()->with('alert-sucess', trans('front.PRODUCT_REMOVE_WISHLIST'));
        //return redirect()->action('Front\ProductsController@wishlist_detail');
    }

    public function remove_img() {

        $auth = LoginUser();
        if (empty($auth)) {
            return redirect()->action('Front\HomesController@index');
        }

        if (empty(Input::get('image_name'))) {
            echo json_encode(['message' => 'Image name']);
            exit;
        } elseif (empty(Input::get('produt_id'))) {
            echo json_encode(['message' => 'Product id.']);
            exit;
        } elseif (empty(Input::get('image_field'))) {
            echo json_encode(['message' => 'Image Field.']);
            exit;
        } else {

            $is_update = Product::where('id', Input::get('produt_id'))
                    ->update([Input::get('image_field') => '']);
            if ($is_update) {
                if (file_exists(IMAGE_URL . Input::get('image_name'))) {
                    unlink(IMAGE_URL . Input::get('image_name'));
                }
                echo json_encode(['message' => 'Image Remove Successfuly']);
                exit;
            }
        }
    }

    public function cart_detail() {
        $auth = LoginUser();
        $session_id = session()->getId();
        //$cartId = Input::get('cartId');
        //$cartIds = Input::get('cartIds');
        //$qcartIds = Input::get('qcartIds');
        //$cartremove = Input::get('cartremove');
        //$size_id = Input::get('size_id');
        //$qty_id = Input::get('qty_id');
        if (!empty(Input::get('cartId'))) {
            Cart::where('id', Input::get('cartId'))->delete();
            echo json_encode(array('message' => 'Successfully'));
            exit;
        } else if (!empty(Input::get('cartremove'))) {
            if(!empty($auth)){
                Cart::where('user_id', $auth->id)->delete();
            }else{
                Cart::where('session_id', $session_id)->delete();
            }
            echo json_encode(array('message' => 'Successfully'));
            exit;
        } else if (!empty(Input::get('size_id'))) {
            $is_update = Cart::where('id', Input::get('cartIds'))
                    ->update(['size_id' => Input::get('size_id')]);
            echo json_encode(array('message' => 'Successfully'));
            exit;
        } else if (!empty(Input::get('qty_id'))) {
            $checkCountProduct = Productcolor::where('product_id', Input::get('product_id'))
                        ->where('color_id', Input::get('color_id'))
                        ->where('size_id', Input::get('sizeId'))
                    ->where('quantity', '>=', Input::get('qty_id'))->count();
                $CountProduct = Productcolor::where('product_id', Input::get('product_id'))
                        ->where('color_id', Input::get('color_id'))
                        ->where('size_id', Input::get('sizeId'))
                        ->select('quantity')
                        ->first();
                //pr($checkCountProduct);exit;
                //pr($CountProduct);exit;
                if($checkCountProduct == 0){
                   echo json_encode(['message' => 'Only '.$CountProduct->quantity.' quantity has left in stock']);
                   exit; 
                }else if($checkCountProduct == 1){ 
            
            $is_updates = Cart::where('id', Input::get('qcartIds'))
                    ->update(['qty' => Input::get('qty_id')]);
            echo json_encode(array('message' => 'Successfully'));
            exit;
                }
        }
        //return redirect()->action('Front\ProductsController@index');

        
        
        if(!empty($auth)){
           $user_id = $auth->id;
           $cart_details = Cart::where('user_id', $auth->id)->get();
        }else{
           $cart_details = Cart::where('session_id', $session_id)->get();
           $user_id = 0; 
        }
        $countCart = CommonHelpers::count_cartlist($session_id, $user_id);
        //pr($session_id);exit;
        $qtyList = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16'];
        unset($qtyList['0']);
//pr($cart_details);exit;
        $title = 'Cart';
        return view('front.products.cart_detail', compact('cart_details', 'countCart', 'qtyList','title'));
    }

    public function checkout() {
        $auth = LoginUser();
        if (empty($auth)) {
            return redirect()->action('Front\HomesController@index');
        } 

        $state = ['' => 'Select State'] + DB :: table('state')->where('country', 101)->orderBy('state_name', 'asc')->pluck('state_name', 'id');
        if(!empty($auth->state)){            
        $city = ['' => 'Select City'] + DB::table('city')->where('state', '=', $auth->state)->orderBy('city_name', 'asc')->pluck('city_name', 'id');
        }else{
         $city = ['' => 'Select City'];   
        }
        $session_id = session()->getId();
        if(!empty($auth)){
            $userId = $auth->id;
            $cart_details = Cart::where('user_id', $auth->id)->get();
        }else{
            $userId = 0;
            $cart_details = Cart::where('session_id', $session_id)->get();
        }
        $countCart = CommonHelpers::count_cartlist($session_id, $userId);
        $price = 0;
        $discount = 0;
        foreach ($cart_details as $cart_detail) {
            if(CURRENCY == '<i class="fa fa-usd" aria-hidden="true"></i>'){
                $price = $price + $cart_detail->qty * $cart_detail->price_usd;
                $discount = $discount + $cart_detail->qty * $cart_detail->discount_usd;
            }else{
                $price = $price + $cart_detail->qty * $cart_detail->price;
                $discount = $discount + $cart_detail->qty * $cart_detail->discount;
            }
        }
        
        //echo Session::get('ORDER_NO');exit;
        if (Session::has('ORDER_NO')) {
            $order_no = Session::get('ORDER_NO');
            $order_id = Order::select('id')->where('order_no', $order_no)->first();
            //$orders = Order::where('order_no', $session_order_no)->delete();
            $is_update = Order::where('order_no', $order_no)
                    ->update(['item_total' => $countCart,'item_total_amount' => $price,
                        'discount' => $discount,'shipping_amount' => Configure('CONFIG_SHIPPING_AMOUNT')]);
            //pr($is_update);exit;
            $order_details = Orderdetail::where('order_no', $order_no)->delete();
            //if($order_details){
            foreach ($cart_details as $cart_detail) {
            $data['user_id'] = $userId;
            $data['order_id'] = $order_id->id;
            $data['order_no'] = $order_no;
            $data['product_id'] = $cart_detail->product_id;
            $data['size_id'] = $cart_detail->size_id;
            $data['color_id'] = $cart_detail->color_id;
            $data['quantity'] = $cart_detail->qty;
            $data['product_name'] = $cart_detail->product_name;
            if(CURRENCY == '<i class="fa fa-usd" aria-hidden="true"></i>'){
            $data['unit_price'] = $cart_detail->price_usd;
            $data['discount'] = $cart_detail->discount_usd;
            }else{
             $data['unit_price'] = $cart_detail->price;
             $data['discount'] = $cart_detail->discount;
            }

            $order_detail = Orderdetail::create($data);
            $order_detail->fill($data)->save();
        }
            //}
        }else{     
        $order_no = rand(1, 1000000000);
        Session::put('ORDER_NO', $order_no);
        
        $input['user_id'] = $userId;
        $input['order_no'] = $order_no;
        $input['item_total'] = $countCart;
        $input['item_total_amount'] = $price;
        $input['discount'] = $discount;        
        $input['shipping_amount'] = Configure('CONFIG_SHIPPING_AMOUNT');
        
        
        $input['first_name'] = $auth->first_name;
        $input['last_name'] = $auth->last_name;
        $input['email'] = $auth->email;
        $input['phone'] = $auth->phone;
        $input['address_1'] = $auth->address_1;
        $input['address_2'] = $auth->address_2;
        $input['pincode'] = $auth->pincode;
        $input['city'] = $auth->city;
        $input['state'] = $auth->state;
        
        $order = Order::create($input);
        $order->fill($input)->save();
        
        
        foreach ($cart_details as $cart_detail) {
            $data['user_id'] = $userId;
            $data['order_id'] = $order->id;
            $data['order_no'] = $order->order_no;
            $data['product_id'] = $cart_detail->product_id;
            $data['size_id'] = $cart_detail->size_id;
            $data['color_id'] = $cart_detail->color_id;
            $data['quantity'] = $cart_detail->qty;
            $data['product_name'] = $cart_detail->product_name;
            if(CURRENCY == '<i class="fa fa-usd" aria-hidden="true"></i>'){
            $data['unit_price'] = $cart_detail->price_usd;
            $data['discount'] = $cart_detail->discount_usd;
            }else{
             $data['unit_price'] = $cart_detail->price;
             $data['discount'] = $cart_detail->discount;
            }

            $order_detail = Orderdetail::create($data);
            $order_detail->fill($data)->save();
        }
        }

        $users = DB::table('orders')
                        ->where('orders.order_no', Session::get('ORDER_NO'))
                        ->select('orders.id as id', 'orders.first_name as first_name', 'orders.last_name as last_name', 'orders.email as email', 'orders.phone as phone', 'orders.address_1 as address_1', 'orders.address_2 as address_2', 'orders.pincode as pincode', 'orders.city as city', 'orders.state as state')->get();
         $title = 'Checkout';
        if(isset($users[0]->state) && !empty($users[0]->state)){
         $state_name = DB :: table('state')->where('country', 101)->where('id', $users[0]->state)->first();
        }else{
           $state_name = ""; 
        }
        if(isset($users[0]->city) && !empty($users[0]->city)){
             $city_name = DB :: table('city')->where('id', $users[0]->city)->first();            
        }else{
            $city_name = "";
        }
        //pr($city_name);exit;
        return view('front.products.checkout', compact('city_name','state_name','title','cart_details', 'countCart', 'users', 'state', 'city', 'order_no','price'));
    }

    public function guest_checkout() {
        $state = ['' => 'Select State'] + DB :: table('state')->where('country', 101)->orderBy('state_name', 'asc')->pluck('state_name', 'id');
        $city = ['' => 'Select City'];
        $session_id = session()->getId();
        $userId = 0;
        $cart_details = Cart::where('session_id', $session_id)->get();       
        $countCart = CommonHelpers::count_cartlist($session_id, $userId);
        $price = 0;
        $discount = 0;
        foreach ($cart_details as $cart_detail) {
            if(CURRENCY == '<i class="fa fa-usd" aria-hidden="true"></i>'){
                $price = $price + $cart_detail->qty * $cart_detail->price_usd;
                $discount = $discount + $cart_detail->qty * $cart_detail->discount_usd;
                //$unit_price = $cart_detail->price_usd;
            }else{
                $price = $price + $cart_detail->qty * $cart_detail->price;
                $discount = $discount + $cart_detail->qty * $cart_detail->discount;
                //$unit_price = $cart_detail->price;
            }
        }
        
        if (Session::has('ORDER_NO')) {
            $order_no = Session::get('ORDER_NO');
            $order_id = Order::select('id')->where('order_no', $order_no)->first();
            //$orders = Order::where('order_no', $session_order_no)->delete();
            //$order_details = Orderdetail::where('order_no', $session_order_no)->delete();
            $is_update = Order::where('order_no', $order_no)
                    ->update(['item_total' => $countCart,'item_total_amount' => $price,
                        'discount' => $discount,'shipping_amount' => Configure('CONFIG_SHIPPING_AMOUNT')]);
            
            $order_details = Orderdetail::where('order_no', $order_no)->delete();
            //if($order_details){
            foreach ($cart_details as $cart_detail) {
            $data['user_id'] = 0;
            $data['order_id'] = $order_id->id;
            $data['order_no'] = $order_no;
            $data['product_id'] = $cart_detail->product_id;
            $data['size_id'] = $cart_detail->size_id;
            $data['color_id'] = $cart_detail->color_id;
            $data['quantity'] = $cart_detail->qty;
            $data['product_name'] = $cart_detail->product_name;
            if(CURRENCY == '<i class="fa fa-usd" aria-hidden="true"></i>'){
            $data['unit_price'] = $cart_detail->price_usd;
            $data['discount'] = $cart_detail->discount_usd;
            }else{
             $data['unit_price'] = $cart_detail->price;
             $data['discount'] = $cart_detail->discount;
            }

            $order_detail = Orderdetail::create($data);
            $order_detail->fill($data)->save();
            }
            
        }else{
            $order_no = rand(1, 1000000000);       
            Session::put('ORDER_NO', $order_no);
        
            
        
        $input['user_id'] = 0;
        $input['order_no'] = $order_no;
        $input['item_total'] = $countCart;
        $input['item_total_amount'] = $price;
        $input['discount'] = $discount;        
        $input['shipping_amount'] = Configure('CONFIG_SHIPPING_AMOUNT');
        
        $order = Order::create($input);
        $order->fill($input)->save();

        foreach ($cart_details as $cart_detail) {
            $data['user_id'] = 0;
            $data['order_id'] = $order->id;
            $data['order_no'] = $order->order_no;
            $data['product_id'] = $cart_detail->product_id;
            $data['size_id'] = $cart_detail->size_id;
            $data['color_id'] = $cart_detail->color_id;
            $data['quantity'] = $cart_detail->qty;
            $data['product_name'] = $cart_detail->product_name;
            if(CURRENCY == '<i class="fa fa-usd" aria-hidden="true"></i>'){
            $data['unit_price'] = $cart_detail->price_usd;
            $data['discount'] = $cart_detail->discount_usd;
            }else{
             $data['unit_price'] = $cart_detail->price; 
             $data['discount'] = $cart_detail->discount;
            }

            $order_detail = Orderdetail::create($data);
            $order_detail->fill($data)->save();
        }
        }
//pr($cart_details);exit;
        $users = DB::table('orders')
                        ->where('orders.order_no', Session::get('ORDER_NO'))
                        ->select('orders.id as id', 'orders.first_name as first_name', 'orders.last_name as last_name', 'orders.email as email', 'orders.phone as phone', 'orders.address_1 as address_1', 'orders.address_2 as address_2', 'orders.pincode as pincode', 'orders.city as city', 'orders.state as state')->get();
         $title = 'Checkout';
        if(isset($users[0]->state) && !empty($users[0]->state)){
         $state_name = DB :: table('state')->where('country', 101)->where('id', $users[0]->state)->first();
        }else{
           $state_name = ""; 
        }
        if(isset($users[0]->city) && !empty($users[0]->city)){
             $city_name = DB :: table('city')->where('id', $users[0]->city)->first();            
        }else{
            $city_name = "";
        }
         $title = 'Guest Checkout';
        return view('front.products.guest_checkout', compact('city_name','state_name','users','title','cart_details', 'countCart', 'state', 'city', 'order_no','price'));
    }
   
    public function by_now_post() { 
        $productId = Input::get('product_id');
        $qty = Input::get('qty');
        $size = Input::get('size');
        $color_id = Input::get('color_id');
        if(CURRENCY == '<i class="fa fa-usd" aria-hidden="true"></i>'){
         $price = Input::get('price_usd');
         $discount = Input::get('discount_usd');
        }else{
         $price = Input::get('price');
         $discount = Input::get('discount');  
        }
        $product_name = Input::get('product_name');
        $cat_id = Input::get('cat_id');
        $sub_cat_id = Input::get('sub_cat_id');
        $sub_sub_cat_id = Input::get('sub_sub_cat_id');
        
        $checkCountProduct = Productcolor::where('product_id', Input::get('product_id'))
                        ->where('color_id', Input::get('color_id'))
                        ->where('size_id', Input::get('size'))
                    ->where('quantity', '>=', Input::get('qty'))->count();
                $CountProduct = Productcolor::where('product_id', Input::get('product_id'))
                        ->where('color_id', Input::get('color_id'))
                        ->where('size_id', Input::get('size'))
                        ->select('quantity')
                        ->first();
                //pr($checkCountProduct);exit;
                //pr($CountProduct);exit;
                if($checkCountProduct == 0){
                   echo json_encode(['message' => 'Only '.$CountProduct->quantity.' quantity has left in stock']);
                   exit; 
                }else if($checkCountProduct == 1){ 
                    
        if (Auth::check()) {
             $auth = LoginUser();
             $wishlists = Wishlist::where('product_id', Input::get('product_id'))
                        ->where('user_id', $auth->id)
                        ->where('color_id', Input::get('color_id'))->first();
             
             if(!empty($wishlists)){
                   $wishlist_delete = Wishlist::where('product_id', Input::get('product_id'))
                        ->where('user_id', $auth->id)
                        ->where('color_id', Input::get('color_id'))->delete();
                   $status = '1';
                }else{
                   $status = '0'; 
                }
            $userId = $auth->id;
            $input['first_name'] = $auth->first_name;
        $input['last_name'] = $auth->last_name;
        $input['email'] = $auth->email;
        $input['phone'] = $auth->phone;
        $input['address_1'] = $auth->address_1;
        $input['address_2'] = $auth->address_2;
        $input['pincode'] = $auth->pincode;
        $input['city'] = $auth->city;
        $input['state'] = $auth->state;
         }else{
             $userId = 0;
         }
         
        $item_total_amount = $price*$qty;
        $discount_total = $discount*$qty;
        $order_no ='';
        //session()->forget('ORDER_NO');
        
        
        if (Session::has('ORDER_NO') && Session::get('ORDER_NO') != 'undefined') { 
            $order_no = Session::get('ORDER_NO');
            
            $order_id = Order::select('id')->where('order_no', $order_no)->first();
            //$orders = Order::where('order_no', $session_order_no)->delete();
            //$order_details = Orderdetail::where('order_no', $session_order_no)->delete();
            $is_update = Order::where('order_no', $order_no)
                    ->update(['item_total' => Input::get('qty'),'item_total_amount' => $item_total_amount,
                        'discount' =>$discount_total,'shipping_amount' => Configure('CONFIG_SHIPPING_AMOUNT')]);
            
            $order_details = Orderdetail::where('order_no', $order_no)->delete();
            //if($order_details){
            //foreach ($cart_details as $cart_detail) {
            $data['user_id'] = $userId;
            $data['order_id'] = $order_id->id;
            $data['order_no'] = $order_no;
            $data['product_id'] = $productId;
            $data['size_id'] = $size;
            $data['color_id'] = $color_id;
            $data['quantity'] = $qty;
            $data['product_name'] = $product_name;
            $data['unit_price'] = $price;

            $order_detail = Orderdetail::create($data);
            $order_detail->fill($data)->save();
            //}
            
        }else{ 
            $order_no = rand(1, 1000000000);       
            Session::put('ORDER_NO', $order_no);
        
           
        $input['user_id'] = $userId;
        $input['order_no'] = $order_no;
        $input['item_total'] = Input::get('qty');
        $input['item_total_amount'] = $item_total_amount;
        $input['discount'] = $discount_total;        
        $input['shipping_amount'] = Configure('CONFIG_SHIPPING_AMOUNT');
        
        $order = Order::create($input);
        $order->fill($input)->save();

        //foreach ($cart_details as $cart_detail) {
            $data['user_id'] = $userId;
            $data['order_id'] = $order->id;
            $data['order_no'] = $order->order_no;
            $data['product_id'] = $productId;
            $data['size_id'] = $size;
            $data['color_id'] = $color_id;
            $data['quantity'] = $qty;
            $data['product_name'] = $product_name;
            $data['unit_price'] = $price;

            $order_detail = Orderdetail::create($data);
            $order_detail->fill($data)->save();
        //}
        }
//pr($order_detail);exit;
    
        echo json_encode(array('message'=>'success', 'order'=>$order_no));
        //echo $order_no = Session::get('ORDER_NO');
exit;
    }
        //return view('front.products.guest_bynow', compact('state', 'city', 'order_no','price','size','color_id','qty','productId'));
    }
    
    public function bynow($order_no) {
        //echo $order_no = Session::get('ORDER_NO');exit;
        $state = ['' => 'Select State'] + DB :: table('state')->where('country', 101)->orderBy('state_name', 'asc')->pluck('state_name', 'id');
        $city = ['' => 'Select City'];
        Session::put('ORDER_NO', $order_no);
        //if (Session::has('ORDER_NO')) {
        $order_no = $order_no;
        $order_details = Orderdetail::where('order_no', $order_no)->first();
        $orders = Order::where('order_no', $order_no)->first();
        //pr($order_details);exit;
        //} 
        
        $users = DB::table('orders')
                        //->join('city', 'orders.city', '=', 'city.id')
                        //->join('state', 'orders.state', '=', 'state.id')
                        ->where('orders.order_no', $order_no)
                        ->select('orders.id as id', 'orders.first_name as first_name', 'orders.last_name as last_name', 'orders.email as email', 'orders.phone as phone', 'orders.address_1 as address_1', 'orders.address_2 as address_2', 'orders.pincode as pincode', 'orders.city as city', 'orders.state as state')->get();
        if (isset($users[0]->state) && !empty($users[0]->state)) {
                $state_name = DB :: table('state')->where('country', 101)->where('id', $users[0]->state)->first();
            } else {
                $state_name = "";
            }
            if (isset($users[0]->city) && !empty($users[0]->city)) {
                $city_name = DB :: table('city')->where('id', $users[0]->city)->first();
            } else {
                $city_name = "";
            }
        $title = 'Checkout By Now';
        return view('front.products.guest_bynow', compact('city_name','state_name','users','title','order_details', 'state', 'city', 'order_no','orders'));
    }
    
    public function bynow_checkout($order_no) {
        $state = ['' => 'Select State'] + DB :: table('state')->where('country', 101)->orderBy('state_name', 'asc')->pluck('state_name', 'id');
        $city = ['' => 'Select City'];
        Session::put('ORDER_NO', $order_no);
        //if (Session::has('ORDER_NO')) {
        $order_no = $order_no;
        $order_details = Orderdetail::where('order_no', $order_no)->first();
        $orders = Order::where('order_no', $order_no)->first();
        //pr($order_details);
        //pr($orders);exit;
        //} 
         $auth = LoginUser();
         //$countCart = CommonHelpers::count_cartlist($session_id, $userId);
        /*$users = DB::table('orders')
                        ->join('city', 'orders.city', '=', 'city.id')
                        ->join('state', 'orders.state', '=', 'state.id')
                        ->where('orders.order_no', $order_no)
                        ->select('orders.id as id', 'orders.first_name as first_name', 'orders.last_name as last_name', 'orders.email as email', 'orders.phone as phone', 'orders.address_1 as address_1', 'orders.address_2 as address_2', 'orders.pincode as pincode', 'city.city_name as city_name', 'state.state_name as state_name')->get();*/
        $users = DB::table('orders')
                        //->join('city', 'orders.city', '=', 'city.id')
                        //->join('state', 'orders.state', '=', 'state.id')
                        ->where('orders.order_no', $order_no)
                        ->select('orders.id as id', 'orders.first_name as first_name', 'orders.last_name as last_name', 'orders.email as email', 'orders.phone as phone', 'orders.address_1 as address_1', 'orders.address_2 as address_2', 'orders.pincode as pincode', 'orders.city as city', 'orders.state as state')->get();
        if (isset($users[0]->state) && !empty($users[0]->state)) {
                $state_name = DB :: table('state')->where('country', 101)->where('id', $users[0]->state)->first();
            } else {
                $state_name = "";
            }
            if (isset($users[0]->city) && !empty($users[0]->city)) {
                $city_name = DB :: table('city')->where('id', $users[0]->city)->first();
            } else {
                $city_name = "";
            }
//pr($users);exit;
        $title = 'Checkout By Now';
        return view('front.products.checkout_bynow', compact('city_name','state_name','title','users','order_details', 'state', 'city', 'order_no','orders'));
    }
   
    
    
    public function postNewAddress() {
        $auth = LoginUser();
        $pincodes = Pincode::where('pincode', Input::get('pincode'))->where('status', '=', '1')->first();
        
        if (empty(Input::get('email'))) {
            echo json_encode(['message' => 'Please enter email id']);
            exit;
        }/* else if (empty($pincodes)) {
            echo json_encode(['message' => 'Delivery is not available at this location.']);
            exit;
        }*/else {
            
            
            $input['first_name'] = Input::get('first_name');
            $input['last_name'] = Input::get('last_name');
            $input['email'] = Input::get('email');
            $input['phone'] = Input::get('phone');
            $input['address_1'] = Input::get('address_1');
            $input['address_2'] = Input::get('address_2');
            $input['pincode'] = Input::get('pincode');
            $input['city'] = Input::get('city');
            $input['state'] = Input::get('state');
//pr($input);
            //if (Session::has('ORDER_NO')) {
                $session_order_no = Session::get('ORDER_NO'); 
                $order = Order::select('id')->where('order_no', $session_order_no)->first();
                $orders = Order::findOrFail($order->id);
                $orders->fill($input)->save();
            /*}else{
                $order_data = Order::create($input);
                $order_data->fill($input)->save();
            }*/
            
            if(Input::get('make_default') == 'yes'){
                unset($input['email']);
              $users = User::findOrFail($auth->id);
              $users->fill($input)->save();  
            }

            echo json_encode(['message' => 'Shipping Address Added Successfully']);
            exit;
        }
    }
    
    public function check_stock() {
        $data = array();
        $session_id = session()->getId();
         if (Auth::check()) {
             $auth = LoginUser();
            $carts = Cart::where('user_id', $auth->id)->get();
         }else{
             $carts = Cart::where('session_id', $session_id)->get();
         }
         //pr($carts);exit;
       
        if (!empty($carts)){
            $i = 1;
            foreach($carts as $cart){            
                $checkCountProduct = Productcolor::where('product_id', $cart->product_id)
                        ->where('color_id', $cart->color_id)
                        ->where('size_id', $cart->size_id)
                    ->where('quantity', '>=', $cart->qty)->count();
                //pr($checkCountProduct);exit;
                $CountProduct = Productcolor::where('product_id', $cart->product_id)
                        ->where('color_id', $cart->color_id)
                        ->where('size_id', $cart->size_id)
                        ->select('quantity')
                        ->first();
                $data[$i]['product_id'] = $cart->product_id;
                $data[$i]['color_id'] = $cart->color_id;
                $data[$i]['size_id'] = $cart->size_id;
                $data[$i]['stock'] = $checkCountProduct;
                /*if($checkCountProduct == 0){
                       echo json_encode(['message' => 'This product is out of stock', 'status' => 'fail','data'=>$data]);
                   exit;  
                }else if($checkCountProduct == 1){                               
                echo json_encode(['message' => 'Success', 'status' => 'success']);
                exit;
                
            }*/
            
            $i++;
                }
             echo json_encode(['message' => 'This product is out of stock', 'status' => 'success','data'=>$data]);
                   exit;
            
        }
    }

}
