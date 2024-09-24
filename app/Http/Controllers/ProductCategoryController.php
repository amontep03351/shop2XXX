<?php
namespace App\Http\Controllers;
use App\Models\ProductCategoryTranslation;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
  
    public function index(Request $request)
    {
        // รับค่าค้นหาและตั้งค่าการเรียงลำดับ
        $search = htmlspecialchars($request->input('search', '')); // ป้องกัน SQL Injection
        $sortOrder = $request->input('sort_order', 'asc');
        $rowsPerPage = (int) $request->input('rows_per_page', 10); // ใช้ค่าเริ่มต้นเป็น 10
        $rowsPerPage = $rowsPerPage > 0 ? $rowsPerPage : 10; // ตรวจสอบให้แน่ใจว่าเป็นค่าที่เป็นบวก
    
        // ค้นหาและแบ่งหน้า
        $categories = ProductCategory::with('translations')
            ->whereNull('parent_id') // แสดงเฉพาะที่ parent_id เป็น null
            ->when($search, function ($query, $search) {
                return $query->whereHas('translations', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%"); 
                });
            })
            ->orderBy('display_order', $sortOrder)
            ->paginate($rowsPerPage);
    
        // ส่งข้อมูลไปยัง View
        return view('product_categories.index', [
            'categories' => $categories,
            'sortOrder' => $sortOrder,
            'rowsPerPage' => $rowsPerPage,
        ]);
    }
     
    public function create()
    {
        return view('product_categories.create');
    }

    public function store(Request $request)
    {
        // ตรวจสอบข้อมูลซ้ำ
        $request->validate([
            'name_en' => 'required|string|max:255|unique:product_category_translations,name,NULL,id,locale,en',
            'name_th' => 'required|string|max:255|unique:product_category_translations,name,NULL,id,locale,jp',
        ]);
        
        // สร้าง ProductCategory ใหม่
        $category = ProductCategory::create();

        // สร้างการแปลภาษา
        ProductCategoryTranslation::create([
            'product_category_id' => $category->id,
            'locale' => 'en',
            'name' => $request->input('name_en'),
        ]);

        ProductCategoryTranslation::create([
            'product_category_id' => $category->id,
            'locale' => 'jp',
            'name' => $request->input('name_th'),
        ]);

        return redirect()->route('product-categories.index')
                         ->with('success', 'Product Category created successfully.');
    }


    public function edit(ProductCategory $productCategory)
    {
        return view('product_categories.edit', compact('productCategory'));
    }

    public function update(Request $request, ProductCategory $productCategory)
    {
        // ตรวจสอบข้อมูลซ้ำ
        $request->validate([
            'name_en' => 'required|string|max:255|unique:product_category_translations,name,' . $productCategory->id . ',product_category_id,locale,en',
            'name_th' => 'required|string|max:255|unique:product_category_translations,name,' . $productCategory->id . ',product_category_id,locale,jp',
        ]);

        // อัพเดทข้อมูลการแปลภาษา
        $productCategory->translations()->updateOrCreate(
            ['locale' => 'en'],
            ['name' => $request->input('name_en')]
        );

        $productCategory->translations()->updateOrCreate(
            ['locale' => 'jp'],
            ['name' => $request->input('name_th')]
        );

        return redirect()->route('product-categories.index')
                         ->with('success', 'Product Category updated successfully.');
    }

    public function destroy(ProductCategory $productCategory)
    {
        // ลบรายการที่เลือก
        $productCategory->delete();
    
        // อัปเดตลำดับใหม่หลังจากลบ
        //$this->reorderDisplayOrder();
    
        return redirect()->route('product-categories.index')->with('success', 'Category deleted successfully.');
    }
    private function reorderDisplayOrder()
    {
        // ดึงรายการทั้งหมดมาเรียงลำดับใหม่
        $categories = ProductCategory::orderBy('display_order')->get();

        // ใช้ loop เพื่ออัปเดตลำดับใหม่
        foreach ($categories as $index => $category) {
            $category->update(['display_order' => $index + 1]); // ลำดับจะเริ่มที่ 1
        }
    }
    
    public function updateOrder(Request $request)
    {
        $sortedIDs = $request->input('sortedIDs');

        foreach ($sortedIDs as $index => $id) {
            ProductCategory::where('id', $id)->update(['display_order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    } 
  
    public function toggleStatus(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');
        ProductCategory::where('id', $id)->update(['status' => $status]);
        return response()->json(['success' => true]);
    }
    
 
    public function showSubcategories($categoryId, Request $request)
    {
        $category = ProductCategory::with('subcategories.translations')
            ->findOrFail($categoryId);
    
        $search = $request->input('search');
        $sortOrder = $request->input('sort_order', 'asc');
        $rowsPerPage = (int) $request->input('rows_per_page', 10); // ใช้ค่าเริ่มต้น 10
    
        $subcategories = $category->subcategories()
            ->with('translations')
            ->when($search, function ($query, $search) {
                return $query->whereHas('translations', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                });
            })
            ->orderBy('display_order', $sortOrder)
            ->paginate($rowsPerPage);
    
        return view('product_categories.subcategories.index', compact('category', 'subcategories', 'sortOrder', 'rowsPerPage'));
    }
    public function createSub(ProductCategory $category)
    { 
        return view('product_categories.subcategories.create_sub', compact('category'));
    }
    
    
    public function storeSub(Request $request, ProductCategory $category)
    {
        $validatedData = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_th' => 'required|string|max:255', 
        ]);

        // ตรวจสอบความซ้ำซ้อนของชื่อในระดับเดียวกันภายใต้ parent_id
        $existingCategory = ProductCategory::where('parent_id', $request->input('parent_id'))
            ->whereHas('translations', function($query) use ($request) {
                $query->where('name', $request->input('name_en'));
            })
            ->first();

        if ($existingCategory) {
            return redirect()->back()->withErrors(['name_en' => 'A subcategory with this name already exists under the same parent.'])->withInput();
        }

        // สร้าง subcategory ใหม่
        $subcategory = new ProductCategory();
        $subcategory->display_order = 0;
        $subcategory->status = 1;
        $subcategory->parent_id = $request->input('parent_id');
        $subcategory->save();

        // เพิ่มการแปล
        $subcategory->translations()->create([
            'name' => $validatedData['name_en'],
            'locale' => 'en',
        ]);
        
        $subcategory->translations()->create([
            'name' => $validatedData['name_th'],
            'locale' => 'jp',
        ]);

        // เปลี่ยนเส้นทางไปยังหน้ารายการ subcategories ของ category ที่เกี่ยวข้อง
        return redirect()->route('product-categories.subcategories.index', ['category' => $subcategory->parent_id])
            ->with('success', 'Subcategory created successfully.');
    }

    public function updateOrder_sub(Request $request)
    {

        $parentId = $request->input('parentId');
        $sortedIDs = $request->input('sortedIDs');
        // ตรวจสอบว่ามี parent_id หรือไม่
        if ($parentId) {
            foreach ($sortedIDs as $index => $id) {
                ProductCategory::where('id', $id)
                    ->where('parent_id', $parentId) // ตรวจสอบ parent_id
                    ->update(['display_order' => $index + 1]);
            }
        } else { 
        }

        return response()->json(['success' => true]);
    } 
    public function destroySubcategory($categoryId, $subcategoryId)
    {
        // ค้นหา Subcategory ที่จะลบ
        $subcategory = ProductCategory::where('id', $subcategoryId)
            ->where('parent_id', $categoryId)
            ->firstOrFail();

        // ลบ Subcategory
        $subcategory->delete();

        // เรียกใช้ฟังก์ชัน reorderDisplayOrder เพื่ออัปเดตลำดับของ Subcategories
        //$this->reorderDisplayOrdersub($categoryId);
        
        // รีไดเร็กต์กลับไปที่หน้าดัชนีของ Subcategories
        return redirect()->route('product-categories.subcategories.index', $categoryId)
            ->with('success', 'Subcategory deleted successfully.');
    }
 
    private function reorderDisplayOrdersub($parentId)
    {
        // ดึงรายการทั้งหมดของ Subcategories ที่มี parent_id เดียวกัน
        $subcategories = ProductCategory::where('parent_id', $parentId)
            ->orderBy('display_order')
            ->get();

        // ใช้ loop เพื่ออัปเดตลำดับใหม่
        foreach ($subcategories as $index => $subcategory) {
            $subcategory->update(['display_order' => $index + 1]); // ลำดับจะเริ่มที่ 1
        }
    }

}
