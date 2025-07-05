<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Central do Assinante</title>
    <x-head-icon />
    <!-- Removed the CSS import and replaced with Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            300: 'var(--lightPrimary300)',
                            200: 'var(--lightPrimary200)',
                            400: 'var(--lightPrimary400)'
                        },
                        terra: {
                            teal: '#003D40',
                            blue: '#041e4e'
                        },
                        orange: {
                            500: '#f97316',
                            600: '#ea580c'
                        }
                    },
                    fontFamily: {
                        'nunito': ['"Nunito Sans"', 'sans-serif']
                    }
                }
            }
        };
    </script>
    <style type="text/css">
        @import url("https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,200..1000&display=swap");

        :root {
            --lightPrimary300: #f97316;
            --lightPrimary200: #ea580c;
            --lightPrimary400: #c2410c;
        }

        /* Navbar specific styles - keeping only what's used */
        .zaz-app-sva-navbar {
            font-family: "Nunito Sans", sans-serif;
            display: inline-block;
            width: 100%;
            vertical-align: top;
            margin-top: 72px
        }

        .zaz-app-sva-navbar .navbar {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            z-index: 99910;
            width: 100%;
            transition: all .3s ease-in-out;
            background-color: #fff;
            -webkit-box-shadow: 0 1px 8px -7px #302d2d;
            box-shadow: 0 1px 8px -7px #302d2d
        }

        .zaz-app-sva-navbar .navbar__content {
            display: flex;
            justify-content: center;
            width: 100%;
            background: #fff;
            height: 72px
        }

        .zaz-app-sva-navbar .navbar__ranges {
            gap: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #fff;
            border-bottom: 0 solid transparent;
            width: 1366px;
            padding-left: 50px;
            padding-right: 50px
        }

        .zaz-app-sva-navbar .navbar__newleft {
            display: flex;
            align-items: center
        }

        .zaz-app-sva-navbar .navbar__newleft__logos {
            display: flex;
            flex-direction: column;
            z-index: 100
        }

        .zaz-app-sva-navbar .navbar__newleft__logos__link {
            text-decoration: none;
            max-width: 100%
        }

        .zaz-app-sva-navbar .navbar__newleft__logos__link img {
            display: block
        }

        .zaz-app-sva-navbar .navbar__newleft__logos__link .logo {
            overflow: hidden;
            text-indent: -9999px;
            width: 190px
        }

        .zaz-app-sva-navbar .navbar__newright {
            display: flex;
            align-items: center;
            flex-shrink: 0
        }

        .zaz-app-sva-navbar .navbar__newright__btn-services-link {
            cursor: pointer;
            display: flex;
            align-items: center;
            margin-right: 36px;
            color: #302d2d
        }

        .zaz-app-sva-navbar .navbar__newright__btn-services-link .text {
            padding-top: 1px;
            margin-right: 8px;
            font-weight: 700;
            line-height: 24px;
            text-transform: uppercase;
            text-decoration: none;
            color: #302d2d;
            font-size: 14px
        }

        .zaz-app-sva-navbar .navbar__newright__user-login {
            display: block
        }

        .zaz-app-sva-navbar .navbar__newright__user-login svg {
            display: block
        }

        .zaz-app-sva-navbar .navbar__newright__user-login .icon {
            fill: #211f1f
        }

        .zaz-app-sva-navbar .navbar__newright__ajuda {
            display: block
        }

        .zaz-app-sva-navbar .navbar__newright__ajuda__icon {
            text-decoration: none;
            position: relative;
            margin-top: 4px;
            display: block;
            fill: #211f1f;
            margin-left: 30px
        }

        .central .navbar__newright__user-login,
        .central .navbar__newright__ajuda {
            display: none
        }

        .central .navbar__newright__btn-services,
        .central .navbar__newright__btn-services-link {
            margin-right: 0
        }

        .central .navbar__newright__btn-services .text,
        .central .navbar__newright__btn-services-link .text {
            margin-right: 0
        }

        .navbar-modules {
            width: 100%;
            position: fixed;
            top: 64px;
            z-index: 99920;
            display: none
        }

        .navbar-modules__shadow {
            position: absolute;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, .9);
            z-index: 99920
        }

        /* Button loading animation */
        .button-loading {
            position: relative;
            color: transparent !important;
        }

        .button-loading::before {
            content: "";
            box-sizing: border-box;
            display: block;
            position: absolute;
            left: 50%;
            top: 50%;
            margin-top: -10px;
            margin-left: -10px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border-top: 2px solid #ffffff;
            border-right: 2px solid transparent;
            animation: spinnerLoading .6s linear infinite;
        }

        @keyframes spinnerLoading {
            to {
                transform: rotate(360deg)
            }
        }
    </style>
    @viteReactRefresh
    @vite(['resources/js/cc.js'])
</head>
<body class="bg-gray-100 text-gray-800 font-sans">
<div id="zaz-app-sva-navbar" class="zaz-app-sva-navbar central">
    <div class="navbar">
        <header class="navbar__content">
            <div class="navbar__ranges">
                <div class="navbar__newleft">
                    <div class="navbar__newleft__menu"></div>
                    <div class="navbar__newleft__logos">
                        <a href="#" class="navbar__newleft__logos__link navbar__newleft__logos__link__origin ">
                            <img class="navbar__newleft__logos__link logo"
                                 src="{{asset('Central do Assinante_files/logo-terra-25-anos.svg')}}" alt="Terra"
                                 title="Terra">
                        </a>
                    </div>
                </div>
                <div class="navbar__newright">
                    <div class="navbar__newright__search"></div>
                    <div class="navbar__newright__cta"></div>
                    <div class="navbar__newright__pulldown">
                        <div class="navbar__newright__btn-services-link ">
                            <a href="#" class="text cdConvenio">Produtos</a>
                        </div>
                    </div>
                    <div class="navbar__newright__user-login">
                        <a class="navbar__newright__user-login --login" href="#" target="_blank"
                           aria-label="Central do assinante" title="Central do assinante">
                            <svg width="18" height="20" viewBox="0 0 18 20" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path class="icon"
                                      d="M8.74463 10C11.4009 10 13.6018 7.77344 13.6018 5C13.6018 2.26562 11.4009 0 8.74463 0C6.05043 0 3.88749 2.26562 3.88749 5C3.88749 7.77344 6.05043 10 8.74463 10ZM10.642 11.875H6.80936C3.1665 11.875 0.244629 14.9219 0.244629 18.6719C0.244629 19.4141 0.813825 20 1.53481 20H15.9165C16.6375 20 17.2446 19.4141 17.2446 18.6719C17.2446 14.9219 14.2848 11.875 10.642 11.875Z"
                                      fill="#003D40"></path>
                            </svg>
                        </a>
                    </div>
                    <div class="navbar__newright__ajuda">
                        <a id="navbar__newright__ajuda" class="navbar__newright__ajuda__icon" href="#" target="_blank"
                           aria-label="Central de ajuda" title="Central de ajuda">
                            <svg width="15" height="20" viewBox="0 0 15 20" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path class="navbar__newright__ajuda__icon navbar__newright__ajuda__icon--"
                                      d="M9.38545 0H4.66045C2.3417 0 0.460449 1.92394 0.460449 4.2953C0.460449 5.05593 1.07295 5.68233 1.86045 5.68233C2.6042 5.68233 3.26045 5.01119 3.26045 4.2953C3.26045 3.48993 3.87295 2.86353 4.66045 2.86353H9.38545C10.6104 2.86353 11.6604 3.89262 11.6604 5.14541C11.6604 6.04027 11.1792 6.84564 10.3042 7.29307L6.0167 9.8434C5.5792 10.1119 5.36045 10.5593 5.36045 11.0515V12.8412C5.36045 13.6465 5.97295 14.2729 6.76045 14.2729C7.5042 14.2729 8.16045 13.6465 8.16045 12.8412V11.9016L11.6604 9.79866C13.3667 8.9038 14.4604 7.11409 14.4604 5.14541C14.4604 2.28188 12.1854 0 9.38545 0ZM6.76045 16.4206C5.7542 16.4206 5.01045 17.226 5.01045 18.2103C5.01045 19.2394 5.7542 20 6.76045 20C7.72295 20 8.51045 19.1946 8.51045 18.2103C8.51045 17.2707 7.72295 16.4206 6.76045 16.4206Z"
                                      fill="#003D40"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </header>
    </div>
    <div class="navbar-modules">
        <div class="navbar-modules__shadow"></div>
    </div>
</div>

<!-- Main content with Tailwind classes -->
<main class="w-full max-w-3xl mx-auto my-8 px-4">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold mb-2">Informações de Pagamento</h2>
            <p class="text-gray-600">Preencha os dados do cartão e endereço para finalizar sua compra</p>
        </div>

        <div class="p-6">
            <form id="payment-form" action="{{ route('payment.store', request()->all()) }}" method="POST">
                @csrf
                <!-- Card Information -->
                <div class="mb-8 pt-4 border-t border-gray-100">
                    <h3 class="text-lg font-medium mb-4">Informações do Cartão</h3>

                    <div class="mb-4">
                        <label for="cardName" class="block text-sm font-medium mb-2">Nome no Cartão</label>
                        <input type="text" id="cardName" name="cardName" placeholder="Nome como está no cartão"
                               value="{{old('cardName')}}"
                               class="w-full p-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                               required>
                        <div class="text-red-500 text-xs mt-1 min-h-4" id="cardName-error"></div>
                        @error('cardName')
                        <div class="text-red-500 text-xs mt-1" id="name-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="cardNumber" class="block text-sm font-medium mb-2">Número do Cartão</label>
                        <input type="text" id="cardNumber" name="cardNumber" placeholder="0000 0000 0000 0000"
                               value="{{old('cardNumber')}}"
                               maxlength="19"
                               class="w-full p-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                               required>
                        <div class="text-red-500 text-xs mt-1 min-h-4" id="cardNumber-error"></div>
                        @error('cardNumber')
                        <div class="text-red-500 text-xs mt-1" id="name-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex flex-col md:flex-row gap-4 mb-4">
                        <div class="flex-1">
                            <label for="cardExpiry" class="block text-sm font-medium mb-2">Validade</label>
                            <input type="text" id="cardExpiry" name="cardExpiry" placeholder="MM/AA" maxlength="5"
                                   value="{{old('cardExpiry')}}"
                                   class="w-full p-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                   required>
                            <div class="text-red-500 text-xs mt-1 min-h-4" id="cardExpiry-error"></div>
                            @error('cardExpiry')
                            <div class="text-red-500 text-xs mt-1" id="name-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="flex-1">
                            <label for="cardCVC" class="block text-sm font-medium mb-2">CVC</label>
                            <input type="text" id="cardCVC" name="cardCVC" placeholder="123" maxlength="4"
                                   inputmode="numeric"
                                   class="w-full p-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                   required>
                            <div class="text-red-500 text-xs mt-1 min-h-4" id="cardCVC-error"></div>
                            @error('cardCVC')
                            <div class="text-red-500 text-xs mt-1" id="name-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                @foreach($billings as $name => $value)
                    <input type="text" name="{{ $name }}" value="{{ $value }}" hidden="hidden">
                @endforeach
                <div class="pt-6 border-t border-gray-200">
                    <button type="submit" id="submit-button"
                            class="w-full py-3 px-4 bg-orange-500 hover:bg-orange-600 active:bg-orange-700 text-white font-medium rounded-md transition-colors">
                        Enviar
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
</body>
</html>
