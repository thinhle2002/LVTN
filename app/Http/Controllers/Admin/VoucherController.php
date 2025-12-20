<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Service\Voucher\VoucherServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VoucherController extends Controller
{
    private $voucherService;
    
    public function __construct(VoucherServiceInterface $voucherService)
    {
        $this->voucherService = $voucherService;
    }

    public function index(Request $request)
    {
        $vouchers = $this->voucherService->searchAndPaginate('title', $request->get('search'));
        return view('admin.voucher.index', compact('vouchers'));
    }

    public function create()
    {
        return view('admin.voucher.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:vouchers,code|regex:/^[A-Z0-9]+$/',
            'type' => 'required|in:1,2',
            'reduce' => 'required|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0', 
            'qty' => 'required|integer|min:1',
            'min_total_value' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề khuyến mãi',
            'code.required' => 'Vui lòng nhập mã khuyến mãi',
            'code.unique' => 'Mã khuyến mãi đã tồn tại',
            'code.regex' => 'Mã khuyến mãi phải là chữ IN HOA và số, không dấu',
            'type.required' => 'Vui lòng chọn loại khuyến mãi',
            'type.in' => 'Loại khuyến mãi không hợp lệ',
            'reduce.required' => 'Vui lòng nhập giá trị giảm',
            'reduce.numeric' => 'Giá trị giảm phải là số',
            'reduce.min' => 'Giá trị giảm phải lớn hơn 0',
            'max_discount.numeric' => 'Giảm tối đa phải là số',
            'max_discount.min' => 'Giảm tối đa phải lớn hơn 0',
            'qty.required' => 'Vui lòng nhập số lượng',
            'qty.integer' => 'Số lượng phải là số nguyên',
            'qty.min' => 'Số lượng phải lớn hơn 0',
            'start_date.required' => 'Vui lòng chọn ngày áp dụng',
            'end_date.required' => 'Vui lòng chọn ngày hết hạn',
            'end_date.after_or_equal' => 'Ngày hết hạn phải sau hoặc bằng ngày áp dụng',
        ]);

     
        if ($validated['type'] == 1) {
            if ($validated['reduce'] > 100) {
                return back()
                    ->withInput()
                    ->withErrors(['reduce' => 'Giá trị giảm theo phần trăm phải từ 0 đến 100']);
            }
        
        } else {
            $validated['max_discount'] = null;
        }

        try {
            $validated['code'] = strtoupper(trim($validated['code']));
            $voucher = Voucher::create($validated);

            return redirect()
                ->route('voucher.index')
                ->with('success', 'Tạo mã khuyến mãi thành công!');

        } catch (\Exception $e) {
                       
            return back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function show(Voucher $voucher)
    {
        return view('admin.voucher.show', compact('voucher'));
    }

    public function edit(Voucher $voucher)
    {
        return view('admin.voucher.edit', compact('voucher'));
    }

    public function update(Request $request, Voucher $voucher)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:vouchers,code,' . $voucher->id . '|regex:/^[A-Z0-9]+$/',
            'type' => 'required|in:1,2',
            'reduce' => 'required|numeric|min:0',
            'qty' => 'required|integer|min:1',
            'min_total_value' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề khuyến mãi',
            'code.required' => 'Vui lòng nhập mã khuyến mãi',
            'code.unique' => 'Mã khuyến mãi đã tồn tại',
            'code.regex' => 'Mã khuyến mãi phải là chữ IN HOA và số, không dấu',
            'type.required' => 'Vui lòng chọn loại khuyến mãi',
            'reduce.required' => 'Vui lòng nhập giá trị giảm',
            'qty.required' => 'Vui lòng nhập số lượng',
            'end_date.after_or_equal' => 'Ngày hết hạn phải sau hoặc bằng ngày áp dụng',
        ]);

        if ($validated['type'] == 1 && $validated['reduce'] > 100) {
            return back()
                ->withInput()
                ->withErrors(['reduce' => 'Giá trị giảm theo phần trăm phải từ 0 đến 100']);
        }

        try {
            $validated['code'] = strtoupper(trim($validated['code']));
            $voucher->update($validated);

            return redirect()
                ->route('voucher.index')
                ->with('success', 'Cập nhật mã khuyến mãi thành công!');

        } catch (\Exception $e) {
            Log::error('Error updating voucher: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function destroy(Voucher $voucher)
    {
        try {
            $voucher->delete();
            
            return redirect()
                ->route('voucher.index')
                ->with('success', 'Xóa mã khuyến mãi thành công!');
                
        } catch (\Exception $e) {
            Log::error('Error deleting voucher: ' . $e->getMessage());
            
            return back()
                ->with('error', 'Có lỗi xảy ra khi xóa: ' . $e->getMessage());
        }
    }
}