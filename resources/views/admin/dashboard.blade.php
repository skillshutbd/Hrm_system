@extends('admin.layouts.admin')

@section('title', 'Admin Dashboard - Skills Hut Ltd')

@push('styles')
<style>
    .kpi-card { border-radius: 12px; transition: transform 0.2s; }
    .kpi-card:hover { transform: translateY(-2px); }
    .kpi-label { font-size: 0.75rem; letter-spacing: 0.5px; }
    .kpi-value { font-size: 2rem; font-weight: 700; color: #1A1A1A; }
    .page-title { font-family: 'Outfit', sans-serif; font-size: 1.6rem; font-weight: 700; }
    .page-subtitle { font-size: 0.9rem; }
    .btn-brand { background-color: #FF5E2B; color: #fff; border: none; border-radius: 8px; font-weight: 600; font-size: 0.88rem; }
    .btn-brand:hover { background-color: #E04B1A; color: #fff; }
    .btn-outline-custom { border: 1px solid #E2E0DD; color: #4A4A4A; border-radius: 8px; font-weight: 600; font-size: 0.88rem; }
    .btn-outline-custom:hover { background-color: #FAF9F6; }

    /* Workflow */
    .workflow-card { border-radius: 16px; border: 1px solid #E2E0DD; background: #fff; padding: 28px; }
    .workflow-badge { background: #FF5E2B; color: #fff; font-size: 0.72rem; font-weight: 700; padding: 4px 10px; border-radius: 20px; letter-spacing: 0.5px; }
    .workflow-step { border: 1px solid #E2E0DD; border-radius: 12px; padding: 20px; text-align: center; flex: 1; position: relative; }
    .workflow-step.active { border-color: #FF5E2B; background: #FFF8F5; }
    .workflow-step-icon { width: 48px; height: 48px; border-radius: 10px; border: 1px solid #E2E0DD; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; font-size: 1.2rem; color: #4A4A4A; }
    .workflow-step.active .workflow-step-icon { border-color: #FF5E2B; color: #FF5E2B; background: #fff; }
    .workflow-step-title { font-size: 0.88rem; font-weight: 700; color: #1A1A1A; margin-bottom: 4px; }
    .workflow-step.active .workflow-step-title { color: #FF5E2B; }
    .workflow-step-desc { font-size: 0.78rem; color: #7F7F7F; }
    .workflow-connector { display: flex; align-items: center; padding: 0 8px; color: #C0BAB4; font-size: 1.2rem; }
    .step-badge { position: absolute; top: -10px; right: -10px; background: #FF5E2B; color: #fff; font-size: 0.7rem; font-weight: 700; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }

    /* Table */
    .section-card { border-radius: 16px; border: 1px solid #E2E0DD; background: #fff; padding: 24px; }
    .section-title { font-family: 'Outfit', sans-serif; font-size: 1rem; font-weight: 700; color: #1A1A1A; }
    .table th { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #7F7F7F; border-bottom: 1px solid #E2E0DD; padding: 10px 12px; }
    .table td { font-size: 0.85rem; color: #1A1A1A; padding: 14px 12px; vertical-align: middle; border-bottom: 1px solid #F4F4F0; }
    .avatar-circle { width: 34px; height: 34px; border-radius: 50%; background: #E2E0DD; display: flex; align-items: center; justify-content: center; font-size: 0.78rem; font-weight: 700; color: #4A4A4A; flex-shrink: 0; }
    .badge-approved { background: #ECFDF5; color: #059669; font-size: 0.75rem; font-weight: 600; padding: 4px 10px; border-radius: 20px; }
    .btn-approve { background: #FF5E2B; color: #fff; border: none; border-radius: 6px; font-size: 0.78rem; font-weight: 600; padding: 5px 12px; }
    .btn-approve:hover { background: #E04B1A; color: #fff; }
    .btn-reject { background: none; border: 1px solid #E2E0DD; color: #4A4A4A; border-radius: 6px; font-size: 0.78rem; font-weight: 600; padding: 5px 12px; }
    .btn-reject:hover { background: #FAF9F6; }
    .link-brand { color: #FF5E2B; font-size: 0.82rem; font-weight: 600; text-decoration: none; }
    .link-brand:hover { text-decoration: underline; }

    /* Activity Log */
    .activity-item { padding: 12px 0; border-bottom: 1px solid #F4F4F0; }
    .activity-item:last-child { border-bottom: none; }
    .activity-item strong { font-size: 0.85rem; color: #1A1A1A; }
    .activity-item p { font-size: 0.82rem; color: #4A4A4A; margin: 2px 0 0; }
    .activity-item .time { font-size: 0.75rem; color: #B2ADA7; }

    /* Bottom cards */
    .feature-card { border-radius: 16px; border: 1px solid #E2E0DD; background: #fff; padding: 24px; }
    .feature-card.highlight { border-color: rgba(255,94,43,0.2); background: #FFF8F5; }
    .feature-title { font-family: 'Outfit', sans-serif; font-size: 0.95rem; font-weight: 700; color: #1A1A1A; }
    .feature-card.highlight .feature-title { color: #FF5E2B; }
    .feature-desc { font-size: 0.82rem; color: #7F7F7F; margin: 6px 0 16px; }
</style>
@endpush

@section('content')

    {{-- Page Header --}}
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
        <div>
            <h1 class="page-title mb-1">Admin Dashboard</h1>
            <p class="page-subtitle text-muted mb-0">Skills Hut Ltd</p>
        </div>
        <div class="d-flex gap-2">
            <!-- <button class="btn btn-outline-custom d-flex align-items-center gap-2">
                <i class="bi bi-download"></i> Export Audit
            </button> -->
         <a href="{{ url()->current() }}" class="btn btn-brand d-flex align-items-center gap-2 text-decoration-none">
    <i class="bi bi-arrow-clockwise"></i> Refresh Data
</a>
        </div>
    </div>

    {{-- KPI Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card kpi-card border-0 shadow-sm h-100">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <span class="kpi-label text-uppercase text-muted fw-semibold d-block mb-2">Total Workforce</span>
                    <h3 class="kpi-value mb-2">1,284</h3>
                    <div class="text-success d-flex align-items-center gap-1">
                        <i class="bi bi-graph-up-arrow"></i><span style="font-size:0.8rem;">+12 New Hires</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card kpi-card border-0 shadow-sm h-100">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <span class="kpi-label text-uppercase text-muted fw-semibold d-block mb-2">Departments</span>
                    <h3 class="kpi-value mb-2">14</h3>
                    <div class="text-muted" style="font-size:0.8rem;">8 Fully Staffed</div>
                </div>
            </div>
        </div>
       
      
    </div>

    {{-- Leave Approval Workflow --}}
    <div class="workflow-card mb-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <div class="section-title">Leave Approval Workflow</div>
                <div style="font-size:0.82rem; color:#7F7F7F;">Three-tier verification architecture</div>
            </div>
            <span class="workflow-badge">PHASE 1 ACTIVE</span>
        </div>
        <div class="d-flex align-items-stretch gap-2">
            <div class="workflow-step">
                <div class="workflow-step-icon"><i class="bi bi-person"></i></div>
                <div class="workflow-step-title">1. Employee Request</div>
                <div class="workflow-step-desc">Submits leave application through dedicated portal</div>
            </div>
            <div class="workflow-connector"><i class="bi bi-chevron-right"></i></div>
            <div class="workflow-step active">
                <div class="step-badge">95</div>
                <div class="workflow-step-icon"><i class="bi bi-people"></i></div>
                <div class="workflow-step-title">2. Team Lead Review</div>
                <div class="workflow-step-desc">First-line operational approval & resource check</div>
            </div>
            <div class="workflow-connector"><i class="bi bi-chevron-right"></i></div>
            <div class="workflow-step">
                <div class="workflow-step-icon"><i class="bi bi-shield-check"></i></div>
                <div class="workflow-step-title">3. HR Admin Final</div>
                <div class="workflow-step-desc">Policy compliance check & final system record</div>
            </div>
        </div>
    </div>

    {{-- Approval Queue + Activity Log --}}
    <div class="row g-4 mb-4">

        {{-- HR Final Approval Queue --}}
        <div class="col-12 col-lg-7">
            <div class="section-card h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="section-title">HR Final Approval Queue</div>
                    <a href="#" class="link-brand">View All Requests</a>
                </div>
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Employee / Dept</th>
                            <th>TL Status</th>
                            <th>Period</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-circle">JH</div>
                                    <div>
                                        <div style="font-weight:600;">Jonathan Harker</div>
                                        <div style="font-size:0.75rem; color:#7F7F7F;">Engineering • Web Team</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge-approved"><i class="bi bi-check-circle me-1"></i>Approved by TL</span></td>
                            <td style="font-size:0.82rem;">Oct 12 - Oct 14</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn-approve">APPROVE</button>
                                    <button class="btn-reject">R</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-circle">MM</div>
                                    <div>
                                        <div style="font-weight:600;">Mina Murray</div>
                                        <div style="font-size:0.75rem; color:#7F7F7F;">Product • Design Hub</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge-approved"><i class="bi bi-check-circle me-1"></i>Approved by TL</span></td>
                            <td style="font-size:0.82rem;">Oct 20 - Oct 25</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn-approve">APPROVE</button>
                                    <button class="btn-reject">R</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- System Activity Log --}}
        <div class="col-12 col-lg-5">
            <div class="section-card h-100">
                <div class="section-title mb-3">System Activity Log</div>
                <div class="activity-item">
                    <strong>Super Admin:</strong>
                    <p>Bulk assigned 12 employees to <em>Design Team Beta.</em></p>
                    <span class="time">12 minutes ago</span>
                </div>
                <div class="activity-item">
                    <strong>Leave System:</strong>
                    <p>Arthur Holmwood (TL) approved 3 leave requests.</p>
                    <span class="time">2 hours ago</span>
                </div>
                <div class="activity-item">
                    <strong>Dept Update:</strong>
                    <p>New department <em>'R&D Operations'</em> created by Super Admin.</p>
                    <span class="time">5 hours ago</span>
                </div>
                <div class="activity-item">
                    <strong>New TL:</strong>
                    <p>Sarah Jenkins promoted to Team Lead (Design).</p>
                    <span class="time">Yesterday</span>
                </div>
                <div class="mt-3">
                    <button class="btn btn-outline-custom w-100" style="font-size:0.82rem;">View Full Audit Log</button>
                </div>
            </div>
        </div>

    </div>


@endsection