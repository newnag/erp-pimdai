@extends('layouts.app')

@section('title', 'รายละเอียดผู้ติดต่อ')

@section('page-title', 'รายละเอียดผู้ติดต่อ')
@section('page-subtitle', $customer->company_name ?: $customer->contact_name ?: '-')

@push('styles')
<style>
    /* ===== Detail Container ===== */
    .customer-detail-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .detail-header-actions {
        display: flex;
        gap: 10px;
        margin-bottom: 24px;
        justify-content: flex-end;
    }

    /* ===== Detail Grid ===== */
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }

    @media (max-width: 1200px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }
    }

    .detail-card {
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

    /* ===== Detail Row ===== */
    .detail-row {
        display: flex;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        flex: 0 0 160px;
        font-size: 0.85rem;
        font-weight: 500;
        color: #64748b;
    }

    .detail-value {
        flex: 1;
        font-size: 0.9rem;
        color: #1e293b;
        word-break: break-word;
    }

    .detail-value a {
        color: #2563eb;
        text-decoration: none;
    }

    .detail-value a:hover {
        text-decoration: underline;
    }

    /* ===== Type Badge ===== */
    .type-badge {
        display: inline-block;
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .customer-badge {
        background: #dbeafe;
        color: #2563eb;
    }

    .vendor-badge {
        background: #fef3c7;
        color: #d97706;
    }

    .contact-type-badge {
        background: #f1f5f9;
        color: #475569;
    }

    .branch-badge {
        background: #ecfdf5;
        color: #059669;
    }

    /* ===== Empty Value ===== */
    .text-empty {
        color: #cbd5e1;
        font-style: italic;
    }

    /* ===== Responsive ===== */
    @media (max-width: 576px) {
        .detail-row {
            flex-direction: column;
            gap: 4px;
        }

        .detail-label {
            flex: none;
        }

        .detail-card {
            padding: 20px;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="customer-detail-container">
        {{-- Header Actions --}}
        <div class="detail-header-actions">
            <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> กลับ
            </a>
            <a href="{{ route('customers.edit', $customer) }}" class="btn btn-primary">
                <i class="fas fa-edit me-1"></i> แก้ไข
            </a>
        </div>

        <div class="detail-grid">
            {{-- Left Column: Contact Information --}}
            <div class="detail-card">
                <h2 class="section-heading">ข้อมูลผู้ติดต่อ</h2>

                <div class="detail-row">
                    <div class="detail-label">ประเภทผู้ติดต่อ</div>
                    <div class="detail-value">
                        <span class="type-badge contact-type-badge">
                            {{ $customer->contact_type === 'Corporate' ? 'นิติบุคคล' : 'บุคคลธรรมดา' }}
                        </span>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">ประเภท</div>
                    <div class="detail-value">
                        @if($customer->customer_type === 'Customer')
                            <span class="type-badge customer-badge">ลูกค้า</span>
                        @else
                            <span class="type-badge vendor-badge">ผู้จำหน่าย</span>
                        @endif
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">เครดิต (วัน)</div>
                    <div class="detail-value">
                        {{ $customer->credit_limit ? number_format($customer->credit_limit, 0) : '-' }}
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">รหัสผู้ติดต่อ</div>
                    <div class="detail-value">
                        {!! $customer->contact_id ?: '<span class="text-empty">ไม่ระบุ</span>' !!}
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">ชื่อธุรกิจ</div>
                    <div class="detail-value">
                        {!! $customer->company_name ?: '<span class="text-empty">ไม่ระบุ</span>' !!}
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">เลขผู้เสียภาษี</div>
                    <div class="detail-value">
                        {!! $customer->tax_id ?: '<span class="text-empty">ไม่ระบุ</span>' !!}
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">สำนักงาน/สาขา</div>
                    <div class="detail-value">
                        @if($customer->com_branch === 'Head')
                            <span class="type-badge branch-badge">สำนักงานใหญ่</span>
                        @elseif($customer->com_branch === 'Branch')
                            <span class="type-badge branch-badge">สาขา</span>
                        @else
                            <span class="text-empty">ไม่ระบุ</span>
                        @endif
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">ที่อยู่</div>
                    <div class="detail-value">
                        {!! $customer->address ? nl2br(e($customer->address)) : '<span class="text-empty">ไม่ระบุ</span>' !!}
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">รหัสไปรษณีย์</div>
                    <div class="detail-value">
                        {!! $customer->postal_code ?: '<span class="text-empty">ไม่ระบุ</span>' !!}
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">ข้อมูลจัดส่ง</div>
                    <div class="detail-value">
                        {!! $customer->delivery_note ? nl2br(e($customer->delivery_note)) : '<span class="text-empty">ไม่ระบุ</span>' !!}
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">เบอร์สำนักงาน</div>
                    <div class="detail-value">
                        {!! $customer->phone ?: '<span class="text-empty">ไม่ระบุ</span>' !!}
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">อีเมล</div>
                    <div class="detail-value">
                        @if($customer->email)
                            <a href="mailto:{{ $customer->email }}">{{ $customer->email }}</a>
                        @else
                            <span class="text-empty">ไม่ระบุ</span>
                        @endif
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">เว็บไซต์</div>
                    <div class="detail-value">
                        @if($customer->website)
                            <a href="{{ $customer->website }}" target="_blank">{{ $customer->website }}</a>
                        @else
                            <span class="text-empty">ไม่ระบุ</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right Column: Contact Details & Bank Info --}}
            <div class="detail-card">
                <h2 class="section-heading">รายละเอียดผู้ติดต่อ</h2>

                <div class="detail-row">
                    <div class="detail-label">ชื่อผู้ติดต่อ</div>
                    <div class="detail-value">
                        {!! $customer->contact_name ?: '<span class="text-empty">ไม่ระบุ</span>' !!}
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">อีเมลผู้ติดต่อ</div>
                    <div class="detail-value">
                        @if($customer->contact_email)
                            <a href="mailto:{{ $customer->contact_email }}">{{ $customer->contact_email }}</a>
                        @else
                            <span class="text-empty">ไม่ระบุ</span>
                        @endif
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">เบอร์ติดต่อ</div>
                    <div class="detail-value">
                        {!! $customer->contact_phone ?: '<span class="text-empty">ไม่ระบุ</span>' !!}
                    </div>
                </div>

                {{-- Bank Info --}}
                <h2 class="section-heading section-heading-blue">ข้อมูลธนาคาร</h2>

                <div class="detail-row">
                    <div class="detail-label">ธนาคาร</div>
                    <div class="detail-value">
                        @php
                            $bankNames = [
                                'BBL'   => 'ธนาคารกรุงเทพ',
                                'KBANK' => 'ธนาคารกสิกรไทย',
                                'KTB'   => 'ธนาคารกรุงไทย',
                                'TMB'   => 'ธนาคารทหารไทย',
                                'SCB'   => 'ธนาคารไทยพาณิชย์',
                                'BAY'   => 'ธนาคารกรุงศรีอยุธยา',
                                'GSB'   => 'ธนาคารออมสิน',
                                'BAAC'  => 'ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตร',
                            ];
                        @endphp
                        {!! $customer->bank ? ($bankNames[$customer->bank] ?? $customer->bank) : '<span class="text-empty">ไม่ระบุ</span>' !!}
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">ชื่อบัญชี</div>
                    <div class="detail-value">
                        {!! $customer->bank_name ?: '<span class="text-empty">ไม่ระบุ</span>' !!}
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">เลขที่บัญชี</div>
                    <div class="detail-value">
                        {!! $customer->bank_acc_no ?: '<span class="text-empty">ไม่ระบุ</span>' !!}
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">ชื่อสาขา</div>
                    <div class="detail-value">
                        {!! $customer->bank_branch ?: '<span class="text-empty">ไม่ระบุ</span>' !!}
                    </div>
                </div>

                {{-- Additional Info --}}
                <h2 class="section-heading section-heading-blue">ข้อมูลเพิ่มเติม</h2>

                <div class="detail-row">
                    <div class="detail-label">แนบไฟล์</div>
                    <div class="detail-value">
                        @if($customer->link_file)
                            <a href="{{ $customer->link_file }}" target="_blank">
                                <i class="fas fa-paperclip me-1"></i> ดูไฟล์แนบ
                            </a>
                        @else
                            <span class="text-empty">ไม่มีไฟล์แนบ</span>
                        @endif
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">โน้ต</div>
                    <div class="detail-value">
                        {!! $customer->note ? nl2br(e($customer->note)) : '<span class="text-empty">ไม่ระบุ</span>' !!}
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">สร้างเมื่อ</div>
                    <div class="detail-value">
                        {{ $customer->created_at?->format('d/m/Y H:i') ?? '-' }}
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">แก้ไขล่าสุด</div>
                    <div class="detail-value">
                        {{ $customer->updated_at?->format('d/m/Y H:i') ?? '-' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
