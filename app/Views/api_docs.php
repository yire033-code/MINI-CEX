<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="API MINI-CEX — Documentación técnica para la sincronización de la App Android con el servidor web.">
<title>API MINI-CEX · Documentación</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
<style>
/* ═══════════════════════════════════════════════
   DESIGN TOKENS
   ═══════════════════════════════════════════════ */
:root {
    --bg-primary: #050a18;
    --bg-secondary: #0a1128;
    --bg-card: rgba(15, 25, 55, 0.6);
    --bg-glass: rgba(255, 255, 255, 0.03);
    --bg-glass-border: rgba(255, 255, 255, 0.06);
    --bg-code: #0d1117;
    --bg-code-header: #161b22;

    --text-primary: #e2e8f0;
    --text-secondary: #94a3b8;
    --text-muted: #64748b;

    --blue: #3b82f6;
    --blue-vivid: #60a5fa;
    --blue-deep: #1d4ed8;
    --blue-glow: rgba(59, 130, 246, 0.12);

    --gold: #d4a012;
    --gold-vivid: #fbbf24;

    --green: #22c55e;
    --green-glow: rgba(34, 197, 94, 0.12);
    --green-dim: #166534;

    --purple: #a855f7;
    --purple-glow: rgba(168, 85, 247, 0.12);

    --rose: #f43f5e;

    --teal: #14b8a6;

    --radius: 16px;
    --radius-md: 12px;
    --radius-sm: 8px;
    --radius-xl: 24px;

    --font: 'Inter', system-ui, -apple-system, sans-serif;
    --font-heading: 'Outfit', var(--font);
    --font-mono: 'JetBrains Mono', 'Fira Code', monospace;

    --ease: cubic-bezier(0.4, 0, 0.2, 1);
    --speed: 0.3s;

    --sidebar-w: 260px;
}

/* ═══════════════════════════════════════════════
   RESET & BASE
   ═══════════════════════════════════════════════ */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

html {
    scroll-behavior: smooth;
    scroll-padding-top: 100px;
}

body {
    font-family: var(--font);
    background: var(--bg-primary);
    color: var(--text-primary);
    line-height: 1.7;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

a { text-decoration: none; color: inherit; }
img { max-width: 100%; }

/* ═══════════════════════════════════════════════
   SCROLLBAR
   ═══════════════════════════════════════════════ */
::-webkit-scrollbar { width: 6px; height: 6px; }
::-webkit-scrollbar-track { background: var(--bg-primary); }
::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, var(--blue), var(--purple));
    border-radius: 3px;
}

/* ═══════════════════════════════════════════════
   LAYOUT
   ═══════════════════════════════════════════════ */
.app-layout {
    display: flex;
    min-height: 100vh;
}

/* ═══════════════════════════════════════════════
   SIDEBAR
   ═══════════════════════════════════════════════ */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: var(--sidebar-w);
    height: 100vh;
    overflow-y: auto;
    z-index: 100;
    background: var(--bg-secondary);
    border-right: 1px solid rgba(255, 255, 255, 0.04);
    padding: 0;
    display: flex;
    flex-direction: column;
}

.sidebar-header {
    padding: 24px 20px 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.04);
    flex-shrink: 0;
}

.sidebar-brand {
    display: flex;
    align-items: center;
    gap: 10px;
}

.sidebar-logo {
    width: 32px;
    height: 32px;
    filter: brightness(0) invert(1);
    flex-shrink: 0;
}

.sidebar-brand-text {
    display: flex;
    flex-direction: column;
}

.sidebar-brand-name {
    font-family: var(--font-heading);
    font-weight: 800;
    font-size: 16px;
    color: #fff;
    letter-spacing: -0.3px;
    line-height: 1.1;
}

.sidebar-brand-sub {
    font-size: 9px;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    color: var(--gold-vivid);
    font-weight: 700;
}

.sidebar-nav {
    padding: 16px 0;
    flex: 1;
    overflow-y: auto;
}

.sidebar-section {
    margin-bottom: 4px;
}

.sidebar-section-title {
    padding: 8px 20px 6px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: var(--text-muted);
    opacity: 0.6;
}

.sidebar-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 20px;
    font-size: 13px;
    font-weight: 500;
    color: var(--text-secondary);
    transition: all var(--speed) var(--ease);
    border-left: 2px solid transparent;
    position: relative;
}

.sidebar-link:hover {
    color: #fff;
    background: rgba(255, 255, 255, 0.03);
}

.sidebar-link.active {
    color: var(--blue-vivid);
    background: var(--blue-glow);
    border-left-color: var(--blue);
}

.sidebar-link .link-dot {
    width: 4px;
    height: 4px;
    border-radius: 50%;
    background: currentColor;
    opacity: 0.4;
    flex-shrink: 0;
}

.sidebar-link.active .link-dot {
    opacity: 1;
    box-shadow: 0 0 8px rgba(59, 130, 246, 0.5);
}

.sidebar-footer {
    padding: 16px 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.04);
    flex-shrink: 0;
}

.sidebar-footer a {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    color: var(--text-muted);
    transition: color var(--speed) var(--ease);
}

.sidebar-footer a:hover { color: var(--blue-vivid); }

/* ═══════════════════════════════════════════════
   MAIN CONTENT
   ═══════════════════════════════════════════════ */
.main-content {
    margin-left: var(--sidebar-w);
    flex: 1;
    min-width: 0;
    padding: 0;
}

/* Top bar */
.top-bar {
    position: sticky;
    top: 0;
    z-index: 50;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 40px;
    background: rgba(5, 10, 24, 0.85);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-bottom: 1px solid rgba(255, 255, 255, 0.04);
}

.top-bar-title {
    font-family: var(--font-heading);
    font-size: 14px;
    font-weight: 700;
    color: #fff;
    letter-spacing: -0.3px;
}

.top-bar-title span {
    color: var(--text-muted);
    font-weight: 400;
}

.top-bar-version {
    padding: 4px 12px;
    background: var(--blue-glow);
    color: var(--blue-vivid);
    font-size: 11px;
    font-weight: 600;
    border-radius: 999px;
    letter-spacing: 0.3px;
}

/* Content wrapper */
.content-wrapper {
    max-width: 900px;
    margin: 0 auto;
    padding: 40px 40px 80px;
}

/* ═══════════════════════════════════════════════
   TYPOGRAPHY
   ═══════════════════════════════════════════════ */
.hero-section {
    margin-bottom: 48px;
    padding-bottom: 32px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.04);
}

.hero-section h1 {
    font-family: var(--font-heading);
    font-size: 36px;
    font-weight: 900;
    color: #fff;
    letter-spacing: -1.5px;
    line-height: 1.15;
    margin-bottom: 12px;
}

.hero-section .hero-gradient-text {
    background: linear-gradient(135deg, var(--blue-vivid), var(--purple), var(--gold-vivid));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-section p {
    font-size: 16px;
    color: var(--text-secondary);
    max-width: 640px;
    line-height: 1.7;
}

.hero-section .base-url {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    background: var(--bg-glass);
    border: 1px solid var(--bg-glass-border);
    border-radius: 8px;
    font-family: var(--font-mono);
    font-size: 13px;
    color: var(--blue-vivid);
    margin-top: 16px;
}

.section-block {
    margin-bottom: 48px;
    scroll-margin-top: 80px;
}

.section-block h2 {
    font-family: var(--font-heading);
    font-size: 26px;
    font-weight: 800;
    color: #fff;
    letter-spacing: -1px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.section-block h2 .section-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: var(--blue-glow);
    color: var(--blue-vivid);
    font-size: 14px;
    font-weight: 700;
    flex-shrink: 0;
}

.section-block h3 {
    font-family: var(--font-heading);
    font-size: 19px;
    font-weight: 700;
    color: #e2e8f0;
    margin-bottom: 14px;
    margin-top: 32px;
    letter-spacing: -0.3px;
}

.section-block p {
    font-size: 15px;
    color: var(--text-secondary);
    line-height: 1.7;
    margin-bottom: 16px;
}

.section-block ul, .section-block ol {
    padding-left: 20px;
    margin-bottom: 16px;
}

.section-block li {
    font-size: 14px;
    color: var(--text-secondary);
    margin-bottom: 6px;
    line-height: 1.6;
}

.section-block li strong { color: var(--text-primary); }

/* ═══════════════════════════════════════════════
   ENDPOINT CARDS
   ═══════════════════════════════════════════════ */
.endpoint-card {
    background: var(--bg-card);
    border: 1px solid var(--bg-glass-border);
    border-radius: var(--radius);
    padding: 0;
    margin-bottom: 20px;
    overflow: hidden;
    transition: border-color var(--speed) var(--ease);
}

.endpoint-card:hover {
    border-color: rgba(255, 255, 255, 0.1);
}

.endpoint-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px 24px;
    background: rgba(255, 255, 255, 0.02);
    border-bottom: 1px solid rgba(255, 255, 255, 0.04);
}

.endpoint-method {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 3px 10px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    font-family: var(--font);
    flex-shrink: 0;
    line-height: 1.4;
}

.method-get { background: rgba(59, 130, 246, 0.15); color: var(--blue-vivid); }
.method-post { background: rgba(34, 197, 94, 0.15); color: var(--green); }

.endpoint-path {
    font-family: var(--font-mono);
    font-size: 14px;
    font-weight: 500;
    color: var(--text-primary);
}

.endpoint-body {
    padding: 24px;
}

.endpoint-desc {
    font-size: 14px;
    color: var(--text-secondary);
    line-height: 1.7;
    margin-bottom: 20px;
}

.endpoint-desc strong { color: var(--text-primary); }

.endpoint-subtitle {
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--text-muted);
    margin-bottom: 10px;
    margin-top: 20px;
}

.endpoint-subtitle:first-child { margin-top: 0; }

/* ═══════════════════════════════════════════════
   CODE BLOCKS
   ═══════════════════════════════════════════════ */
.code-block {
    background: var(--bg-code);
    border: 1px solid rgba(255, 255, 255, 0.06);
    border-radius: var(--radius-sm);
    overflow: hidden;
    margin-bottom: 16px;
    position: relative;
}

.code-block-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 14px;
    background: var(--bg-code-header);
    border-bottom: 1px solid rgba(255, 255, 255, 0.04);
}

.code-block-header .lang-label {
    font-size: 11px;
    font-weight: 600;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.copy-btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.06);
    border-radius: 6px;
    font-size: 11px;
    font-weight: 500;
    color: var(--text-muted);
    cursor: pointer;
    transition: all var(--speed) var(--ease);
    font-family: var(--font);
}

.copy-btn:hover {
    background: rgba(255, 255, 255, 0.1);
    color: var(--text-primary);
    border-color: rgba(255, 255, 255, 0.12);
}

.copy-btn.copied {
    background: rgba(34, 197, 94, 0.15);
    color: var(--green);
    border-color: rgba(34, 197, 94, 0.2);
}

.code-block pre {
    margin: 0;
    padding: 16px 20px;
    overflow-x: auto;
    font-family: var(--font-mono);
    font-size: 13px;
    line-height: 1.65;
    color: #e2e8f0;
    tab-size: 2;
}

.code-block pre .comment { color: #6b7280; font-style: italic; }
.code-block pre .string { color: #fbbf24; }
.code-block pre .number { color: #f472b6; }
.code-block pre .key { color: #60a5fa; }
.code-block pre .null { color: #a78bfa; }
.code-block pre .boolean { color: #34d399; }

/* ═══════════════════════════════════════════════
   TABLES
   ═══════════════════════════════════════════════ */
.table-wrap {
    overflow-x: auto;
    margin-bottom: 20px;
    border: 1px solid rgba(255, 255, 255, 0.06);
    border-radius: var(--radius-sm);
}

.table-wrap table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}

.table-wrap th {
    background: rgba(255, 255, 255, 0.03);
    font-weight: 600;
    color: var(--text-primary);
    text-align: left;
    padding: 10px 14px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table-wrap td {
    padding: 10px 14px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.04);
    color: var(--text-secondary);
    vertical-align: top;
}

.table-wrap tr:last-child td { border-bottom: none; }

.table-wrap td code {
    background: rgba(59, 130, 246, 0.1);
    padding: 1px 6px;
    border-radius: 4px;
    font-family: var(--font-mono);
    font-size: 12px;
    color: var(--blue-vivid);
}

.table-wrap tr:hover td {
    background: rgba(255, 255, 255, 0.02);
}

/* ═══════════════════════════════════════════════
   INFO BOXES
   ═══════════════════════════════════════════════ */
.info-box {
    display: flex;
    gap: 12px;
    padding: 14px 18px;
    border-radius: var(--radius-sm);
    font-size: 14px;
    line-height: 1.6;
    margin-bottom: 16px;
}

.info-box-icon {
    flex-shrink: 0;
    width: 20px;
    height: 20px;
    margin-top: 2px;
}

.info-box-info {
    background: rgba(59, 130, 246, 0.08);
    border: 1px solid rgba(59, 130, 246, 0.15);
    color: var(--blue-vivid);
}

.info-box-warn {
    background: rgba(251, 191, 36, 0.08);
    border: 1px solid rgba(251, 191, 36, 0.15);
    color: var(--gold-vivid);
}

.info-box strong {
    color: #fff;
}

.info-box code {
    background: rgba(255, 255, 255, 0.08);
    padding: 1px 6px;
    border-radius: 4px;
    font-family: var(--font-mono);
    font-size: 12px;
}

/* ═══════════════════════════════════════════════
   FLOW DIAGRAM — Visual Flowchart
   ═══════════════════════════════════════════════ */
.flow-diagram {
    background: var(--bg-code);
    border: 1px solid rgba(255, 255, 255, 0.06);
    border-radius: var(--radius-sm);
    overflow: hidden;
    margin-bottom: 20px;
    padding: 0;
}

/* ── Main container ── */
.flowchart {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 36px 24px 28px;
    position: relative;
}

/* Vertical timeline line */
.flowchart::before {
    content: '';
    position: absolute;
    top: 80px;
    bottom: 70px;
    left: 50%;
    width: 2px;
    background: linear-gradient(180deg,
        var(--blue) 0%,
        var(--blue) 18%,
        var(--green) 18%,
        var(--green) 78%,
        var(--teal) 78%,
        var(--teal) 100%
    );
    transform: translateX(-50%);
    opacity: 0.25;
    z-index: 0;
}

/* ── Connector arrow ── */
.fc-connector {
    position: relative;
    z-index: 1;
    height: 32px;
    width: 2px;
    background: linear-gradient(180deg, rgba(148, 163, 184, 0.35), rgba(148, 163, 184, 0.1));
    flex-shrink: 0;
}
.fc-connector::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 0;
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    border-top: 6px solid rgba(148, 163, 184, 0.5);
}

/* ── Card ── */
.fc-card {
    position: relative;
    z-index: 1;
    width: 100%;
    max-width: 520px;
    background: rgba(15, 25, 55, 0.5);
    border: 1px solid rgba(255, 255, 255, 0.06);
    border-radius: var(--radius-md);
    padding: 18px 20px 18px 24px;
    transition: border-color 0.2s ease, transform 0.2s ease;
    cursor: default;
}
.fc-card:hover {
    transform: translateY(-1px);
}

/* Timeline dot attached to each card */
.fc-card::before {
    content: '';
    position: absolute;
    top: 22px;
    left: calc(50% - 7px);
    width: 14px;
    height: 14px;
    border-radius: 50%;
    z-index: 2;
    border: 2px solid;
    transition: box-shadow 0.2s ease, transform 0.2s ease;
}
.fc-card:hover::before {
    transform: scale(1.2);
}

/* ── Card variants ── */
.fc-card.fc-app {
    border-left: 3px solid var(--blue);
}
.fc-card.fc-app::before {
    background: var(--blue);
    border-color: var(--blue);
    box-shadow: 0 0 10px rgba(59, 130, 246, 0.35);
}

.fc-card.fc-server {
    border-left: 3px solid var(--green);
}
.fc-card.fc-server::before {
    background: var(--green);
    border-color: var(--green);
    box-shadow: 0 0 10px rgba(34, 197, 94, 0.35);
}

.fc-card.fc-done {
    border-left: 3px solid var(--teal);
    background: rgba(20, 184, 166, 0.06);
}
.fc-card.fc-done::before {
    background: var(--teal);
    border-color: var(--teal);
    box-shadow: 0 0 10px rgba(20, 184, 166, 0.4);
}

/* PDF Flow — disable the global timeline line */
.flowchart.pdf-flow::before {
    display: none;
}

/* PDF Report variant (gold/amber) */
.fc-card.fc-pdf {
    border-left: 3px solid var(--gold);
}
.fc-card.fc-pdf::before {
    display: none;
}
.fc-pdf .fc-step-num {
    background: rgba(212, 160, 18, 0.18);
    color: var(--gold-vivid);
}
.fc-phase-pdf {
    background: rgba(212, 160, 18, 0.12);
    color: var(--gold-vivid);
}

/* ── Card header row ── */
.fc-card-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 8px;
}

.fc-step-num {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    font-size: 11px;
    font-weight: 700;
    font-family: var(--font);
    flex-shrink: 0;
    line-height: 1;
}
.fc-app .fc-step-num {
    background: rgba(59, 130, 246, 0.2);
    color: var(--blue-vivid);
}
.fc-server .fc-step-num {
    background: rgba(34, 197, 94, 0.2);
    color: var(--green);
}
.fc-done .fc-step-num {
    background: rgba(20, 184, 166, 0.2);
    color: var(--teal);
}

.fc-phase {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    padding: 2px 8px;
    border-radius: 4px;
    line-height: 1.4;
}
.fc-phase-app {
    background: rgba(59, 130, 246, 0.12);
    color: var(--blue-vivid);
}
.fc-phase-server {
    background: rgba(34, 197, 94, 0.12);
    color: var(--green);
}

/* ── Card body ── */
.fc-card-body {
    font-size: 14px;
    color: var(--text-secondary);
    line-height: 1.65;
}
.fc-card-body strong {
    color: var(--text-primary);
    font-weight: 600;
}
.fc-card-body .fc-mono {
    font-family: var(--font-mono);
    font-size: 13px;
    color: var(--text-primary);
    background: rgba(255, 255, 255, 0.04);
    padding: 1px 6px;
    border-radius: 4px;
}
.fc-card-body .fc-detail-list {
    margin-top: 10px;
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.fc-card-body .fc-detail-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: var(--text-muted);
}
.fc-card-body .fc-detail-item .fc-bullet {
    width: 5px;
    height: 5px;
    border-radius: 50%;
    flex-shrink: 0;
}
.fc-detail-item .fc-bullet-blue { background: var(--blue-vivid); }
.fc-detail-item .fc-bullet-green { background: var(--green); }
.fc-detail-item .fc-bullet-gold { background: var(--gold-vivid); }

/* ── Server Zone wrapper ── */
.fc-server-zone {
    position: relative;
    z-index: 1;
    width: 100%;
    max-width: 560px;
    border: 1px solid rgba(34, 197, 94, 0.15);
    border-radius: var(--radius);
    background: rgba(34, 197, 94, 0.03);
    padding: 16px 16px 20px;
    margin: 4px 0;
}
.fc-server-zone::before {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: var(--radius);
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.04) 0%, transparent 50%);
    pointer-events: none;
}

.fc-zone-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-family: var(--font-heading);
    font-size: 13px;
    font-weight: 700;
    color: var(--green);
    text-transform: uppercase;
    letter-spacing: 0.8px;
    padding-bottom: 14px;
    border-bottom: 1px solid rgba(34, 197, 94, 0.1);
    margin-bottom: 12px;
}
.fc-zone-label svg { flex-shrink: 0; }

/* Adjust cards inside server zone to be full width */
.fc-server-zone .fc-card {
    max-width: 100%;
}

/* Remove timeline dots from server-zone cards (we use the zone wrapper) */
.fc-server-zone .fc-card::before { display: none; }

/* Adjust connectors inside server zone */
.fc-server-zone .fc-connector::after {
    border-top-color: rgba(34, 197, 94, 0.3);
}

/* ── Complete checkmark row ── */
.fc-complete {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 10px 24px;
    border-radius: 999px;
    background: rgba(20, 184, 166, 0.08);
    border: 1px solid rgba(20, 184, 166, 0.15);
    font-size: 13px;
    font-weight: 600;
    color: var(--teal);
    z-index: 1;
    position: relative;
}
.fc-complete svg { flex-shrink: 0; }

/* ── Responsive tweaks ── */
@media (max-width: 768px) {
    .flowchart::before { display: none; }
    .fc-card::before { display: none; }
    .fc-card { max-width: 100%; }
    .fc-server-zone { max-width: 100%; }
}

@media (max-width: 640px) {
    .flowchart { padding: 20px 8px 16px; }
    .fc-card { padding: 14px 14px 14px 16px; }
    .fc-card-body { font-size: 13px; }
    .fc-card-body .fc-detail-item { font-size: 12px; }
    .fc-server-zone { padding: 10px 8px 14px; }
    .fc-zone-label { font-size: 12px; }
    .fc-connector { height: 24px; }
    .fc-complete { font-size: 12px; padding: 8px 16px; }
}

@media (max-width: 480px) {
    .fc-card-body .fc-detail-list { gap: 3px; }
    .fc-card-body .fc-detail-item { font-size: 11px; }
    .fc-step-num { width: 20px; height: 20px; font-size: 10px; }
    .fc-phase { font-size: 9px; padding: 1px 6px; }
}

/* ═══════════════════════════════════════════════
   BADGES (inline)
   ═══════════════════════════════════════════════ */
.badge-inline {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.badge-blue { background: rgba(59, 130, 246, 0.12); color: var(--blue-vivid); }
.badge-green { background: rgba(34, 197, 94, 0.12); color: var(--green); }
.badge-gold { background: rgba(251, 191, 36, 0.12); color: var(--gold-vivid); }
.badge-purple { background: rgba(168, 85, 247, 0.12); color: var(--purple); }

/* ═══════════════════════════════════════════════
   STATUS CODE BADGES
   ═══════════════════════════════════════════════ */
.status-code {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 22px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 800;
    font-family: var(--font-mono);
}

.status-2xx { background: rgba(34, 197, 94, 0.15); color: var(--green); }
.status-4xx { background: rgba(244, 63, 94, 0.15); color: var(--rose); }
.status-5xx { background: rgba(251, 191, 36, 0.15); color: var(--gold-vivid); }

/* ═══════════════════════════════════════════════
   STATUS LINE (for description)
   ═══════════════════════════════════════════════ */
.status-line {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 6px 0;
}

/* ═══════════════════════════════════════════════
   FOOTER
   ═══════════════════════════════════════════════ */
.docs-footer {
    margin-top: 60px;
    padding-top: 24px;
    border-top: 1px solid rgba(255, 255, 255, 0.04);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
}

.docs-footer p {
    font-size: 12px;
    color: var(--text-muted);
}

.docs-footer a {
    font-size: 12px;
    color: var(--blue-vivid);
    transition: color var(--speed) var(--ease);
}

.docs-footer a:hover { color: #fff; }

/* ═══════════════════════════════════════════════
   MOBILE HAMBURGER
   ═══════════════════════════════════════════════ */
.sidebar-toggle {
    display: none;
    background: none;
    border: none;
    color: #fff;
    cursor: pointer;
    padding: 6px;
}

/* ═══════════════════════════════════════════════
   RESPONSIVE
   ═══════════════════════════════════════════════ */
@media (max-width: 1024px) {
    .sidebar { transform: translateX(-100%); transition: transform 0.3s var(--ease); }
    .sidebar.open { transform: translateX(0); }
    .sidebar-toggle { display: flex; }
    .main-content { margin-left: 0; }
    .content-wrapper { padding: 24px 24px 60px; }
    .top-bar { padding: 12px 24px; }
}

@media (max-width: 640px) {
    .hero-section h1 { font-size: 28px; }
    .section-block h2 { font-size: 22px; }
    .section-block h3 { font-size: 17px; }
    .content-wrapper { padding: 16px 16px 60px; }
    .top-bar { padding: 10px 16px; }
    .endpoint-header { flex-direction: column; align-items: flex-start; gap: 8px; }
    .endpoint-body { padding: 16px; }
    .code-block pre { padding: 12px 14px; font-size: 12px; }
    .docs-footer { flex-direction: column; text-align: center; }
}

/* Mobile overlay */
.sidebar-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.6);
    z-index: 99;
}

.sidebar-overlay.show { display: block; }
</style>
</head>
<body>

<!-- ═══════════════════════════════════════════════
     SIDEBAR OVERLAY (mobile)
     ═══════════════════════════════════════════════ -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- ═══════════════════════════════════════════════
     SIDEBAR
     ═══════════════════════════════════════════════ -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="<?= base_url() ?>" class="sidebar-brand">
            <img src="<?= base_url('logo_small.png') ?>" alt="MINI-CEX" class="sidebar-logo">
            <div class="sidebar-brand-text">
                <span class="sidebar-brand-name">MINI-CEX</span>
                <span class="sidebar-brand-sub">API Docs</span>
            </div>
        </a>
    </div>
    <nav class="sidebar-nav">
        <div class="sidebar-section">
            <div class="sidebar-section-title">Comenzando</div>
            <a href="#intro" class="sidebar-link active"><span class="link-dot"></span> Introducción</a>
        </div>
        <div class="sidebar-section">
            <div class="sidebar-section-title">Endpoints</div>
            <a href="#auth" class="sidebar-link"><span class="link-dot"></span> Autenticación</a>
            <a href="#students" class="sidebar-link"><span class="link-dot"></span> Alumnos</a>
            <a href="#evaluations" class="sidebar-link"><span class="link-dot"></span> Evaluaciones</a>
            <a href="#queue" class="sidebar-link"><span class="link-dot"></span> Cola Offline</a>
            <a href="#resend" class="sidebar-link"><span class="link-dot"></span> Reenvío Email</a>
        </div>
        <div class="sidebar-section">
            <div class="sidebar-section-title">Referencia</div>
            <a href="#flow" class="sidebar-link"><span class="link-dot"></span> Diagrama de Flujo</a>
            <a href="#mapping" class="sidebar-link"><span class="link-dot"></span> Mapeo de Campos</a>
            <a href="#status" class="sidebar-link"><span class="link-dot"></span> Códigos HTTP</a>
            <a href="#notes" class="sidebar-link"><span class="link-dot"></span> Notas Técnicas</a>
            <a href="#seed" class="sidebar-link"><span class="link-dot"></span> Seed Data</a>
            <a href="#reportes-pdf" class="sidebar-link"><span class="link-dot"></span> Reportes PDF</a>
        </div>
    </nav>
    <div class="sidebar-footer">
        <a href="<?= base_url() ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Volver al inicio
        </a>
    </div>
</aside>

<!-- ═══════════════════════════════════════════════
     MAIN CONTENT
     ═══════════════════════════════════════════════ -->
<main class="main-content">
    <!-- Top Bar -->
    <div class="top-bar">
        <div style="display:flex;align-items:center;gap:12px;">
            <button class="sidebar-toggle" id="sidebarToggle" aria-label="Menú">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
            <span class="top-bar-title">API <span>Documentación</span></span>
        </div>
        <span class="top-bar-version">v2.0</span>
    </div>

    <div class="content-wrapper">

        <!-- ═══ HERO ═══ -->
        <div class="hero-section" id="intro">
            <h1>API <span class="hero-gradient-text">MINI-CEX</span></h1>
            <p>API REST para la sincronización bidireccional entre la App Android y el servidor web. Documentación técnica de los endpoints, formatos de datos y flujo de sincronización offline.</p>
            <div class="base-url">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                Base URL: <strong><?= base_url() ?></strong>
            </div>
        </div>

        <!-- ═══ 1. INTRODUCCIÓN ═══ -->
        <div class="section-block" id="architecture">
            <h2><span class="section-number">1</span> Arquitectura</h2>
            <p>La API está construida con <strong>CodeIgniter 4</strong> y utiliza <strong>PDO nativo</strong> para el acceso a datos. El flujo de comunicación es bidireccional:</p>
            <ul>
                <li><strong>App → Servidor:</strong> La app envía evaluaciones, alumnos y operaciones de cola realizadas offline.</li>
                <li><strong>Servidor → App:</strong> El servidor responde con datos actualizados (usuarios, alumnos, evaluaciones) para reconciliación local.</li>
            </ul>
            <p>El mecanismo principal de sincronización offline es <code style="background:rgba(59,130,246,0.1);padding:2px 8px;border-radius:4px;font-family:var(--font-mono);font-size:13px;color:var(--blue-vivid);">/api/sync/process_queue</code>.</p>

            <h3>Base de Datos — Esquema</h3>
            <div class="table-wrap">
            <table>
                <tr><th>Tabla</th><th>Descripción</th><th>Columnas clave</th></tr>
                <tr><td><code>usuarios</code></td><td>Usuarios del sistema (docentes)</td><td><code>id_usuario</code>, <code>nombre_completo</code>, <code>email</code>, <code>password_hash</code>, <code>rol</code></td></tr>
                <tr><td><code>alumnos</code></td><td>Alumnos asignados a un docente</td><td><code>id_alumno</code>, <code>uuid</code>, <code>matricula</code>, <code>nombre_completo</code>, <code>semestre_grupo</code>, <code>correo</code>, <code>id_docente</code></td></tr>
                <tr><td><code>evaluaciones</code></td><td>Evaluaciones MINI-CEX</td><td><code>id_evaluacion</code>, <code>uuid</code>, <code>id_evaluador</code>, <code>id_alumno</code>, <code>fecha_evaluacion</code>, <code>entorno_clinico</code>, <code>tipo_paciente</code>, <code>asunto_principal</code>, <code>complejidad</code>, <code>calificacion_total</code>, <code>firma_evaluador</code>, <code>firma_alumno</code>, <code>is_synced</code></td></tr>
                <tr><td><code>detalles_rubrica</code></td><td>Detalles de competencias por evaluación</td><td><code>id_detalle</code>, <code>id_evaluacion</code>, <code>competencia</code>, <code>puntaje</code>, <code>notas</code>, <code>a_destacar</code>, <code>a_mejorar</code></td></tr>
                <tr><td><code>sync_queue</code></td><td>Historial de operaciones de sincronización</td><td><code>id</code>, <code>user_id</code>, <code>action</code>, <code>table_name</code>, <code>entity_uuid</code>, <code>data_payload</code></td></tr>
            </table>
            </div>

            <h3>Convenciones de la API</h3>
            <ul>
                <li><span class="badge-inline badge-blue">CORS</span> Permitido para todos los orígenes (<code>*</code>).</li>
                <li><span class="badge-inline badge-green">Content-Type</span> <code>application/json</code></li>
                <li><span class="badge-inline badge-gold">Auth</span> Comparación de contraseña en texto plano (sin hash).</li>
                <li><span class="badge-inline badge-purple">Mapeo</span> Kotlin camelCase ↔ MySQL snake_case.</li>
                <li><span class="badge-inline badge-blue">Tiempos</span> Las fechas/horas se transmiten como timestamps en milisegundos.</li>
            </ul>
        </div>

        <!-- ═══ 2. ENDPOINTS ═══ -->
        <div class="section-block">
            <h2><span class="section-number">2</span> Endpoints</h2>

            <!-- 2.1 Auth -->
            <h3 id="auth">2.1 Autenticación</h3>
            <div class="endpoint-card">
                <div class="endpoint-header">
                    <span class="endpoint-method method-post">POST</span>
                    <span class="endpoint-path">/api/auth/login</span>
                </div>
                <div class="endpoint-body">
                    <div class="endpoint-desc">Inicia sesión con credenciales de docente.</div>

                    <div class="endpoint-subtitle">Request Body</div>
                    <div class="code-block">
                        <div class="code-block-header">
                            <span class="lang-label">JSON</span>
                            <button class="copy-btn" data-copy='{"email":"evaluador@upe.edu.mx","password":"password123"}'>
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                                Copiar
                            </button>
                        </div>
                        <pre>{
    <span class="key">"email"</span>:    <span class="string">"evaluador@upe.edu.mx"</span>,  <span class="comment">// string (requerido)</span>
    <span class="key">"password"</span>: <span class="string">"password123"</span>             <span class="comment">// string (requerido)</span>
}</pre>
                    </div>

                    <div class="endpoint-subtitle">Response <span class="badge-inline badge-green">200</span></div>
                    <div class="code-block">
                        <div class="code-block-header">
                            <span class="lang-label">JSON</span>
                            <button class="copy-btn" data-copy='{"success":true,"user":{"id_usuario":1,"nombre_completo":"Dr. Evaluador Ejemplo","email":"evaluador@upe.edu.mx","rol":"Docente"}}'>
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                                Copiar
                            </button>
                        </div>
                        <pre>{
    <span class="key">"success"</span>: <span class="boolean">true</span>,
    <span class="key">"user"</span>: {
        <span class="key">"id_usuario"</span>:     <span class="number">1</span>,
        <span class="key">"nombre_completo"</span>: <span class="string">"Dr. Evaluador Ejemplo"</span>,
        <span class="key">"email"</span>:           <span class="string">"evaluador@upe.edu.mx"</span>,
        <span class="key">"rol"</span>:             <span class="string">"Docente"</span>
    }
}</pre>
                    </div>

                    <div class="endpoint-subtitle">Response <span class="badge-inline badge-gold">401</span></div>
                    <div class="code-block">
                        <div class="code-block-header">
                            <span class="lang-label">JSON</span>
                            <button class="copy-btn" data-copy='{"success":false,"message":"Credenciales incorrectas."}'>Copiar</button>
                        </div>
                        <pre>{
    <span class="key">"success"</span>: <span class="boolean">false</span>,
    <span class="key">"message"</span>: <span class="string">"Credenciales incorrectas."</span>
}</pre>
                    </div>
                </div>
            </div>

            <!-- 2.2 Students -->
            <h3 id="students">2.2 Alumnos</h3>
            <div class="endpoint-card">
                <div class="endpoint-header">
                    <span class="endpoint-method method-get">GET</span>
                    <span class="endpoint-path">/api/students</span>
                </div>
                <div class="endpoint-body">
                    <div class="endpoint-desc">Obtiene los alumnos asignados a un evaluador. Parámetro opcional: <code>?evaluador_id=1</code> (default: 1).</div>
                    <div class="endpoint-subtitle">Response</div>
                    <div class="code-block">
                        <div class="code-block-header">
                            <span class="lang-label">JSON</span>
                            <button class="copy-btn" data-copy='[{"id_alumno":1,"matricula":"202601","nombre_completo":"Juan Pérez","semestre_grupo":"6to A","correo":"juan.perez@example.com"}]'>Copiar</button>
                        </div>
                        <pre>[
    {
        <span class="key">"id_alumno"</span>:      <span class="number">1</span>,
        <span class="key">"matricula"</span>:      <span class="string">"202601"</span>,
        <span class="key">"nombre_completo"</span>: <span class="string">"Juan Pérez"</span>,
        <span class="key">"semestre_grupo"</span>:  <span class="string">"6to A"</span>,
        <span class="key">"correo"</span>:         <span class="string">"juan.perez@example.com"</span>
    },
    ...
]</pre>
                    </div>
                </div>
            </div>

            <div class="endpoint-card">
                <div class="endpoint-header">
                    <span class="endpoint-method method-post">POST</span>
                    <span class="endpoint-path">/api/sync/students</span>
                </div>
                <div class="endpoint-body">
                    <div class="endpoint-desc">Sincroniza alumnos desde la app hacia el servidor. Inserta o actualiza según matrícula.</div>
                    <div class="endpoint-subtitle">Request Body</div>
                    <div class="code-block">
                        <div class="code-block-header">
                            <span class="lang-label">JSON</span>
                            <button class="copy-btn" data-copy='[{"matricula":"202601","nombre_completo":"Juan Pérez","semestre_grupo":"6to A","correo":"juan.perez@example.com","id_docente":1}]'>Copiar</button>
                        </div>
                        <pre>[
    {
        <span class="key">"matricula"</span>:      <span class="string">"202601"</span>,
        <span class="key">"nombre_completo"</span>: <span class="string">"Juan Pérez"</span>,
        <span class="key">"semestre_grupo"</span>:  <span class="string">"6to A"</span>,
        <span class="key">"correo"</span>:         <span class="string">"juan.perez@example.com"</span>,
        <span class="key">"id_docente"</span>:     <span class="number">1</span>          <span class="comment">// opcional (default: 1)</span>
    },
    ...
]</pre>
                    </div>
                    <div class="endpoint-subtitle">Response</div>
                    <div class="code-block">
                        <div class="code-block-header">
                            <span class="lang-label">JSON</span>
                            <button class="copy-btn" data-copy='{"success":true,"synced":[{"matricula":"202601","id_alumno":1}]}'>Copiar</button>
                        </div>
                        <pre>{
    <span class="key">"success"</span>: <span class="boolean">true</span>,
    <span class="key">"synced"</span>: [
        { <span class="key">"matricula"</span>: <span class="string">"202601"</span>, <span class="key">"id_alumno"</span>: <span class="number">1</span> }
    ]
}</pre>
                    </div>
                </div>
            </div>

            <!-- 2.3 Evaluations -->
            <h3 id="evaluations">2.3 Evaluaciones</h3>
            <div class="endpoint-card">
                <div class="endpoint-header">
                    <span class="endpoint-method method-post">POST</span>
                    <span class="endpoint-path">/api/sync/evaluations</span>
                </div>
                <div class="endpoint-body">
                    <div class="endpoint-desc">
                        Envía evaluaciones desde la app al servidor. <strong>Idempotente:</strong> si el <code>uuid</code> ya existe, se omite.
                        Al insertar una evaluación nueva, se genera un PDF y se envía por correo al alumno (si tiene email registrado).
                        La operación es <strong>atómica</strong> (transacción).
                    </div>
                    <div class="endpoint-subtitle">Request Body</div>
                    <div class="code-block">
                        <div class="code-block-header">
                            <span class="lang-label">JSON</span>
                            <button class="copy-btn" data-copy='[{"evaluation":{"uuid":"a1b2c3d4-...","idEvaluador":1,"idAlumno":1,"fechaEvaluacion":1700000000000,"entornoClinico":"Consulta MF","tipoPaciente":"Nuevo","asuntoPrincipal":"Evaluación inicial","complejidad":"Media","tiempoObservacion":15,"tiempoFeedback":10,"calificacionTotal":8.5},"details":[{"competencia":"Historia Clínica","puntaje":9,"notas":"Buen desempeño","aDestacar":"Rapport excelente","aMejorar":"Profundizar antecedentes"}]}]'>Copiar</button>
                        </div>
                        <pre>[
    {
        <span class="key">"evaluation"</span>: {
            <span class="key">"uuid"</span>:             <span class="string">"a1b2c3d4-..."</span>,
            <span class="key">"idEvaluador"</span>:      <span class="number">1</span>,
            <span class="key">"idAlumno"</span>:         <span class="number">1</span>,
            <span class="key">"fechaEvaluacion"</span>:  <span class="number">1700000000000</span>,   <span class="comment">// timestamp ms</span>
            <span class="key">"entornoClinico"</span>:   <span class="string">"Consulta MF"</span>,    <span class="comment">// Consulta MF | Piso | Otros</span>
            <span class="key">"tipoPaciente"</span>:     <span class="string">"Nuevo"</span>,          <span class="comment">// Nuevo | Subsecuente</span>
            <span class="key">"asuntoPrincipal"</span>:  <span class="string">"Evaluación inicial"</span>,
            <span class="key">"complejidad"</span>:      <span class="string">"Media"</span>,          <span class="comment">// Baja | Media | Alta</span>
            <span class="key">"tiempoObservacion"</span>: <span class="number">15</span>,
            <span class="key">"tiempoFeedback"</span>:    <span class="number">10</span>,
            <span class="key">"calificacionTotal"</span>: <span class="number">8.5</span>,
            <span class="key">"firmaEvaluador"</span>:   <span class="string">"data:image/png;base64,..."</span>,  <span class="comment">// opcional</span>
            <span class="key">"firmaAlumno"</span>:      <span class="string">"data:image/png;base64,..."</span>   <span class="comment">// opcional</span>
        },
        <span class="key">"details"</span>: [
            {
                <span class="key">"competencia"</span>: <span class="string">"Historia Clínica"</span>,
                <span class="key">"puntaje"</span>:     <span class="number">9</span>,
                <span class="key">"notas"</span>:       <span class="string">"Buen desempeño"</span>,
                <span class="key">"aDestacar"</span>:   <span class="string">"Rapport excelente"</span>,
                <span class="key">"aMejorar"</span>:    <span class="string">"Profundizar antecedentes"</span>
            }
        ]
    }
]</pre>
                    </div>
                    <div class="endpoint-subtitle">Response</div>
                    <div class="code-block">
                        <div class="code-block-header">
                            <span class="lang-label">JSON</span>
                            <button class="copy-btn" data-copy='{"success":true,"message":"Sincronización completada con éxito.","syncedUuids":["a1b2c3d4-..."]}'>Copiar</button>
                        </div>
                        <pre>{
    <span class="key">"success"</span>:    <span class="boolean">true</span>,
    <span class="key">"message"</span>:    <span class="string">"Sincronización completada con éxito."</span>,
    <span class="key">"syncedUuids"</span>: [<span class="string">"a1b2c3d4-..."</span>]
}</pre>
                    </div>
                    <div class="info-box info-box-info">
                        <svg class="info-box-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                        <span><strong>Mapeo camelCase → snake_case:</strong> Los campos en <code>camelCase</code> (Kotlin) se convierten a <code>snake_case</code> en MySQL. Ej: <code>fechaEvaluacion</code> → <code>fecha_evaluacion</code>.</span>
                    </div>
                </div>
            </div>

            <div class="endpoint-card">
                <div class="endpoint-header">
                    <span class="endpoint-method method-get">GET</span>
                    <span class="endpoint-path">/api/sync/evaluations?evaluador_id=1</span>
                </div>
                <div class="endpoint-body">
                    <div class="endpoint-desc">Obtiene todas las evaluaciones de un evaluador, con sus detalles de rúbrica.</div>
                    <div class="endpoint-subtitle">Response</div>
                    <div class="code-block">
                        <div class="code-block-header">
                            <span class="lang-label">JSON</span>
                            <button class="copy-btn" data-copy='[{"evaluation":{"idEvaluacion":1,"uuid":"a1b2c3d4-...","idEvaluador":1,"idAlumno":1,"fechaEvaluacion":1700000000000,"entornoClinico":"Consulta MF","tipoPaciente":"Nuevo","asuntoPrincipal":"Evaluación inicial","complejidad":"Media","tiempoObservacion":15,"tiempoFeedback":10,"calificacionTotal":8.5,"isSynced":true},"details":[{"idDetalle":1,"idEvaluacion":1,"competencia":"Historia Clínica","puntaje":9,"notas":"Buen desempeño","aDestacar":"Rapport excelente","aMejorar":"Profundizar antecedentes"}]}]'>Copiar</button>
                        </div>
                        <pre>[
    {
        <span class="key">"evaluation"</span>: {
            <span class="key">"idEvaluacion"</span>:      <span class="number">1</span>,
            <span class="key">"uuid"</span>:              <span class="string">"a1b2c3d4-..."</span>,
            <span class="key">"idEvaluador"</span>:       <span class="number">1</span>,
            <span class="key">"idAlumno"</span>:          <span class="number">1</span>,
            <span class="key">"fechaEvaluacion"</span>:   <span class="number">1700000000000</span>,
            <span class="key">"entornoClinico"</span>:    <span class="string">"Consulta MF"</span>,
            <span class="key">"tipoPaciente"</span>:      <span class="string">"Nuevo"</span>,
            <span class="key">"asuntoPrincipal"</span>:   <span class="string">"Evaluación inicial"</span>,
            <span class="key">"complejidad"</span>:       <span class="string">"Media"</span>,
            <span class="key">"tiempoObservacion"</span>:  <span class="number">15</span>,
            <span class="key">"tiempoFeedback"</span>:     <span class="number">10</span>,
            <span class="key">"calificacionTotal"</span>:  <span class="number">8.5</span>,
            <span class="key">"isSynced"</span>:          <span class="boolean">true</span>,
            <span class="key">"createdAt"</span>:          <span class="number">1700000000000</span>
        },
        <span class="key">"details"</span>: [
            {
                <span class="key">"idDetalle"</span>:    <span class="number">1</span>,
                <span class="key">"idEvaluacion"</span>: <span class="number">1</span>,
                <span class="key">"competencia"</span>:  <span class="string">"Historia Clínica"</span>,
                <span class="key">"puntaje"</span>:      <span class="number">9</span>,
                <span class="key">"notas"</span>:        <span class="string">"Buen desempeño"</span>,
                <span class="key">"aDestacar"</span>:    <span class="string">"Rapport excelente"</span>,
                <span class="key">"aMejorar"</span>:     <span class="string">"Profundizar antecedentes"</span>
            }
        ]
    }
]</pre>
                    </div>
                </div>
            </div>

            <!-- 2.4 Process Queue -->
            <h3 id="queue">2.4 Cola de Sincronización (Offline Bidireccional)</h3>
            <div class="endpoint-card">
                <div class="endpoint-header">
                    <span class="endpoint-method method-post">POST</span>
                    <span class="endpoint-path">/api/sync/process_queue?evaluador_id=1</span>
                </div>
                <div class="endpoint-body">
                    <div class="endpoint-desc">
                        <strong>Endpoint principal de sincronización offline.</strong> Procesa una cola de operaciones
                        enviadas por la app y devuelve <code>serverActions</code> para que la app reconcilie su estado local.
                    </div>
                    <div class="endpoint-subtitle">Request Body</div>
                    <div class="code-block">
                        <div class="code-block-header">
                            <span class="lang-label">JSON</span>
                            <button class="copy-btn" data-copy='[{"action":"insert","tableName":"alumnos","entityUuid":"uuid-del-alumno","dataPayload":"{}","timestamp":1700000000000}]'>Copiar</button>
                        </div>
                        <pre>[
    {
        <span class="key">"action"</span>:      <span class="string">"insert"</span>,            <span class="comment">// "insert" | "update" | "delete"</span>
        <span class="key">"tableName"</span>:   <span class="string">"alumnos"</span>,           <span class="comment">// "alumnos" | "evaluaciones"</span>
        <span class="key">"entityUuid"</span>:  <span class="string">"uuid-del-alumno"</span>,
        <span class="key">"dataPayload"</span>: <span class="string">"{ ... }"</span>,           <span class="comment">// string JSON</span>
        <span class="key">"timestamp"</span>:   <span class="number">1700000000000</span>
    }
]</pre>
                    </div>

                    <div class="endpoint-subtitle">dataPayload — Alumnos (insert/update)</div>
                    <div class="code-block">
                        <div class="code-block-header">
                            <span class="lang-label">JSON</span>
                            <button class="copy-btn" data-copy='{"matricula":"202601","nombreCompleto":"Juan Pérez","semestreGrupo":"6to A","correo":"juan@example.com","idAlumno":0}'>Copiar</button>
                        </div>
                        <pre>{
    <span class="key">"matricula"</span>:      <span class="string">"202601"</span>,
    <span class="key">"nombreCompleto"</span>: <span class="string">"Juan Pérez"</span>,
    <span class="key">"semestreGrupo"</span>:  <span class="string">"6to A"</span>,
    <span class="key">"correo"</span>:         <span class="string">"juan@example.com"</span>,
    <span class="key">"idAlumno"</span>:       <span class="number">0</span>           <span class="comment">// ID local de la app (mapeo)</span>
}</pre>
                    </div>

                    <div class="endpoint-subtitle">Response</div>
                    <div class="code-block">
                        <div class="code-block-header">
                            <span class="lang-label">JSON</span>
                            <button class="copy-btn" data-copy='{"success":true,"message":"Cola procesada correctamente","processedIds":[],"serverActions":[{"action":"update","tableName":"usuarios","entityUuid":"","dataPayload":"{}","timestamp":1700000000000}]}'>Copiar</button>
                        </div>
                        <pre>{
    <span class="key">"success"</span>:       <span class="boolean">true</span>,
    <span class="key">"message"</span>:       <span class="string">"Cola procesada correctamente"</span>,
    <span class="key">"processedIds"</span>:  [],
    <span class="key">"serverActions"</span>: [
        {
            <span class="key">"action"</span>:      <span class="string">"update"</span>,
            <span class="key">"tableName"</span>:   <span class="string">"usuarios"</span>,
            <span class="key">"entityUuid"</span>:  <span class="string">""</span>,
            <span class="key">"dataPayload"</span>: <span class="string">"{ \"id_usuario\": 1, ... }"</span>,
            <span class="key">"timestamp"</span>:   <span class="number">1700000000000</span>
        }
        <span class="comment">// + alumnos + evaluaciones</span>
    ]
}</pre>
                    </div>

                    <div class="info-box info-box-warn">
                        <svg class="info-box-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                        <span><strong>Importante:</strong> Si el usuario logueado fue eliminado del servidor, se devuelve <code>{ "action": "delete", "tableName": "usuarios" }</code> para que la app cierre sesión.</span>
                    </div>

                    <div class="info-box info-box-info">
                        <svg class="info-box-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                        <span><strong>Flujo:</strong> La app envía operaciones pendientes → el servidor las procesa en transacción → responde con <code>serverActions</code> (usuarios + alumnos + evaluaciones) para que la app actualice su BD local.</span>
                    </div>
                </div>
            </div>

            <!-- 2.5 Resend Email -->
            <h3 id="resend">2.5 Reenvío de Correo</h3>
            <div class="endpoint-card">
                <div class="endpoint-header">
                    <span class="endpoint-method method-post">POST</span>
                    <span class="endpoint-path">/api/sync/resend-email</span>
                </div>
                <div class="endpoint-body">
                    <div class="endpoint-desc">Reenvía el correo de notificación con PDF adjunto para una evaluación específica (por UUID).</div>
                    <div class="endpoint-subtitle">Request Body</div>
                    <div class="code-block">
                        <div class="code-block-header">
                            <span class="lang-label">JSON</span>
                            <button class="copy-btn" data-copy='{"uuid":"a1b2c3d4-..."}'>Copiar</button>
                        </div>
                        <pre>{
    <span class="key">"uuid"</span>: <span class="string">"a1b2c3d4-..."</span>   <span class="comment">// UUID de la evaluación</span>
}</pre>
                    </div>
                    <div class="endpoint-subtitle">Response <span class="badge-inline badge-green">200</span></div>
                    <div class="code-block">
                        <div class="code-block-header">
                            <span class="lang-label">JSON</span>
                            <button class="copy-btn" data-copy='{"success":true,"message":"Correo reenviado con éxito."}'>Copiar</button>
                        </div>
                        <pre>{
    <span class="key">"success"</span>: <span class="boolean">true</span>,
    <span class="key">"message"</span>: <span class="string">"Correo reenviado con éxito."</span>
}</pre>
                    </div>
                    <div class="endpoint-subtitle">Posibles Errores</div>
                    <table style="width:100%;border-collapse:collapse;font-size:13px;">
                        <tr><td style="padding:6px 0;"><span class="badge-inline badge-gold">400</span></td><td style="padding:6px 0;color:var(--text-secondary);">UUID requerido / El alumno no tiene correo</td></tr>
                        <tr><td style="padding:6px 0;"><span class="badge-inline badge-gold">404</span></td><td style="padding:6px 0;color:var(--text-secondary);">Evaluación no encontrada</td></tr>
                        <tr><td style="padding:6px 0;"><span class="badge-inline badge-gold">500</span></td><td style="padding:6px 0;color:var(--text-secondary);">Error SMTP o al generar PDF</td></tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- ═══ 3. FLOW DIAGRAM ═══ -->
        <div class="section-block" id="flow">
            <h2><span class="section-number">3</span> Diagrama de Flujo</h2>
            <p>Ciclo completo de sincronización offline entre la App Android y el Servidor.</p>
            <div class="flow-diagram">
                <div class="flowchart">

                    <!-- ── Step 1 ── -->
                    <div class="fc-card fc-app">
                        <div class="fc-card-header">
                            <span class="fc-step-num">1</span>
                            <span class="fc-phase fc-phase-app">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"/><line x1="9" y1="9" x2="15" y2="15"/><line x1="15" y1="9" x2="9" y2="15"/></svg>
                                App Android
                            </span>
                        </div>
                        <div class="fc-card-body">
                            <strong>Modo offline</strong> — Crea o edita <strong>alumnos</strong> y <strong>evaluaciones</strong> sin conexión. Las operaciones se almacenan en una cola local (SQLite).
                        </div>
                    </div>

                    <div class="fc-connector"></div>

                    <!-- ── Step 2 ── -->
                    <div class="fc-card fc-app">
                        <div class="fc-card-header">
                            <span class="fc-step-num">2</span>
                            <span class="fc-phase fc-phase-app">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                                App Android
                            </span>
                        </div>
                        <div class="fc-card-body">
                            <strong>Al recuperar conexión</strong> — Envía la cola de operaciones pendientes mediante <span class="fc-mono">POST /api/sync/process_queue</span>.
                        </div>
                    </div>

                    <div class="fc-connector"></div>

                    <!-- ══ Server Zone ══ -->
                    <div class="fc-server-zone">
                        <div class="fc-zone-label">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"/><rect x="2" y="14" width="20" height="8" rx="2" ry="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/></svg>
                            Servidor — PHP + MySQL
                        </div>

                        <!-- ── Step 3 ── -->
                        <div class="fc-card fc-server">
                            <div class="fc-card-header">
                                <span class="fc-step-num">3</span>
                                <span class="fc-phase fc-phase-server">Servidor</span>
                            </div>
                            <div class="fc-card-body">
                                <strong>Recibe y valida</strong> — Procesa la cola de operaciones y verifica la existencia del usuario en la base de datos.
                            </div>
                        </div>

                        <div class="fc-connector"></div>

                        <!-- ── Step 4 ── -->
                        <div class="fc-card fc-server">
                            <div class="fc-card-header">
                                <span class="fc-step-num">4</span>
                                <span class="fc-phase fc-phase-server">Servidor</span>
                            </div>
                            <div class="fc-card-body">
                                <strong>Transacción atómica</strong> — Procesa en una sola transacción MySQL:
                                <div class="fc-detail-list">
                                    <div class="fc-detail-item"><span class="fc-bullet fc-bullet-blue"></span> <strong style="color:var(--blue-vivid);">Alumnos:</strong> insert / update / delete</div>
                                    <div class="fc-detail-item"><span class="fc-bullet fc-bullet-green"></span> <strong style="color:var(--green);">Evaluaciones:</strong> insert / update + detalles_rubrica</div>
                                    <div class="fc-detail-item"><span class="fc-bullet fc-bullet-gold"></span> Rollback completo si algo falla</div>
                                </div>
                            </div>
                        </div>

                        <div class="fc-connector"></div>

                        <!-- ── Step 5 ── -->
                        <div class="fc-card fc-server">
                            <div class="fc-card-header">
                                <span class="fc-step-num">5</span>
                                <span class="fc-phase fc-phase-server">Servidor</span>
                            </div>
                            <div class="fc-card-body">
                                <strong>Prepara <span class="fc-mono">serverActions</span></strong> — Compila los datos actualizados para la reconciliación local de la app:
                                <div class="fc-detail-list">
                                    <div class="fc-detail-item"><span class="fc-bullet fc-bullet-blue"></span> Usuarios completos (login offline)</div>
                                    <div class="fc-detail-item"><span class="fc-bullet fc-bullet-green"></span> Alumnos del evaluador (IDs mapeados)</div>
                                    <div class="fc-detail-item"><span class="fc-bullet fc-bullet-gold"></span> Evaluaciones (UUIDs confirmados)</div>
                                </div>
                            </div>
                        </div>

                        <div class="fc-connector"></div>

                        <!-- ── Step 6 ── -->
                        <div class="fc-card fc-server">
                            <div class="fc-card-header">
                                <span class="fc-step-num">6</span>
                                <span class="fc-phase fc-phase-server">Servidor</span>
                            </div>
                            <div class="fc-card-body">
                                <strong>PDF + Email</strong> — Si hay evaluaciones nuevas:
                                <div class="fc-detail-list">
                                    <div class="fc-detail-item"><span class="fc-bullet fc-bullet-blue"></span> Genera PDF con <strong>FPDF</strong> personalizado</div>
                                    <div class="fc-detail-item"><span class="fc-bullet fc-bullet-green"></span> Envía notificación por <strong>PHPMailer</strong> al alumno</div>
                                    <div class="fc-detail-item"><span class="fc-bullet fc-bullet-gold"></span> Auto-heal SMTP si el host no coincide</div>
                                </div>
                            </div>
                        </div>

                        <div class="fc-connector"></div>

                        <!-- ── Step 7 ── -->
                        <div class="fc-card fc-server">
                            <div class="fc-card-header">
                                <span class="fc-step-num">7</span>
                                <span class="fc-phase fc-phase-server">Servidor</span>
                            </div>
                            <div class="fc-card-body">
                                <strong>Responde con <span class="fc-mono">serverActions</span></strong> — El servidor responde con todas las acciones necesarias para que la app reconcilie su estado local.
                            </div>
                        </div>
                    </div>
                    <!-- ══ End Server Zone ══ -->

                    <div class="fc-connector"></div>

                    <!-- ── Step 8 ── -->
                    <div class="fc-card fc-app">
                        <div class="fc-card-header">
                            <span class="fc-step-num">8</span>
                            <span class="fc-phase fc-phase-app">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"/><line x1="9" y1="9" x2="15" y2="15"/><line x1="15" y1="9" x2="9" y2="15"/></svg>
                                App Android
                            </span>
                        </div>
                        <div class="fc-card-body">
                            <strong>Reconciliación local</strong> — Actualiza su BD (SQLite) con los <span class="fc-mono">serverActions</span>:
                            <div class="fc-detail-list">
                                <div class="fc-detail-item"><span class="fc-bullet fc-bullet-blue"></span> Usuarios → permite login offline</div>
                                <div class="fc-detail-item"><span class="fc-bullet fc-bullet-green"></span> Alumnos → mapea IDs locales ↔ servidor</div>
                                <div class="fc-detail-item"><span class="fc-bullet fc-bullet-gold"></span> Evaluaciones → confirma UUIDs</div>
                            </div>
                        </div>
                    </div>

                    <div class="fc-connector"></div>

                    <!-- ── Done ── -->
                    <div class="fc-complete">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        Sincronización completada con éxito
                    </div>

                </div>
            </div>
        </div>

        <!-- ═══ 4. FIELD MAPPING ═══ -->
        <div class="section-block" id="mapping">
            <h2><span class="section-number">4</span> Mapeo de Campos</h2>
            <p>Convención de nomenclatura entre la App (Kotlin camelCase) y la Base de Datos (MySQL snake_case).</p>
            <div class="table-wrap">
            <table>
                <tr><th>App (Kotlin camelCase)</th><th>Servidor (MySQL snake_case)</th><th>Tipo</th></tr>
                <tr><td><code>idEvaluador</code></td><td><code>id_evaluador</code></td><td>INT</td></tr>
                <tr><td><code>idAlumno</code></td><td><code>id_alumno</code></td><td>INT</td></tr>
                <tr><td><code>fechaEvaluacion</code></td><td><code>fecha_evaluacion</code></td><td>DATE (timestamp ms)</td></tr>
                <tr><td><code>entornoClinico</code></td><td><code>entorno_clinico</code></td><td>ENUM</td></tr>
                <tr><td><code>tipoPaciente</code></td><td><code>tipo_paciente</code></td><td>ENUM</td></tr>
                <tr><td><code>asuntoPrincipal</code></td><td><code>asunto_principal</code></td><td>VARCHAR</td></tr>
                <tr><td><code>complejidad</code></td><td><code>complejidad</code></td><td>ENUM</td></tr>
                <tr><td><code>tiempoObservacion</code></td><td><code>tiempo_observacion</code></td><td>INT</td></tr>
                <tr><td><code>tiempoFeedback</code></td><td><code>tiempo_feedback</code></td><td>INT</td></tr>
                <tr><td><code>calificacionTotal</code></td><td><code>calificacion_total</code></td><td>DECIMAL</td></tr>
                <tr><td><code>firmaEvaluador</code></td><td><code>firma_evaluador</code></td><td>LONGTEXT (base64)</td></tr>
                <tr><td><code>firmaAlumno</code></td><td><code>firma_alumno</code></td><td>LONGTEXT (base64)</td></tr>
                <tr><td><code>isSynced</code></td><td><code>is_synced</code></td><td>BOOLEAN</td></tr>
                <tr><td><code>createdAt</code></td><td><code>created_at</code></td><td>TIMESTAMP (ms)</td></tr>
                <tr><td><code>nombreCompleto</code></td><td><code>nombre_completo</code></td><td>VARCHAR</td></tr>
                <tr><td><code>semestreGrupo</code></td><td><code>semestre_grupo</code></td><td>VARCHAR</td></tr>
                <tr><td><code>aDestacar</code></td><td><code>a_destacar</code></td><td>TEXT</td></tr>
                <tr><td><code>aMejorar</code></td><td><code>a_mejorar</code></td><td>TEXT</td></tr>
                <tr><td><code>idDocente</code></td><td><code>id_docente</code></td><td>INT</td></tr>
            </table>
            </div>
        </div>

        <!-- ═══ 5. HTTP STATUS ═══ -->
        <div class="section-block" id="status">
            <h2><span class="section-number">5</span> Códigos de Estado HTTP</h2>
            <div class="table-wrap">
            <table>
                <tr><th>Código</th><th>Significado</th><th>Uso</th></tr>
                <tr><td><span class="status-code status-2xx">200</span></td><td>OK</td><td>Respuesta exitosa estándar</td></tr>
                <tr><td><span class="status-code status-4xx">400</span></td><td>Bad Request</td><td>Faltan campos requeridos, formato inválido</td></tr>
                <tr><td><span class="status-code status-4xx">401</span></td><td>Unauthorized</td><td>Credenciales incorrectas</td></tr>
                <tr><td><span class="status-code status-4xx">404</span></td><td>Not Found</td><td>Evaluación no encontrada</td></tr>
                <tr><td><span class="status-code status-5xx">500</span></td><td>Internal Server Error</td><td>Error de BD, SMTP, o excepción</td></tr>
            </table>
            </div>
        </div>

        <!-- ═══ 6. TECHNICAL NOTES ═══ -->
        <div class="section-block" id="notes">
            <h2><span class="section-number">6</span> Notas Técnicas</h2>
            <p>Detalles relevantes sobre el comportamiento interno de la API.</p>
            <div class="table-wrap">
            <table>
                <tr><th>Tema</th><th>Detalle</th></tr>
                <tr><td>CORS</td><td><code>Access-Control-Allow-Origin: *</code>. Preflight OPTIONS manejado automáticamente.</td></tr>
                <tr><td>Autenticación</td><td>Comparación directa de contraseña en texto plano. No usa <code>password_hash</code>.</td></tr>
                <tr><td>Idempotencia</td><td>Las evaluaciones se identifican por <code>uuid</code>. Si existe, se omite el insert.</td></tr>
                <tr><td>Transacciones</td><td><code>sync/evaluations</code> y <code>process_queue</code> usan transacciones atómicas. Rollback completo si falla.</td></tr>
                <tr><td>Manejo de errores</td><td>Try/catch con <code>\Throwable</code>. Los errores incluyen mensaje y ocasionalmente trace.</td></tr>
                <tr><td>Fechas</td><td>La app envía timestamps en milisegundos. El servidor divide por 1000 y usa <code>date('Y-m-d')</code>.</td></tr>
                <tr><td>Email/SMTP</td><td>PHPMailer. Auto-heal de host si SMTP_HOST es <code>smtp.example.com</code> pero el username es <code>@gmail.com</code>. Logs en <code>email_log.log</code>.</td></tr>
                <tr><td>PDF</td><td>FPDF personalizado en <code>api/pdf_generator.php</code>. Se adjunta al email como string.</td></tr>
                <tr><td>Migración automática</td><td>Cada request ejecuta <code>ALTER TABLE alumnos ADD COLUMN correo VARCHAR(255)</code> (falla silenciosamente si ya existe).</td></tr>
            </table>
            </div>
        </div>

        <!-- ═══ 7. SEED DATA ═══ -->
        <div class="section-block" id="seed">
            <h2><span class="section-number">7</span> Seed Data</h2>
            <p>Registros iniciales creados por <code>setup.php</code> al reiniciar la base de datos.</p>
            <div class="table-wrap">
            <table>
                <tr><th>Tabla</th><th>Registros</th></tr>
                <tr><td><code>usuarios</code></td><td><code>evaluador@upe.edu.mx</code> / <code>password123</code> (Rol: Docente)</td></tr>
                <tr><td><code>alumnos</code></td><td>Juan Pérez (202601), María García (202602), Carlos López (202603)</td></tr>
            </table>
            </div>
        </div>

        <!-- ═══ 8. REPORTES PDF ═══ -->
        <div class="section-block" id="reportes-pdf">
            <h2><span class="section-number">8</span> Reportes PDF</h2>
            <p>Generación automatizada de reportes clínicos en PDF con formato institucional. El proceso se ejecuta cada vez que se sincroniza una evaluación nueva o se solicita un reenvío de correo.</p>

            <div class="flow-diagram">
                <div class="flowchart pdf-flow">

                    <!-- ── Step 1 ── -->
                    <div class="fc-card fc-pdf">
                        <div class="fc-card-header">
                            <span class="fc-step-num">1</span>
                            <span class="fc-phase fc-phase-pdf">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                                Disparador
                            </span>
                        </div>
                        <div class="fc-card-body">
                            <strong>Evento detonante</strong> — Se genera un reporte PDF cuando:
                            <div class="fc-detail-list">
                                <div class="fc-detail-item"><span class="fc-bullet fc-bullet-blue"></span> Una evaluación se sincroniza desde la app (<span class="fc-mono">POST /api/sync/evaluations</span>)</div>
                                <div class="fc-detail-item"><span class="fc-bullet fc-bullet-gold"></span> Se solicita reenvío de correo (<span class="fc-mono">POST /api/sync/resend-email</span>)</div>
                                <div class="fc-detail-item"><span class="fc-bullet fc-bullet-green"></span> Se genera desde el panel admin (<span class="fc-mono">AdminController</span>)</div>
                            </div>
                        </div>
                    </div>

                    <div class="fc-connector"></div>

                    <!-- ── Step 2 ── -->
                    <div class="fc-card fc-pdf">
                        <div class="fc-card-header">
                            <span class="fc-step-num">2</span>
                            <span class="fc-phase fc-phase-pdf">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"/><line x1="9" y1="9" x2="15" y2="15"/><line x1="15" y1="9" x2="9" y2="15"/></svg>
                                Servidor
                            </span>
                        </div>
                        <div class="fc-card-body">
                            <strong>Consulta de datos</strong> — El servidor obtiene de MySQL:
                            <div class="fc-detail-list">
                                <div class="fc-detail-item"><span class="fc-bullet fc-bullet-blue"></span> Evaluación completa con <strong>uuid, fechas, entorno clínico, complejidad</strong></div>
                                <div class="fc-detail-item"><span class="fc-bullet fc-bullet-green"></span> Datos del alumno: <strong>nombre, matrícula, semestre/grupo, correo</strong></div>
                                <div class="fc-detail-item"><span class="fc-bullet fc-bullet-gold"></span> Datos del evaluador: <strong>nombre completo</strong></div>
                                <div class="fc-detail-item"><span class="fc-bullet" style="background:var(--purple);"></span> Detalles de rúbrica: <strong>competencias, puntajes, notas, feedback</strong></div>
                            </div>
                        </div>
                    </div>

                    <div class="fc-connector"></div>

                    <!-- ══ PDF Generation Zone ══ -->
                    <div class="fc-server-zone" style="border-color:rgba(212,160,18,0.2);background:rgba(212,160,18,0.03);">
                        <div class="fc-zone-label" style="color:var(--gold-vivid);border-bottom-color:rgba(212,160,18,0.15);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                            Motor PDF — FPDF
                        </div>

                        <!-- ── Step 3 ── -->
                        <div class="fc-card fc-pdf" style="border-left-color:var(--gold-vivid);">
                            <div class="fc-card-header">
                                <span class="fc-step-num">3</span>
                                <span class="fc-phase fc-phase-pdf">Render</span>
                            </div>
                            <div class="fc-card-body">
                                <strong>Construcción del PDF</strong> — <span class="fc-mono">api/pdf_generator.php :: generateEvaluationPdf()</span>:
                                <div class="fc-detail-list">
                                    <div class="fc-detail-item"><span class="fc-bullet" style="background:#1B5E96;"></span> <strong>Banner superior:</strong> barra azul institucional (#1B5E96) + línea dorada (#B8860B)</div>
                                    <div class="fc-detail-item"><span class="fc-bullet" style="background:#B8860B;"></span> <strong>Logotipo:</strong> Escala dinámica de alta resolución → 400px para FPDF</div>
                                    <div class="fc-detail-item"><span class="fc-bullet fc-bullet-blue"></span> <strong>Encabezado:</strong> nombre de la institución, título "MINI-CEX"</div>
                                    <div class="fc-detail-item"><span class="fc-bullet fc-bullet-green"></span> <strong>Datos generales:</strong> alumno, evaluador, fecha, entorno clínico, tipo de paciente, complejidad</div>
                                    <div class="fc-detail-item"><span class="fc-bullet fc-bullet-gold"></span> <strong>Tabla de rúbrica:</strong> competencias con puntajes (1-9) y notas cualitativas</div>
                                    <div class="fc-detail-item"><span class="fc-bullet" style="background:var(--purple);"></span> <strong>Feedback:</strong> "A destacar" y "A mejorar" con viñetas</div>
                                    <div class="fc-detail-item"><span class="fc-bullet" style="background:var(--teal);"></span> <strong>Firmas:</strong> espacio para firma del evaluador y del alumno (base64 → PNG)</div>
                                </div>
                            </div>
                        </div>

                        <div class="fc-connector"></div>

                        <!-- ── Step 4 ── -->
                        <div class="fc-card fc-pdf" style="border-left-color:var(--gold-vivid);">
                            <div class="fc-card-header">
                                <span class="fc-step-num">4</span>
                                <span class="fc-phase fc-phase-pdf">Render</span>
                            </div>
                            <div class="fc-card-body">
                                <strong>Salida del PDF</strong> — La función retorna el contenido binario del PDF como <strong>string</strong> (<span class="fc-mono">$pdf->Output('', 'S')</span>), listo para ser adjuntado al correo.
                            </div>
                        </div>
                    </div>

                    <div class="fc-connector"></div>

                    <!-- ── Step 5 ── -->
                    <div class="fc-card fc-pdf">
                        <div class="fc-card-header">
                            <span class="fc-step-num">5</span>
                            <span class="fc-phase fc-phase-pdf">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                PHPMailer
                            </span>
                        </div>
                        <div class="fc-card-body">
                            <strong>Notificación por correo</strong> — Se envía el PDF al alumno mediante <strong>PHPMailer</strong>:
                            <div class="fc-detail-list">
                                <div class="fc-detail-item"><span class="fc-bullet fc-bullet-blue"></span> Destinatario: <strong>correo del alumno</strong> (columna <span class="fc-mono">correo</span> en <span class="fc-mono">alumnos</span>)</div>
                                <div class="fc-detail-item"><span class="fc-bullet fc-bullet-green"></span> Asunto: <strong>"Resultado de Evaluación MINI-CEX"</strong></div>
                                <div class="fc-detail-item"><span class="fc-bullet fc-bullet-gold"></span> Adjunto: PDF generado como <span class="fc-mono">string</span> vía <span class="fc-mono">addStringAttachment()</span></div>
                                <div class="fc-detail-item"><span class="fc-bullet" style="background:var(--purple);"></span> <strong>Auto-heal SMTP:</strong> si <span class="fc-mono">SMTP_HOST</span> es <span class="fc-mono">smtp.example.com</span> pero el username es <span class="fc-mono">@gmail.com</span>, se conmuta automáticamente a <span class="fc-mono">smtp.gmail.com</span></div>
                            </div>
                        </div>
                    </div>

                    <div class="fc-connector"></div>

                    <!-- ── Step 6 ── -->
                    <div class="fc-card fc-pdf">
                        <div class="fc-card-header">
                            <span class="fc-step-num">6</span>
                            <span class="fc-phase fc-phase-pdf">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                                Registro
                            </span>
                        </div>
                        <div class="fc-card-body">
                            <strong>Logging</strong> — Cada envío se registra en <span class="fc-mono">email_log.log</span> con:
                            <div class="fc-detail-list">
                                <div class="fc-detail-item"><span class="fc-bullet fc-bullet-blue"></span> Fecha y hora del envío</div>
                                <div class="fc-detail-item"><span class="fc-bullet fc-bullet-green"></span> UUID de la evaluación</div>
                                <div class="fc-detail-item"><span class="fc-bullet fc-bullet-gold"></span> Correo del destinatario</div>
                                <div class="fc-detail-item"><span class="fc-bullet" style="background:var(--purple);"></span> Estado: <strong style="color:var(--green);">✓ Enviado</strong> o <strong style="color:var(--rose);">✗ Error</strong></div>
                            </div>
                        </div>
                    </div>

                    <div class="fc-connector"></div>

                    <!-- ── Done ── -->
                    <div class="fc-complete" style="background:rgba(212,160,18,0.08);border-color:rgba(212,160,18,0.2);color:var(--gold-vivid);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        Reporte PDF generado y entregado al alumno
                    </div>

                </div>
            </div>

            <p style="margin-top:16px;">El flujo completo es <strong>automático y transparente</strong> para el evaluador: al sincronizar una evaluación desde la app, el servidor genera el PDF y lo envía por correo sin intervención manual.</p>

            <div class="info-box info-box-info">
                <svg class="info-box-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                <span><strong>Nota:</strong> El PDF se genera con <strong>FPDF</strong> (librería personalizada en <span class="fc-mono">api/fpdf/</span>), no con TCPDF. El motor incluye escalado dinámico de imágenes para evitar agotar la memoria en logotipos de alta resolución.</span>
            </div>
        </div>

        <!-- ═══ FOOTER ═══ -->
        <div class="docs-footer">
            <p>Documentación generada del código fuente — MINI-CEX v2.0</p>
            <a href="<?= base_url() ?>">← Volver al inicio</a>
        </div>

    </div>
</main>

<!-- ═══════════════════════════════════════════════
     JAVASCRIPT
     ═══════════════════════════════════════════════ -->
<script>
(function() {
    'use strict';

    // ─── Sidebar Toggle (mobile) ────────────────
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const toggle = document.getElementById('sidebarToggle');

    function openSidebar() {
        sidebar.classList.add('open');
        overlay.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('show');
        document.body.style.overflow = '';
    }

    if (toggle) toggle.addEventListener('click', openSidebar);
    if (overlay) overlay.addEventListener('click', closeSidebar);

    // ─── Active Link Highlighting ───────────────
    const links = document.querySelectorAll('.sidebar-link');
    const sections = [];

    links.forEach(link => {
        const href = link.getAttribute('href');
        if (href && href.startsWith('#')) {
            const target = document.getElementById(href.slice(1));
            if (target) {
                sections.push({ el: target, link: link });
            }
        }
    });

    function updateActiveLink() {
        const scrollY = window.scrollY + 120;
        let current = null;

        sections.forEach(({ el, link }) => {
            const top = el.offsetTop;
            const bottom = top + el.offsetHeight;

            if (scrollY >= top && scrollY < bottom) {
                current = link;
            }
        });

        // Si no se encuentra ninguno y estamos al final, activa el último
        if (!current && sections.length > 0) {
            const last = sections[sections.length - 1];
            const bottom = last.el.offsetTop + last.el.offsetHeight;
            if (window.scrollY + window.innerHeight >= document.documentElement.scrollHeight - 50) {
                current = last.link;
            }
        }

        links.forEach(link => link.classList.remove('active'));
        if (current) current.classList.add('active');
    }

    window.addEventListener('scroll', updateActiveLink, { passive: true });
    window.addEventListener('resize', updateActiveLink, { passive: true });
    updateActiveLink();

    // ─── Copy to Clipboard ──────────────────────
    document.querySelectorAll('.copy-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const text = this.getAttribute('data-copy');
            if (!text) return;

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(() => {
                    showCopied(this);
                }).catch(() => {
                    fallbackCopy(text, this);
                });
            } else {
                fallbackCopy(text, this);
            }
        });
    });

    function fallbackCopy(text, btn) {
        const ta = document.createElement('textarea');
        ta.value = text;
        ta.style.position = 'fixed';
        ta.style.opacity = '0';
        document.body.appendChild(ta);
        ta.select();
        try {
            document.execCommand('copy');
            showCopied(btn);
        } catch (e) {}
        document.body.removeChild(ta);
    }

    function showCopied(btn) {
        const original = btn.innerHTML;
        btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Copiado';
        btn.classList.add('copied');
        setTimeout(() => {
            btn.innerHTML = original;
            btn.classList.remove('copied');
        }, 2000);
    }

    // ─── Close sidebar on link click (mobile) ────
    links.forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 1024) {
                closeSidebar();
            }
        });
    });
})();
</script>
</body>
</html>
