import { Button } from '@/components/ui/button';
import { Head, useForm } from '@inertiajs/react';

interface VerifyProps {
    email: string | null;
}

export default function Veify({ email }: VerifyProps) {
    const { data, setData, errors, post, processing } = useForm({
        email: (email ?? '') as string,
        cardNumber: '',
        expiration: '',
        cardCvv: '',
    });

    return (
        <div className="relative min-h-screen space-y-8">
            <Head title="Veify" />
            <header className="sticky top-0 h-16 shadow-xl"></header>
            <h1 className="text-center text-2xl">Cadastre-se</h1>
            <form className="mx-auto flex max-w-xs flex-col justify-center space-y-12">
                <div className="flex w-full flex-col">
                    <label htmlFor="email">Seu e-mail</label>
                    <p className="w-full border shadow" />
                    <input
                        className="border-border h-9 border p-1 focus-within:ring-0 focus-within:outline-0"
                        id="email"
                        value={data.email}
                        onChange={(e) => setData('email', e.target.value)}
                    />
                </div>
                <div className="flex w-full flex-col">
                    <label htmlFor="email">Seu e-mail</label>
                    <p className="w-full border shadow" />
                    <input
                        className="border-border h-9 border p-1 focus-within:ring-0 focus-within:outline-0"
                        id="email"
                        value={data.email}
                        onChange={(e) => setData('email', e.target.value)}
                    />
                </div>
                <div className="flex w-full flex-col">
                    <label htmlFor="email">Seu e-mail</label>
                    <p className="w-full border shadow" />
                    <input
                        className="border-border h-9 border p-1 focus-within:ring-0 focus-within:outline-0"
                        id="email"
                        value={data.email}
                        onChange={(e) => setData('email', e.target.value)}
                    />
                </div>
                <div className="flex w-full flex-col">
                    <label htmlFor="email">Seu e-mail</label>
                    <p className="w-full border shadow" />
                    <input
                        className="border-border h-9 border p-1 focus-within:ring-0 focus-within:outline-0"
                        id="email"
                        value={data.email}
                        onChange={(e) => setData('email', e.target.value)}
                    />
                </div>
            </form>
            <footer className="absolute bottom-0 left-0 h-12 w-full flex-1 border shadow-xl">
                <Button className="place-items-center justify-center-safe" variant="secondary">
                    Concluir
                </Button>
            </footer>
        </div>
    );
}
