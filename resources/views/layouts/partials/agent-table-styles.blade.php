<style>
/* ============================================================
   AGENT DASHBOARD — Dark SaaS Premium Theme
   Linear · Vercel · Supabase · Clerk
   bg #050B12 · card #0D1823 · neon #3DFF7A
   ============================================================ */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

/* ── Design tokens ───────────────────────────────────── */
:root {
    --bg-primary:  #050B12;
    --bg-secondary:#07131B;
    --card:        #0D1823;
    --border:      #142634;
    --text:        #E9F2F7;
    --muted:       #AEBBC6;
    --neon:        #3DFF7A;
    --glow:        #00C45A;
    --danger:      #FF6B6B;
    --warning:     #FFC107;
    --accent:      #0B5CFF;
}

/* ── Root ────────────────────────────────────────────── */
.at-root {
    font-family: 'Inter', sans-serif;
    color: var(--text);
}

/* Override page background for agent section */
.dashboard-content { background: var(--bg-primary) !important; }

/* ── Page header ─────────────────────────────────────── */
.at-page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 28px;
}
.at-page-title {
    font-size: 1.45rem;
    font-weight: 700;
    color: var(--text);
    margin: 0;
    letter-spacing: -0.4px;
}
.at-page-subtitle {
    font-size: .82rem;
    color: var(--muted);
    margin: 3px 0 0;
}

/* ── Toolbar ─────────────────────────────────────────── */
.at-toolbar {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 16px;
}
.at-search-wrap {
    position: relative;
    flex: 1;
    min-width: 200px;
    max-width: 340px;
}
.at-search-wrap svg {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--muted);
    pointer-events: none;
}
.at-search {
    width: 100%;
    padding: 10px 14px 10px 38px;
    background: var(--bg-secondary);
    border: 1px solid var(--border);
    border-radius: 10px;
    font-size: .875rem;
    font-family: 'Inter', sans-serif;
    color: var(--text);
    outline: none;
    transition: border-color .2s, box-shadow .2s;
}
.at-search::placeholder { color: var(--muted); }
.at-search:focus {
    border-color: var(--glow);
    box-shadow: 0 0 0 3px rgba(0,196,90,.15);
}
.at-filter-select {
    padding: 10px 14px;
    background: var(--bg-secondary);
    border: 1px solid var(--border);
    border-radius: 10px;
    font-size: .875rem;
    font-family: 'Inter', sans-serif;
    color: var(--text);
    cursor: pointer;
    outline: none;
    transition: border-color .2s;
}
.at-filter-select:focus { border-color: var(--glow); }

/* ── Card ────────────────────────────────────────────── */
.at-card {
    background: var(--card);
    border-radius: 16px;
    border: 1px solid var(--border);
    box-shadow: 0 4px 24px rgba(0,0,0,.5);
    overflow: hidden;
    animation: atFadeIn .35s ease both;
}
@keyframes atFadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── Table ───────────────────────────────────────────── */
.at-table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
.at-table {
    width: 100%;
    border-collapse: collapse;
    font-size: .875rem;
}
.at-table thead tr { background: var(--bg-secondary); }
.at-table thead th {
    color: var(--muted);
    font-weight: 600;
    font-size: .72rem;
    text-transform: uppercase;
    letter-spacing: .8px;
    padding: 14px 20px;
    white-space: nowrap;
    cursor: pointer;
    user-select: none;
    border-bottom: 1px solid var(--border);
}
.at-table thead th:hover { color: var(--text); }
.at-table thead th .sort-icon {
    display: inline-flex;
    flex-direction: column;
    gap: 1px;
    margin-left: 5px;
    vertical-align: middle;
    opacity: .4;
    transition: opacity .15s;
}
.at-table thead th:hover .sort-icon { opacity: .8; }
.at-table thead th .sort-icon span { display: block; width: 0; height: 0; }
.at-table thead th .sort-icon .up   { border-left: 3px solid transparent; border-right: 3px solid transparent; border-bottom: 4px solid var(--muted); }
.at-table thead th .sort-icon .down { border-left: 3px solid transparent; border-right: 3px solid transparent; border-top: 4px solid var(--muted); }

.at-table tbody tr {
    border-bottom: 1px solid var(--border);
    transition: background .2s;
    animation: atRowIn .3s ease both;
}
@keyframes atRowIn {
    from { opacity: 0; transform: translateX(-6px); }
    to   { opacity: 1; transform: translateX(0); }
}
.at-table tbody tr:hover { background: rgba(61,255,122,.04); }
.at-table tbody tr:last-child { border-bottom: none; }
.at-table tbody td {
    padding: 16px 20px;
    color: var(--text);
    vertical-align: middle;
    white-space: nowrap;
}

/* ── Avatar initials ─────────────────────────────────── */
.at-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(0,196,90,.15);
    border: 1px solid rgba(61,255,122,.3);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--neon);
    font-weight: 700;
    font-size: .78rem;
    flex-shrink: 0;
}
.at-user-cell { display: flex; align-items: center; gap: 11px; }
.at-user-name { font-weight: 600; color: var(--text); font-size: .875rem; }
.at-user-sub  { font-size: .76rem; color: var(--muted); margin-top: 1px; }

/* ── Mono reference ──────────────────────────────────── */
.at-ref {
    font-family: 'JetBrains Mono', 'Fira Code', monospace;
    font-size: .8rem;
    color: var(--neon);
    font-weight: 600;
}
.at-ref-link { text-decoration: none; transition: color .15s; }
.at-ref-link:hover { color: var(--glow); text-shadow: 0 0 8px var(--glow); }

/* ── Badges ──────────────────────────────────────────── */
.at-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: .72rem;
    font-weight: 600;
    letter-spacing: .3px;
    white-space: nowrap;
    border: 1px solid transparent;
    transition: box-shadow .2s;
}
.at-badge::before {
    content: '';
    width: 5px;
    height: 5px;
    border-radius: 50%;
    background: currentColor;
    display: block;
    opacity: .9;
}
.at-badge:hover { box-shadow: 0 0 8px currentColor; opacity: .9; }

.at-badge-blue   { background: rgba(11,92,255,.15);   color: #60a5fa;         border-color: rgba(11,92,255,.3); }
.at-badge-green  { background: rgba(61,255,122,.12);  color: var(--neon);      border-color: rgba(61,255,122,.3); }
.at-badge-orange { background: rgba(255,193,7,.12);  color: var(--warning);   border-color: rgba(255,193,7,.3); }
.at-badge-red    { background: rgba(255,107,107,.12); color: var(--danger);    border-color: rgba(255,107,107,.3); }
.at-badge-gray   { background: rgba(174,187,198,.08); color: var(--muted);    border-color: rgba(174,187,198,.2); }
.at-badge-purple { background: rgba(167,139,250,.12); color: #a78bfa;         border-color: rgba(167,139,250,.3); }

/* ── Action buttons (42×42) ──────────────────────────── */
.at-actions { display: flex; align-items: center; gap: 6px; }
.at-btn-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    border: 1px solid var(--border);
    background: transparent;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: var(--muted);
    cursor: pointer;
    text-decoration: none;
    transition: background .2s, border-color .2s, color .2s, transform .15s;
    flex-shrink: 0;
}
.at-btn-icon:hover { background: rgba(61,255,122,.07); color: var(--neon); border-color: rgba(61,255,122,.3); transform: translateY(-1px); }
.at-btn-icon-blue:hover   { background: rgba(11,92,255,.15);   color: #60a5fa;        border-color: rgba(11,92,255,.4); }
.at-btn-icon-red:hover    { background: rgba(255,107,107,.15); color: var(--danger);  border-color: rgba(255,107,107,.4); }
.at-btn-icon-green:hover  { background: rgba(61,255,122,.15);  color: var(--neon);   border-color: rgba(61,255,122,.4); }

/* ── CTA / text buttons ──────────────────────────────── */
.at-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 9px 16px;
    border-radius: 10px;
    font-size: .83rem;
    font-weight: 600;
    font-family: 'Inter', sans-serif;
    cursor: pointer;
    border: 1px solid transparent;
    text-decoration: none;
    transition: all .2s;
    white-space: nowrap;
    outline: none;
}
.at-btn-primary {
    background: var(--glow);
    color: #050B12;
    border-color: var(--glow);
    box-shadow: 0 2px 14px rgba(0,196,90,.35);
}
.at-btn-primary:hover {
    background: var(--neon);
    box-shadow: 0 4px 22px rgba(61,255,122,.45);
    transform: translateY(-1px);
    color: #050B12;
    text-decoration: none;
}
.at-btn-ghost {
    background: rgba(174,187,198,.06);
    color: var(--muted);
    border-color: var(--border);
}
.at-btn-ghost:hover {
    background: rgba(61,255,122,.07);
    color: var(--neon);
    border-color: rgba(61,255,122,.25);
    text-decoration: none;
}
.at-btn-sm { padding: 6px 12px; font-size: .78rem; }

/* ── Table footer ────────────────────────────────────── */
.at-table-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    padding: 14px 20px;
    border-top: 1px solid var(--border);
    background: var(--bg-secondary);
    font-size: .82rem;
    color: var(--muted);
}
.at-table-footer .pagination { margin: 0; }
.at-table-footer .pagination .page-link {
    background: var(--card);
    border: 1px solid var(--border);
    color: var(--muted);
    border-radius: 8px !important;
    font-size: .8rem;
    padding: 5px 11px;
    margin: 0 2px;
    transition: all .2s;
}
.at-table-footer .pagination .page-link:hover {
    background: rgba(61,255,122,.1);
    border-color: rgba(61,255,122,.35);
    color: var(--neon);
}
.at-table-footer .pagination .page-item.active .page-link {
    background: var(--glow);
    border-color: var(--glow);
    color: #050B12;
    font-weight: 700;
    box-shadow: 0 2px 10px rgba(0,196,90,.4);
}

/* ── Loader ──────────────────────────────────────────── */
.at-loader { display:none; position:absolute; inset:0; background:rgba(5,11,18,.7); backdrop-filter:blur(3px); border-radius:16px; z-index:10; align-items:center; justify-content:center; }
.at-loader.show { display:flex; }
.at-spinner { width:34px; height:34px; border:2.5px solid var(--border); border-top-color:var(--neon); border-radius:50%; animation:spin .7s linear infinite; }
@keyframes spin { to { transform:rotate(360deg); } }

/* ── Empty state ─────────────────────────────────────── */
.at-empty { text-align:center; padding:60px 24px; color:var(--muted); }
.at-empty svg { margin-bottom:16px; }
.at-empty p { margin:0; font-size:.9rem; color:var(--muted); }

/* ── Stat cards ──────────────────────────────────────── */
.at-stat-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}
.at-stat-card {
    background: var(--card);
    border-radius: 14px;
    padding: 20px 22px;
    border: 1px solid var(--border);
    box-shadow: 0 4px 20px rgba(0,0,0,.4);
    display: flex;
    align-items: center;
    gap: 16px;
    animation: atFadeIn .35s ease both;
    transition: border-color .2s, box-shadow .2s;
}
.at-stat-card:hover { border-color: rgba(61,255,122,.2); box-shadow: 0 4px 20px rgba(0,196,90,.08); }
.at-stat-icon { width:46px; height:46px; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.at-stat-icon-blue   { background:rgba(11,92,255,.15);   color:#60a5fa; }
.at-stat-icon-green  { background:rgba(61,255,122,.12);  color:var(--neon); }
.at-stat-icon-orange { background:rgba(255,193,7,.12);   color:var(--warning); }
.at-stat-label { font-size:.77rem; color:var(--muted); font-weight:500; margin-bottom:4px; text-transform:uppercase; letter-spacing:.5px; }
.at-stat-value { font-size:1.15rem; font-weight:700; color:var(--text); }

/* ── Section title inside card ───────────────────────── */
.at-card-header {
    padding: 16px 20px;
    border-bottom: 1px solid var(--border);
    font-weight: 600;
    font-size: .9rem;
    color: var(--text);
}

/* ── Filter card (forms) ─────────────────────────────── */
.at-filter-card {
    background: var(--card);
    border-radius: 14px;
    border: 1px solid var(--border);
    padding: 16px 20px;
    margin-bottom: 20px;
}
.at-filter-card input[type=date],
.at-filter-card input[type=month] {
    background: var(--bg-secondary);
    border: 1px solid var(--border);
    border-radius: 9px;
    color: var(--text);
    padding: 9px 14px;
    font-family: 'Inter', sans-serif;
    font-size: .875rem;
    outline: none;
    transition: border-color .2s;
}
.at-filter-card input:focus { border-color: var(--glow); box-shadow: 0 0 0 2px rgba(0,196,90,.15); }

/* ── Responsive ──────────────────────────────────────── */
@media (max-width: 768px) {
    .at-page-title  { font-size: 1.2rem; }
    .at-search-wrap { max-width: 100%; }
    .at-table thead th,
    .at-table tbody td { padding: 12px 14px; font-size: .82rem; }
    .at-stat-grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 480px) {
    .at-stat-grid { grid-template-columns: 1fr; }
    .at-table-footer { flex-direction: column; align-items: flex-start; }
    .at-page-header { flex-direction: column; align-items: flex-start; }
}
</style>