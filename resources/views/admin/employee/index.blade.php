@extends('admin.layouts.admin')

@section('title', 'Employee Directory - Skills Hut Ltd')

@push('styles')
<style>
    .page-title { font-family: 'Outfit', sans-serif; font-size: 1.8rem; font-weight: 700; color: #1A1A1A; }
    .page-subtitle { font-size: 0.88rem; color: #7F7F7F; }

    .btn-export { background: #fff; border: 1px solid #E2E0DD; color: #1A1A1A; border-radius: 8px; font-weight: 600; font-size: 0.88rem; padding: 10px 20px; transition: all 0.2s; }
    .btn-export:hover { background: #FAF9F6; }
    .btn-add-emp { background: #FF5E2B; color: #fff; border: none; border-radius: 8px; font-weight: 600; font-size: 0.88rem; padding: 10px 20px; transition: all 0.2s; }
    .btn-add-emp:hover { background: #E04B1A; color: #fff; }

    /* Filter Bar */
    .filter-bar { background: #fff; border: 1px solid #E2E0DD; border-radius: 12px; padding: 14px 20px; }
    .filter-select { border: 1px solid #E2E0DD; border-radius: 8px; font-size: 0.85rem; color: #1A1A1A; padding: 7px 32px 7px 12px; background: #FAF9F6; appearance: none; cursor: pointer; }
    .filter-select:focus { outline: none; border-color: #FF5E2B; box-shadow: 0 0 0 3px rgba(255,94,43,0.1); }
    .view-toggle { border: 1px solid #E2E0DD; border-radius: 8px; overflow: hidden; display: flex; }
    .view-btn { background: none; border: none; padding: 7px 10px; color: #7F7F7F; transition: all 0.2s; }
    .view-btn.active { background: #FF5E2B; color: #fff; }
    .view-btn:hover:not(.active) { background: #FAF9F6; }

    /* Employee Card */
    .emp-card { background: #fff; border: 1px solid #E2E0DD; border-radius: 14px; padding: 20px; transition: all 0.2s; height: 100%; }
    .emp-card:hover { border-color: #FF5E2B; box-shadow: 0 4px 16px rgba(255,94,43,0.08); transform: translateY(-2px); }

    .emp-photo-wrap { position: relative; display: inline-block; margin-bottom: 14px; }
    .emp-photo { width: 72px; height: 72px; border-radius: 10px; object-fit: cover; filter: grayscale(20%); }
    .emp-photo-placeholder { width: 72px; height: 72px; border-radius: 10px; background: #F4F4F0; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: #B2ADA7; }

    .status-badge { position: absolute; top: -8px; right: -8px; font-size: 0.65rem; font-weight: 700; padding: 3px 8px; border-radius: 20px; letter-spacing: 0.3px; }
    .status-active { background: #ECFDF5; color: #059669; }
    .status-leave { background: #FEF3C7; color: #D97706; }
    .status-inactive { background: #F4F4F0; color: #7F7F7F; }

    .emp-name { font-family: 'Outfit', sans-serif; font-size: 1.05rem; font-weight: 700; color: #1A1A1A; margin-bottom: 2px; }
    .emp-role { font-size: 0.78rem; font-weight: 600; color: #FF5E2B; margin-bottom: 4px; }
    .emp-dept { font-size: 0.78rem; color: #7F7F7F; display: flex; align-items: center; gap: 4px; }

    .emp-divider { border-color: #F4F4F0; margin: 14px 0; }

    .emp-avatar-initials { width: 30px; height: 30px; border-radius: 50%; background: #F4F4F0; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700; color: #4A4A4A; }
    .link-view { color: #FF5E2B; font-size: 0.82rem; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 4px; }
    .link-view:hover { text-decoration: underline; color: #E04B1A; }

    /* Add New Card */
    .emp-card-add { background: #fff; border: 2px dashed #C0BAB4; border-radius: 14px; padding: 20px; display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 220px; cursor: pointer; transition: all 0.2s; }
    .emp-card-add:hover { border-color: #FF5E2B; background: #FFF8F5; }
    .add-icon { width: 44px; height: 44px; border-radius: 50%; background: #F4F4F0; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; color: #7F7F7F; margin-bottom: 10px; transition: all 0.2s; }
    .emp-card-add:hover .add-icon { background: #FF5E2B; color: #fff; }
    .add-label { font-size: 0.85rem; color: #7F7F7F; font-weight: 500; }

    /* Pagination */
    .pagination-info { font-size: 0.82rem; color: #7F7F7F; }
    .page-btn { width: 34px; height: 34px; border-radius: 8px; border: 1px solid #E2E0DD; background: #fff; color: #1A1A1A; font-size: 0.82rem; font-weight: 600; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; }
    .page-btn:hover { border-color: #FF5E2B; color: #FF5E2B; }
    .page-btn.active { background: #FF5E2B; color: #fff; border-color: #FF5E2B; }
    .page-btn.disabled { color: #C0BAB4; cursor: not-allowed; }
    .page-btn.disabled:hover { border-color: #E2E0DD; color: #C0BAB4; }
</style>
@endpush

@section('content')

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="page-title mb-1">Employee Directory</h1>
            <p class="page-subtitle mb-0">Manage and view all team members across the organization.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn-export d-flex align-items-center gap-2">
                <i class="bi bi-download"></i> Export
            </button>
            <button class="btn-add-emp d-flex align-items-center gap-2">
                <i class="bi bi-person-plus"></i> Add Employee
            </button>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="filter-bar d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <span style="font-size:0.82rem; font-weight:600; color:#7F7F7F;">Filter by:</span>
            <div style="position:relative;">
                <select class="filter-select">
                    <option>All Departments</option>
                    <option>Engineering</option>
                    <option>Human Resources</option>
                    <option>Marketing</option>
                    <option>Design</option>
                    <option>Sales</option>
                </select>
                <i class="bi bi-chevron-down" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);font-size:0.7rem;color:#7F7F7F;pointer-events:none;"></i>
            </div>
            <div style="position:relative;">
                <select class="filter-select">
                    <option>All Roles</option>
                    <option>Team Lead</option>
                    <option>Employee</option>
                    <option>HR Admin</option>
                </select>
                <i class="bi bi-chevron-down" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);font-size:0.7rem;color:#7F7F7F;pointer-events:none;"></i>
            </div>
            <div style="position:relative;">
                <select class="filter-select">
                    <option>Status: All</option>
                    <option>Active</option>
                    <option>On Leave</option>
                    <option>Inactive</option>
                </select>
                <i class="bi bi-chevron-down" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);font-size:0.7rem;color:#7F7F7F;pointer-events:none;"></i>
            </div>
        </div>
        <div class="view-toggle">
            <button class="view-btn active" id="grid-view"><i class="bi bi-grid"></i></button>
            <button class="view-btn" id="list-view"><i class="bi bi-list-ul"></i></button>
        </div>
    </div>

    {{-- Employee Grid --}}
    <div class="row g-3 mb-4">

        {{-- Card 1 --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="emp-card">
                <div class="emp-photo-wrap">
                    <img src="{{ asset('images/admin_avatar.png') }}" class="emp-photo" alt="Sarah Jenkins">
                    <span class="status-badge status-active">ACTIVE</span>
                </div>
                <div class="emp-name">Sarah Jenkins</div>
                <div class="emp-role">Lead UX Designer</div>
                <div class="emp-dept"><i class="bi bi-building" style="font-size:0.7rem;"></i> Product Design</div>
                <hr class="emp-divider">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="emp-avatar-initials">SJ</div>
                    <a href="#" class="link-view">View Profile <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>

        {{-- Card 2 --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="emp-card">
                <div class="emp-photo-wrap">
                    <img src="{{ asset('images/admin_avatar.png') }}" class="emp-photo" alt="David Chen">
                    <span class="status-badge status-leave">ON LEAVE</span>
                </div>
                <div class="emp-name">David Chen</div>
                <div class="emp-role">Senior Backend Engineer</div>
                <div class="emp-dept"><i class="bi bi-building" style="font-size:0.7rem;"></i> Engineering</div>
                <hr class="emp-divider">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="emp-avatar-initials">DC</div>
                    <a href="#" class="link-view">View Profile <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>

        {{-- Card 3 --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="emp-card">
                <div class="emp-photo-wrap">
                    <img src="{{ asset('images/admin_avatar.png') }}" class="emp-photo" alt="Amara Okafor">
                    <span class="status-badge status-active">ACTIVE</span>
                </div>
                <div class="emp-name">Amara Okafor</div>
                <div class="emp-role">HR Manager</div>
                <div class="emp-dept"><i class="bi bi-building" style="font-size:0.7rem;"></i> Human Resources</div>
                <hr class="emp-divider">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="emp-avatar-initials">AO</div>
                    <a href="#" class="link-view">View Profile <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>

        {{-- Card 4 --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="emp-card">
                <div class="emp-photo-wrap">
                    <img src="{{ asset('images/admin_avatar.png') }}" class="emp-photo" alt="Marcus Thorne">
                    <span class="status-badge status-active">ACTIVE</span>
                </div>
                <div class="emp-name">Marcus Thorne</div>
                <div class="emp-role">Marketing Director</div>
                <div class="emp-dept"><i class="bi bi-building" style="font-size:0.7rem;"></i> Growth & Ops</div>
                <hr class="emp-divider">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="emp-avatar-initials">MT</div>
                    <a href="#" class="link-view">View Profile <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>

        {{-- Card 5 --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="emp-card">
                <div class="emp-photo-wrap">
                    <img src="{{ asset('images/admin_avatar.png') }}" class="emp-photo" alt="Elena Rodriguez">
                    <span class="status-badge status-active">ACTIVE</span>
                </div>
                <div class="emp-name">Elena Rodriguez</div>
                <div class="emp-role">UI Developer</div>
                <div class="emp-dept"><i class="bi bi-building" style="font-size:0.7rem;"></i> Engineering</div>
                <hr class="emp-divider">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="emp-avatar-initials">ER</div>
                    <a href="#" class="link-view">View Profile <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>

        {{-- Add New --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="emp-card-add">
                <div class="add-icon"><i class="bi bi-plus-lg"></i></div>
                <div class="add-label">Add New Employee</div>
            </div>
        </div>

    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-between align-items-center">
        <span class="pagination-info">Showing 1 to 5 of 42 employees</span>
        <div class="d-flex gap-1 align-items-center">
            <button class="page-btn disabled"><i class="bi bi-chevron-left"></i></button>
            <button class="page-btn active">1</button>
            <button class="page-btn">2</button>
            <button class="page-btn">3</button>
            <span style="font-size:0.82rem; color:#7F7F7F; padding: 0 4px;">...</span>
            <button class="page-btn">9</button>
            <button class="page-btn"><i class="bi bi-chevron-right"></i></button>
        </div>
    </div>

@endsection