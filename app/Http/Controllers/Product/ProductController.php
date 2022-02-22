<?php

namespace App\Http\Controllers\Product;

use App\Models\Lang;
use App\Models\Design;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductsColor;
use App\Models\ProductsDesign;
use App\Models\ProductTranslation;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Customer;

/**
 * Controls the data flow into a product object and updates the view whenever data changes.
 */
class ProductController extends Controller {
	/**
	 * The user repository instance.
	 */
	protected $lang;
	protected $design;
	protected $product;
	protected $productsColor;
	protected $productsDesign;
	protected $productTranslation;
	protected $customer;

	/**
	 *
	 * @param      \App\Models\ProductTranslation  $productTranslation  The product translation
	 * @param      \App\Models\Product             $product             The product
	 * @param      \App\Models\Design              $design              The design
	 * @param      \App\Models\Lang                $lang                The language
	 */
	public function __construct(ProductTranslation $productTranslation, Product $product, Design $design, Lang $lang, ProductsDesign $productsDesign, ProductsColor $productsColor, Customer $customer) {
		$this->lang = $lang;
		$this->design = $design;
		$this->product = $product;
		$this->productsColor = $productsColor;
		$this->productsDesign = $productsDesign;
		$this->productTranslation = $productTranslation;
		$this->customer = $customer;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {

	}

	/**
	 * Gets the product featured.
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 *
	 * @return      The product featured.
	 */
	public function getDetailProduct(Request $request) {
		$lang = $this->getSessionLang($request);
		/**
		 * get product rating
		 */
		$id = Auth::id();
		if ($id == "") {
			$products = $this->productsDesign->with([
				'products.productTranslations' => function ($query) use ($lang) {
					$query->where('langs_id', $lang->id);
				}, 'products.productsColors.colors',
			])
				->where('designs_id', $request->id)
				->whereHas('products.productsColors.resources', function ($query) use ($request) {
					$query->where('is_active', true);
				})->get();
			/**
			 * return View
			 */
			return view('ecommerce.detail-product', compact('products', 'id'));
		} else {
			$customer = $this->customer::where('users_id', $id)->first();
			$products = $this->productsDesign->with([
				'products.productTranslations' => function ($query) use ($lang) {
					$query->where('langs_id', $lang->id);
				}, 'products.productsColors.colors',
				'products.customerLikes' => function ($query) use ($customer) {
					$query->where('customers_id', $customer->id);
				},
			])
				->where('designs_id', $request->id)
				->whereHas('products.productsColors.resources', function ($query) use ($request) {
					$query->where('is_active', true);
				})->get();
			/**
			 * return View
			 */
			return view('ecommerce.detail-product', compact('products', 'id'));
		}
		
	}

	/**
	 * Gets the session language.
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 *
	 * @return      The session language.
	 */
	public function getSessionLang(Request $request) {
		$data = $request->session()->all();
		if ($request->session()->has('lang')) {
			$iso_code = $request->session()->get('lang'); // si existe imprime el valor de la variable mensaje
			return $this->lang->where('iso_code', $iso_code)->first();
		} else {
			return $this->lang->where('iso_code', 'es')->first();
		}
	}

	/**
	 * changeColorActive
	 * @param      \Illuminate\Http\Request  $request  The request
	 */
	public function changeColorActive(Request $request) {
		if ($request->ajax()) {
			return $productsColor = $this->productsColor->with('resources')->where('id', $request->id)->first();
		} else {
			return $this->redirect;
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id, Request $request) {
		$lang = $this->getSessionLang($request);
		return $this->product->with(['productTranslations' => function ($query) use ($lang) {
			$query->where('langs_id', $lang->id);
		}, 'productsColors.colors', 'productTranslations.langs',
		])->where('id', $id)
			->whereHas('productsColors.resources', function ($query) use ($request) {
				$query->where('is_active', true);
			})->first();
	}
}
