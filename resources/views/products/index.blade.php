<x-app-layout>
    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Hero Header --}}
            <div class="mb-8 animate-fade-in-up">
                <p class="section-label mb-2">Discover</p>
                <h1 class="text-4xl sm:text-5xl font-extrabold gradient-text mb-3">Our Products</h1>
                <p class="text-gray-400 text-lg max-w-xl">
                    Hand-picked items, curated just for you. Find exactly what you're looking for.
                </p>
            </div>

            {{-- ─── Search & Filter Bar ───────────────────────────────────────────── --}}
            <form id="search-form" method="GET" action="{{ route('products.index') }}">
                <div class="glass mb-8 p-5 space-y-5" style="border-radius:1rem;">

                    {{-- Row 1: Search + Sort --}}
                    <div class="flex flex-col sm:flex-row gap-3">
                        {{-- Text search --}}
                        <div class="relative flex-1">
                            <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                                </svg>
                            </span>
                            {{-- Spinner --}}
                            <span id="search-spinner"
                                  class="absolute inset-y-0 right-3 hidden items-center"
                                  style="display:none;">
                                <svg class="w-4 h-4 text-violet-400 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                    <path class="opacity-75" fill="currentColor"
                                          d="M4 12a8 8 0 018-8v8H4z"/>
                                </svg>
                            </span>
                            <input type="text"
                                   name="q"
                                   id="q"
                                   value="{{ request('q') }}"
                                   placeholder="Search products…"
                                   autocomplete="off"
                                   class="w-full pl-10 pr-10 py-2.5 rounded-lg text-sm text-gray-100 placeholder-gray-500
                                          bg-white/5 border border-white/10 focus:outline-none focus:border-violet-500
                                          focus:ring-1 focus:ring-violet-500 transition">
                        </div>

                        {{-- Sort --}}
                        <div class="sm:w-52">
                            <select name="sort" id="sort"
                                    class="w-full px-3 py-2.5 rounded-lg text-sm text-gray-100 bg-white/5
                                           border border-white/10 focus:outline-none focus:border-violet-500
                                           focus:ring-1 focus:ring-violet-500 transition appearance-none cursor-pointer">
                                <option value="newest"    {{ request('sort','newest')=='newest'    ? 'selected' : '' }}>🕐 Newest first</option>
                                <option value="price_asc" {{ request('sort')=='price_asc'          ? 'selected' : '' }}>💰 Price: Low → High</option>
                                <option value="price_desc"{{ request('sort')=='price_desc'         ? 'selected' : '' }}>💎 Price: High → Low</option>
                                <option value="name_asc"  {{ request('sort')=='name_asc'           ? 'selected' : '' }}>🔤 Name: A → Z</option>
                            </select>
                        </div>
                    </div>

                    {{-- Row 2: Price Range --}}
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Price</span>
                        <div class="flex items-center gap-2">
                            <input type="number" name="price_min" id="price_min"
                                   value="{{ request('price_min') }}" placeholder="Min $"
                                   min="0" step="1"
                                   class="w-28 px-3 py-2 rounded-lg text-sm text-gray-100 bg-white/5 border border-white/10
                                          focus:outline-none focus:border-violet-500 focus:ring-1 focus:ring-violet-500 transition">
                            <span class="text-gray-500">—</span>
                            <input type="number" name="price_max" id="price_max"
                                   value="{{ request('price_max') }}" placeholder="Max $"
                                   min="0" step="1"
                                   class="w-28 px-3 py-2 rounded-lg text-sm text-gray-100 bg-white/5 border border-white/10
                                          focus:outline-none focus:border-violet-500 focus:ring-1 focus:ring-violet-500 transition">
                        </div>
                    </div>

                    {{-- Row 3: Categories --}}
                    @if($categories->isNotEmpty())
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-widest mr-1">Category</span>
                            <button type="button" data-filter="category" data-value=""
                                    class="filter-pill {{ !request('category') ? 'filter-pill--active' : '' }}">All</button>
                            @foreach($categories as $cat)
                                <button type="button" data-filter="category" data-value="{{ $cat->slug }}"
                                        class="filter-pill {{ request('category') === $cat->slug ? 'filter-pill--active' : '' }}">
                                    {{ $cat->name }}
                                </button>
                            @endforeach
                        </div>
                    @endif

                    {{-- Row 4: Tags --}}
                    @if($tags->isNotEmpty())
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-widest mr-1">Tag</span>
                            <button type="button" data-filter="tag" data-value=""
                                    class="filter-pill {{ !request('tag') ? 'filter-pill--active' : '' }}">All</button>
                            @foreach($tags as $tag)
                                <button type="button" data-filter="tag" data-value="{{ $tag->slug }}"
                                        class="filter-pill {{ request('tag') === $tag->slug ? 'filter-pill--active' : '' }}">
                                    {{ $tag->name }}
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Hidden inputs for pill selections --}}
                <input type="hidden" name="category" id="category-input" value="{{ request('category') }}">
                <input type="hidden" name="tag"      id="tag-input"      value="{{ request('tag') }}">
            </form>
            {{-- ─────────────────────────────────────────────────────────────────────── --}}

            {{-- Results area (swapped by live search) --}}
            <div id="results-area">
                @include('products._results')
            </div>

        </div>
    </div>

    {{-- ─── Styles ─────────────────────────────────────────────────────────────── --}}
    <style>
        .filter-pill {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            border: 1px solid rgba(255,255,255,0.12);
            color: #9ca3af;
            background: rgba(255,255,255,0.04);
            transition: all 0.2s;
            cursor: pointer;
        }
        .filter-pill:hover {
            border-color: rgba(139,92,246,0.5);
            color: #c4b5fd;
            background: rgba(139,92,246,0.1);
        }
        .filter-pill--active {
            border-color: rgba(139,92,246,0.6);
            color: #ddd6fe;
            background: rgba(139,92,246,0.2);
        }
        #results-area {
            transition: opacity 0.2s ease;
        }
        #results-area.loading {
            opacity: 0.4;
            pointer-events: none;
        }
    </style>

    {{-- ─── Live Search Engine ──────────────────────────────────────────────────── --}}
    <script>
    (function () {
        const LIVE_URL  = '{{ route('products.live-search') }}';
        const INDEX_URL = '{{ route('products.index') }}';
        const form      = document.getElementById('search-form');
        const area      = document.getElementById('results-area');
        const spinner   = document.getElementById('search-spinner');
        let   debounce  = null;
        let   controller= null;          // AbortController for in-flight requests

        // ── Collect all current filter values into a plain object ──────────────
        function getFilters() {
            return {
                q         : document.getElementById('q').value.trim(),
                sort      : document.getElementById('sort').value,
                price_min : document.getElementById('price_min').value,
                price_max : document.getElementById('price_max').value,
                category  : document.getElementById('category-input').value,
                tag       : document.getElementById('tag-input').value,
            };
        }

        // ── Build a URLSearchParams string, skipping empty values ──────────────
        function toQS(filters) {
            const p = new URLSearchParams();
            Object.entries(filters).forEach(([k, v]) => { if (v) p.set(k, v); });
            return p.toString();
        }

        // ── Fire the AJAX request ──────────────────────────────────────────────
        function doSearch() {
            const filters = getFilters();
            const qs      = toQS(filters);

            // Update the browser URL without reloading
            const newURL = qs ? INDEX_URL + '?' + qs : INDEX_URL;
            history.pushState({ qs }, '', newURL);

            // Cancel any previous in-flight request
            if (controller) controller.abort();
            controller = new AbortController();

            // Show loading state
            area.classList.add('loading');
            spinner.style.display = 'flex';

            fetch(LIVE_URL + (qs ? '?' + qs : ''), {
                headers  : { 'X-Requested-With': 'XMLHttpRequest' },
                signal   : controller.signal,
            })
            .then(r => {
                if (!r.ok) throw new Error('Network error');
                return r.text();
            })
            .then(html => {
                area.innerHTML = html;
                area.classList.remove('loading');
                spinner.style.display = 'none';
                // Re-attach pagination click handlers (pagination links are new DOM)
                attachPaginationHandlers();
            })
            .catch(err => {
                if (err.name !== 'AbortError') {
                    area.classList.remove('loading');
                    spinner.style.display = 'none';
                }
            });
        }

        // ── Debounce wrapper (300ms for typing, 0ms for pill/sort clicks) ──────
        function scheduleSearch(delay = 300) {
            clearTimeout(debounce);
            debounce = setTimeout(doSearch, delay);
        }

        // ── Pill filter buttons ────────────────────────────────────────────────
        function attachPillHandlers() {
            document.querySelectorAll('[data-filter]').forEach(btn => {
                btn.addEventListener('click', () => {
                    const filterName = btn.dataset.filter;
                    const value      = btn.dataset.value;

                    // Update hidden input
                    document.getElementById(filterName + '-input').value = value;

                    // Update active pill styling
                    document.querySelectorAll(`[data-filter="${filterName}"]`).forEach(b => {
                        b.classList.toggle('filter-pill--active', b === btn);
                    });

                    scheduleSearch(0);
                });
            });
        }

        // ── Intercept pagination link clicks inside the results area ──────────
        function attachPaginationHandlers() {
            area.querySelectorAll('a[href]').forEach(link => {
                // Only intercept Laravel pagination links (contain ?page=)
                if (!link.href.includes('page=')) return;
                link.addEventListener('click', e => {
                    e.preventDefault();
                    const url    = new URL(link.href);
                    const params = Object.fromEntries(url.searchParams.entries());
                    // Merge page into current filters
                    const filters = { ...getFilters(), page: params.page };
                    const qs = toQS(filters);
                    history.pushState({ qs }, '', INDEX_URL + '?' + qs);
                    area.classList.add('loading');
                    spinner.style.display = 'flex';
                    if (controller) controller.abort();
                    controller = new AbortController();
                    fetch(LIVE_URL + '?' + qs, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' },
                        signal : controller.signal,
                    })
                    .then(r => r.text())
                    .then(html => {
                        area.innerHTML = html;
                        area.classList.remove('loading');
                        spinner.style.display = 'none';
                        attachPaginationHandlers();
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    })
                    .catch(() => {
                        area.classList.remove('loading');
                        spinner.style.display = 'none';
                    });
                });
            });
        }

        // ── Text input (debounced) ─────────────────────────────────────────────
        document.getElementById('q').addEventListener('input', () => scheduleSearch(300));

        // ── Sort dropdown (instant) ────────────────────────────────────────────
        document.getElementById('sort').addEventListener('change', () => scheduleSearch(0));

        // ── Price inputs (debounced) ───────────────────────────────────────────
        ['price_min', 'price_max'].forEach(id => {
            document.getElementById(id).addEventListener('input', () => scheduleSearch(400));
        });

        // ── Prevent default form submission (everything is now AJAX) ──────────
        form.addEventListener('submit', e => {
            e.preventDefault();
            scheduleSearch(0);
        });

        // ── Boot ──────────────────────────────────────────────────────────────
        attachPillHandlers();
        attachPaginationHandlers();
    })();
    </script>
</x-app-layout>
