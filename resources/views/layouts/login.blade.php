<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME') }}</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <x-css-layers/>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login_style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/settings_style.css') }}">

    <x-early-frontend-bridge/>
    <script src="{{ asset('js/functions.js') }}"></script>
    <script src="{{ asset('js/settings_functions.js') }}"></script>
    <script src="{{ asset('js/announcements.js') }}"></script>
    @vite('resources/js/app.ts')

    <x-settings-panel/>

    <script>
        InitializePreDomSettings(false);
        UpdateSettingsLanguage();
    </script>

</head>
<body>
<div class="wrapper">
    <div class="sidebar">
        <div class="logo"></div>

        <div class="loginPanel">
            {!! $authForms !!}
        </div>


        <div class="footerPanel">
            @php $tooltipId = str()->uuid() @endphp
            <button class="btn-sm" onclick="toggleSettingsPanel(true)" aria-labelledby="{{ $tooltipId }}">
                <x-icon name="settings-icon" aria-hidden="true"/>
                <div class="label tooltip tt-abs-left" aria-hidden="true" id="{{ $tooltipId }}">
                    {{ __("Settings") }}
                </div>
            </button>
            <div class="impressumPanel">
                <a href="/dataprotection" target="_blank" class="btn-text">{{ __("DataProtection") }}</a>
                <a href="{{ env("IMPRINT_LOCATION") }}" target="_blank" class="btn-text">{{ __("Impressum") }}</a>
            </div>
        </div>

    </div>

    <main>
        <div class="backgroundImageContainer">
            <video class="image_preview_container" src="" type="video/m4v" preload="none" tabindex="-1" autoplay loop muted></video>
            <a href="" target="_blank" class="video-credits" tabindex="-1"></a>
        </div>
    </main>
</div>

@include('partials.overlay')

</body>
</html>

<script>
    window.waitUntilReady(() => {
        if (window.innerWidth < 480) {
            const bgVideo = document.querySelector('.image_preview_container');
            bgVideo.remove();
        }

        setTimeout(() => {
            if (@json($activeOverlay)) {
                // console.log('close overlay');
                setOverlay(false, true);
            }
        }, 100);
    });

    function onLoginKeydown(event) {
        if (event.key === 'Enter') {
            const username = document.getElementById('account');
            // console.log(username.value);
            if (!username.value) {
                return;
            }
            const password = document.getElementById('password');
            if (document.activeElement !== password) {
                password.focus();
                return;
            }
            if (username.value && password.value) {
                submitLogin();
            }
        }
    }

    async function submitLogin() {
        try {
            var formData = new FormData();
            formData.append('account', document.getElementById('account').value);
            formData.append('password', document.getElementById('password').value);
            const csrfToken = document.getElementById('hawkiLoginForm').querySelector('input[name="_token"]').value;

            const response = await fetch('/req/login', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            });

            if (!response.ok) {
                throw new Error('Login request failed');
            }

            const data = await response.json();

            if (data.success) {
                await setOverlay(true, true);
                window.location.href = data.redirectUri;

            } else {
                // console.log('login failed');
                document.getElementById('login-message').textContent = 'Login Failed!';
            }
        } catch (error) {
            console.error(error);
        }
    }

    /**
     * @deprecated: use submitLogin() instead!
     */
    async function LoginLDAP() {
        await submitLogin();
    }
</script>
<!-- 
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME') }}</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('img/blablador-icon.svg') }}">

    <x-css-layers/>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login_style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/settings_style.css') }}">

    <x-early-frontend-bridge/>

    <script src="{{ asset('js/functions.js') }}"></script>
    <script src="{{ asset('js/settings_functions.js') }}"></script>
    <script src="{{ asset('js/announcements.js') }}"></script>

    @vite('resources/js/app.ts')

    <x-settings-panel/>

    <script>
        InitializePreDomSettings(false);
        UpdateSettingsLanguage();
    </script>

    <style>
        body {
            margin: 0;
            min-height: 100vh;
        }

        .login-page {
            min-height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .login-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 2rem;
        }

        .login-logo {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-logo img {
            width: 220px;
            height: auto;
            display: block;
        }

        .loginPanel {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /*
         * Footer: bottom-left
         */
        .login-footer {
            position: fixed;
            left: 1.5rem;
            bottom: 1.5rem;

            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .login-footer .impressumPanel {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .darkMode .login-logo img {
            filter: invert(1);
        }

        @media (max-width: 480px) {
            .login-logo img {
                width: 180px;
            }

            .login-footer {
                left: 1rem;
                bottom: 1rem;
            }
        }
    </style>

</head>

<body>

<div class="login-page">

    <div class="login-content">

        <div class="login-logo">
            <img
                src="{{ asset('img/blablador-logo.svg') }}"
                alt="Blablador"
            >
        </div>

        <div class="loginPanel">
            {!! $authForms !!}
        </div>

    </div>

    <div class="login-footer">

        @php $tooltipId = str()->uuid() @endphp

        <button
            class="btn-sm"
            onclick="toggleSettingsPanel(true)"
            aria-labelledby="{{ $tooltipId }}"
        >
            <x-icon name="settings-icon" aria-hidden="true"/>

            <div
                class="label tooltip tt-abs-left"
                aria-hidden="true"
                id="{{ $tooltipId }}"
            >
                {{ __("Settings") }}
            </div>
        </button>

        <div class="impressumPanel">

            <a
                href="/dataprotection"
                target="_blank"
                class="btn-text"
            >
                {{ __("DataProtection") }}
            </a>

            <a
                href="{{ env("IMPRINT_LOCATION") }}"
                target="_blank"
                class="btn-text"
            >
                {{ __("Impressum") }}
            </a>

        </div>

    </div>

</div>

@include('partials.overlay')

</body>

</html>

<script>
    window.waitUntilReady(() => {
        setTimeout(() => {
            if (@json($activeOverlay)) {
                setOverlay(false, true);
            }
        }, 100);
    });
</script> -->