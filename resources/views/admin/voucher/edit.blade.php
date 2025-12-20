@extends('admin.layout.master')
@section('title', 'Voucher Edit')
@section('body')

    <!-- Main -->
    <div class="app-main__inner">

        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-ticket icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>
                        Voucher
                        <div class="page-title-subheading">
                            View, create, update, delete and manage.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <form method="post" action="{{ route('voucher.update', $voucher->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                                                                               
                            <div class="position-relative row form-group">
                                <label for="title" class="col-md-3 text-md-right col-form-label">Tiêu đề khuyến mãi</label>
                                <div class="col-md-9 col-xl-8">
                                    <input required name="title" id="title" placeholder="Nhập tiêu đề khuyến mãi" type="text"
                                        class="form-control" value="{{ old('title', $voucher->title) }}">
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="code" class="col-md-3 text-md-right col-form-label">Mã khuyến mãi</label>
                                <div class="col-md-9 col-xl-8">
                                    <input required name="code" id="code"
                                        placeholder="Mã khuyến mãi (VD: WINTER2025)" type="text" class="form-control" value="{{ old('code', $voucher->code) }}">
                                    <small class="form-text text-muted">Mã phải là chữ IN HOA, không dấu, không khoảng trắng</small>
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="type" class="col-md-3 text-md-right col-form-label">Loại khuyến mãi</label>
                                <div class="col-md-9 col-xl-8">
                                    <select required name="type" id="type" class="form-control">
                                        <option value="">-- Chọn loại khuyến mãi --</option>
                                        <option value="1" {{ old('type', $voucher->type) == '1' ? 'selected' : '' }}>Giảm theo phần trăm (%)</option>
                                        <option value="2" {{ old('type', $voucher->type) == '2' ? 'selected' : '' }}>Giảm giá trị tiền cố định (VNĐ)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="reduce" class="col-md-3 text-md-right col-form-label">
                                    Giá trị giảm <span id="reduce-unit"></span>
                                </label>
                                <div class="col-md-9 col-xl-8">
                                    <div class="input-group">
                                        <input required name="reduce" id="reduce"
                                            placeholder="Nhập giá trị giảm" type="number" min="0" step="0.01" 
                                            class="form-control" value="{{ old('reduce', $voucher->reduce) }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="reduce-suffix"></span>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted" id="reduce-hint"></small>
                                </div>
                            </div>

                            <!-- THÊM FIELD MAX_DISCOUNT -->
                            <div class="position-relative row form-group" id="max-discount-group" style="display:none;">
                                <label for="max_discount" class="col-md-3 text-md-right col-form-label">
                                    <i class="fa fa-hand-holding-usd mr-2"></i>Giảm tối đa (VNĐ)
                                </label>
                                <div class="col-md-9 col-xl-8">
                                    <div class="input-group">
                                        <input
                                            name="max_discount"
                                            id="max_discount"
                                            placeholder="Nhập số tiền giảm tối đa"
                                            type="number"
                                            min="0"
                                            class="form-control"
                                            value="{{ old('max_discount', $voucher->max_discount ?? '') }}"
                                        >
                                        <div class="input-group-append">
                                            <span class="input-group-text">VNĐ</span>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">
                                        Chỉ áp dụng cho voucher giảm theo phần trăm. Để trống nếu không giới hạn.
                                    </small>
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="qty" class="col-md-3 text-md-right col-form-label">Số lượng</label>
                                <div class="col-md-9 col-xl-8">
                                    <input required name="qty" id="qty"
                                        placeholder="Nhập số lượng code" type="number" min="1" class="form-control" value="{{ old('qty', $voucher->qty) }}">
                                    <small class="form-text text-muted">Số lần mã có thể được sử dụng</small>
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="min_total_value" class="col-md-3 text-md-right col-form-label">
                                    <i class="fa fa-money-bill-wave mr-2"></i>Đơn hàng tối thiểu
                                </label>
                                <div class="col-md-9 col-xl-8">
                                    <div class="input-group">
                                        <input
                                            type="number"
                                            name="min_total_value"
                                            id="min_total_value"
                                            class="form-control"
                                            min="0"
                                            placeholder="Nhập giá trị đơn tối thiểu"
                                            value="{{ old('min_total_value', $voucher->min_total_value ?? 0) }}"
                                        >
                                        <div class="input-group-append">
                                            <span class="input-group-text">VNĐ</span>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">
                                        Nhập <strong>0</strong> nếu không giới hạn giá trị đơn hàng
                                    </small>
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="start_date" class="col-md-3 text-md-right col-form-label">Ngày áp dụng</label>
                                <div class="col-md-9 col-xl-8">
                                    <input
                                        required
                                        name="start_date"
                                        id="start_date"
                                        type="date"
                                        class="form-control"
                                        value="{{ old('start_date', \Carbon\Carbon::parse($voucher->start_date)->format('Y-m-d')) }}"
                                    >
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="end_date" class="col-md-3 text-md-right col-form-label">Ngày hết hạn</label>
                                <div class="col-md-9 col-xl-8">
                                    <input
                                        required
                                        name="end_date"
                                        id="end_date"
                                        type="date"
                                        class="form-control"
                                        value="{{ old('end_date', \Carbon\Carbon::parse($voucher->end_date)->format('Y-m-d')) }}"
                                    >
                                </div>
                            </div>

                            
                            <div class="position-relative row form-group mb-1"> 
                                <div class="col-md-9 col-xl-8 offset-md-3">
                                    <a href="{{ route('voucher.index') }}" class="border-0 btn btn-outline-danger mr-1">
                                        <span class="btn-icon-wrapper pr-1 opacity-8">
                                            <i class="fa fa-times fa-w-20"></i>
                                        </span>
                                        <span>Hủy</span>
                                    </a>
                                    <button type="submit" class="btn-shadow btn-hover-shine btn btn-primary">
                                        <span class="btn-icon-wrapper pr-2 opacity-8">
                                            <i class="fa fa-download fa-w-20"></i>
                                        </span>
                                        <span>Lưu</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Main -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('type');
            const reduceInput = document.getElementById('reduce');
            const reduceUnit = document.getElementById('reduce-unit');
            const reduceSuffix = document.getElementById('reduce-suffix');
            const reduceHint = document.getElementById('reduce-hint');
            const maxDiscountGroup = document.getElementById('max-discount-group');
            const maxDiscountInput = document.getElementById('max_discount');

            // Function để update giao diện
            function updateReduceField() {
                const selectedType = typeSelect.value;
                
                if (selectedType === '1') {
                    // Giảm theo phần trăm
                    reduceUnit.textContent = '(%)';
                    reduceSuffix.textContent = '%';
                    reduceInput.placeholder = 'VD: 30';
                    reduceInput.setAttribute('max', '100');
                    reduceHint.textContent = 'Nhập giá trị từ 0 đến 100';
                    
                    // HIỂN THỊ FIELD MAX DISCOUNT
                    maxDiscountGroup.style.display = 'flex';
                    
                } else if (selectedType === '2') {
                    // Giảm giá trị tiền
                    reduceUnit.textContent = '(VNĐ)';
                    reduceSuffix.textContent = 'VNĐ';
                    reduceInput.placeholder = 'VD: 50000';
                    reduceInput.removeAttribute('max');
                    reduceHint.textContent = 'Nhập số tiền giảm (VNĐ)';
                    
                    // ẨN FIELD MAX DISCOUNT VÀ XÓA GIÁ TRỊ
                    maxDiscountGroup.style.display = 'none';
                    maxDiscountInput.value = '';
                    
                } else {
                    // Chưa chọn
                    reduceUnit.textContent = '';
                    reduceSuffix.textContent = '';
                    reduceInput.placeholder = 'Vui lòng chọn loại khuyến mãi trước';
                    reduceHint.textContent = '';
                    maxDiscountGroup.style.display = 'none';
                }
            }

            // Lắng nghe sự kiện thay đổi
            typeSelect.addEventListener('change', updateReduceField);

            // Khởi tạo lần đầu (cho trường hợp old() value hoặc dữ liệu từ database)
            updateReduceField();

            // Validate ngày
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');

            startDateInput.addEventListener('change', function() {
                endDateInput.setAttribute('min', this.value);
            });

            endDateInput.addEventListener('change', function() {
                if (this.value < startDateInput.value) {
                    alert('Ngày hết hạn phải sau ngày áp dụng!');
                    this.value = '';
                }
            });
        });
    </script>

@endsection