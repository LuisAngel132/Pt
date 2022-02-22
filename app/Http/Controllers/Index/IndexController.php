<?php

namespace App\Http\Controllers\Index;

use Auth;
use Redirect;
use App\Models\Lang;
use App\Models\Design;
use GuzzleHttp\Client;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\ProductsDesign;
use App\Http\Controllers\Controller;
use App\Models\BaseCategoryTranslation;

/**
 * Controls the data flow into an index object and updates the view whenever data changes.
 */
class IndexController extends Controller
{

    /**
     * The user repository instance.
     */
    protected $lang;
    protected $product;
    protected $design;
    protected $baseCategoryTranslation;
    protected $customer;
    /**
     *
     * @param      \App\Models\Product                  $product                  The product
     * @param      \App\Models\BaseCategoryTranslation  $baseCategoryTranslation  The base category translation
     * @param      \App\Models\Lang                     $lang                     The language
     * @param      \App\Models\Design                   $design                   The design
     */
    public function __construct(Product $product, BaseCategoryTranslation $baseCategoryTranslation, Lang $lang, Design $design, ProductsDesign $productsDesign, Customer $customer)
    {
        $this->lang                    = $lang;
        $this->design                  = $design;
        $this->product                 = $product;
        $this->baseCategoryTranslation = $baseCategoryTranslation;
        $this->customer                = $customer;
        $this->redirect                = Redirect::to('inicio');
    }

    /**
     * Gets the token login.
     * @param      \Illuminate\Http\Request  $request  The request
     * @return     <type>                    The token login.
     */
    public function getToken(Request $request)
    {
        return $request->session()->get('token');
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lang  = $this->getSessionLang($request);
        $token = $this->getToken($request);
        if ($token == '') {
            /*
            not logged in*/
            $client = new Client([]);
            $query  = $client->request('GET', config('constants.BASE_URL') . '/v1/products/top', [
                'headers' => [
                    'Accept-Language' => $lang->iso_code,
                ],
            ]);
            $data     = $query->getBody();
            $response = json_decode($data, true);
            $top      = collect($response['data']['best_sellers']);

            /*Products new*/
            $productsnew_all = $this->product->with([
                'productTranslations' => function ($query) use ($lang) {
                    $query->where('langs_id', $lang->id);
                },
                'productsColors.resources.galleries',
                'productsDesigns',
                'productsColors.colors',
            ])
                ->whereHas('productsColors', function ($productsColors) {
                    $productsColors->where('is_active', 1);
                })
                ->where('is_active', 1)
                ->orderBy('created_at', 'desc')
                ->get();
            /*Only the products have products-colors*/
            $array_products_new = [];
            foreach ($productsnew_all as $value) {
                if (count($value->productsColors) != 0) {
                    array_push($array_products_new, $value);
                }
            }
            $productsnew = collect($array_products_new)->take(5);
            $id          = '';
            return view('ecommerce.index', compact('top', 'productsnew', 'id'));

        } else {
            $client = new Client([]);
            $query  = $client->request('GET', config('constants.BASE_URL') . '/v1/products/top', [
                'headers' => [
                    'Authorization'   => 'Bearer ' . $token,
                    'Accept-Language' => $lang->iso_code,
                ],
            ]);
            $data     = $query->getBody();
            $response = json_decode($data, true);
            $top      = collect($response['data']['best_sellers']);

            /*Products new*/
            $customer        = $this->customer->where('users_id', Auth::id())->first();
            $productsnew_all = $this->product->with([
                'productTranslations' => function ($query) use ($lang) {
                    $query->where('langs_id', $lang->id);
                },
                'productsColors.resources.galleries',
                'productsDesigns',
                'productsColors.colors',
                'customerLikes'       => function ($query) use ($customer) {
                    $query->where('customers_id', $customer->id);
                },
            ])
                ->whereHas('productsColors', function ($productsColors) {
                    $productsColors->where('is_active', 1);
                })
                ->where('is_active', 1)
                ->orderBy('created_at', 'desc')
                ->get();
            /*Only the products have products-colors*/
            $array_products_new = [];
            foreach ($productsnew_all as $value) {
                if (count($value->productsColors) != 0) {
                    array_push($array_products_new, $value);
                }
            }
            $productsnew = collect($array_products_new)->take(5);
            $id          = Auth::id();
            return view('ecommerce.index', compact('top', 'productsnew', 'id'));

        }
    }

    public function searchProduct(Request $request, $id)
    {
        $lang  = $this->getSessionLang($request);
        $token = $this->getToken($request);

        if ($token == '') {
            $client = new Client([]);
            $query  = $client->request('GET', config('constants.BASE_URL') . '/v1/products/' . $id, [
                'headers' => [
                    'Accept-Language' => $lang->iso_code,
                ],
            ]);
            $data           = $query->getBody();
            $response       = json_decode($data, true);
            return $product = $response['data'];
        } else {
            $client = new Client([]);
            $query  = $client->request('GET', config('constants.BASE_URL') . '/v1/products/' . $id, [
                'headers' => [
                    'Authorization'   => 'Bearer ' . $token,
                    'Accept-Language' => $lang->iso_code,
                ],
            ]);
            $data           = $query->getBody();
            $response       = json_decode($data, true);
            return $product = $response['data'];
        }
    }
}
