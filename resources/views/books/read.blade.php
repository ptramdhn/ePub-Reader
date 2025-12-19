<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membaca: {{ $book->title }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;1,400&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jszip@3.10.1/dist/jszip.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/epubjs@0.3.93/dist/epub.min.js"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: { colors: { uin: { blue: '#0F265C', yellow: '#FFC700' } } }
            }
        }
        // Logic Tema Awal
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        body { background-color: #f3f4f6; transition: background-color 0.3s; }
        .dark body { background-color: #111827; } /* Dark Gray BG */
        
        #viewer {
            background-color: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            min-height: 80vh;
            padding: 40px;
            transition: background-color 0.3s;
        }
        /* Mode Gelap untuk Kertas */
        .dark #viewer {
            background-color: #1f2937; /* Gray-800 */
            box-shadow: none;
            border: 1px solid #374151;
        }

        html { scroll-behavior: smooth; }
        
        /* Custom Scrollbar Dark Support */
        .dark ::-webkit-scrollbar-track { background: #1f2937; }
        .dark ::-webkit-scrollbar-thumb { background: #4b5563; }
        .dark ::-webkit-scrollbar-thumb:hover { background: #6b7280; }
    </style>
</head>
<body class="flex flex-col h-screen font-sans overflow-hidden bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100 transition-colors duration-300">

    <header class="h-16 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between px-4 z-50 shadow-sm flex-shrink-0 transition-colors">
        <div class="flex items-center gap-4 overflow-hidden">
            <a href="{{ route('dashboard') }}" class="text-gray-500 dark:text-gray-400 hover:text-blue-800 dark:hover:text-white transition flex items-center gap-1 text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path></svg>
                Kembali
            </a>
            <div class="h-6 w-px bg-gray-300 dark:bg-gray-600"></div>
            <h1 class="font-bold text-gray-800 dark:text-white text-sm sm:text-base truncate max-w-md">{{ $book->title }}</h1>
        </div>
        
        <div class="flex items-center gap-4">
            <button onclick="toggleTheme()" class="p-1.5 rounded-full text-gray-500 dark:text-yellow-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                <svg class="hidden dark:block w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <svg class="block dark:hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
            </button>

            <button onclick="toggleToc()" class="flex items-center gap-2 px-3 py-2 text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-md transition text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                <span class="hidden sm:inline">Daftar Isi</span>
            </button>
        </div>
    </header>

    <div class="flex-1 overflow-y-auto relative" id="main-scroll">
        
        <div id="toc-sidebar" class="fixed inset-y-0 right-0 top-16 w-80 bg-white dark:bg-gray-800 shadow-2xl transform translate-x-full transition-transform duration-300 z-40 border-l border-gray-200 dark:border-gray-700 flex flex-col">
            <div class="p-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-900">
                <span class="font-bold text-gray-700 dark:text-white">Daftar Bab</span>
                <button onclick="toggleToc()" class="text-gray-400 hover:text-red-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div id="toc-list" class="flex-1 overflow-y-auto p-2 space-y-1 pb-20"></div>
        </div>

        <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 flex flex-col min-h-full">
            
            <div id="loader" class="flex flex-col items-center justify-center py-20">
                <div class="w-10 h-10 border-4 border-blue-200 dark:border-gray-600 border-t-blue-900 dark:border-t-yellow-400 rounded-full animate-spin"></div>
                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm font-medium animate-pulse">Memuat Bab...</p>
            </div>

            <div id="viewer" class="rounded shadow-sm transition-colors duration-300"></div>

            <div class="flex justify-between items-center mt-8 pb-10 px-2" id="controls">
                <button onclick="prevChapter()" class="flex items-center gap-2 px-6 py-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 rounded-full shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition disabled:opacity-50 disabled:cursor-not-allowed group">
                    <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    <span>Bab Sebelumnya</span>
                </button>

                <button onclick="nextChapter()" class="flex items-center gap-2 px-6 py-3 bg-blue-900 dark:bg-yellow-500 text-white dark:text-gray-900 rounded-full shadow-md hover:bg-blue-800 dark:hover:bg-yellow-400 transition group">
                    <span>Bab Selanjutnya</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>

        </div>
    </div>


    <script>
        var bookUrl = "{{ asset('storage/' . $book->file_path) }}";
        var book = ePub(bookUrl);
        
        var rendition = book.renderTo("viewer", {
            width: "100%",
            flow: "scrolled",
            manager: "default",
            allowScriptedContent: false
        });

        // TEMA
        rendition.themes.register("light", { body: { color: "#000000", background: "#ffffff" } });
        rendition.themes.register("dark", { body: { color: "#e5e7eb", background: "#1f2937" }, "a": { color: "#60a5fa" } });

        if (localStorage.getItem('color-theme') === 'dark') {
            rendition.themes.select("dark");
        } else {
            rendition.themes.select("light");
        }

        // --- UPDATE PENTING: LOGIKA NAVIGATION YANG LEBIH AMAN ---
        book.loaded.navigation.then(function(tocInput) {
            var $nav = document.getElementById("toc-list");
            $nav.innerHTML = "";
            var docfrag = document.createDocumentFragment();
            
            // 1. Normalisasi Data TOC (Kadang berupa Array, kadang Object)
            var toc = Array.isArray(tocInput) ? tocInput : (tocInput.toc || []);

            // 2. Jika TOC Kosong, Tampilkan pesan & Buka halaman awal default
            if (toc.length === 0) {
                $nav.innerHTML = '<p class="text-center text-gray-400 text-sm mt-10">Daftar isi tidak tersedia.</p>';
                rendition.display().then(() => hideLoader());
                return;
            }
            
            // 3. Generate Sidebar
            toc.forEach(function(chapter) {
                // Cek safety: lewati jika chapter invalid
                if (!chapter) return; 

                var btn = document.createElement("button");
                btn.textContent = (chapter.label || "Bab Tanpa Judul").trim();
                btn.className = "w-full text-left px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-900 dark:hover:text-white border-b border-gray-50 dark:border-gray-700 transition truncate";
                btn.onclick = function() {
                    loadChapter(chapter.href);
                    toggleToc();
                };
                docfrag.appendChild(btn);
            });
            $nav.appendChild(docfrag);

            // 4. STRATEGI SKIP HALAMAN PERTAMA
            // Cek apakah item pertama TOC valid
            if (toc[0] && toc[0].href) {
                // Buka langsung Bab 1 dari TOC (melewati cover/navigasi internal)
                console.log("Membuka bab pertama: " + toc[0].label);
                rendition.display(toc[0].href).then(() => hideLoader());
            } else {
                // Fallback: Jika gagal, buka halaman standar
                rendition.display().then(() => hideLoader());
            }

        }).catch(function(err) {
            console.error("Gagal memuat navigasi:", err);
            // Fallback Terakhir: Tetap buka buku walau navigasi error
            rendition.display().then(() => hideLoader());
        });
        // ---------------------------------------------------------

        // Helper Functions
        function loadChapter(href) {
            document.getElementById('loader').style.display = 'flex';
            rendition.display(href).then(() => {
                hideLoader();
                // Scroll container, bukan window
                var container = document.getElementById('main-scroll');
                if(container) container.scrollTo(0,0);
            });
        }

        function hideLoader() {
            var loader = document.getElementById('loader');
            if(loader) loader.style.display = 'none';
        }

        function nextChapter() {
            document.getElementById('loader').style.display = 'flex';
            rendition.next().then(() => {
                hideLoader();
                var container = document.getElementById('main-scroll');
                if(container) container.scrollTo(0,0);
            });
        }

        function prevChapter() {
            document.getElementById('loader').style.display = 'flex';
            rendition.prev().then(() => {
                hideLoader();
                var container = document.getElementById('main-scroll');
                if(container) container.scrollTo(0,0);
            });
        }

        function toggleToc() {
            var sidebar = document.getElementById('toc-sidebar');
            if (sidebar.classList.contains('translate-x-full')) {
                sidebar.classList.remove('translate-x-full');
            } else {
                sidebar.classList.add('translate-x-full');
            }
        }

        function toggleTheme() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
                rendition.themes.select("light");
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
                rendition.themes.select("dark");
            }
        }
    </script>

</html>