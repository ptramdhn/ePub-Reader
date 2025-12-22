<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Membaca: {{ $book->title }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;1,400&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jszip@3.10.1/dist/jszip.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/epubjs@0.3.93/dist/epub.min.js"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: { extend: { colors: { uin: { blue: '#0F265C', yellow: '#FFC700' } } } }
        }

        // Set initial theme
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        body { background-color: #f3f4f6; transition: background-color 0.3s; }
        .dark body { background-color: #111827; }

        #viewer {
            background-color: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            min-height: 80vh;
            padding: 40px;
            transition: background-color 0.3s;
            border-radius: 8px;
        }
        .dark #viewer {
            background-color: #1f2937;
            box-shadow: none;
            border: 1px solid #374151;
        }

        /* Highlight Menu */
        #highlight-menu {
            display: none;
            position: fixed;
            z-index: 1000;
            background: white;
            padding: 10px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            border: 1px solid #e5e7eb;
        }
        .dark #highlight-menu {
            background: #374151;
            border-color: #4b5563;
        }

        /* Search Highlight */
        mark.search-result {
            background-color: #f97316 !important;
            color: #ffffff !important;
            padding: 2px 6px;
            border-radius: 4px;
            box-shadow: 0 0 6px #f97316;
        }
        .dark mark.search-result {
            background-color: #ea580c !important;
            box-shadow: 0 0 6px #ea580c;
        }

        /* Custom Scrollbar */
        .dark ::-webkit-scrollbar-track { background: #1f2937; }
        .dark ::-webkit-scrollbar-thumb { background: #4b5563; }
        .dark ::-webkit-scrollbar-thumb:hover { background: #6b7280; }
    </style>
</head>
<body class="flex flex-col h-screen font-sans overflow-hidden bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100 transition-colors duration-300">

    <!-- Header -->
    <header class="h-16 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between px-4 shadow-sm">
        <div class="flex items-center gap-4 w-1/3">
            <a href="{{ route('dashboard') }}" class="text-gray-500 dark:text-gray-400 hover:text-blue-800 dark:hover:text-white flex items-center gap-1 text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>

        <div class="flex-1 text-center hidden sm:block">
            <h1 class="font-bold truncate max-w-md mx-auto">{{ $book->title }}</h1>
        </div>

        <div class="flex items-center justify-end gap-4 w-1/3">
            <button onclick="toggleSearch()" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700" title="Cari">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </button>

            <button id="btn-bookmark" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700" title="Bookmark">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                </svg>
            </button>

            <button onclick="toggleTheme()" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700">
                <svg class="hidden dark:block w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <svg class="block dark:hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
            </button>

            <button onclick="toggleToc()" class="flex items-center gap-2 px-3 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-md text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <span class="hidden sm:inline">Daftar Isi</span>
            </button>
        </div>
    </header>

    <div class="flex-1 overflow-y-auto relative" id="main-scroll">
        <!-- TOC Sidebar -->
        <div id="toc-sidebar" class="fixed inset-y-0 right-0 top-16 w-80 bg-white dark:bg-gray-800 shadow-2xl transform translate-x-full transition-transform z-40 border-l border-gray-200 dark:border-gray-700 flex flex-col">
            <div class="p-4 border-b bg-gray-50 dark:bg-gray-900 flex justify-between items-center">
                <span class="font-bold">Daftar Bab</span>
                <button onclick="toggleToc()" class="text-gray-400 hover:text-red-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div id="toc-list" class="flex-1 overflow-y-auto p-4"></div>
        </div>

        <!-- Search Sidebar -->
        <div id="search-sidebar" class="fixed inset-y-0 right-0 top-16 w-80 bg-white dark:bg-gray-800 shadow-2xl transform translate-x-full transition-transform z-40 border-l border-gray-200 dark:border-gray-700 flex flex-col">
            <div class="p-4 border-b bg-gray-50 dark:bg-gray-900">
                <div class="flex justify-between items-center mb-3">
                    <span class="font-bold">Pencarian</span>
                    <button onclick="toggleSearch()" class="text-gray-400 hover:text-red-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="relative">
                    <input type="text" id="search-input" placeholder="Cari kata..." class="w-full px-4 py-2 border rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                    <div id="search-loading" class="absolute right-3 top-2.5 hidden">
                        <svg class="animate-spin h-4 w-4 text-blue-500" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/></svg>
                    </div>
                </div>
            </div>
            <div id="search-results" class="flex-1 overflow-y-auto p-4">
                <p class="text-center text-gray-400 text-sm mt-10">Ketik untuk mencari...</p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 flex flex-col min-h-full relative">
            <div id="loader" class="flex flex-col items-center justify-center py-20">
                <div class="w-10 h-10 border-4 border-blue-200 dark:border-gray-600 border-t-blue-900 dark:border-t-yellow-400 rounded-full animate-spin"></div>
                <p class="mt-4 text-gray-500 dark:text-gray-400">Memuat Bab...</p>
            </div>

            <div id="viewer" class="relative"></div>

            <!-- Navigation Buttons -->
            <div class="flex justify-between mt-8 pb-10" id="controls">
                <button onclick="prevChapter()" class="flex items-center gap-2 px-6 py-3 bg-white dark:bg-gray-800 border rounded-full shadow hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Bab Sebelumnya
                </button>
                <button onclick="nextChapter()" class="flex items-center gap-2 px-6 py-3 bg-blue-900 dark:bg-yellow-500 text-white dark:text-gray-900 rounded-full shadow hover:bg-blue-800 dark:hover:bg-yellow-400">
                    Bab Selanjutnya
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>

            <!-- Highlight Color Menu -->
            <div id="highlight-menu" class="flex gap-3">
                <button onclick="applyHighlight('yellow')" class="w-10 h-10 rounded-full bg-yellow-300 hover:ring-4 ring-yellow-400 transition"></button>
                <button onclick="applyHighlight('green')" class="w-10 h-10 rounded-full bg-green-300 hover:ring-4 ring-green-400 transition"></button>
                <button onclick="applyHighlight('blue')" class="w-10 h-10 rounded-full bg-blue-300 hover:ring-4 ring-blue-400 transition"></button>
                <button onclick="applyHighlight('red')" class="w-10 h-10 rounded-full bg-red-300 hover:ring-4 ring-red-400 transition"></button>
            </div>
        </div>
    </div>

    <script>
        // ==================== KONFIGURASI DASAR ====================
        const bookUrl = "{{ asset('storage/' . $book->file_path) }}";
        const book = ePub(bookUrl);
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        let myBookmarks = @json($bookmarks ?? []);
        let myHighlights = @json($highlights ?? []);
        let currentSelection = null;
        let globalToc = [];
        let currentSearchQuery = ""; // Untuk highlight semua kemunculan di chapter

        const rendition = book.renderTo("viewer", {
            width: "100%",
            height: "100%",
            flow: "scrolled",
            manager: "default",
            allowScriptedContent: false
        });

        // ==================== TEMA ====================
        rendition.themes.register("light", {
            body: { color: "#000000", background: "#ffffff" },
            "::selection": { background: "#fef08a" },
            ".highlight-yellow": { "background-color": "#fde047 !important" },
            ".highlight-green":  { "background-color": "#86efac !important" },
            ".highlight-blue":   { "background-color": "#93c5fd !important" },
            ".highlight-red":    { "background-color": "#fca5a5 !important" }
        });

        rendition.themes.register("dark", {
            body: { color: "#e5e7eb", background: "#1f2937" },
            "a": { color: "#60a5fa" },
            "p, span, h1, h2, h3, h4, h5, h6, li, div": { color: "inherit !important" },
            "::selection": { background: "#374151" },
            ".highlight-yellow": { "background-color": "#854d0e !important", "color": "#fff" },
            ".highlight-green":  { "background-color": "#14532d !important", "color": "#fff" },
            ".highlight-blue":   { "background-color": "#1e3a8a !important", "color": "#fff" },
            ".highlight-red":    { "background-color": "#7f1d1d !important", "color": "#fff" }
        });

        function applyTheme() {
            const isDark = document.documentElement.classList.contains('dark');
            rendition.themes.select(isDark ? "dark" : "light");
        }
        applyTheme();

        // ==================== BOOK READY & HIGHLIGHTS LAMA ====================
        book.ready.then(() => book.locations.generate(1000))
                  .then(() => {
                      myHighlights.forEach(hl => {
                          rendition.annotations.add("highlight", hl.cfi_range, {}, null, "highlight-" + hl.color);
                      });
                  });

        // ==================== BOOKMARK ====================
        function updateBookmarkButton(location) {
            const btn = document.getElementById("btn-bookmark");
            const svg = btn.querySelector("svg");
            const cfi = location.start.cfi;
            const isBookmarked = myBookmarks.some(bm => cfi.includes(bm.cfi) || bm.cfi.includes(cfi));

            if (isBookmarked) {
                btn.classList.add("text-yellow-500");
                btn.classList.remove("text-gray-400");
                svg.setAttribute("fill", "currentColor");
            } else {
                btn.classList.remove("text-yellow-500");
                btn.classList.add("text-gray-400");
                svg.setAttribute("fill", "none");
            }
        }

        // Variabel untuk mencegah spam request ke server (Debounce)
        let saveTimeout; 

        rendition.on("relocated", location => {
            // 1. Update tombol bookmark (Kode lama Anda)
            updateBookmarkButton(location);

            // 2. Simpan History & Lokasi Terakhir (Kode BARU)
            // Kita beri jeda 1 detik setelah user berhenti scrolling/pindah bab
            clearTimeout(saveTimeout);
            saveTimeout = setTimeout(() => {
                saveHistory(location.start.cfi);
            }, 1000);
        });

        function saveHistory(cfi) {
            fetch("/books/{{ $book->id }}/history", {
                method: "POST",
                headers: { 
                    "Content-Type": "application/json", 
                    "X-CSRF-TOKEN": csrfToken 
                },
                body: JSON.stringify({ 
                    last_location: cfi,
                    percentage: book.locations.percentageFromCfi(cfi) // Opsional: Simpan persentase baca
                })
            }).then(response => {
                if (!response.ok) console.error("Gagal menyimpan history");
            }).catch(err => console.error("Error history:", err));
        }

        document.getElementById("btn-bookmark").addEventListener("click", () => {
            const location = rendition.currentLocation();
            if (!location) return;
            const cfi = location.start.cfi;

            const exists = myBookmarks.findIndex(bm => cfi.includes(bm.cfi) || bm.cfi.includes(cfi));
            if (exists !== -1) {
                // Hapus bookmark
                myBookmarks.splice(exists, 1);
                updateBookmarkButton(location);
            } else {
                // Tambah bookmark
                myBookmarks.push({ cfi });
                fetch("{{ route('books.bookmark', $book->id) }}", {
                    method: "POST",
                    headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": csrfToken },
                    body: JSON.stringify({ cfi, label: "Bookmark Halaman" })
                });
                updateBookmarkButton(location);
            }
            renderTOC();
        });

        // ==================== HIGHLIGHT TEKS ====================
        rendition.on("selected", (cfiRange, contents) => {
            const text = contents.window.getSelection().toString().trim();
            if (!text) {
                hideHighlightMenu();
                return;
            }

            currentSelection = { cfiRange, text, contents };
            showHighlightMenu(contents);
        });

        function showHighlightMenu(contents) {
            const menu = document.getElementById("highlight-menu");
            const selection = contents.window.getSelection();
            if (selection.rangeCount === 0) return;

            const range = selection.getRangeAt(0);
            const rect = range.getBoundingClientRect();

            menu.style.position = "fixed";
            menu.style.top = `${rect.top - 60}px`;
            menu.style.left = `${rect.left + rect.width / 2}px`;
            menu.style.transform = "translateX(-50%)";
            menu.style.display = "flex";
        }

        function hideHighlightMenu() {
            document.getElementById("highlight-menu").style.display = "none";
            currentSelection = null;
        }

        // Tutup menu saat klik di luar
        document.addEventListener("click", e => {
            const menu = document.getElementById("highlight-menu");
            if (!menu.contains(e.target) && !e.target.closest("#viewer")) {
                hideHighlightMenu();
            }
        });

        document.getElementById("highlight-menu").addEventListener("click", e => e.stopPropagation());

        window.applyHighlight = function(color) {
            if (!currentSelection) return;

            const { cfiRange, text, contents } = currentSelection;

            rendition.annotations.add("highlight", cfiRange, {}, null, "highlight-" + color);

            fetch("{{ route('books.highlight', $book->id) }}", {
                method: "POST",
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": csrfToken },
                body: JSON.stringify({ cfi_range: cfiRange, text, color, note: "" })
            }).catch(console.error);

            if (contents?.window.getSelection) {
                contents.window.getSelection().removeAllRanges();
            }
            hideHighlightMenu();
        };

        // ==================== PENCARIAN - HIGHLIGHT MANUAL (STABIL & SOLID) ====================
        let searchTimeout = null;

        document.getElementById("search-input").addEventListener("keyup", e => {
            clearTimeout(searchTimeout);
            const query = e.target.value.trim();

            if (query.length < 3) {
                document.getElementById("search-results").innerHTML = '<p class="text-center text-gray-400 text-sm mt-10">Ketik minimal 3 huruf...</p>';
                currentSearchQuery = "";
                clearSearchHighlights();
                return;
            }

            document.getElementById("search-loading").classList.remove("hidden");
            searchTimeout = setTimeout(() => performSearch(query), 800);
        });

        function performSearch(query) {
            currentSearchQuery = query.toLowerCase(); // Simpan untuk highlight di chapter
            document.getElementById("search-results").innerHTML = "";

            Promise.all(
                book.spine.spineItems.map(item =>
                    item.load(book.load.bind(book))
                        .then(() => item.find(query))
                        .finally(() => item.unload())
                )
            ).then(allResults => {
                document.getElementById("search-loading").classList.add("hidden");
                const results = [].concat(...allResults);

                if (results.length === 0) {
                    document.getElementById("search-results").innerHTML = '<p class="text-center text-gray-400 text-sm mt-10">Tidak ditemukan.</p>';
                    return;
                }

                results.forEach(result => {
                    const btn = document.createElement("button");
                    btn.className = "w-full text-left p-4 hover:bg-gray-100 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-700 transition";

                    const highlightedExcerpt = result.excerpt.replace(
                        new RegExp(`(${query})`, "gi"),
                        '<mark class="bg-orange-500 text-white px-1 rounded">$1</mark>'
                    );

                    btn.innerHTML = `
                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">Hasil ditemukan</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">...${highlightedExcerpt}...</p>
                    `;

                    btn.onclick = () => {
                        clearSearchHighlights();

                        rendition.display(result.cfi).then(() => {
                            setTimeout(() => {
                                highlightAllInCurrentChapter(query);
                                scrollToFirstSearchResult();
                            }, 800); // Delay cukup untuk iframe ready
                        });

                        if (window.innerWidth < 768) toggleSearch();
                    };

                    document.getElementById("search-results").appendChild(btn);
                });
            });
        }

        // Highlight semua kemunculan kata di chapter saat ini (manual wrap <mark>)
        function highlightAllInCurrentChapter(query) {
            const contents = rendition.getContents()[0];
            if (!contents) return;

            const doc = contents.document;
            const regex = new RegExp(`(${query})`, "gi");

            const textNodes = [];
            const walker = doc.createTreeWalker(doc.body, NodeFilter.SHOW_TEXT, null, false);
            let node;
            while (node = walker.nextNode()) {
                textNodes.push(node);
            }

            textNodes.forEach(node => {
                const text = node.nodeValue;
                if (regex.test(text)) {
                    const fragment = doc.createDocumentFragment();
                    const parts = text.split(regex);

                    parts.forEach(part => {
                        if (regex.test(part)) {
                            const mark = doc.createElement("mark");
                            mark.className = "search-result";
                            mark.textContent = part;
                            fragment.appendChild(mark);
                        } else if (part) {
                            fragment.appendChild(doc.createTextNode(part));
                        }
                    });

                    node.parentNode.replaceChild(fragment, node);
                }
            });
        }

        // Scroll ke hasil pertama
        function scrollToFirstSearchResult() {
            const contents = rendition.getContents()[0];
            if (!contents) return;
            const first = contents.document.querySelector("mark.search-result");
            if (first) first.scrollIntoView({ behavior: "smooth", block: "center" });
        }

        // Bersihkan semua highlight search
        function clearSearchHighlights() {
            const contents = rendition.getContents();
            contents.forEach(content => {
                const marks = content.document.querySelectorAll("mark.search-result");
                marks.forEach(mark => {
                    mark.outerHTML = mark.innerHTML; // Unwrap
                });
            });
        }

        // Saat pindah chapter, bersihkan & re-highlight jika ada query aktif
        rendition.on("relocated", () => {
            clearSearchHighlights();
            if (currentSearchQuery) {
                highlightAllInCurrentChapter(currentSearchQuery);
                scrollToFirstSearchResult();
            }
        });

        // ==================== TOC & NAVIGASI ====================
        book.loaded.navigation.then(nav => {
            globalToc = Array.isArray(nav) ? nav : (nav.toc || []);
            renderTOC();

            // Cek apakah ada lokasi terakhir yang disimpan di database
            // Pastikan Controller 'show' atau 'read' Anda mengirim variabel $lastLocation
            const savedLocation = "{{ $lastLocation ?? '' }}"; 

            if (savedLocation) {
                rendition.display(savedLocation).then(hideLoader);
            } else {
                // Jika tidak ada history, buka bab pertama
                const firstChapter = globalToc[0]?.href || null;
                rendition.display(firstChapter).then(hideLoader);
            }
        });

        function renderTOC() {
            const container = document.getElementById("toc-list");
            container.innerHTML = "";

            if (globalToc.length === 0) {
                container.innerHTML = '<p class="text-center text-gray-400">Daftar isi tidak tersedia.</p>';
                return;
            }

            globalToc.forEach(ch => {
                if (!ch?.href) return;
                const btn = document.createElement("button");
                btn.className = "w-full text-left px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 rounded";
                btn.textContent = ch.label?.trim() || "Bab";
                btn.onclick = () => {
                    loadChapter(ch.href);
                    toggleToc();
                };
                container.appendChild(btn);
            });

            if (myBookmarks.length > 0) {
                const divider = document.createElement("div");
                divider.className = "my-4 text-xs font-bold text-gray-500 uppercase";
                divider.textContent = "Bookmark";
                container.appendChild(divider);

                myBookmarks.forEach(bm => {
                    const btn = document.createElement("button");
                    btn.className = "w-full text-left px-4 py-3 text-yellow-600 dark:text-yellow-400 hover:bg-yellow-50 dark:hover:bg-gray-700 flex items-center gap-2";
                    btn.innerHTML = `<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg> Bookmark`;
                    btn.onclick = () => {
                        rendition.display(bm.cfi);
                        toggleToc();
                    };
                    container.appendChild(btn);
                });
            }
        }

        function loadChapter(href) {
            document.getElementById("loader").style.display = "flex";
            rendition.display(href).then(() => {
                hideLoader();
                document.getElementById("main-scroll").scrollTop = 0;
            });
        }

        function hideLoader() {
            document.getElementById("loader").style.display = "none";
        }

        function prevChapter() { document.getElementById("loader").style.display = "flex"; rendition.prev().then(hideLoader); }
        function nextChapter() { document.getElementById("loader").style.display = "flex"; rendition.next().then(hideLoader); }

        function toggleToc() {
            document.getElementById("search-sidebar").classList.add("translate-x-full");
            document.getElementById("toc-sidebar").classList.toggle("translate-x-full");
        }

        function toggleSearch() {
            document.getElementById("toc-sidebar").classList.add("translate-x-full");
            document.getElementById("search-sidebar").classList.toggle("translate-x-full");
            setTimeout(() => document.getElementById("search-input").focus(), 300);
        }

        function toggleTheme() {
            document.documentElement.classList.toggle("dark");
            localStorage.setItem("color-theme", document.documentElement.classList.contains("dark") ? "dark" : "light");
            applyTheme();
        }
    </script>
</body>
</html>