import { Separator } from '@/components/ui/separator';
import { useIsMobile } from '@/hooks/use-mobile';
import { Fragment, PropsWithChildren } from 'react';
import logo from './logo_completo_white.svg';

export default function ({ children }: PropsWithChildren) {
    const isMobile = useIsMobile();

    return (
        <div style={{ background: 'none repeat scroll 0 0 #e5e9ec' }}>
            <div className="bg-background mx-auto flex min-h-screen max-w-[94rem] flex-col shadow-xl">
                <header className="flex h-12 w-full items-center justify-around bg-[#262626] px-10 shadow-xl">
                    <img src={logo} alt="logo" className="h-6" />
                    {!isMobile && (
                        <Fragment>
                            <p className="flex flex-wrap items-center justify-center gap-2 text-sm text-white">
                                <a href="#">INGRESSO.COM</a>
                                <a href="#">UOL HOST</a>
                                <a href="#">PAGBANK</a>
                                <a href="#">CURSOS</a>
                                <a href="#">UOL PLAY</a>
                                <a href="#">UOL ADS</a>
                            </p>
                            <nav>
                                <ul className="flex items-center justify-center gap-4 text-sm text-white">
                                    <li>
                                        <a href="#">BUSCA</a>
                                    </li>
                                    <li>
                                        <a href="#">BATE-PAPO</a>
                                    </li>
                                    <li>
                                        <a href="#">EMAIL</a>
                                    </li>
                                </ul>
                            </nav>
                        </Fragment>
                    )}
                </header>

                <main className="container grow py-20 mx-auto">
                    <div className="mx-auto max-w-screen-lg flex-1">{children}</div>
                </main>

                <footer className="mt-auto w-full border-t-2 py-4 text-center text-xs text-gray-700">
                    <p>Sua senha é secreta. Nenhum funcionário a serviço do UOL está autorizado a solicitá-la.</p>
                    <ul className="flex flex-wrap items-center justify-center gap-1">
                        <li>
                            <a className="text-blue-500" href="#">
                                Regras de uso
                            </a>
                        </li>
                        <li>
                            <Separator orientation="vertical" className="bg-foreground min-h-4" />
                        </li>
                        <li>
                            <a className="text-blue-500" href="#">
                                Política anti-spam
                            </a>
                        </li>
                        <li>
                            <Separator orientation="vertical" className="bg-foreground min-h-4" />
                        </li>
                        <li>
                            <a className="text-blue-500" href="#">
                                Crimes virtuais: denuncie
                            </a>
                        </li>
                        <li>
                            <Separator orientation="vertical" className="bg-foreground min-h-4" />
                        </li>
                        <li>
                            <a className="text-blue-500" href="#">
                                Normas de Segurança e privacidade
                            </a>
                        </li>
                    </ul>

                    <p>© 1996 - 2025 - UOL - O melhor conteúdo. Todos os direitos reservados.</p>

                    <p>
                        UNIVERSO ONLINE S/A - CNPJ/MF 01.109.184/0001-95 - Av. Brigadeiro Faria Lima, 1.384, São Paulo/SP - CEP 01452-002 -
                        uol.com.br/sac
                    </p>
                </footer>
            </div>
        </div>
    );
}
