@extends('admin.layouts.admin')

@section('title', 'TL Assignment - Skills Hut Ltd')

@push('styles')
<style>
    .page-title { font-family: 'Outfit', sans-serif; font-size: 1.2rem; font-weight: 700; color: #1A1A1A; }
    .page-subtitle { font-size: 0.85rem; color: #7F7F7F; }

    /* Filter */
    .filter-select {
        border: 1px solid #E2E0DD;
        border-radius: 8px;
        font-size: 0.85rem;
        padding: 9px 36px 9px 14px;
        background: #fff;
        color: #1A1A1A;
        appearance: none;
        cursor: pointer;
        min-width: 180px;
    }
    .filter-select:focus { outline: none; border-color: #FF5E2B; box-shadow: 0 0 0 3px rgba(255,94,43,0.1); }
    .filter-wrap { position: relative; }
    .filter-wrap .bi-chevron-down { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); font-size: 0.7rem; color: #7F7F7F; pointer-events: none; }

    /* KPI */
    .kpi-card { background: #fff; border: 1px solid #E2E0DD; border-radius: 12px; padding: 20px 24px; display: flex; justify-content: space-between; align-items: center; }
    .kpi-label { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #7F7F7F; margin-bottom: 6px; }
    .kpi-value { font-family: 'Outfit', sans-serif; font-size: 2rem; font-weight: 800; color: #1A1A1A; }
    .kpi-value.orange { color: #FF5E2B; }
    .kpi-icon { width: 40px; height: 40px; border-radius: 50%; background: #FAF9F6; border: 1px solid #E2E0DD; display: flex; align-items: center; justify-content: center; color: #7F7F7F; font-size: 1.1rem; }
    .kpi-icon.orange { background: #FFF3EE; border-color: rgba(255,94,43,0.2); color: #FF5E2B; }

    /* Table */
    .tl-table-wrap { background: #fff; border: 1px solid #E2E0DD; border-radius: 12px; overflow: hidden; }
    .tl-table { width: 100%; margin: 0; }
    .tl-table thead th { font-size: 0.78rem; font-weight: 700; color: #1A1A1A; padding: 16px 20px; border-bottom: 1px solid #E2E0DD; background: #fff; }
    .tl-table tbody tr { border-bottom: 1px solid #F4F4F0; transition: background 0.15s; }
    .tl-table tbody tr:last-child { border-bottom: none; }
    .tl-table tbody tr:hover { background: #FAF9F6; }
    .tl-table td { padding: 18px 20px; vertical-align: middle; }

    .emp-avatar { width: 38px; height: 38px; border-radius: 50%; background: #F4F4F0; display: flex; align-items: center; justify-content: center; font-size: 0.78rem; font-weight: 700; color: #4A4A4A; flex-shrink: 0; }
    .emp-name { font-size: 0.9rem; font-weight: 700; color: #1A1A1A; }
    .emp-id { font-size: 0.75rem; color: #B2ADA7; font-family: monospace; }
    .emp-designation { font-size: 0.85rem; color: #4A4A4A; }

    .badge-member { background: #F4F4F0; color: #4A4A4A; border-radius: 20px; font-size: 0.75rem; font-weight: 600; padding: 5px 12px; display: inline-flex; align-items: center; gap: 5px; }
    .badge-member::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: #B2ADA7; display: inline-block; }
    .badge-tl { background: #FFF3EE; color: #FF5E2B; border-radius: 20px; font-size: 0.75rem; font-weight: 700; padding: 5px 12px; display: inline-flex; align-items: center; gap: 5px; }
    .badge-tl::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: #FF5E2B; display: inline-block; }

    .btn-assign { background: #FF5E2B; color: #fff; border: none; border-radius: 6px; font-size: 0.75rem; font-weight: 800; letter-spacing: 0.5px; padding: 8px 18px; transition: all 0.2s; }
    .btn-assign:hover { background: #E04B1A; color: #fff; }
    .btn-modify { background: #fff; color: #1A1A1A; border: 1px solid #E2E0DD; border-radius: 6px; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px; padding: 8px 18px; transition: all 0.2s; }
    .btn-modify:hover { background: #FAF9F6; border-color: #FF5E2B; color: #FF5E2B; }

    /* Pagination */
    .pagination-wrap { padding: 16px 20px; border-top: 1px solid #E2E0DD; display: flex; justify-content: space-between; align-items: center; }
    .pagination-info { font-size: 0.78rem; color: #7F7F7F; font-family: monospace; }
    .page-btn { width: 32px; height: 32px; border-radius: 6px; border: 1px solid #E2E0DD; background: #fff; color: #1A1A1A; font-size: 0.82rem; font-weight: 600; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; }
    .page-btn:hover { border-color: #FF5E2B; color: #FF5E2B; }
    .page-btn.active { background: #FF5E2B; color: #fff; border-color: #FF5E2B; }
    .page-btn.disabled { color: #C0BAB4; cursor: not-allowed; }
    .page-btn.disabled:hover { border-color: #E2E0DD; color: #C0BAB4; }
</style>
@endpush

@section('content')

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
        <div>
            <h1 class="page-title mb-1">Team Lead Assignment</h1>
            <p class="page-subtitle mb-0">Delegate leadership responsibilities to senior staff members.</p>
        </div>
        <div>
            <div style="font-size:0.75rem; font-weight:700; color:#7F7F7F; margin-bottom:6px; text-transform:uppercase; letter-spacing:0.5px;">Filter by Department</div>
            <div class="filter-wrap">
                <select class="filter-select">
                    <option>Engineering</option>
                    <option>Human Resources</option>
                    <option>Marketing</option>
                    <option>Design</option>
                    <option>Sales</option>
                </select>
                <i class="bi bi-chevron-down"></i>
            </div>
        </div>
    </div>

    {{-- KPI Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="kpi-card">
                <div>
                    <div class="kpi-label">Total Members</div>
                    <div class="kpi-value">42</div>
                </div>
                <div class="kpi-icon"><i class="bi bi-people"></i></div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="kpi-card">
                <div>
                    <div class="kpi-label">Assigned Leads</div>
                    <div class="kpi-value orange">08</div>
                </div>
                <div class="kpi-icon orange"><i class="bi bi-shield-check"></i></div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="kpi-card">
                <div>
                    <div class="kpi-label">Open Positions</div>
                    <div class="kpi-value">03</div>
                </div>
                <div class="kpi-icon"><i class="bi bi-person-plus"></i></div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="tl-table-wrap">
        <table class="tl-table">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Designation</th>
                    <th>Current Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="emp-avatar">AD</div>
                            <div>
                                <div class="emp-name">Alex Dimitri</div>
                                <div class="emp-id">EMP-2094</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="emp-designation">Senior Fullstack Engineer</span></td>
                    <td><span class="badge-member">Member</span></td>
                    <td><button class="btn-assign">ASSIGN AS TL</button></td>
                </tr>
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="emp-avatar" style="background:#FFF3EE; color:#FF5E2B;">SL</div>
                            <div>
                                <div class="emp-name">Sarah Lancaster</div>
                                <div class="emp-id">EMP-3102</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="emp-designation">Backend Architect</span></td>
                    <td><span class="badge-tl">Team Lead</span></td>
                    <td><button class="btn-modify">MODIFY ROLE</button></td>
                </tr>
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="emp-avatar">MK</div>
                            <div>
                                <div class="emp-name">Marcus Kane</div>
                                <div class="emp-id">EMP-1188</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="emp-designation">DevOps Specialist</span></td>
                    <td><span class="badge-member">Member</span></td>
                    <td><button class="btn-assign">ASSIGN AS TL</button></td>
                </tr>
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="emp-avatar">EJ</div>
                            <div>
                                <div class="emp-name">Elena Jovic</div>
                                <div class="emp-id">EMP-4421</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="emp-designation">Frontend Developer</span></td>
                    <td><span class="badge-member">Member</span></td>
                    <td><button class="btn-assign">ASSIGN AS TL</button></td>
                </tr>
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="emp-avatar">TH</div>
                            <div>
                                <div class="emp-name">Thomas Hiddleston</div>
                                <div class="emp-id">EMP-5009</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="emp-designation">System Security Engineer</span></td>
                    <td><span class="badge-member">Member</span></td>
                    <td><button class="btn-assign">ASSIGN AS TL</button></td>
                </tr>
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="pagination-wrap">
            <span class="pagination-info">Showing 1-5 of 42 employees</span>
            <div class="d-flex gap-1">
                <button class="page-btn disabled"><i class="bi bi-chevron-left"></i></button>
                <button class="page-btn active">1</button>
                <button class="page-btn">2</button> 
                <button class="page-btn">3</button>
                <button class="page-btn"><i class="bi bi-chevron-right"></i></button>
            </div>
        </div>
    </div>
</div>

@endsection