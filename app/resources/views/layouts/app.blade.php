<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <i class="bi bi-box-arrow-in-right me-1"></i>{{ __('Login') }}
                                </a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">
                                        <i class="bi bi-person-plus me-1"></i>{{ __('Register') }}
                                    </a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }} <span
                                        class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3"
                                    aria-labelledby="navbarDropdown">
                                    @if(Auth::user()->role === 1)
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                            <i class="bi bi-speedometer2 me-2"></i>管理者ダッシュボード
                                        </a>
                                        <div class="dropdown-divider"></div>
                                    @elseif(Auth::user()->role === 0)
                                        <a class="dropdown-item" href="{{ route('mypage.show') }}">
                                            <i class="bi bi-person me-2"></i>マイページ
                                        </a>
                                        <div class="dropdown-divider"></div>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i>{{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- 非同期処理 --}}
    <script>
        document.addEventListener('click', async (e) => {
            const btn = e.target.closest('.js-bookmark-btn');
            if (!btn) return;

            @if(!auth()->check())
                // 未ログインならログインへ
                window.location.href = "{{ route('login') }}";
                return;
            @endif

            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const postId = btn.dataset.postId;
            const isBookmarked = btn.dataset.bookmarked === '1';

            const url = isBookmarked
                ? "{{ url('/bookmarks') }}/" + postId
                : "{{ url('/bookmarks') }}/" + postId;

            const options = {
                method: isBookmarked ? 'DELETE' : 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            };

            btn.disabled = true;
            try {
                const res = await fetch(url, options);
                const data = await res.json();

                if (data.ok) {
                    btn.dataset.bookmarked = data.bookmarked ? '1' : '0';
                    btn.classList.toggle('btn-warning', data.bookmarked);
                    btn.classList.toggle('btn-outline-warning', !data.bookmarked);

                    const cnt = btn.querySelector('.js-bookmark-count');
                    if (cnt) cnt.textContent = data.count;
                } else {
                    alert('更新に失敗しました');
                }
            } catch (err) {
                console.error(err);
                alert('通信エラーが発生しました');
            } finally {
                btn.disabled = false;
            }
        });
    </script>
</body>

</html>