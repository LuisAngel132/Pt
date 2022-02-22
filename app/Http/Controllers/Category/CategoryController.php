<?php

namespace App\Http\Controllers\Category;

use Redirect;
use App\Models\Lang;
use App\Models\Size;
use App\Models\Design;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\ProductsColor;
use App\Models\CategoriesDesign;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\BaseCategoryTranslation;
use App\Models\ProductGenreTranslation;
use App\Models\ProductStyleTranslation;

/**
 * Controls the data flow into a category object and updates the view whenever data changes.
 */
class CategoryController extends Controller
{
    /**
     * The user repository instance.
     */
    protected $size;
    protected $lang;
    protected $design;
    protected $product;
    protected $customer;
    protected $productsColor;
    protected $categoriesDesign;
    protected $productStyleTranslation;
    protected $baseCategoryTranslation;
    protected $productGenreTranslation;

    /**
     *
     * @param      \App\Models\Product                  $product                  The product
     * @param      \App\Models\BaseCategoryTranslation  $baseCategoryTranslation  The base category translation
     * @param      \App\Models\Lang                     $lang                     The language
     * @param      \App\Models\Design                   $design                   The design
     * @param      \App\Models\CategoriesDesign         $categoriesDesign         The categories design
     * @param      \App\Models\ProductGenreTranslation  $productGenreTranslation  The product genre translation
     * @param      \App\Models\Size                     $size                     The size
     * @param      \App\Models\ProductStyleTranslation  $productStyleTranslation  The product style translation
     */

    public function __construct(Product $product, BaseCategoryTranslation $baseCategoryTranslation, Lang $lang, Design $design, CategoriesDesign $categoriesDesign, ProductGenreTranslation $productGenreTranslation, Size $size, ProductStyleTranslation $productStyleTranslation, Customer $customer, ProductsColor $productsColor)
    {

        $this->size                    = $size;
        $this->lang                    = $lang;
        $this->design                  = $design;
        $this->customer                = $customer;
        $this->product                 = $product;
        $this->productsColor           = $productsColor;
        $this->categoriesDesign        = $categoriesDesign;
        $this->productStyleTranslation = $productStyleTranslation;
        $this->baseCategoryTranslation = $baseCategoryTranslation;
        $this->productGenreTranslation = $productGenreTranslation;
        $this->redirect                = Redirect::to('category');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lang = $this->getSessionLang($request);
        $id   = Auth::id();
        if ($id == '') {
            $producs_all = $this->product->with([
                'productTranslations' => function ($query) use ($lang) {
                    $query->where('langs_id', $lang->id);
                },
                'productsColors.resources.galleries',
                'productsDesigns.designs.categoriesDesigns',
                'productsColors.colors',
            ])->when($request->has('categories_id'), function ($callback) use ($request) {
                return $callback->whereHas('productsDesigns.designs.categoriesDesigns', function ($query) use ($request) {
                    $query->where('base_categories_id', $request->categories_id);
                });
            })->when($request->has('styles_id'), function ($query) use ($request) {
                return $query->where('product_styles_id', $request->styles_id);
            })->when($request->has('genres_id'), function ($query) use ($request) {
                return $query->where('product_genres_id', $request->genres_id);
            }, function ($query) {
                return $query;
            })
                ->whereHas('productsColors', function ($productsColors) {
                    $productsColors->where('is_active', 1);
                })
                ->where('is_active', 1)
                ->get();
            $auth = $id;
        } else {
            $customer    = $this->customer->where('users_id', $id)->first();
            $producs_all = $this->product->with([
                'productTranslations' => function ($query) use ($lang) {
                    $query->where('langs_id', $lang->id);
                },
                'productsColors.resources.galleries',
                'productsDesigns.designs.categoriesDesigns',
                'productsColors.colors',
                'customerLikes'       => function ($query) use ($customer) {
                    $query->where('customers_id', $customer->id);
                },
            ])->when($request->has('categories_id'), function ($callback) use ($request) {
                return $callback->whereHas('productsDesigns.designs.categoriesDesigns', function ($query) use ($request) {
                    $query->where('base_categories_id', $request->categories_id);
                });
            })->when($request->has('styles_id'), function ($query) use ($request) {
                return $query->where('product_styles_id', $request->styles_id);
            })->when($request->has('genres_id'), function ($query) use ($request) {
                return $query->where('product_genres_id', $request->genres_id);
            }, function ($query) {
                return $query;
            })
                ->whereHas('productsColors', function ($productsColors) {
                    $productsColors->where('is_active', 1);
                })
                ->where('is_active', 1)
                ->get();
            $auth = $id;
        }
        /*Only the products have products-colors*/
        $array_producs = [];
        foreach ($producs_all as $value) {
            if (count($value->productsColors) != 0) {
                array_push($array_producs, $value);
            }
        }
        /*pagination array src= https://styde.net/paginacion-personalizada-en-laravel-sin-eloquent/*/
        // Get current page form url e.x. &page=1
        $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
        // Create a new Laravel collection from the array data
        $itemCollection = collect($array_producs);
        // Define how many items we want to be visible in each page
        $perPage = 9;
        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        // Create our paginator and pass it to the view
        $producs = new \Illuminate\Pagination\LengthAwarePaginator($currentPageItems, count($itemCollection), $perPage);
        // set url path for generted links
        $producs->setPath($request->url());

        $categories = $this->baseCategoryTranslation->where('langs_id', $lang->id)
            ->with('baseCategories')
            ->whereHas('baseCategories', function ($query) {
                $query->where('is_active', 1);
            })
            ->get();
        $genres = $this->productGenreTranslation->where('langs_id', $lang->id)
            ->with('productGenres')
            ->whereHas('productGenres', function ($query) {
                $query->where('is_active', 1);
            })
            ->get();
        $styles = $this->productStyleTranslation->with('productStyles.styleResources')
            ->where('langs_id', $lang->id)
            ->whereHas('productStyles', function ($query) {
                $query->where('is_active', 1);
            })
            ->get();
        return view('ecommerce.category', compact('producs', 'categories', 'genres', 'styles', 'auth'));

    }

    /**
     * Gets the category.
     *
     * @param      \Illuminate\Http\Request  $request  The request
     *
     * @return                     The category.
     */
    public function getCategory(Request $request)
    {

        if ($request->ajax()) {
            $lang = $this->getSessionLang($request);

            return $this->baseCategoryTranslation->where('langs_id', $lang->id)->get();
        } else {
            return $this->redirect;
        }
    }

    /**
     * Gets the gender.
     *
     * @param      \Illuminate\Http\Request  $request  The request
     *
     * @return       The gender.
     */
    public function getGender(Request $request)
    {
        if ($request->ajax()) {
            $lang = $this->getSessionLang($request);
            return $this->productGenreTranslation->where('langs_id', $lang->id)->get();
        } else {
            return $this->redirect;
        }
    }

    /**
     * Gets the style.
     *
     * @param      \Illuminate\Http\Request  $request  The request
     *
     * @return      The style.
     */
    public function getStyle(Request $request)
    {
        if ($request->ajax()) {
            $lang = $this->getSessionLang($request);
            return $this->productStyleTranslation->with('productStyles.styleResources')->where('langs_id', $lang->id)->get();
        } else {
            return $this->redirect;
        }
    }

    /**
     * Gets the size.
     *
     * @param      \Illuminate\Http\Request  $request  The request
     *
     * @return     <type>                    The size.
     */
    public function getSize(Request $request, $id)
    {
        if ($request->ajax()) {
            $lang       = $this->getSessionLang($request);
            $collection = collect($this->productsColor
                    ->where('products_id', $id)
                    ->where('is_active', 1)
                    ->with('size')
                    ->get());
            return $collection->groupBy('sizes_id');

        } else {
            return $this->redirect;
        }
    }

    /**
     * Gets the session language.
     *
     * @param      \Illuminate\Http\Request  $request  The request
     *
     * @return     \Illuminate\Http\Request  The session language.
     */
    public function getSessionLang(Request $request)
    {
        $data = $request->session()->all();
        if ($request->session()->has('lang')) {
            $iso_code = $request->session()->get('lang'); // si existe imprime el valor de la variable mensaje
            return $this->lang->where('iso_code', $iso_code)->first();
        } else {
            return $this->lang->where('iso_code', 'es')->first();
        }
    }

    public function filter(Request $request)
    {
        try {
            $lang           = $this->getSessionLang($request);
            return $producs = $this->product->with([
                'productTranslations' => function ($query) use ($lang) {
                    $query->where('langs_id', $lang->id);
                }, 'productsColors.resources',
                'productsDesigns.designs.categoriesDesigns',
                'productsColors.colors',
            ])->whereHas('productsDesigns.designs.categoriesDesigns', function ($query) use ($request) {
                $query->where('base_categories_id', $request->id_category);
            })->where
                ->paginate(10);
        } catch (Exception $e) {

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        if ($request->ajax()) {
            $id_auth = Auth::id();
            if ($id_auth == "") {
                $lang = $this->getSessionLang($request);
                return $this->product->with([
                    'productTranslations' => function ($query) use ($lang) {
                        $query->where('langs_id', $lang->id);
                    }, 'productsColors.resources',
                    'productTranslations.langs',
                    'productsColors.colors',
                ])
                    ->where('id', $id)->get();
            } else {
                $customer = $this->customer::where('users_id', $id_auth)->first();
                $lang     = $this->getSessionLang($request);
                return $this->product->with([
                    'productTranslations' => function ($query) use ($lang) {
                        $query->where('langs_id', $lang->id);
                    }, 'productsColors.resources',
                    'productTranslations.langs',
                    'productsColors.colors',
                    'customerLikes'       => function ($query) use ($customer) {
                        $query->where('customers_id', $customer->id);
                    },
                ])
                    ->where('id', $id)->get();
            }

        } else {
            return $this->redirect;
        }
    }

}
