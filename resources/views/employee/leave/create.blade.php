@extends('employee.layouts.employee')

@section('title', 'Apply for Leave - Skills Hut Ltd')

@push('styles')
<style>
    .breadcrumb-nav {
        font-size: 0.82rem;
        color: #7F7F7F;
        margin-bottom: 20px;
    }
    .breadcrumb-nav a { color: #7F7F7F; text-decoration: none; }
    .breadcrumb-nav a:hover { color: #1A1A1A; }
    .breadcrumb-nav .current { color: #FF5E2B; font-weight: 600; }
    .breadcrumb-sep { margin: 0 8px; color: #C4C4C4; }

    .page-title {
        font-family: 'Outfit', sans-serif;
        font-size: 1.8rem;
        font-weight: 800;
        color: #1A1A1A;
        margin-bottom: 6px;
    }
    .page-subtitle { font-size: 0.88rem; color: #7F7F7F; }

    .notice-box {
        background: #FFF7ED;
        border: 1px solid #FED7AA;
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 0.85rem;
        color: #92400E;
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }
    .notice-box i { color: #FF5E2B; margin-top: 2px; flex-shrink: 0; }

    .form-card {
        background: #fff;
        border: 1px solid #E2E0DD;
        border-radius: 14px;
        padding: 28px;
    }

    .form-section-label {
        font-size: 0.72rem;
        font-weight: 700;
        color: #7F7F7F;
        letter-spacing: 0.6px;
        text-transform: uppercase;
        margin-bottom: 8px;
    }
    .required-star { color: #FF5E2B; }

    /* Balance bar */
    .balance-bar {
        border: 1px solid #E2E0DD;
        border-radius: 10px;
        display: flex;
        overflow: hidden;
        height: 100%;
    }
    .balance-item {
        flex: 1;
        padding: 14px 16px;
        text-align: center;
        border-right: 1px solid #E2E0DD;
    }
    .balance-item:last-child { border-right: none; }
    .balance-item-label {
        font-size: 0.68rem;
        font-weight: 700;
        color: #7F7F7F;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-bottom: 6px;
    }
    .balance-item-value {
        font-family: 'Outfit', sans-serif;
        font-size: 1.3rem;
        font-weight: 700;
        color: #1A1A1A;
    }
    .balance-item-value.pending { color: #FF5E2B; }
    .balance-item-value.used    { color: #7F7F7F; }

    /* Form controls */
    .form-control, .form-select {
        border: 1px solid #E2E0DD;
        border-radius: 8px;
        font-size: 0.88rem;
        color: #1A1A1A;
        padding: 10px 14px;
        background: #fff;
        transition: border-color 0.2s;
    }
    .form-control:focus, .form-select:focus {
        border-color: #FF5E2B;
        box-shadow: 0 0 0 3px rgba(255,94,43,0.08);
        outline: none;
    }
    .form-control::placeholder { color: #C4C4C4; }
    textarea.form-control { resize: vertical; min-height: 120px; }

    /* Duration display */
    .duration-display {
        background: #F4F4F0;
        border-radius: 8px;
        padding: 10px 16px;
        font-size: 0.85rem;
        color: #7F7F7F;
        font-weight: 600;
        text-align: center;
        display: none;
    }
    .duration-display.visible { display: block; }
    .duration-display strong { color: #FF5E2B; font-size: 1rem; }

    /* Upload zone */
    .upload-zone {
        border: 2px dashed #E2B8B0;
        border-radius: 10px;
        padding: 32px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        background: #FFFAF9;
        position: relative;
    }
    .upload-zone:hover {
        border-color: #FF5E2B;
        background: #FFF0EB;
    }
    .upload-zone input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
    }
    .upload-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        border: 1px solid #E2E0DD;
        background: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        color: #FF5E2B;
        margin-bottom: 12px;
    }
    .upload-title {
        font-size: 0.88rem;
        font-weight: 700;
        color: #1A1A1A;
        margin-bottom: 4px;
    }
    .upload-sub { font-size: 0.78rem; color: #7F7F7F; }
    .upload-file-name {
        margin-top: 10px;
        font-size: 0.82rem;
        color: #059669;
        font-weight: 600;
        display: none;
    }

    /* Divider */
    .form-divider {
        border: none;
        border-top: 1px solid #F4F4F0;
        margin: 24px 0;
    }

    /* Buttons */
    .btn-cancel {
        background: #fff;
        border: 1px solid #E2E0DD;
        border-radius: 8px;
        font-size: 0.88rem;
        font-weight: 600;
        color: #1A1A1A;
        padding: 11px 24px;
        text-decoration: none;
        transition: background 0.2s;
    }
    .btn-cancel:hover { background: #F4F4F0; color: #1A1A1A; }

    .btn-submit {
        background: #FF5E2B;
        border: none;
        border-radius: 8px;
        font-size: 0.88rem;
        font-weight: 700;
        color: #fff;
        padding: 11px 28px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background 0.2s;
    }
    .btn-submit:hover { background: #E04B1A; }
</style>
@endpush

@section('content')

{{-- Breadcrumb --}}
<div class="breadcrumb-nav">
    <a href="{{ route('employee.dashboard') }}">Dashboard</a>
    <span class="breadcrumb-sep">›</span>
    <a href="#">Leave Management</a>
    <span class="breadcrumb-sep">›</span>
    <span class="current">New Leave Request</span>
</div>

{{-- Page Header + Notice --}}
<div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
    <div>
        <div class="page-title">Apply for Leave</div>
        <div class="page-subtitle">Fill in the details below to submit your leave request for approval.</div>
    </div>
    <div class="notice-box" style="max-width:380px;">
        <i class="bi bi-info-circle-fill"></i>
    <span><strong>Note:</strong> Your leave request will be sent to your manager for approval.</span>
    </div>
</div>

{{-- Form --}}
<div class="form-card">
   <form action="{{ route('employee.leave_request.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Leave Type + Balance --}}
        <div class="row g-3 align-items-stretch mb-4">
            <div class="col-md-6">
                <div class="form-section-label">Leave Type <span class="required-star">*</span></div>
                <select name="leave_type_id" id="leaveTypeSelect"
                        class="form-select @error('leave_type_id') is-invalid @enderror"
                        required onchange="updateBalance(this)">
                    <option value="" disabled selected>Select leave type</option>
                    @foreach($leaveTypes ?? [] as $type)
                       <option value="{{ $type->id }}"
        data-available="{{ $type->days_allowed ?? 0 }}"
        data-used="0"
        data-pending="0"
        {{ old('leave_type_id') == $type->id ? 'selected' : '' }}>
    {{ $type->name }}
</option>
                    @endforeach
                </select>
                @error('leave_type_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <div class="balance-bar" id="balanceBar">
                    <div class="balance-item">
                        <div class="balance-item-label">Available</div>
                        <div class="balance-item-value" id="balAvailable">  {{ $remainingLeaves ?? 0 }}<span> total</span></div>
                    </div>
                    <div class="balance-item">
                        <div class="balance-item-label">Used</div>
                        <div class="balance-item-value used" id="balUsed">—</div>
                    </div>
                    <div class="balance-item">
                        <div class="balance-item-label">Pending</div>
                        <div class="balance-item-value pending" id="balPending">—</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Start + End Date --}}
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="form-section-label">Start Date <span class="required-star">*</span></div>
                <input type="date" name="from_date" id="fromDate"
                       class="form-control @error('from_date') is-invalid @enderror"
                       value="{{ old('from_date') }}" required
                       onchange="calcDuration()">
                @error('from_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <div class="form-section-label">End Date <span class="required-star">*</span></div>
                <input type="date" name="to_date" id="toDate"
                       class="form-control @error('to_date') is-invalid @enderror"
                       value="{{ old('to_date') }}" required
                       onchange="calcDuration()">
                @error('to_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Duration display --}}
        <div class="duration-display mb-4" id="durationDisplay"></div>

        {{-- Reason --}}
        <div class="mb-4">
            <div class="form-section-label">Show Cause / Reason <span class="required-star">*</span></div>
            <textarea name="reason"
                      class="form-control @error('reason') is-invalid @enderror"
                      placeholder="Briefly explain the reason for your leave request..."
                      required>{{ old('reason') }}</textarea>
            @error('reason')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Document Attachment --}}
        <div class="mb-2">
            <div class="form-section-label">Document Attachment</div>
            <div class="upload-zone" id="uploadZone">
                <input type="file" name="attachment" id="fileInput"
                       accept=".pdf,.jpg,.jpeg,.png"
                       onchange="showFileName(this)">
                <div class="upload-icon"><i class="bi bi-file-earmark-arrow-up"></i></div>
                <div class="upload-title">Click to upload or drag and drop</div>
                <div class="upload-sub">Medical certificate, travel bookings or other supporting docs (PDF, JPG up to 5MB)</div>
                <div class="upload-file-name" id="uploadFileName"></div>
            </div>
            @error('attachment')
                <div class="text-danger mt-1" style="font-size:0.82rem;">{{ $message }}</div>
            @enderror
        </div>

        <hr class="form-divider">

        {{-- Actions --}}
        <div class="d-flex justify-content-end gap-3">
            <a href="#" class="btn-cancel">Cancel</a>
            <button type="submit" class="btn-submit">
                <i class="bi bi-send"></i> Submit Request
            </button>
        </div>

    </form>
</div>

@endsection

@push('scripts')
<script>
    function updateBalance(select) {
        const opt = select.options[select.selectedIndex];
        const available = opt.dataset.available ?? '—';
        const used      = opt.dataset.used      ?? '—';
        const pending   = opt.dataset.pending   ?? '—';

        document.getElementById('balAvailable').textContent = available !== '—' ? available + ' Days' : '—';
        document.getElementById('balUsed').textContent      = used      !== '—' ? used      + ' Days' : '—';
        document.getElementById('balPending').textContent   = pending   !== '—' ? pending   + ' Days' : '—';
    }

    function calcDuration() {
        const from = document.getElementById('fromDate').value;
        const to   = document.getElementById('toDate').value;
        const box  = document.getElementById('durationDisplay');

        if (!from || !to) { box.classList.remove('visible'); return; }

        let start = new Date(from);
        let end   = new Date(to);
        if (end < start) { box.classList.remove('visible'); return; }

        // Count weekdays only (exclude Sat & Sun)
        let days = 0;
        let cur  = new Date(start);
        while (cur <= end) {
            const day = cur.getDay();
            if (day !== 0 && day !== 6) days++;
            cur.setDate(cur.getDate() + 1);
        }

        box.innerHTML = `Duration: <strong>${days} Working Day${days !== 1 ? 's' : ''}</strong> (weekends excluded)`;
        box.classList.add('visible');
    }

    function showFileName(input) {
        const label = document.getElementById('uploadFileName');
        if (input.files && input.files[0]) {
            label.textContent = '✓ ' + input.files[0].name;
            label.style.display = 'block';
        }
    }

    // Drag and drop styling
    const zone = document.getElementById('uploadZone');
    zone.addEventListener('dragover',  e => { e.preventDefault(); zone.style.borderColor = '#FF5E2B'; });
    zone.addEventListener('dragleave', () => { zone.style.borderColor = '#E2B8B0'; });
    zone.addEventListener('drop',      e => { e.preventDefault(); zone.style.borderColor = '#E2B8B0'; });
</script>
@endpush