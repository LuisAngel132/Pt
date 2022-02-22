<?php

namespace App\Http\Controllers\ShoppingHistory;

use DB;
use Auth;
use Validator;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\CustomerRating;
use App\Http\Controllers\Controller;

class RatingController extends Controller
{

    protected $product;
    protected $customer;
    protected $customerRating;

    /**
     * __construct
     *
     * @param      \App\Models\Product         $product         The product
     * @param      \App\Models\Customer        $customer        The customer
     * @param      \App\Models\CustomerRating  $customerRating  The customer rating
     */
    public function __construct(Product $product, Customer $customer, CustomerRating $customerRating)
    {
        $this->product        = $product;
        $this->customer       = $customer;
        $this->customerRating = $customerRating;
    }

    public function store(Request $request)
    {
        try {
            $request->all();
            $mensajes = "";
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'rating'     => 'required|max:1',
                'title'      => 'required|string',
                'comentario' => 'required|string',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                foreach ($errors->all() as $key => $value) {
                    $mensajes = $mensajes . $value . "\n";
                }
                $mensajes;
                return $data = [
                    'status'  => "warning",
                    "mensaje" => $mensajes,
                ];
            } else {
                $customer       = $this->customer->where('users_id', Auth::id())->first();
                $customerRating = $this->customerRating->create([
                    'customers_id' => $customer->id,
                    'products_id'  => $request->products,
                    'title'        => $request->title,
                    'description'  => $request->comentario,
                    'rating'       => $request->rating,
                ]);
                DB::commit();
                return $data = [
                    'status'  => "success",
                    "mensaje" => $mensajes,
                ];
            }

        } catch (Exception $e) {
            DB::rollback();
        }
    }

    /**
     * rating Customers
     * @param      \Illuminate\Http\Request  $request  The request
     */
    public function ratingCustomers(Request $request)
    {
        $customer       = $this->customer->where('users_id', Auth::id())->first();
        $rating         = $this->customerRating->where('customers_id', $customer->id)->where('products_id', $request->product_id)->first();
        $ratingCustomer = $this->customerRating->where('products_id', $request->product_id)->count();
        $product        = $this->product->find($request->product_id);
        if ($rating) {
            return $data = [
                'rating'              => true,
                'ratingCustomer'      => $rating->rating,
                'ratingTitle'         => $rating->title,
                'ratingDescription'   => $rating->description,
                'ratingTotal'         => optional($product)->average_rating,
                'ratingCustomerTotal' => $ratingCustomer,
                'ratingCustomerID'    => $rating->id,
            ];
        } else {
            return $data = [
                'rating'              => false,
                'ratingTotal'         => optional($product)->average_rating,
                'ratingCustomerTotal' => $ratingCustomer,
            ];
        }
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
        try {
            $request->all();
            $mensajes = "";
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'rating_edit'     => 'required|max:1',
                'title_edit'      => 'required|string',
                'comentario_edit' => 'required|string',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                foreach ($errors->all() as $key => $value) {
                    $mensajes = $mensajes . $value . "\n";
                }
                $mensajes;
                return $data = [
                    'status'  => "warning",
                    "mensaje" => $mensajes,
                ];
            } else {
                $customer            = $this->customer->where('users_id', Auth::id())->first();
                $customerRatingexist = $this->customerRating->where('customers_id', $customer->id)->where('products_id', $request->products_edit)->first();
                $customerRatingexist->update([
                    'customers_id' => $customer->id,
                    'products_id'  => $request->products_edit,
                    'title'        => $request->title_edit,
                    'description'  => $request->comentario_edit,
                    'rating'       => $request->rating_edit,
                ]);
                DB::commit();
                return $data = [
                    'status'  => "success",
                    "mensaje" => $mensajes,
                ];
            }
        } catch (Exception $e) {
            DB::rollback();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $customerRatingexist = $this->customerRating->where('id', $id)->delete();
            DB::commit();
            return $data = [
                'status' => "success",
            ];
        } catch (Exception $e) {
            DB::rollback();
        }
    }

}
