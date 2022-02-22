<?php

namespace App\Http\Controllers\Design;

use App\Models\Lang;
use App\Models\Design;
use App\Models\BaseCategory;
use Illuminate\Http\Request;
use App\Models\CategoriesDesign;
use App\Http\Controllers\Controller;
use App\Models\BaseCategoryTranslation;

class DesignController extends Controller
{
    /**
     * The user repository instance.
     */
    protected $lang;
    protected $design;
    protected $baseCategory;
    protected $categoriesDesign;
    protected $baseCategoryTranslation;

    /**
     * Create a new controller instance.
     *
     * @param  Design  $design
     * @return void
     */
    public function __construct(Lang $lang, Design $design, CategoriesDesign $categoriesDesign, BaseCategoryTranslation $baseCategoryTranslation, BaseCategory $baseCategory)
    {
        $this->lang                    = $lang;
        $this->design                  = $design;
        $this->baseCategory            = $baseCategory;
        $this->categoriesDesign        = $categoriesDesign;
        $this->baseCategoryTranslation = $baseCategoryTranslation;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lang     = $this->getSessionLang($request);
        $category = $this->baseCategoryTranslation->where('langs_id', $lang->id)
            ->with('baseCategories')
            ->whereHas('baseCategories', function ($query) {
                $query->where('is_active', 1);
            })
            ->get();
        if ($request->id) {
            $designs = $this->categoriesDesign
                ->with('designs', 'baseCategories')
                ->whereHas('designs', function ($q) {
                    $q->where('is_active', 1);
                })
                ->where('base_categories_id', $request->id)
                ->paginate(12);
            $img_category = $this->baseCategory::where('id', $request->id)->first();
            return view('ecommerce.design', compact('designs', 'category', 'img_category'));
        } else {
            $designs = $this->categoriesDesign
                ->with('designs')
                ->whereHas('designs', function ($q) {
                    $q->where('is_active', 1);
                })
                ->paginate(12);
            $img_category = '';
            return view('ecommerce.design', compact('designs', 'category', 'img_category'));
        }
    }

    public function getDesigns(Request $request)
    {

        $lang     = $this->getSessionLang($request);
        $category = $this->baseCategoryTranslation->where('langs_id', $lang->id)->get();
        if ($request->id) {
            $designs = $this->design
                ->where('is_active', 1)
                ->with('categoriesDesigns')
                ->whereHas('categoriesDesigns', function ($query) use ($request) {
                    $query->where('base_categories_id', $request->id);
                })
                ->paginate(12);
        } else {
            $designs = $this->design
                ->where('is_active', 1)
                ->with('categoriesDesigns')
                ->paginate(12);
        }
        return compact('designs', 'category');

    }

    /**
     * Gets the session language.
     * @param      \Illuminate\Http\Request  $request  The request
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
}
