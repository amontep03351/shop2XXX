<?php 
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategoryTranslation;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // รับค่าค้นหาและตั้งค่าการเรียงลำดับ
        $search = $request->input('search', '');
        $sortOrder = $request->input('sort_order', 'asc');
        $rowsPerPage = (int) $request->input('rows_per_page', 10);
        $rowsPerPage = $rowsPerPage > 0 ? $rowsPerPage : 10;

        // ค้นหาและแบ่งหน้า
        $products = Product::with('translations')
            ->when($search, function ($query, $search) {
                return $query->whereHas('translations', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                });
            })
            ->orderBy('display_order', $sortOrder)
            ->paginate($rowsPerPage);

        // ส่งข้อมูลไปยัง View
        return view('product.index', [
            'products' => $products,
            'sortOrder' => $sortOrder,
            'rowsPerPage' => $rowsPerPage,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ProductCategory::with('translations')->get(); 
        return view('product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name_en' => 'required|string|max:255',
            'name_th' => 'required|string|max:255',
            'category_id' => 'required', 
            'description_en' => 'required|string',
            'description_th' => 'required|string',
            'display_order' => 'required|integer',
            'status' => 'required|boolean',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // Validation for main image
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // Validation for additional images
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Create a new product
        $product = Product::create([
            'display_order' => $request->input('display_order'),
            'status' => $request->input('status'),
            'category_id' => $request->input('category_id'),
        ]);
    
        // Handle main image upload
        if ($request->hasFile('main_image')) {
            $mainImagePath = $request->file('main_image')->store('uploads', 'public');
            $product->update(['product_image' => $mainImagePath]);
        }
    
        // Save the product translations
        $product->translations()->create([
            'locale' => 'en',
            'name' => $request->input('name_en'),
            'description' => $request->input('description_en'),
        ]);
    
        $product->translations()->create([
            'locale' => 'jp',
            'name' => $request->input('name_th'),
            'description' => $request->input('description_th'),
        ]);
    
        // Handle additional image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('uploads', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $path,
                ]);
            }
        }
    
        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        // ดึงข้อมูลหมวดหมู่ทั้งหมดพร้อมกับการแปล
        $categories = ProductCategory::with('translations')->get();
        $images = $product->images;
        // ส่งข้อมูลผลิตภัณฑ์และหมวดหมู่ไปยัง View
        return view('product.edit', compact('product', 'categories', 'images'));
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
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name_en' => 'required|string|max:255',
            'name_th' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_th' => 'required|string',
            'category_id' => 'required',
            'display_order' => 'required|integer',
            'status' => 'required|boolean',
            
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Find the product
        $product = Product::findOrFail($id);
    
        // Update product details
        $product->update([
            'category_id' => $request->category_id,
            'display_order' => $request->display_order,
            'status' => $request->status,
        ]);
    
        // Update product translations
        $product->translations()->updateOrCreate(
            ['locale' => 'en'],
            ['name' => $request->name_en, 'description' => $request->description_en]
        );
        
        $product->translations()->updateOrCreate(
            ['locale' => 'jp'],
            ['name' => $request->name_th, 'description' => $request->description_th]
        );
     
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }
    


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // ลบสินค้า
        $product->delete();
    
        // ส่งข้อความแสดงผลสำเร็จกลับไป
        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
    
    public function updateImage(Request $request, $id)
    {
        $request->validate([
            'product_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);
   
        $product = Product::findOrFail($id);
    
        // ลบรูปภาพเก่าถ้ามี
        if (Storage::exists('public/' . $product->product_image)) {
            Storage::delete('public/' . $product->product_image);
        }
    
        // อัปโหลดรูปภาพใหม่
        $path = $request->file('product_image')->store('products', 'public');
    
        // บันทึกเส้นทางรูปภาพใหม่ในฐานข้อมูล
        $product->product_image = $path;
        $product->save();
    
        return redirect()->back()->with('success', 'Product image updated successfully.');
    }
    public function toggleStatus(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');
        Product::where('id', $id)->update(['status' => $status]);
        return response()->json(['success' => true]);
    }
}
