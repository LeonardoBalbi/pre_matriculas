@if (request()->is('admin/login'))
    <style>
        .fi-panel-admin .fi-simple-layout {
            position: relative;
            display: grid;
            grid-template-columns: minmax(0, 1.05fr) minmax(420px, .95fr);
            min-height: 100vh;
            overflow: hidden;
            background: #032c5b;
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .fi-panel-admin .fi-simple-layout::before,
        .fi-panel-admin .fi-simple-layout::after {
            position: absolute;
            inset: 0;
            content: "";
        }

        .fi-panel-admin .fi-simple-layout::before {
            background: url("{{ asset('flaro-assets/images/blog/ceim-aarao-de-moura-brito-filho.jpg') }}") center / cover no-repeat;
            transform: scale(1.02);
        }

        .fi-panel-admin .fi-simple-layout::after {
            background: linear-gradient(90deg, rgba(3, 44, 91, .94) 0%, rgba(8, 63, 134, .78) 52%, rgba(245, 248, 252, .96) 52%, rgba(255, 255, 255, .98) 100%);
        }

        .fi-panel-admin .admin-login-hero,
        .fi-panel-admin .fi-simple-main-ctn {
            position: relative;
            z-index: 1;
        }

        .fi-panel-admin .admin-login-hero {
            display: flex;
            align-items: center;
            min-height: 100vh;
            padding: clamp(2rem, 6vw, 5rem);
            color: #fff;
        }

        .fi-panel-admin .admin-login-hero__content {
            width: min(100%, 720px);
        }

        .fi-panel-admin .admin-login-hero__brand {
            display: inline-flex;
            margin-bottom: 2rem;
        }

        .fi-panel-admin .admin-login-hero__brand img {
            width: min(360px, 80vw);
            height: auto;
            filter: brightness(0) invert(1);
        }

        .fi-panel-admin .admin-login-hero__kicker {
            display: inline-block;
            margin-bottom: .75rem;
            color: #9ee7ff;
            font-size: .8rem;
            font-weight: 900;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .fi-panel-admin .admin-login-hero h2 {
            max-width: 680px;
            margin: 0 0 1rem;
            font-size: clamp(2.35rem, 5vw, 4.9rem);
            font-weight: 900;
            line-height: .98;
            letter-spacing: 0;
        }

        .fi-panel-admin .admin-login-hero p {
            max-width: 600px;
            margin: 0 0 1.5rem;
            color: rgba(255, 255, 255, .86);
            font-size: 1.05rem;
            line-height: 1.7;
        }

        .fi-panel-admin .admin-login-hero__actions,
        .fi-panel-admin .admin-login-hero__metrics {
            display: flex;
            flex-wrap: wrap;
            gap: .75rem;
        }

        .fi-panel-admin .admin-login-hero__actions a {
            display: inline-flex;
            align-items: center;
            min-height: 44px;
            padding: .65rem 1rem;
            border: 1px solid rgba(255, 255, 255, .58);
            border-radius: 8px;
            color: #fff;
            font-weight: 800;
            text-decoration: none;
        }

        .fi-panel-admin .admin-login-hero__actions a:first-child {
            background: #fff;
            color: #084f8f;
            border-color: #fff;
        }

        .fi-panel-admin .admin-login-hero__metrics {
            margin-top: 2rem;
        }

        .fi-panel-admin .admin-login-hero__metrics span {
            padding: .55rem .8rem;
            border: 1px solid rgba(255, 255, 255, .24);
            border-radius: 8px;
            background: rgba(255, 255, 255, .1);
            color: rgba(255, 255, 255, .9);
            font-size: .82rem;
            font-weight: 800;
        }

        .fi-panel-admin .fi-simple-main-ctn {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: clamp(1.25rem, 4vw, 3rem);
        }

        .fi-panel-admin .fi-simple-main {
            width: min(100%, 460px);
            max-width: 460px !important;
        }

        .fi-panel-admin .fi-simple-page-content {
            padding: clamp(1.25rem, 4vw, 2rem);
            border: 1px solid rgba(203, 213, 225, .88);
            border-radius: 8px;
            background: rgba(255, 255, 255, .98);
            box-shadow: 0 24px 60px rgba(21, 34, 56, .18);
        }

        .fi-panel-admin .fi-simple-header {
            align-items: flex-start;
            text-align: left;
        }

        .fi-panel-admin .fi-simple-header .fi-logo {
            width: min(270px, 100%);
            height: auto !important;
            object-fit: contain;
        }

        .fi-panel-admin .fi-simple-header-heading {
            color: #152238;
            font-size: 1.75rem;
            font-weight: 900;
            letter-spacing: 0;
        }

        .fi-panel-admin .fi-simple-header-subheading {
            color: #64748b;
            font-size: .96rem;
            line-height: 1.6;
            text-align: left;
        }

        .fi-panel-admin .fi-fo-field-label {
            color: #25344d;
            font-weight: 800;
        }

        .fi-panel-admin .fi-input-wrp {
            min-height: 46px;
            border-color: #cbd5e1;
            border-radius: 8px;
            background: #fff;
        }

        .fi-panel-admin .fi-input-wrp:focus-within {
            border-color: #145ab8;
            box-shadow: 0 0 0 .2rem rgba(20, 90, 184, .14);
        }

        .fi-panel-admin .fi-input {
            color: #152238;
        }

        .fi-panel-admin .fi-btn {
            min-height: 44px;
            border-radius: 8px;
            font-weight: 800;
        }

        .fi-panel-admin .fi-btn-color-primary {
            background: #145ab8;
        }

        .fi-panel-admin .fi-btn-color-primary:hover {
            background: #084f8f;
        }

        @media (max-width: 1023px) {
            .fi-panel-admin .fi-simple-layout {
                grid-template-columns: 1fr;
            }

            .fi-panel-admin .fi-simple-layout::after {
                background: linear-gradient(180deg, rgba(3, 44, 91, .88) 0%, rgba(8, 63, 134, .72) 42%, rgba(245, 248, 252, .98) 42%, rgba(255, 255, 255, .99) 100%);
            }

            .fi-panel-admin .admin-login-hero {
                min-height: auto;
                padding: 1.25rem 1.25rem 0;
            }

            .fi-panel-admin .admin-login-hero__brand img {
                width: min(260px, 70vw);
            }

            .fi-panel-admin .admin-login-hero h2 {
                font-size: 2.2rem;
            }

            .fi-panel-admin .admin-login-hero p,
            .fi-panel-admin .admin-login-hero__metrics {
                display: none;
            }

            .fi-panel-admin .fi-simple-main-ctn {
                min-height: auto;
                padding: 1.25rem;
            }
        }

        @media (max-width: 575px) {
            .fi-panel-admin .admin-login-hero__actions a,
            .fi-panel-admin .fi-btn {
                width: 100%;
                justify-content: center;
            }

            .fi-panel-admin .fi-simple-page-content {
                padding: 1rem;
            }
        }
    </style>
@endif
