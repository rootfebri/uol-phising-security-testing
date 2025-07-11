import { WarningIcon } from '@/components/icons';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter, CardHeader } from '@/components/ui/card';
import Layout from '@/Layouts/Layout';
import { Head, useForm } from '@inertiajs/react';

export default function Restricted() {
    const { get, processing } = useForm();
    return (
        <Layout>
            <Head title="Conta Restrita - UOL" />
            <Card className="mx-auto w-full max-w-sm shadow-none rounded-none border-none">
                <CardHeader>
                    <div className="flex h-12 p-2 break-words">
                        <WarningIcon className="size-8" />
                        <strong className="text-2xl text-[#484848]">Conta Restrita</strong>
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
                        className="flex h-12 w-full justify-center rounded-xs bg-[#e29933] px-4 py-3 font-medium text-white transition-colors duration-200 hover:bg-[#d4862e] disabled:opacity-50"
                    >
                        Continuar
                    </Button>
                </CardFooter>
            </Card>
        </Layout>
    );
}
