<?php

namespace App\Http\Controllers;

use App\Enums\online_medicine\OnlineMedicineStatus;
use App\Enums\TypeProductCart;
use App\Models\Cart;
use App\Models\DrugIngredients;
use App\Models\MedicalFavourite;
use App\Models\online_medicine\CategoryProduct;
use App\Models\online_medicine\ProductMedicine;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\WishList;
use Illuminate\Support\Facades\Auth;
use App\Models\Province;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicineController extends Controller
{
    public function index()
    {
        $clinicQuery = DB::table('clinics as c1')
            ->select('c1.user_id', DB::raw('MIN(c1.id) as min_id'))
            ->groupBy('c1.user_id');
        $medicines = ProductMedicine::where('product_medicines.status', OnlineMedicineStatus::APPROVED)
            ->leftJoin('users', 'product_medicines.user_id', '=', 'users.id')
            ->leftJoin('provinces', 'provinces.id', '=', 'users.province_id')
            ->leftJoinSub($clinicQuery, 'first_clinic', function ($join) {
                $join->on('product_medicines.user_id', '=', 'first_clinic.user_id');
            })
            ->leftJoin('clinics as c2', 'first_clinic.min_id', '=', 'c2.id')
            ->select(
                'product_medicines.*',
                'provinces.name as location_name',
                'users.email',
                'c2.latitude',
                'c2.longitude'
            );

        $medicine10 = $medicines->orderBy('created_at','desc')->get();
        $medicines = $medicines->orderBy('created_at','desc')->get();

        // count all medicine
        $countAllMedicine = ProductMedicine::where('product_medicines.status', OnlineMedicineStatus::APPROVED)->count();
        $categoryMedicines = CategoryProduct::where('status', true)->get();

        //get all product in cart by user_id
        $carts = null;
        if (Auth::check()) {
            $carts = Cart::where('user_id', Auth::user()->id)
                ->where('type_product', TypeProductCart::MEDICINE)
                ->whereNull('prescription_id')
                ->get();
        }
        $provinces = Province::all();
        $medical_favourites = WishList::where('isFavorite', 1);
        if (Auth::check()) {
            $medical_favourites = WishList::where('user_id', Auth::user()->id)->where('isFavorite', 1)->where('type_product', TypeProductCart::MEDICINE);
        }
        $medical_favourites = json_encode($medical_favourites->pluck('product_id')->toArray());
        $array_company = null;
        $array_country = null;
        foreach ($medicines as $product) {
            if ($product->manufacturing_company) {
                $array_company[] = $product->manufacturing_company;
                $array_company = array_unique($array_company);
            }

            if ($product->manufacturing_country) {
                $array_country[] = $product->manufacturing_country;
                $array_country = array_unique($array_country);
            }
        }
        return view('medicine.list', compact('medicines', 'medicine10',
            'categoryMedicines', 'provinces', 'countAllMedicine',
            'carts', 'medical_favourites', 'array_company', 'array_country'));
    }

    public function detail($id)
    {
        $medicine = ProductMedicine::find($id);
        $medicineIngredient = DrugIngredients::where('product_id', $id)->first()->component_name;
        $medicineIngredient = str_replace("),", ")," . "<br>", $medicineIngredient);
//        $user_email = User::find($medicine->user_id)->email;
        $categoryMedicines = CategoryProduct::where('status', true)->get();
        $carts = null;
        $name_role = '';
        if (Auth::check()) {
            $carts = Cart::where('user_id', Auth::user()->id)
                ->whereNull('prescription_id')
                ->where('type_product', TypeProductCart::MEDICINE)
                ->get();
            $role = RoleUser::where('user_id',Auth::user()->id)->first();
            $name_role = Role::find($role->role_id)->name;
        }
        return view('medicine.detailMedicine', compact('medicine', 'categoryMedicines', 'carts', 'id','name_role', 'medicineIngredient'));
    }

    public function wishList()
    {
        $medicines = ProductMedicine::where('product_medicines.status', OnlineMedicineStatus::APPROVED)
            ->leftJoin('users', 'product_medicines.user_id', '=', 'users.id')
            ->leftJoin('provinces', 'provinces.id', '=', 'users.province_id')
            ->select('product_medicines.*', 'provinces.name as location_name');

        $medicine10 = $medicines->paginate(10);
        $medicines = $medicines->paginate(16);

        // count all medicine
        $countAllMedicine = ProductMedicine::where('product_medicines.status', OnlineMedicineStatus::APPROVED)->count();
        $categoryMedicines = CategoryProduct::where('status', true)->get();

        //get all product in cart by user_id
        $carts = null;
        if (Auth::check()) {
            $carts = Cart::where('user_id', Auth::user()->id)
                ->whereNull('prescription_id')
                ->where('type_product', TypeProductCart::MEDICINE)
                ->get();
        }
        $provinces = Province::all();
        $medical_favourites = MedicalFavourite::where('is_favorite', 1);
        if (Auth::check()) {
            $medical_favourites = MedicalFavourite::where('user_id', Auth::user()->id)->where('is_favorite', 1);
        }
        $medical_favourites = json_encode($medical_favourites->pluck('medical_id')->toArray());

        return view('medicine.wishlistMedicine', compact('medicines', 'medicine10', 'categoryMedicines', 'provinces', 'countAllMedicine', 'carts', 'medical_favourites'));
    }

    public function searchOnlineMedicine(Request $request)
    {
        $medicines = ProductMedicine::where('product_medicines.status', OnlineMedicineStatus::APPROVED);

        $name = $request->input('name');

        $filter = $request->input('filter');
        $object = $request->input('object');

        $category = $request->input('category');
        $location = $request->input('location');

        $company = $request->input('company');
        $country = $request->input('country');
        /* Tìm kiếm theo filter */
        $medicines->when($filter, function ($query) use ($filter) {
            $filterValues = explode(',', $filter);
            $ifFilterValuesHasZero = in_array(0, $filterValues);
            if (!$ifFilterValuesHasZero) {
                $query->whereIn('filter_', $filterValues);
            }
        });

        /* Tìm kiếm theo object */
        $medicines->when($object, function ($query) use ($object) {
            $objectValues = explode(',', $object);
            $query->whereIn('object_', $objectValues);
        });

        $medicines->when($company, function ($query) use ($company) {
            $objectValues = explode(',', $company);
            $query->whereIn('manufacturing_company', $objectValues);
        });

        $medicines->when($country, function ($query) use ($country) {
            $objectValues = explode(',', $country);
            $query->whereIn('manufacturing_country', $objectValues);
        });

//        /* Tìm kiếm theo giá */
//        $medicines->when($min_price, function ($query) use ($min_price) {
//            $query->where('price', '>=', $min_price);
//        });
//
//        $medicines->when($max_price, function ($query) use ($max_price) {
//            $query->where('price', '<=', $max_price);
//        });

        /* Tìm kiếm theo category */
        $medicines->when($category, function ($query) use ($category) {
            $query->where('category_id', $category);
        });

        /* Tìm kiếm theo location */
        $medicines->when($location, function ($query) use ($location) {
            $query->where('provinces.id', $location);
        });

        /* Tìm kiếm theo tên */
        $medicines->when($name, function ($query) use ($name) {
            $query->where(function ($sup_query) use ($name) {
                $sup_query->where('product_medicines.uses', 'like', '%' . $name . '%')
                    ->orWhere('product_medicines.specifications', 'like', '%' . $name . '%')
                    ->orWhere('product_medicines.name', 'like', '%' . $name . '%')
                    ->orWhere('product_medicines.name_en', 'like', '%' . $name . '%')
                    ->orWhere('product_medicines.name_laos', 'like', '%' . $name . '%');
            });
            $query->join('drug_ingredients', 'drug_ingredients.product_id', '=', 'product_medicines.id')
                ->orWhere('drug_ingredients.component_name', 'like', '%' . $name . '%');
        });

        $clinicQuery = DB::table('clinics as c1')
            ->select('c1.user_id', DB::raw('MIN(c1.id) as min_id'))
            ->groupBy('c1.user_id');

        /* Join và select */
        $medicines->leftJoin('users', 'product_medicines.user_id', '=', 'users.id')
            ->leftJoin('provinces', 'provinces.id', '=', 'users.province_id')
            ->leftJoinSub($clinicQuery, 'first_clinic', function ($join) {
                $join->on('product_medicines.user_id', '=', 'first_clinic.user_id');
            })
            ->leftJoin('clinics as c2', 'first_clinic.min_id', '=', 'c2.id')
            ->select('product_medicines.*', 'provinces.name as location_name','users.email','c2.latitude','c2.longitude');

        $medicines = $medicines->distinct()->orderBy('created_at','desc')->get();

        return response()->json($medicines);
    }

    public function searchOnlineMedicineNoPaginate(Request $request)
    {
        $medicines = ProductMedicine::all();

        $medicineList = $medicines->map(function ($medicine) {
            $medicineIngredient = DrugIngredients::where('product_id', $medicine->id)->first();
            $component_name = $medicineIngredient ? $medicineIngredient->component_name : null;

            if ($component_name) {
                $component_name = str_replace("),", ")," . "<br>", $component_name);
            }

            $medicine->medicineIngredient = $component_name;

            return $medicine;
        });

        return response()->json($medicineList);
    }


    public function getLocationByUserId(Request $request)
    {
        $user = User::find($request->input('user_id'));
        $location_id = $user->province_id;
        $nameLocation = Province::find($location_id)->full_name;
        return response()->json($nameLocation);
    }

    public function getIngredientsByMedicineId($id)
    {
        $ingredients = DrugIngredients::where('product_id', $id)->first('component_name');
        return response()->json($ingredients);
    }

}
