@extends('layouts.app')

@section('title', 'สร้างรายชื่อผู้ติดต่อ')

@section('page-title', 'สร้างรายชื่อผู้ติดต่อ')
@section('page-subtitle', 'เพิ่มรายชื่อผู้ติดต่อใหม่')

@push('styles')
<style>
    /* ===== Form Container ===== */
    .customer-form-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* ===== Header Actions ===== */
    .form-header-actions {
        display: flex;
        gap: 10px;
        margin-bottom: 24px;
        justify-content: flex-end;
    }

    /* ===== Form Grid ===== */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 32px;
    }

    @media (max-width: 1200px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }

    .form-column {
        background: #fff;
        border-radius: 12px;
        padding: 28px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    }

    /* ===== Section Heading ===== */
    .section-heading {
        font-size: 1rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e2e8f0;
    }

    .section-heading-blue {
        color: #2563eb;
        border-bottom-color: #bfdbfe;
        margin-top: 28px;
    }

    /* ===== Form Group ===== */
    .form-group {
        margin-bottom: 18px;
    }

    .form-group .form-label {
        font-size: 0.85rem;
        font-weight: 500;
        color: #475569;
        margin-bottom: 6px;
    }

    .form-group .form-control,
    .form-group .form-select {
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        font-size: 0.9rem;
        padding: 10px 14px;
        transition: all 0.2s;
    }

    .form-group .form-control:focus,
    .form-group .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-group textarea.form-control {
        resize: vertical;
        min-height: 60px;
    }

    /* ===== Radio & Checkbox Groups ===== */
    .radio-group,
    .checkbox-group {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .radio-label,
    .checkbox-label {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        font-size: 0.9rem;
        color: #334155;
    }

    .radio-label input[type="radio"],
    .checkbox-label input[type="checkbox"] {
        accent-color: #3b82f6;
        width: 16px;
        height: 16px;
    }

    /* ===== Attach Button ===== */
    .btn-attach {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border: 2px dashed #cbd5e1;
        border-radius: 8px;
        background: #f8fafc;
        color: #64748b;
        font-size: 0.88rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-attach:hover {
        border-color: #3b82f6;
        color: #3b82f6;
        background: #eff6ff;
    }

    /* ===== Validation ===== */
    .is-invalid {
        border-color: #ef4444 !important;
    }

    .invalid-feedback {
        font-size: 0.8rem;
    }

    /* ===== Responsive ===== */
    @media (max-width: 768px) {
        .form-header-actions {
            flex-wrap: wrap;
        }

        .form-column {
            padding: 20px;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="customer-form-container">
        {{-- Header Actions --}}
        <div class="form-header-actions">
            <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-times me-1"></i> ปิดหน้าต่าง
            </a>
            <button type="submit" form="customerForm" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> บันทึกแล้วปิด
            </button>
        </div>

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <strong><i class="fas fa-exclamation-triangle me-2"></i>กรุณาตรวจสอบข้อมูล:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form id="customerForm" action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-grid">
                {{-- Left Column: Contact Information --}}
                <div class="form-column">
                    <h2 class="section-heading">ข้อมูลผู้ติดต่อ</h2>

                    {{-- Contact Type --}}
                    <div class="form-group">
                        <label class="form-label">ประเภทผู้ติดต่อ:</label>
                        <div class="radio-group">
                            <label class="radio-label">
                                <input type="radio" name="contact_type" value="Corporate"
                                       {{ old('contact_type', 'Corporate') === 'Corporate' ? 'checked' : '' }}>
                                <span>นิติบุคคล</span>
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="contact_type" value="Individual"
                                       {{ old('contact_type') === 'Individual' ? 'checked' : '' }}>
                                <span>บุคคลธรรมดา</span>
                            </label>
                        </div>
                    </div>

                    {{-- Customer Type --}}
                    <div class="form-group">
                        <label class="form-label">ประเภท:</label>
                        <div class="radio-group">
                            <label class="radio-label">
                                <input type="radio" name="customer_type" value="Customer"
                                       {{ old('customer_type', 'Customer') === 'Customer' ? 'checked' : '' }}>
                                <span>ลูกค้า</span>
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="customer_type" value="Vendor"
                                       {{ old('customer_type') === 'Vendor' ? 'checked' : '' }}>
                                <span>ผู้จำหน่าย</span>
                            </label>
                        </div>
                    </div>

                    {{-- Credit Limit --}}
                    <div class="form-group">
                        <label class="form-label">เครดิต (วัน):</label>
                        <input type="number" name="credit_limit" class="form-control @error('credit_limit') is-invalid @enderror"
                               placeholder="จำนวนวัน" min="0" value="{{ old('credit_limit') }}">
                        @error('credit_limit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Contact ID --}}
                    <div class="form-group">
                        <label class="form-label">รหัสผู้ติดต่อ:</label>
                        <input type="text" name="contact_id" class="form-control @error('contact_id') is-invalid @enderror"
                               placeholder="รหัสผู้ติดต่อ" value="{{ old('contact_id') }}">
                        @error('contact_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Company Name --}}
                    <div class="form-group">
                        <label class="form-label">
                            ชื่อธุรกิจ:
                            <i class="fas fa-info-circle text-muted" title="กรอกชื่อบริษัท/ร้านค้า"></i>
                        </label>
                        <textarea name="company_name" class="form-control @error('company_name') is-invalid @enderror"
                                  rows="2" placeholder="ตัวอย่างการกรอก: บริษัท โฟลว์แอคเคานท์ จำกัด">{{ old('company_name') }}</textarea>
                        @error('company_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tax ID --}}
                    <div class="form-group">
                        <label class="form-label">เลขประจำตัวผู้เสียภาษี:</label>
                        <input type="text" name="tax_id" class="form-control @error('tax_id') is-invalid @enderror"
                               placeholder="เลขประจำตัวผู้เสียภาษี" maxlength="13" value="{{ old('tax_id') }}">
                        @error('tax_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Branch Type --}}
                    <div class="form-group">
                        <label class="form-label">สำนักงาน/สาขา:</label>
                        <div class="radio-group">
                            <label class="radio-label">
                                <input type="radio" name="com_branch" value="Head"
                                       {{ old('com_branch', 'Head') === 'Head' ? 'checked' : '' }}>
                                <span>สำนักงานใหญ่</span>
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="com_branch" value="Branch"
                                       {{ old('com_branch') === 'Branch' ? 'checked' : '' }}>
                                <span>สาขา</span>
                            </label>
                        </div>
                    </div>

                    {{-- Address --}}
                    <div class="form-group">
                        <label class="form-label">ที่อยู่:</label>
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror"
                                  rows="3" placeholder="ที่อยู่">{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Postal Code --}}
                    <div class="form-group">
                        <label class="form-label">รหัสไปรษณีย์:</label>
                        <input type="text" name="postal_code" class="form-control @error('postal_code') is-invalid @enderror"
                               placeholder="รหัสไปรษณีย์" maxlength="5" value="{{ old('postal_code') }}">
                        @error('postal_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Delivery Note --}}
                    <div class="form-group">
                        <label class="form-label">ข้อมูลจัดส่ง:</label>
                        <textarea name="delivery_note" class="form-control @error('delivery_note') is-invalid @enderror"
                                  rows="3" placeholder="ข้อมูลสำหรับการจัดส่ง">{{ old('delivery_note') }}</textarea>
                        @error('delivery_note')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Office Phone --}}
                    <div class="form-group">
                        <label class="form-label">เบอร์สำนักงาน:</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                               placeholder="เบอร์สำนักงาน" value="{{ old('phone') }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Website --}}
                    <div class="form-group">
                        <label class="form-label">เว็บไซต์:</label>
                        <input type="url" name="website" class="form-control @error('website') is-invalid @enderror"
                               placeholder="https://" value="{{ old('website') }}">
                        @error('website')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="form-group">
                        <label class="form-label">อีเมล:</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               placeholder="อีเมล" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Right Column: Contact Details & Bank Info --}}
                <div class="form-column">
                    <h2 class="section-heading">รายละเอียดผู้ติดต่อ</h2>

                    {{-- Contact Name --}}
                    <div class="form-group">
                        <label class="form-label">ชื่อผู้ติดต่อ:</label>
                        <input type="text" name="contact_name" class="form-control @error('contact_name') is-invalid @enderror"
                               placeholder="ชื่อผู้ติดต่อ" value="{{ old('contact_name') }}">
                        @error('contact_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Contact Email --}}
                    <div class="form-group">
                        <label class="form-label">อีเมลผู้ติดต่อ:</label>
                        <input type="email" name="contact_email" class="form-control @error('contact_email') is-invalid @enderror"
                               placeholder="อีเมลผู้ติดต่อ" value="{{ old('contact_email') }}">
                        @error('contact_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Contact Phone --}}
                    <div class="form-group">
                        <label class="form-label">เบอร์ติดต่อ:</label>
                        <input type="tel" name="contact_phone" class="form-control @error('contact_phone') is-invalid @enderror"
                               placeholder="เบอร์ติดต่อ" value="{{ old('contact_phone') }}">
                        @error('contact_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Bank Information --}}
                    <h2 class="section-heading section-heading-blue">ข้อมูลธนาคาร</h2>

                    {{-- Bank --}}
                    <div class="form-group">
                        <label class="form-label">ธนาคาร:</label>
                        <select name="bank" class="form-select @error('bank') is-invalid @enderror">
                            <option value="">กรุณาเลือกธนาคาร</option>
                            <option value="BBL" {{ old('bank') === 'BBL' ? 'selected' : '' }}>ธนาคารกรุงเทพ</option>
                            <option value="KBANK" {{ old('bank') === 'KBANK' ? 'selected' : '' }}>ธนาคารกสิกรไทย</option>
                            <option value="KTB" {{ old('bank') === 'KTB' ? 'selected' : '' }}>ธนาคารกรุงไทย</option>
                            <option value="TMB" {{ old('bank') === 'TMB' ? 'selected' : '' }}>ธนาคารทหารไทย</option>
                            <option value="SCB" {{ old('bank') === 'SCB' ? 'selected' : '' }}>ธนาคารไทยพาณิชย์</option>
                            <option value="BAY" {{ old('bank') === 'BAY' ? 'selected' : '' }}>ธนาคารกรุงศรีอยุธยา</option>
                            <option value="GSB" {{ old('bank') === 'GSB' ? 'selected' : '' }}>ธนาคารออมสิน</option>
                            <option value="BAAC" {{ old('bank') === 'BAAC' ? 'selected' : '' }}>ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตร</option>
                        </select>
                        @error('bank')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Bank Account Name --}}
                    <div class="form-group">
                        <label class="form-label">ชื่อบัญชี:</label>
                        <input type="text" name="bank_name" class="form-control @error('bank_name') is-invalid @enderror"
                               placeholder="ชื่อบัญชี" value="{{ old('bank_name') }}">
                        @error('bank_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Bank Account Number --}}
                    <div class="form-group">
                        <label class="form-label">เลขที่บัญชี:</label>
                        <input type="text" name="bank_acc_no" class="form-control @error('bank_acc_no') is-invalid @enderror"
                               placeholder="เลขที่บัญชี" value="{{ old('bank_acc_no') }}">
                        @error('bank_acc_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Bank Branch --}}
                    <div class="form-group">
                        <label class="form-label">ชื่อสาขา:</label>
                        <input type="text" name="bank_branch" class="form-control @error('bank_branch') is-invalid @enderror"
                               placeholder="ชื่อสาขา" value="{{ old('bank_branch') }}">
                        @error('bank_branch')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Additional Information --}}
                    <h2 class="section-heading section-heading-blue">ข้อมูลเพิ่มเติม</h2>

                    {{-- File Attachment --}}
                    <div class="form-group">
                        <label class="form-label">
                            แนบไฟล์:
                            <i class="fas fa-info-circle text-muted" title="แนบเอกสารเพิ่มเติม"></i>
                        </label>
                        <label class="btn-attach" for="attachmentInput">
                            <i class="fas fa-paperclip"></i>
                            แนบไฟล์
                        </label>
                        <input type="file" name="link_file" id="attachmentInput" class="d-none">
                        <small class="text-muted d-block mt-1" id="fileName"></small>
                    </div>

                    {{-- Note --}}
                    <div class="form-group">
                        <label class="form-label">โน้ต:</label>
                        <textarea name="note" class="form-control @error('note') is-invalid @enderror"
                                  rows="4" placeholder="โน้ต">{{ old('note') }}</textarea>
                        @error('note')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Show selected filename
    document.getElementById('attachmentInput')?.addEventListener('change', function() {
        const fileName = this.files[0]?.name || '';
        document.getElementById('fileName').textContent = fileName;
    });
</script>
@endpush
