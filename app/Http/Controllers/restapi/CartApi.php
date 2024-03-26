<?php

namespace App\Http\Controllers\restapi;

use App\Enums\CartStatus;
use App\Enums\TypeProductCart;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\online_medicine\ProductMedicine;
use App\Models\ProductInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CartApi extends Controller
{
    public function showCartByUserID($id)
    {
        $carts = DB::table('carts')
            ->where('user_id', $id)
            ->cursor()
            ->map(function ($item) {
                if ($item->type_product == TypeProductCart::MEDICINE) {
                    $products = ProductMedicine::find($item->product_id);
                } else {
                    $products = ProductInfo::find($item->product_id);
                }
                $cart = (array)$item;
                $cart['products'] = $products->toArray();
                return $cart;
            });
        return response()->json($carts);
    }

    public function addToCart(Request $request)
    {
        $userID = $request->input('user_id');

        $productID = $request->input('product_id');
        $typeProduct = $request->input('type_product');

        $quantity = $request->input('quantity');

        try {
            $cart = Cart::where('user_id', $userID)
                ->where('product_id', $productID)
                ->where('type_product', $typeProduct)
                ->first();

            if ($typeProduct == TypeProductCart::MEDICINE) {
                $product = ProductMedicine::find($productID);
            } else {
                $product = ProductInfo::find($productID);
            }

            if (!$product) {
                return response((new MainApi())->returnMessage('Product not found'), 404);
            }

            if ($product->quantity == 0) {
                return response((new MainApi())->returnMessage('Product out of stock'), 400);
            }

            if ($cart) {
                $quantity = $cart->quantity + $quantity;
                if ($quantity > $product->quantity) {
                    $quantity = $product->quantity;
                }
                $cart->quantity = $quantity;
            } else {
                $cart = new Cart();
                $cart->product_id = $productID;

                if ($quantity && $quantity > $product->quantity) {
                    $quantity = $product->quantity;
                }

                $cart->quantity = $quantity;
                $cart->user_id = $userID;
                $cart->type_product = $typeProduct;
            }

            $success = $cart->save();
            if ($success) {
                return response()->json($cart);
            }
            return response('Error, Please try again!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function addToCartV2(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'user_id' => 'required|numeric',
                'products.*.id' => 'required|numeric',
                'products.*.quantity' => 'required|integer|min:1',
                'products.*.note' => 'nullable|string',
                'type_product' => 'nullable|string',
            ]);

            if ($validated->fails()) {
                return response()->json(['error' => -1, 'message' => $validated->errors()->first()], 400);
            }

            $validatedData = $validated->validated();

            $typeProduct = $request->input('type_product') ?? TypeProductCart::MEDICINE;

            $userID = $validatedData['user_id'];

            $prescription_id = strtoupper(Str::random(3)) . '_' . time();

            // Add each product to the cart
            foreach ($validatedData['products'] as $productData) {
                if ($typeProduct == TypeProductCart::MEDICINE) {
                    $product = ProductMedicine::find($productData['id']);
                } else {
                    $product = ProductInfo::find($productData['id']);
                }

                if (!$product) {
                    return response((new MainApi())->returnMessage('Product not found'), 404);
                }

                if ($product->quantity == 0) {
                    return response((new MainApi())->returnMessage('Product out of stock'), 400);
                }

                $quantity = $productData['quantity'];

                if ($productData['quantity'] && $productData['quantity'] > $product->quantity) {
                    $quantity = $product->quantity;
                }

                // Add the product to the cart with the specified quantity
                Cart::create([
                    'product_id' => $productData['id'],
                    'quantity' => $quantity,
                    'user_id' => $userID,
                    'type_product' => $typeProduct,
                    'status' => CartStatus::PENDING,
                    'note' => $productData['note'] ?? "",
                    'prescription_id' => $prescription_id
                ]);
            }
            if ($typeProduct == TypeProductCart::MEDICINE) {
                $carts = Cart::with(['users', 'productMedicine'])
                    ->where('prescription_id', $prescription_id)
                    ->get();
            } else {
                $carts = Cart::with(['users', 'productMedicine'])
                    ->where('prescription_id', $prescription_id)
                    ->get();
            }

            return response()->json(['error' => 0, 'data' => $carts]);
        } catch (\Exception $e) {
            return response(['error' => -1, 'message' => $e->getMessage()], 400);
        }
    }

    public function searchCart(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'prescription_id' => 'nullable|string',
            ]);

            if ($validated->fails()) {
                return response()->json(['error' => -1, 'message' => $validated->errors()->first()], 400);
            }

            $prescription_id = $request->input('prescription_id');

            $carts = Cart::query()->with('users');

            if ($prescription_id) {
                $carts = $carts->where('prescription_id', $prescription_id);
            }

            $carts = $carts->get();

            if ($carts->isEmpty()) {
                return response()->json(['error' => -1, 'message' => 'No carts found.']);
            }

            $carts->each(function ($cart) {
                if ($cart->type_product == TypeProductCart::MEDICINE) {
                    $cart->load('productMedicine');
                } else {
                    $cart->load('productInfo');
                }
            });

            return response()->json(['error' => 0, 'data' => $carts]);
        } catch (\Exception $e) {
            return response(['error' => -1, 'message' => $e->getMessage()], 400);
        }
    }

    public function changeQuantityCart(Request $request, $id)
    {
        try {
            $cart = Cart::where('id', $id)->first();

            $typeProduct = $cart->type_product;

            if ($typeProduct == TypeProductCart::MEDICINE) {
                $product = ProductMedicine::find($cart->product_id);
            } else {
                $product = ProductInfo::find($cart->product_id);
            }

            $quantity = $request->input('quantity');

            if ($quantity && $quantity > $product->quantity) {
                $quantity = $product->quantity;
            }

            $cart->quantity = $quantity;
            $success = $cart->save();
            if ($success) {
                return response((new MainApi())->returnMessage('Update success!'), 200);
            }
            return response('Error, Please try again!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function deleteCart($id)
    {
        try {
            $success = Cart::where('id', $id)->delete();
            if ($success) {
                return response('Success!', 200);
            }
            return response('Error, Please try again!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function clearCart($id)
    {
        try {
            $success = Cart::where('user_id', $id)->delete();
            if ($success) {
                return response('Success!', 200);
            }
            return response('Error, Please try again!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }
}
