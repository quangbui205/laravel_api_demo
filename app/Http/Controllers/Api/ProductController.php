<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = Product::all();

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Lấy dữ liệu thành công!',
            'data' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:2|max:255',
            'price' => 'required|integer|min:1000',
            'quantity' => 'required',
        ];

        $messages = [
            'name.required' => 'Tên sản phẩm không được để trống',
            'name.min' => 'Tên sản phẩm phải có độ dài ít nhất 2 ký tự',
            'name.max' => 'Tên sản phẩm dài không quá 255 ký tự',
            'price.required'  => 'Giá sản phẩm không được để trống',
            'price.integer'  => 'Giá sản phẩm phải là số',
            'price.min'  => 'Giá sản phẩm phải có giá trị tối thiểu 1000vnđ',
            'quantity.required'  => 'Số lượng sản phẩm không được để trống',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails())
        {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => 'Lỗi! Dữ liệu đầu vào không hợp lệ!',
                'errors' => $validator->errors()->all()
            ]);
        }
        $product = Product::create($request->all());

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Thêm dữ liệu thành công',
            'data' => $product
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if(!$product) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => 'Lỗi! Dữ liệu không tồn tại',
            ]);
        }

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Lấy dữ liệu thành công!',
            'data' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $rules = [
            'name' => 'required|min:2|max:255',
            'price' => 'required|integer|min:1000',
            'quantity' => 'required',
        ];

        $messages = [
            'name.required' => 'Tên sản phẩm không được để trống',
            'name.min' => 'Tên sản phẩm phải có độ dài ít nhất 2 ký tự',
            'name.max' => 'Tên sản phẩm dài không quá 255 ký tự',
            'price.required'  => 'Giá sản phẩm không được để trống',
            'price.integer'  => 'Giá sản phẩm phải là số',
            'price.min'  => 'Giá sản phẩm phải có giá trị tối thiểu 1000vnđ',
            'quantity.required'  => 'Số lượng sản phẩm không được để trống',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails())
        {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => 'Lỗi! Dữ liệu đầu vào không hợp lệ!',
                'errors' => $validator->errors()->all()
            ]);
        }

        $product = Product::find($id);

        if(!$product) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => 'Lỗi! Dữ liệu không tồn tại',
            ]);
        }

        $product->update($request->all());

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Cập nhập dữ liệu thành công!',
            'data' => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if(!$product) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => 'Lỗi! Dữ liệu không tồn tại',

            ]);
        }

        $product->delete();

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Xóa dữ liệu thành công',
        ]);
    }
}
