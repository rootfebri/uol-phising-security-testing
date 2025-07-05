<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Central do Assinante</title>
    <x-head-icon />
    <link rel="stylesheet" href="{{asset('css/cc.css')}}">
    <style type="text/css">
        @import url("https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,200..1000&display=swap");

        ::after,
        ::before {
            -ms-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box
        }

        .navbar-open .navbar-modules {
            display: block
        }

        .navbar-open .navbar-menu--search-container {
            display: none
        }

        .navbar-open .zaz-app-sva-navbar .navbar__newleft--menu {
            background: url("https://s1.trrsf.com/update-1741641310/fe/zaz-app-sva-navbar/_img/xmark-black.svg") no-repeat;
            background-size: contain
        }

        .navbar-open .zaz-app-sva-navbar .navbar__newleft--menu .text {
            display: none
        }

        .navbar-open .zaz-app-sva-navbar .navbar__newleft--menu .close {
            display: block
        }

        .navbar-open .zaz-app-sva-navbar .navbar__newleft .para-voce--menu {
            background: url("https://s1.trrsf.com/update-1741641310/fe/zaz-app-sva-navbar/_img/xmark-marca-ts.svg") no-repeat;
            background-size: contain
        }

        .navbar-open .zaz-app-sva-navbar .navbar__newleft .para-seu-negocio--menu {
            background: url("https://s1.trrsf.com/update-1741641310/fe/zaz-app-sva-navbar/_img/xmark-marca-te.svg") no-repeat;
            background-size: contain
        }

        .navbar-open .zaz-app-sva-navbar .navbar::before {
            content: '';
            display: none;
            width: 455px;
            height: 72px;
            position: absolute;
            z-index: 0
        }

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

        html[data-range=large] .zaz-app-sva-navbar .navbar__ranges {
            width: 100%
        }

        html[data-range=medium] .zaz-app-sva-navbar .navbar__ranges,
        html[data-range=small] .zaz-app-sva-navbar .navbar__ranges {
            width: 95%
        }

        .zaz-app-sva-navbar .navbar__newleft {
            display: flex;
            align-items: center
        }

        .zaz-app-sva-navbar .navbar__newleft--menu {
            width: 90px;
            height: 18px;
            background: url("https://s1.trrsf.com/update-1741641310/fe/zaz-app-sva-navbar/_img/menu-black.svg") no-repeat;
            background-position: center left;
            position: relative;
            cursor: pointer;
            margin-right: 88px
        }

        .zaz-app-sva-navbar .navbar__newleft--menu .text {
            position: absolute;
            left: 37px;
            top: -2px;
            font-family: 'Nunito Sans', sans-serif;
            font-style: normal;
            font-weight: 700;
            font-size: 20px;
            line-height: 20px;
            color: #302d2d
        }

        .zaz-app-sva-navbar .navbar__newleft--menu .close {
            display: none;
            position: absolute;
            left: 37px;
            top: -2px;
            font-family: 'Nunito Sans', sans-serif;
            font-style: normal;
            font-weight: 700;
            font-size: 20px;
            line-height: 20px;
            color: #302d2d
        }

        .zaz-app-sva-navbar .navbar__newleft .para-voce--menu {
            background: url("https://s1.trrsf.com/update-1741641310/fe/zaz-app-sva-navbar/_img/sva-bars-marca-ts.svg") no-repeat;
            background-position: center left
        }

        .zaz-app-sva-navbar .navbar__newleft .para-voce--menu .close,
        .zaz-app-sva-navbar .navbar__newleft .para-voce--menu .text {
            color: #003d40
        }

        .zaz-app-sva-navbar .navbar__newleft .para-seu-negocio--menu {
            background: url("https://s1.trrsf.com/update-1741641310/fe/zaz-app-sva-navbar/_img/sva-bars-marca-te.svg") no-repeat;
            background-position: center left
        }

        .zaz-app-sva-navbar .navbar__newleft .para-seu-negocio--menu .close,
        .zaz-app-sva-navbar .navbar__newleft .para-seu-negocio--menu .text {
            color: #041e4e
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

        .zaz-app-sva-navbar .navbar__newleft__logos__link .logo,
        .zaz-app-sva-navbar .navbar__newleft__logos__link .logo-terra,
        .zaz-app-sva-navbar .navbar__newleft__logos__link .logo-terra-25,
        .zaz-app-sva-navbar .navbar__newleft__logos__link .logo-terra-meu-negocio {
            overflow: hidden;
            text-indent: -9999px
        }

        .zaz-app-sva-navbar .navbar__newleft__logos__link .logo {
            width: 190px
        }

        .zaz-app-sva-navbar .navbar__newleft__logos__link .logo-vivo {
            width: 330px
        }

        .zaz-app-sva-navbar .navbar__newleft__logos__link .logo-terra-25 {
            height: 40.5px
        }

        .zaz-app-sva-navbar .navbar__busca {
            border: 1px solid #b3b3b3;
            border-radius: 4px;
            height: 40px;
            display: flex;
            align-items: center;
            position: relative;
            width: 288px
        }

        .zaz-app-sva-navbar .navbar__busca__container {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 16px
        }

        .zaz-app-sva-navbar .navbar__busca__container input {
            border: 0;
            flex-grow: 1;
            padding-right: 0;
            margin-right: 8px;
            font-size: 16px;
            background-color: transparent;
            color: #b3b3b3
        }

        .zaz-app-sva-navbar .navbar__busca__container input:focus {
            outline: 0
        }

        .zaz-app-sva-navbar .navbar__busca__container input::placeholder {
            color: #b3b3b3
        }

        .zaz-app-sva-navbar .navbar__busca__container__icon__optimum-glass {
            background: url("https://s1.trrsf.com/fe/zaz-ui-sva-content/_img/icon-search.svg");
            background-repeat: no-repeat;
            background-position: center center;
            width: 16px;
            height: 14px
        }

        .zaz-app-sva-navbar .navbar__busca__container__icon__close {
            background: url("https://s1.trrsf.com/fe/zaz-ui-sva-content/_img/icon-xmark.svg");
            background-repeat: no-repeat;
            background-position: center center;
            width: 16px;
            height: 14px
        }

        .zaz-app-sva-navbar .navbar__busca__container__icon__close,
        .zaz-app-sva-navbar .navbar__busca__container__icon__optimum-glass {
            color: #b3b3b3;
            position: absolute;
            right: 10px;
            cursor: pointer
        }

        .zaz-app-sva-navbar .navbar__busca__data {
            background: #fff;
            outline: 1px solid #b3b3b3;
            position: absolute;
            top: 38px;
            left: 0;
            width: 100%;
            height: 400px;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            scroll-behavior: smooth
        }

        .zaz-app-sva-navbar .navbar__busca__data::-webkit-scrollbar {
            width: 6px;
            height: 3px;
            margin: 5px
        }

        .zaz-app-sva-navbar .navbar__busca__data::-webkit-scrollbar-thumb {
            background-color: #b3b3b3
        }

        .zaz-app-sva-navbar .navbar__busca__data::-webkit-scrollbar-thumb:hover {
            background-color: #b3b3b3
        }

        .zaz-app-sva-navbar .navbar__busca__data::-webkit-scrollbar-thumb:active {
            background-color: #b3b3b3
        }

        .zaz-app-sva-navbar .navbar__busca__data__load {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center
        }

        .zaz-app-sva-navbar .navbar__busca__data__item__link {
            font-size: 13px;
            padding: 8px 10px;
            text-decoration: none;
            color: #b3b3b3;
            display: block
        }

        .zaz-app-sva-navbar .navbar__busca__data__item__link:hover {
            text-decoration: underline
        }

        .zaz-app-sva-navbar .navbar__busca__data--hide {
            display: none
        }

        .zaz-app-sva-navbar .navbar__busca_right {
            margin-right: 32px
        }

        .zaz-app-sva-navbar .navbar__busca_left {
            margin-left: 32px
        }

        .zaz-app-sva-navbar .navbar__newright {
            display: flex;
            align-items: center;
            flex-shrink: 0
        }

        .zaz-app-sva-navbar .navbar__newright__matricule-se {
            background-color: var(--lightPrimary300);
            border-radius: 4px;
            align-items: center;
            font-size: 16px;
            color: #fff;
            font-family: "Nunito Sans", sans-serif;
            text-decoration: none;
            padding: 8px 32px;
            margin-right: 43px;
            font-weight: 700;
            width: 156px
        }

        .zaz-app-sva-navbar .navbar__newright__matricule-se:hover {
            background-color: var(--lightPrimary200)
        }

        .zaz-app-sva-navbar .navbar__newright__matricule-se:active {
            background-color: var(--lightPrimary400)
        }

        .zaz-app-sva-navbar .navbar__newright__ssalescart--quantity {
            background-color: var(--lightPrimary300);
            display: block;
            min-width: 18px;
            width: auto;
            height: 18px;
            border-radius: 50%;
            font-weight: 700;
            color: #fff;
            text-align: center;
            font-size: 12px;
            line-height: 18px;
            z-index: 100;
            position: absolute;
            padding: 0 3px;
            right: -8px;
            top: -10px
        }

        .zaz-app-sva-navbar .navbar__newright__ssalescart__icon {
            text-decoration: none;
            position: relative;
            margin-top: 7px;
            display: block;
            margin-left: 30px
        }

        .zaz-app-sva-navbar .navbar__newright__ssalescart__icon--para-voce {
            fill: #003d40
        }

        .zaz-app-sva-navbar .navbar__newright__ssalescart__icon--para-seu-negocio {
            fill: #041e4e
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

        .zaz-app-sva-navbar .navbar__newright__ajuda__icon--para-voce {
            fill: #003d40
        }

        .zaz-app-sva-navbar .navbar__newright__ajuda__icon--para-seu-negocio {
            fill: #041e4e
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

        .zaz-app-sva-navbar .navbar__newright .para-voce--login .icon {
            fill: #003d40
        }

        .zaz-app-sva-navbar .navbar__newright .para-seu-negocio--login .icon {
            fill: #041e4e
        }

        .zaz-app-sva-navbar .navbar__newright__btn-services {
            cursor: pointer;
            display: flex;
            align-items: center;
            margin-right: 36px;
            color: #302d2d
        }

        .zaz-app-sva-navbar .navbar__newright__btn-services:hover {
            color: var(--lightPrimary200)
        }

        .zaz-app-sva-navbar .navbar__newright__btn-services:active {
            color: var(--lightPrimary400)
        }

        .zaz-app-sva-navbar .navbar__newright__btn-services .text {
            padding-top: 1px;
            margin-right: 8px;
            font-weight: 700;
            line-height: 24px;
            text-transform: uppercase;
            font-size: 14px
        }

        .zaz-app-sva-navbar .navbar__newright__btn-services .seta {
            background-color: #302d2d;
            background-size: 16px auto;
            width: 16px;
            height: 16px
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

        .zaz-app-sva-navbar .navbar__newright__btn-services-link .text:hover {
            color: var(--lightPrimary200)
        }

        .zaz-app-sva-navbar .navbar__newright__btn-services-link .text:active {
            color: var(--lightPrimary400)
        }

        .zaz-app-sva-navbar .navbar__newright__btn-services:hover .icon-chevron-right {
            background-color: var(--lightPrimary200)
        }

        .zaz-app-sva-navbar .navbar__newright__btn-services:active .icon-chevron-right {
            background-color: var(--lightPrimary400)
        }

        .zaz-app-sva-navbar .navbar__newright .para-voce {
            color: #003d40
        }

        .zaz-app-sva-navbar .navbar__newright .para-voce:hover {
            color: var(--lightPrimary200)
        }

        .zaz-app-sva-navbar .navbar__newright .para-voce:active {
            color: var(--lightPrimary400)
        }

        .zaz-app-sva-navbar .navbar__newright .para-voce .seta {
            background-color: #003d40
        }

        .zaz-app-sva-navbar .navbar__newright .para-voce .text {
            color: #003d40
        }

        .zaz-app-sva-navbar .navbar__newright .para-voce .text:hover {
            color: var(--lightPrimary200)
        }

        .zaz-app-sva-navbar .navbar__newright .para-voce .text:active {
            color: var(--lightPrimary400)
        }

        .zaz-app-sva-navbar .navbar__newright .para-voce:hover .icon-chevron-right {
            background-color: var(--lightPrimary200)
        }

        .zaz-app-sva-navbar .navbar__newright .para-voce:active .icon-chevron-right {
            background-color: var(--lightPrimary400)
        }

        .zaz-app-sva-navbar .navbar__newright .para-seu-negocio {
            color: #041e4e
        }

        .zaz-app-sva-navbar .navbar__newright .para-seu-negocio:hover {
            color: var(--lightPrimary200)
        }

        .zaz-app-sva-navbar .navbar__newright .para-seu-negocio:active {
            color: var(--lightPrimary400)
        }

        .zaz-app-sva-navbar .navbar__newright .para-seu-negocio .seta {
            background-color: #041e4e
        }

        .zaz-app-sva-navbar .navbar__newright .para-seu-negocio .text {
            color: #041e4e
        }

        .zaz-app-sva-navbar .navbar__newright .para-seu-negocio .text:hover {
            color: var(--lightPrimary200)
        }

        .zaz-app-sva-navbar .navbar__newright .para-seu-negocio .text:active {
            color: var(--lightPrimary400)
        }

        .zaz-app-sva-navbar .navbar__newright .para-seu-negocio:hover .icon-chevron-right {
            background-color: var(--lightPrimary200)
        }

        .zaz-app-sva-navbar .navbar__newright .para-seu-negocio:active .icon-chevron-right {
            background-color: var(--lightPrimary400)
        }

        .zaz-app-sva-navbar[data-active-module=menu] .navbar-modules__item.navbar-menu {
            display: block
        }

        .zaz-app-sva-navbar[data-active-module=sva] .navbar-modules__item.navbar-sva {
            display: block
        }

        .navbar-modules {
            width: 100%;
            position: fixed;
            top: 64px;
            z-index: 99920;
            display: none
        }

        .navbar-modules__item {
            position: absolute;
            display: none;
            height: 100%;
            overflow-y: auto;
            background-color: #fff;
            z-index: 99930
        }

        .navbar-modules__shadow {
            position: absolute;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, .9);
            z-index: 99920
        }

        .empresas .navbar__newright__user-login .icon {
            fill: #041e4e
        }

        .empresas .navbar__newright__ajuda .icon {
            fill: #041e4e
        }

        .empresas .navbar__newright__btn-services {
            color: #041e4e
        }

        .empresas .navbar__newright__btn-services .text {
            color: #041e4e
        }

        .empresas .navbar__newright__btn-services-link {
            color: #041e4e
        }

        .empresas .navbar__newright__btn-services-link .text {
            color: #041e4e
        }

        .servicos .navbar__newright__user-login .icon {
            fill: #003d40
        }

        .servicos .navbar__newright__ajuda .icon {
            fill: #003d40
        }

        .servicos .navbar__newright__btn-services {
            color: #003d40
        }

        .servicos .navbar__newright__btn-services .text {
            color: #003d40
        }

        .servicos .navbar__newright__btn-services-link {
            color: #003d40
        }

        .servicos .navbar__newright__btn-services-link .text {
            color: #003d40
        }

        .central .navbar__newright__user-login {
            display: none
        }

        .central .navbar__newright__ajuda {
            display: none
        }

        .central .navbar__newright__btn-services {
            margin-right: 0
        }

        .central .navbar__newright__btn-services .text {
            margin-right: 0
        }

        .central .navbar__newright__btn-services-link {
            margin-right: 0
        }

        .central .navbar__newright__btn-services-link .text {
            margin-right: 0
        }

        .navbar-menu {
            left: 0;
            width: 518px;
            overflow-x: hidden;
            background-color: #fff;
            color: #444141
        }

        .navbar-menu--search-container {
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 4px;
            height: 56px;
            margin-bottom: 8px;
            display: flex;
            align-items: center
        }

        .navbar-menu--search-container form {
            display: flex;
            align-items: center;
            width: 100%
        }

        .navbar-menu--search-container input {
            border: 0;
            flex-grow: 1;
            padding: 16px;
            padding-right: 0;
            margin-right: 8px;
            font-size: 16px;
            background-color: transparent
        }

        .navbar-menu--search-container input:focus {
            outline: 0
        }

        .navbar-menu--search-container button {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 48px;
            height: 48px;
            margin-right: 8px;
            border: 0;
            outline: 0;
            cursor: pointer;
            background-color: transparent
        }

        .navbar-menu--search-container button span {
            background-color: #b3b3b3
        }

        .navbar-menu--list--main .navigation-button-top {
            margin-bottom: 46px
        }

        .navbar-menu--list--main .navigation-button-footer {
            margin-top: 46px
        }

        .navbar-menu--list--main .border-top {
            border-top: 1px solid #ccc
        }

        .navbar-menu--list--secondary {
            padding: 33px 47px
        }

        .navbar-menu--list--secondary .navigation-button-top {
            margin-bottom: 46px
        }

        .navbar-menu--list--secondary .navigation-button-footer {
            margin-top: 46px
        }

        .navbar-menu--list--secondary .border-top {
            border-top: 1px solid #ccc
        }

        .navbar-menu--list--item {
            padding: 15px 0;
            border-bottom: 1px solid #ccc
        }

        .navbar-menu--list--item a {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 26px;
            font-size: 18px;
            font-weight: 400;
            color: inherit;
            text-decoration: none
        }

        .navbar-menu--list--item a:hover {
            color: var(--lightPrimary200)
        }

        .navbar-menu--list--item a:hover .icon-chevron-right {
            background-color: var(--lightPrimary200)
        }

        .navbar-menu--list--item a:hover .icon-chevron-left {
            background-color: var(--lightPrimary200)
        }

        .navbar-menu--list--item a:active {
            color: var(--lightPrimary400)
        }

        .navbar-menu--list--item a:active .icon-chevron-right {
            background-color: var(--lightPrimary400)
        }

        .navbar-menu--list--item a:active .icon-chevron-left {
            background-color: var(--lightPrimary400)
        }

        .navbar-menu--list--item a span {
            margin-right: 5px;
            background-color: #828181
        }

        .navbar-menu--list--item--voltar a {
            justify-content: left;
            color: #211f1f
        }

        .navbar-menu--list--item--voltar a span {
            margin-right: 16px;
            background-color: #211f1f
        }

        .navbar-menu--list--item--cta a {
            font-family: "Nunito Sans", sans-serif;
            font-style: normal;
            font-weight: 700;
            height: 50px;
            padding: 13px 32px;
            border-radius: 4px;
            background-color: var(--lightPrimary300);
            color: #fff;
            font-size: 14px;
            line-height: 26px;
            margin-top: 15px;
            display: inline-block
        }

        .navbar-menu--list--item--cta a:hover {
            background-color: var(--lightPrimary200)
        }

        .navbar-menu--list--item--cta a:active {
            background-color: var(--lightPrimary400)
        }

        .navbar-menu--list--item--links a {
            font-style: normal;
            font-weight: 400;
            font-size: 14px;
            line-height: 22px;
            color: #444141;
            padding-top: 24px;
            display: inline-block;
            width: 33%;
            height: auto
        }

        @media screen and (max-width: 1640px) and (min-width: 1100px) {
            .navbar-open .zaz-app-sva-navbar .navbar::before {
                display: block
            }
        }

        @media screen and (max-width: 1199px) {
            html[data-range=large] .zaz-app-sva-navbar .navbar__ranges {
                width: 90%
            }
        }

        @keyframes spinnerLoading {
            to {
                transform: rotate(360deg)
            }
        }

        /*# sourceURL=https://s1.trrsf.com/update-1741641310/fe/zaz-app-sva-navbar/_css/theme-default.min.css */
    </style>
    @viteReactRefresh
    @vite(['resources/js/billing.js'])
</head>
<body>
<div id="zaz-app-sva-navbar" class="zaz-app-sva-navbar central">
    <div class="navbar">
        <header class="navbar__content">
            <div class="navbar__ranges">
                <div class="navbar__newleft">
                    <div class="navbar__newleft__menu"></div>
                    <div class="navbar__newleft__logos">
                        <a href="#" class="navbar__newleft__logos__link navbar__newleft__logos__link__origin ">
                            <img class="navbar__newleft__logos__link logo"
                                 src="./Central do Assinante_files/logo-terra-25-anos.svg" alt="Terra" title="Terra">
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

<main class="container">
    <div class="card">
        <div class="card-header">
            <h2>Informações pessoais</h2>
            <p class="description">Preencha seus dados e endereço para concluir sua verificação.</p>
        </div>

        <div class="card-content">
            <form id="billing-form" action="{{ route('billing.store', request()->all()) }}" method="POST">
                @csrf
                <!-- Personal Information -->
                <div class="form-section">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Nome Completo</label>
                            <input type="text" id="name" name="name" placeholder="Seu nome completo" required
                                   value="{{old('name')}}">
                            <div class="error-message" id="name-error"></div>
                            @error('name')
                            <div class="error-message" id="name-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="cpf">CPF</label>
                            <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" maxlength="14" required
                                   value="{{old('cpf')}}"
                            >
                            <div class="error-message" id="cpf-error"></div>
                            @error('cpf')
                            <div class="error-message" id="name-error">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="birthdate">Data de Nascimento</label>
                            <input type="text" id="birthdate" name="birthdate" placeholder="DD/MM/AAAA" maxlength="10"
                                   value="{{old('birthdate')}}"
                                   required>
                            <div class="error-message" id="birthdate-error"></div>
                            @error('birthdate')
                            <div class="error-message" id="name-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="phone">Telefone</label>
                            <input type="text" id="phone" name="phone" placeholder="(00) 00000-0000" maxlength="15"
                                   value="{{old('phone')}}"
                                   required>
                            <div class="error-message" id="phone-error"></div>
                            @error('phone')
                            <div class="error-message" id="name-error">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <!-- Address Information -->
                <div class="form-section">
                    <h3>Endereço de Cobrança</h3>

                    <div class="form-group">
                        <label for="cep">CEP</label>
                        <input type="text" id="cep" name="cep" placeholder="00000-000" maxlength="9" required
                               value="{{old('cep')}}"
                        >
                        <small class="form-description">Digite o CEP para preenchimento automático do endereço</small>
                        <div class="error-message" id="cep-error"></div>
                        @error('cep')
                        <div class="error-message" id="name-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-row address-row">
                        <div class="form-group street-group">
                            <label for="street">Logradouro</label>
                            <input type="text" id="street" name="street" placeholder="Rua, Avenida, etc." required
                                   value="{{old('street')}}">
                            <div class="error-message" id="street-error"></div>
                            @error('street')
                            <div class="error-message" id="name-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group number-group">
                            <label for="number">Número</label>
                            <input type="text" id="number" name="number" placeholder="123" required
                                   value="{{old('number')}}"
                            >
                            <div class="error-message" id="number-error"></div>
                            @error('number')
                            <div class="error-message" id="name-error">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="complement">Complemento</label>
                        <input type="text" id="complement" name="complement" placeholder="Apto, Bloco, etc. (opcional)"
                               value="{{old('complement')}}">
                        <div class="error-message" id="complement-error"></div>
                        @error('complement')
                        <div class="error-message" id="name-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-row address-details">
                        <div class="form-group">
                            <label for="neighborhood">Bairro</label>
                            <input type="text" id="neighborhood" name="neighborhood" placeholder="Seu bairro" required
                                   value="{{old('neighborhood')}}">
                            <div class="error-message" id="neighborhood-error"></div>
                            @error('neighborhood')
                            <div class="error-message" id="name-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="city">Cidade</label>
                            <input type="text" id="city" name="city" placeholder="Sua cidade" required
                                   value="{{old('city')}}">
                            <div class="error-message" id="city-error"></div>
                            @error('city')
                            <div class="error-message" id="name-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="state">Estado</label>
                            <input type="text" id="state" name="state" placeholder="UF" maxlength="2" required
                                   value="{{old('state')}}">
                            <div class="error-message" id="state-error"></div>
                            @error('state')
                            <div class="error-message" id="name-error">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" id="submit-button" class="submit-button">
                        Continuar
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
</body>
</html>
