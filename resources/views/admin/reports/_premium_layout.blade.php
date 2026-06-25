{{--
  Component: Premium Admin Reports
  Variables (best-effort):
  - $stats (array)
  - $monthly (array of rows)
  - $loans (paginator/collection) for credits view
--}}

<style>
    :root{
        --bg-primary:#050B12;
        --bg-secondary:#07131B;
        --card:#0D1823;
        --border:#142634;
        --text:#E9F2F7;
        --muted:#AEBBC6;
        --neon:#3DFF7A;
        --glow:#00C45A;
        --danger:#FF6B6B;
        --warning:#FFC107;
        --accent-blue:#49A7FF;
        --glass: rgba(13,24,35,.62);
    }

    .reports-wrap{
        background: radial-gradient(circle at top right, rgba(0,196,90,.10), transparent 40%),
                    radial-gradient(circle at bottom left, rgba(73,167,255,.06), transparent 45%);
        border:1px solid var(--border);
        border-radius: 22px;
        padding: 18px;
    }

    .reports-title{
        margin:0;
        font-weight:950;
        letter-spacing:.03em;
        font-size: 1.35rem;
    }

    .glass-card{
        background: rgba(13,24,35,.45);
        border: 1px solid var(--border);
        border-radius: 18px;
        padding: 14px;
    }

    .stat-grid{
        display:grid;
        grid-template-columns:repeat(4, minmax(0,1fr));
        gap:12px;
        margin: 14px 0;
    }
    @media (max-width: 992px){ .stat-grid{ grid-template-columns: repeat(2, minmax(0,1fr)); } }
    @media (max-width: 576px){ .stat-grid{ grid-template-columns: 1fr; } }

    .stat-item{
        background: rgba(13,24,35,.35);
        border:1px solid rgba(20,38,52,1);
        border-radius: 18px;
        padding: 14px;
        transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
    }
    .stat-item:hover{
        transform: translateY(-3px);
        border-color: rgba(61,255,122,.35);
        box-shadow: 0 0 22px rgba(0,196,90,.12);
    }

    .stat-label{ color:var(--muted); font-weight:800; font-size:.85rem; margin:0 0 8px; }
    .stat-value{ color:var(--text); font-weight:1000; font-size:1.35rem; margin:0; }

    .table-premium{
        width:100%;
        border-collapse:separate;
        border-spacing:0;
        border-radius:18px;
        border:1px solid var(--border);
        background: rgba(13,24,35,.35);
        overflow:hidden;
    }
    .table-premium thead th{
        background: rgba(7,19,27,.45);
        border-bottom: 1px solid rgba(20,38,52,1);
        color: var(--muted);
        font-size: .78rem;
        font-weight: 950;
        letter-spacing:.06em;
        text-transform: uppercase;
        padding: 14px 14px;
        white-space: nowrap;
    }
    .table-premium tbody td{
        padding: 12px 14px;
        border-top: 1px solid rgba(20,38,52,.7);
        vertical-align: middle;
        color: var(--text);
    }

    .table-premium tbody tr:hover td{ background: rgba(61,255,122,.05); }

    .btn-premium{
        border-radius:14px;
        font-weight:950;
        border: 1px solid var(--border);
        background: rgba(7,19,27,.28);
        color: var(--text);
        padding: 10px 14px;
        text-decoration:none;
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease, background .2s ease;
        display:inline-flex;
        align-items:center;
        gap:10px;
    }
    .btn-premium:hover{ transform: translateY(-3px); border-color: rgba(61,255,122,.35); box-shadow: 0 0 18px rgba(0,196,90,.14); background: rgba(61,255,122,.06); }
    .btn-premium-outline{ background: transparent; }

    .filter-row .form-control,
    .filter-row .form-select{
        border-radius: 12px;
    }
</style>

