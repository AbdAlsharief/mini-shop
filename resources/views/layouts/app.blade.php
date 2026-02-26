<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'MiniShop') }} — Premium Store</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* ── AI Sidebar Layout ─────────────────────────────────────── */
            :root { --sidebar-w: 320px; }

            #ai-sidebar {
                position: fixed;
                top: 0; right: 0; bottom: 0;
                width: var(--sidebar-w);
                z-index: 8000;
                display: flex;
                flex-direction: column;
                background: rgba(14,11,26,0.97);
                border-left: 1px solid rgba(139,92,246,0.2);
                box-shadow: -8px 0 40px rgba(0,0,0,0.4);
                transform: translateX(100%);
                transition: transform 0.3s cubic-bezier(0.4,0,0.2,1);
            }
            #ai-sidebar.open { transform: translateX(0); }

            /* toggle button */
            #ai-sidebar-toggle {
                position: fixed;
                top: 50%;
                right: 0;
                transform: translateY(-50%);
                z-index: 8100;
                background: linear-gradient(180deg, #8b5cf6, #6366f1);
                border: none;
                border-radius: 10px 0 0 10px;
                padding: 0.85rem 0.55rem;
                cursor: pointer;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 0.3rem;
                box-shadow: -4px 0 20px rgba(139,92,246,0.45);
                transition: padding-right 0.2s, box-shadow 0.2s;
                writing-mode: vertical-rl;
            }
            #ai-sidebar-toggle:hover {
                box-shadow: -6px 0 28px rgba(139,92,246,0.65);
            }
            #ai-sidebar.open + #ai-sidebar-toggle {
                transform: translateY(-50%) translateX(calc(-1 * var(--sidebar-w)));
            }

            /* sidebar header */
            .ai-sidebar-header {
                padding: 1.1rem 1.2rem 0.9rem;
                border-bottom: 1px solid rgba(139,92,246,0.15);
                display: flex;
                align-items: center;
                gap: 0.75rem;
                flex-shrink: 0;
            }

            /* chat history scroll area */
            #ai-chat-history {
                flex: 1;
                overflow-y: auto;
                padding: 1rem;
                display: flex;
                flex-direction: column;
                gap: 1rem;
                scrollbar-width: thin;
                scrollbar-color: rgba(139,92,246,0.3) transparent;
            }

            /* chat messages */
            .ai-bubble-user {
                align-self: flex-end;
                max-width: 90%;
                background: linear-gradient(135deg, rgba(139,92,246,0.25), rgba(99,102,241,0.2));
                border: 1px solid rgba(139,92,246,0.3);
                border-radius: 1rem 1rem 0.25rem 1rem;
                padding: 0.65rem 0.9rem;
                color: #e5e7eb;
                font-size: 0.8rem;
                line-height: 1.5;
            }
            .ai-bubble-ai {
                align-self: flex-start;
                max-width: 100%;
                display: flex;
                flex-direction: column;
                gap: 0.6rem;
            }
            .ai-bubble-ai-text {
                background: rgba(255,255,255,0.04);
                border: 1px solid rgba(255,255,255,0.08);
                border-radius: 0.25rem 1rem 1rem 1rem;
                padding: 0.65rem 0.9rem;
                color: #c4b5fd;
                font-size: 0.8rem;
                line-height: 1.6;
                white-space: pre-wrap;
            }

            /* product mini-cards */
            .ai-product-card {
                background: rgba(139,92,246,0.06);
                border: 1px solid rgba(139,92,246,0.18);
                border-radius: 0.75rem;
                padding: 0.75rem;
                display: flex;
                flex-direction: column;
                gap: 0.35rem;
                transition: border-color 0.2s, background 0.2s;
            }
            .ai-product-card:hover {
                border-color: rgba(139,92,246,0.4);
                background: rgba(139,92,246,0.1);
            }
            .ai-product-name {
                color: #e5e7eb;
                font-size: 0.82rem;
                font-weight: 600;
                line-height: 1.3;
            }
            .ai-product-desc {
                color: #6b7280;
                font-size: 0.72rem;
                line-height: 1.4;
            }
            .ai-product-footer {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-top: 0.25rem;
            }
            .ai-product-price {
                font-size: 0.9rem;
                font-weight: 700;
                background: linear-gradient(90deg, #8b5cf6, #6366f1);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
            .ai-product-btn {
                font-size: 0.7rem;
                font-weight: 600;
                padding: 0.3rem 0.7rem;
                background: linear-gradient(135deg, #8b5cf6, #6366f1);
                color: #fff;
                border: none;
                border-radius: 9999px;
                cursor: pointer;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 0.3rem;
                transition: opacity 0.2s;
                white-space: nowrap;
            }
            .ai-product-btn:hover { opacity: 0.82; }

            /* input area */
            .ai-input-area {
                padding: 0.85rem 1rem;
                border-top: 1px solid rgba(139,92,246,0.15);
                flex-shrink: 0;
            }
            #ai-sidebar-story {
                width: 100%;
                background: rgba(255,255,255,0.05);
                border: 1px solid rgba(255,255,255,0.1);
                border-radius: 0.75rem;
                color: #e5e7eb;
                font-size: 0.8rem;
                padding: 0.65rem 0.85rem;
                outline: none;
                resize: none;
                font-family: inherit;
                line-height: 1.5;
                transition: border-color 0.2s;
            }
            #ai-sidebar-story:focus { border-color: rgba(139,92,246,0.6); }
            #ai-sidebar-story::placeholder { color: #4b5563; }
            .ai-send-btn {
                margin-top: 0.6rem;
                width: 100%;
                background: linear-gradient(135deg, #8b5cf6, #6366f1);
                color: #fff;
                border: none;
                border-radius: 0.75rem;
                padding: 0.6rem;
                font-size: 0.82rem;
                font-weight: 600;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                transition: opacity 0.2s;
            }
            .ai-send-btn:hover:not(:disabled) { opacity: 0.85; }
            .ai-send-btn:disabled { opacity: 0.5; cursor: not-allowed; }

            /* typing indicator */
            .ai-typing {
                display: flex;
                gap: 4px;
                padding: 0.65rem 0.9rem;
                background: rgba(255,255,255,0.04);
                border: 1px solid rgba(255,255,255,0.08);
                border-radius: 0.25rem 1rem 1rem 1rem;
                width: fit-content;
            }
            .ai-typing span {
                width: 6px; height: 6px;
                background: #8b5cf6;
                border-radius: 50%;
                animation: ai-bounce 1.2s ease-in-out infinite;
            }
            .ai-typing span:nth-child(2) { animation-delay: 0.2s; }
            .ai-typing span:nth-child(3) { animation-delay: 0.4s; }
            @keyframes ai-bounce {
                0%, 80%, 100% { transform: translateY(0); opacity: 0.4; }
                40%           { transform: translateY(-6px); opacity: 1; }
            }

            /* overlay for mobile */
            #ai-sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.5);
                z-index: 7900;
                backdrop-filter: blur(2px);
            }
            #ai-sidebar-overlay.show { display: block; }

            @media (max-width: 640px) {
                :root { --sidebar-w: 100vw; }
                #ai-sidebar-toggle { top: auto; bottom: 1.5rem; transform: none;
                    right: 1rem; border-radius: 50%; width: 3rem; height: 3rem;
                    writing-mode: horizontal-tb; padding: 0.6rem; }
                #ai-sidebar.open + #ai-sidebar-toggle {
                    display: none;
                }
            }
        </style>
    </head>
    <body class="font-sans antialiased" style="background-color:#0f0f14; color:#e5e7eb;">

        <!-- Background gradient orbs -->
        <div class="fixed inset-0 pointer-events-none overflow-hidden" style="z-index:0;">
            <div class="absolute -top-40 -left-40 w-96 h-96 rounded-full opacity-10 blur-3xl"
                 style="background:radial-gradient(circle, #8b5cf6 0%, transparent 70%);"></div>
            <div class="absolute top-1/2 -right-40 w-96 h-96 rounded-full opacity-8 blur-3xl"
                 style="background:radial-gradient(circle, #6366f1 0%, transparent 70%);"></div>
            <div class="absolute -bottom-20 left-1/3 w-80 h-80 rounded-full opacity-8 blur-3xl"
                 style="background:radial-gradient(circle, #a78bfa 0%, transparent 70%);"></div>
        </div>

        <!-- Mobile overlay -->
        <div id="ai-sidebar-overlay"></div>

        <!-- ── AI Sidebar ─────────────────────────────────────────────── -->
        <aside id="ai-sidebar" role="complementary" aria-label="AI Shopping Advisor">

            <!-- Header -->
            <div class="ai-sidebar-header">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                     style="background:linear-gradient(135deg,#8b5cf6,#6366f1);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2a4 4 0 0 1 4 4v1h1a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v1a4 4 0 0 1-8 0v-1H7a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h1V6a4 4 0 0 1 4-4z"/>
                        <circle cx="9" cy="10" r="0.8" fill="white" stroke="none"/>
                        <circle cx="15" cy="10" r="0.8" fill="white" stroke="none"/>
                        <path d="M9 14s1 1.5 3 1.5 3-1.5 3-1.5"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-gray-100 font-bold text-sm">AI Shopping Advisor</p>
                    <p class="text-gray-500 text-xs truncate">Powered by Llama 3 · Mini-Shop</p>
                </div>
                <button id="ai-sidebar-close" aria-label="Close sidebar"
                        style="background:none;border:none;cursor:pointer;color:#6b7280;padding:0.2rem;
                               display:flex;align-items:center;flex-shrink:0;"
                        onmouseover="this.style.color='#c4b5fd'" onmouseout="this.style.color='#6b7280'">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>

            <!-- Chat history -->
            <div id="ai-chat-history">
                <!-- Welcome message -->
                <div class="ai-bubble-ai">
                    <div class="ai-bubble-ai-text">
                        👋 Hi! Tell me what you're looking for and I'll find the perfect product from our store for you.
                    </div>
                </div>
            </div>

            <!-- Input area -->
            <div class="ai-input-area">
                <textarea id="ai-sidebar-story"
                          placeholder="e.g. looking for a birthday gift for my dad who loves cooking…"
                          rows="2"
                          maxlength="1000"></textarea>
                <button id="ai-sidebar-send" class="ai-send-btn">
                    <svg id="ai-send-icon" width="14" height="14" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="22" y1="2" x2="11" y2="13"/>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                    </svg>
                    <svg id="ai-send-spinner" class="animate-spin" width="14" height="14"
                         fill="none" viewBox="0 0 24 24" style="display:none;">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"/>
                        <path class="opacity-75" fill="white" d="M4 12a8 8 0 018-8v8H4z"/>
                    </svg>
                    <span id="ai-send-label">Ask AI</span>
                </button>
            </div>
        </aside>

        <!-- Sidebar toggle tab -->
        <button id="ai-sidebar-toggle" aria-label="Open AI advisor" title="AI Shopping Advisor">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2a4 4 0 0 1 4 4v1h1a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v1a4 4 0 0 1-8 0v-1H7a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h1V6a4 4 0 0 1 4-4z"/>
                <circle cx="9" cy="10" r="0.8" fill="white" stroke="none"/>
                <circle cx="15" cy="10" r="0.8" fill="white" stroke="none"/>
            </svg>
            <span style="color:#fff; font-size:0.65rem; font-weight:700; letter-spacing:0.05em;">AI</span>
        </button>

        <div class="relative min-h-screen" style="z-index:1;">
            @include('layouts.navigation')

            <!-- Flash Messages -->
            @if(session('success') || session('error') || session('info'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
                    @if(session('success'))
                        <div class="flex items-center gap-3 px-4 py-3 rounded-xl mb-2 animate-fade-in"
                             style="background:rgba(16,185,129,0.1); border:1px solid rgba(16,185,129,0.3);">
                            <span class="text-green-400">✓</span>
                            <span class="text-green-300 text-sm font-medium">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="flex items-center gap-3 px-4 py-3 rounded-xl mb-2 animate-fade-in"
                             style="background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.3);">
                            <span class="text-red-400">✕</span>
                            <span class="text-red-300 text-sm font-medium">{{ session('error') }}</span>
                        </div>
                    @endif
                    @if(session('info'))
                        <div class="flex items-center gap-3 px-4 py-3 rounded-xl mb-2 animate-fade-in"
                             style="background:rgba(99,102,241,0.1); border:1px solid rgba(99,102,241,0.3);">
                            <span class="text-indigo-400">ℹ</span>
                            <span class="text-indigo-300 text-sm font-medium">{{ session('info') }}</span>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="mt-20 py-8 text-center" style="border-top:1px solid rgba(139,92,246,0.12);">
                <p class="text-gray-600 text-sm">
                    © {{ date('Y') }} <span class="gradient-text font-semibold">MiniShop</span> — Crafted with ❤️
                </p>
            </footer>
        </div>

        <!-- ── AI Sidebar Script ───────────────────────────────────────── -->
        <script>
        (function () {
            const AI_URL  = '{{ route('ai.recommend') }}';
            const CSRF    = document.querySelector('meta[name="csrf-token"]').content;

            const sidebar  = document.getElementById('ai-sidebar');
            const overlay  = document.getElementById('ai-sidebar-overlay');
            const toggle   = document.getElementById('ai-sidebar-toggle');
            const closeBtn = document.getElementById('ai-sidebar-close');
            const history  = document.getElementById('ai-chat-history');
            const story    = document.getElementById('ai-sidebar-story');
            const sendBtn  = document.getElementById('ai-sidebar-send');
            const sendIcon = document.getElementById('ai-send-icon');
            const sendSpin = document.getElementById('ai-send-spinner');
            const sendLbl  = document.getElementById('ai-send-label');

            // Open / close
            const openSidebar  = () => { sidebar.classList.add('open'); overlay.classList.add('show'); story.focus(); };
            const closeSidebar = () => { sidebar.classList.remove('open'); overlay.classList.remove('show'); };
            toggle.addEventListener('click', () => sidebar.classList.contains('open') ? closeSidebar() : openSidebar());
            closeBtn.addEventListener('click', closeSidebar);
            overlay.addEventListener('click', closeSidebar);
            document.addEventListener('keydown', e => { if (e.key === 'Escape') closeSidebar(); });

            // Send on Enter (Shift+Enter = new line)
            story.addEventListener('keydown', e => {
                if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); send(); }
            });
            sendBtn.addEventListener('click', send);

            function appendBubble(html, cls = 'ai-bubble-ai') {
                const wrap = document.createElement('div');
                wrap.className = cls;
                wrap.innerHTML = html;
                history.appendChild(wrap);
                history.scrollTop = history.scrollHeight;
                return wrap;
            }

            function buildProductCards(products) {
                if (!products || !products.length) return '';
                return products.map(p => `
                    <div class="ai-product-card">
                        <div class="ai-product-name">${escHtml(p.name)}</div>
                        ${p.description ? `<div class="ai-product-desc">${escHtml(p.description)}</div>` : ''}
                        <div class="ai-product-footer">
                            <span class="ai-product-price">$${escHtml(p.price)}</span>
                            <a href="${escHtml(p.url)}" class="ai-product-btn">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                    <circle cx="16" cy="21" r="1"/><circle cx="9" cy="21" r="1"/>
                                </svg>
                                View
                            </a>
                        </div>
                    </div>`
                ).join('');
            }

            function escHtml(str) {
                const d = document.createElement('div');
                d.appendChild(document.createTextNode(String(str)));
                return d.innerHTML;
            }

            async function send() {
                const text = story.value.trim();
                if (!text) { story.focus(); return; }

                // Show user bubble
                appendBubble(`<div class="ai-bubble-user">${escHtml(text)}</div>`, 'ai-bubble-user-wrap');

                story.value = '';
                sendBtn.disabled = true;
                sendIcon.style.display = 'none';
                sendSpin.style.display = 'inline-block';
                sendLbl.textContent = 'Thinking…';

                // Show typing indicator
                const typingEl = appendBubble(`
                    <div class="ai-typing">
                        <span></span><span></span><span></span>
                    </div>`, 'ai-bubble-ai');

                try {
                    const res  = await fetch(AI_URL, {
                        method : 'POST',
                        headers: {
                            'Content-Type' : 'application/x-www-form-urlencoded',
                            'X-CSRF-TOKEN' : CSRF,
                            'Accept'       : 'application/json',
                        },
                        body: new URLSearchParams({ story: text }),
                    });
                    const data = await res.json();

                    // Remove typing indicator
                    typingEl.remove();

                    if (!res.ok) {
                        const msg = data.errors?.story?.[0] ?? data.message ?? 'Something went wrong.';
                        appendBubble(`<div class="ai-bubble-ai-text" style="color:#f87171;">⚠ ${escHtml(msg)}</div>`);
                    } else {
                        const cards = buildProductCards(data.products);
                        appendBubble(`
                            <div class="ai-bubble-ai-text">${escHtml(data.answer)}</div>
                            ${cards}
                        `);
                    }
                } catch (_) {
                    typingEl.remove();
                    appendBubble(`<div class="ai-bubble-ai-text" style="color:#f87171;">⚠ Network error. Please try again.</div>`);
                } finally {
                    sendBtn.disabled = false;
                    sendIcon.style.display = 'inline-block';
                    sendSpin.style.display = 'none';
                    sendLbl.textContent = 'Ask AI';
                }
            }
        })();
        </script>
    </body>
</html>
