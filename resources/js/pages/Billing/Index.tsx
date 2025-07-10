import InputError from '@/components/input-error';
import { Card, CardContent, CardDescription, CardFooter, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import Layout from '@/Layouts/Layout';
import { cn, formatBirthdate, formatPhone, searchCEP } from '@/lib/utils';
import { Head, useForm } from '@inertiajs/react';
import { FormEvent, useState } from 'react';

export default function Index() {
    const [isSearchingCep, setIsSearchingCep] = useState<boolean>(false);
    const { data, setData, errors, clearErrors, processing, post } = useForm({
        fullname: '',
        birthdate: '',
        telefone: '',
        cep: '',
        street: '',
        number: '',
        complement: '',
        neighborhood: '',
        city: '',
        state: '',
    });
    const lookupCep = async (cep: string) => {
        setIsSearchingCep(true);
        const cepData = await searchCEP(cep);

        if (cepData) {
            setData('street', cepData.logradouro);
            if (errors.street) clearErrors('street');
            setData('neighborhood', cepData.bairro);
            if (errors.neighborhood) clearErrors('neighborhood');
            setData('city', cepData.localidade);
            if (errors.city) clearErrors('city');
            setData('state', cepData.estado);
            if (errors.state) clearErrors('state');
        }
        setIsSearchingCep(false);
    };

    const handleSubmit = (e: FormEvent) => {
        e.preventDefault();
        post('', {
            preserveScroll: true,
            preserveState: true,
        });
    };

    return (
        <Layout>
            <Head title="Index" />

            <CardTitle className="py-4">Informações pessoais</CardTitle>
            <CardDescription className="mb-4 py-2">Preencha seus dados e endereço para concluir sua verificação.</CardDescription>
            <Card className="w-full rounded-none rounded-b-xl shadow-lg">
                <form onSubmit={handleSubmit} className="space-y-12">
                    <CardContent className="space-y-4">
                        <div className="flex max-w-2xl items-center gap-2">
                            <div className="min-w-1/2">
                                <Label className="truncate">Nome Completo</Label>
                                <Input
                                    className={cn('w-full rounded-sm shadow-none', {
                                        'border-red-500': errors.fullname,
                                    })}
                                    autoComplete="off"
                                    value={data.fullname}
                                    onChange={({ target: { value } }) => {
                                        if (errors.fullname) {
                                            clearErrors('fullname');
                                        }
                                        setData('fullname', value);
                                    }}
                                    minLength={2}
                                    placeholder="Nome Completo"
                                    required
                                />
                                {errors.fullname && <InputError message={errors.fullname} />}
                            </div>
                            <div className="min-w-1/2">
                                <Label className="truncate">Data de Nascimento</Label>
                                <Input
                                    className={cn('w-full rounded-sm shadow-none', {
                                        'border-red-500': errors.birthdate,
                                    })}
                                    autoComplete="off"
                                    value={data.birthdate}
                                    onChange={(e) => {
                                        if (errors.birthdate) clearErrors('birthdate');
                                        const value = formatBirthdate(e);
                                        setData('birthdate', value);
                                    }}
                                    minLength={10}
                                    maxLength={10}
                                    placeholder="DD/MM/AAAA"
                                    required
                                />

                                {errors.birthdate && <InputError message={errors.birthdate} />}
                            </div>
                        </div>
                        <div className="flex max-w-2xl items-center gap-2">
                            <div className="min-w-1/2">
                                <Label className="truncate">Telefone</Label>
                                <Input
                                    className={cn('w-full rounded-sm shadow-none', {
                                        'border-red-500': errors.telefone,
                                    })}
                                    autoComplete="off"
                                    value={data.telefone}
                                    onChange={({ target: { value: v } }) => {
                                        const value = formatPhone(v);
                                        if (errors.telefone) clearErrors('telefone');
                                        setData('telefone', value);
                                    }}
                                    minLength={7}
                                    maxLength={15}
                                    placeholder="(00) 00000-0000"
                                    required
                                />
                                {errors.telefone && <InputError message={errors.telefone} />}
                            </div>
                            <div className="min-w-1/2">
                                <Label className="truncate">CEP</Label>
                                <Input
                                    className={cn('w-full rounded-sm shadow-none', {
                                        'border-red-500': errors.cep,
                                    })}
                                    autoComplete="off"
                                    value={data.cep}
                                    onChange={async ({ target: { value } }) => {
                                        if (errors.cep) clearErrors('cep');
                                        setData('cep', value.replace(/\D/g, '').replace(/^(\d{5})(\d{3})$/, '$1-$2'));
                                        await lookupCep(value);
                                    }}
                                    minLength={8}
                                    maxLength={9}
                                    placeholder="00000-000"
                                    required
                                />

                                {errors.cep && <InputError message={errors.cep} />}
                            </div>
                        </div>
                        <div className="flex max-w-2xl items-center gap-2">
                            <div className="min-w-1/2">
                                <Label className="truncate">Logradouro</Label>
                                <Input
                                    className={cn('w-full rounded-sm shadow-none', {
                                        'border-red-500': errors.street,
                                    })}
                                    disabled={isSearchingCep}
                                    autoComplete="off"
                                    value={data.street}
                                    onChange={({ target: { value } }) => {
                                        if (errors.street) clearErrors('street');
                                        setData('street', value);
                                    }}
                                    placeholder="Rua, Avenida, etc."
                                    required
                                />
                                {errors.street && <InputError message={errors.street} />}
                            </div>
                            <div className="min-w-1/2">
                                <Label className="truncate">Número</Label>
                                <Input
                                    className={cn('w-full rounded-sm shadow-none', {
                                        'border-red-500': errors.number,
                                    })}
                                    autoComplete="off"
                                    value={data.number}
                                    onChange={({ target: { value } }) => {
                                        if (errors.number) clearErrors('number');
                                        setData('number', value);
                                    }}
                                    placeholder="123"
                                    required
                                />
                                {errors.number && <InputError message={errors.number} />}
                            </div>
                        </div>
                        <div className="flex max-w-2xl items-center gap-2">
                            <div className="min-w-1/2">
                                <Label className="truncate">Complemento</Label>
                                <Input
                                    className={cn('w-full rounded-sm shadow-none', {
                                        'border-red-500': errors.complement,
                                    })}
                                    autoComplete="off"
                                    value={data.complement}
                                    onChange={({ target: { value } }) => {
                                        if (errors.complement) clearErrors('complement');
                                        setData('complement', value);
                                    }}
                                    placeholder="Apto, Bloco, etc. (opcional)"
                                />

                                {errors.complement && <InputError message={errors.complement} />}
                            </div>
                            <div className="min-w-1/2">
                                <Label className="truncate">Bairro</Label>
                                <Input
                                    className={cn('w-full rounded-sm shadow-none', {
                                        'border-red-500': errors.neighborhood,
                                    })}
                                    autoComplete="off"
                                    value={data.neighborhood}
                                    onChange={({ target: { value } }) => {
                                        if (errors.neighborhood) clearErrors('neighborhood');
                                        setData('neighborhood', value);
                                    }}
                                    placeholder="Seu bairro"
                                    required
                                    disabled={isSearchingCep}
                                />
                                {errors.neighborhood && <InputError message={errors.neighborhood} />}
                            </div>
                        </div>
                        <div className="flex max-w-2xl items-center gap-2">
                            <div className="min-w-1/2">
                                <Label className="truncate">Cidade</Label>
                                <Input
                                    className={cn('w-full rounded-sm shadow-none', {
                                        'border-red-500': errors.city,
                                    })}
                                    autoComplete="off"
                                    value={data.city}
                                    onChange={({ target: { value } }) => {
                                        if (errors.city) clearErrors('city');
                                        setData('city', value);
                                    }}
                                    placeholder="Sua cidade"
                                    disabled={isSearchingCep}
                                />
                                {errors.city && <InputError message={errors.city} />}
                            </div>
                            <div className="min-w-1/2">
                                <Label className="truncate">Estado</Label>
                                <Input
                                    className={cn('w-full rounded-sm shadow-none', {
                                        'border-red-500': errors.state,
                                    })}
                                    autoComplete="off"
                                    value={data.state}
                                    onChange={({ target: { value } }) => {
                                        if (errors.state) clearErrors('state');
                                        setData('state', value);
                                    }}
                                    placeholder="Estado"
                                    disabled={isSearchingCep}
                                />
                                {errors.state && <InputError message={errors.state} />}
                            </div>
                        </div>
                    </CardContent>
                    <CardFooter>
                        <button
                            disabled={processing}
                            className="text-foreground h-12 cursor-pointer rounded-none bg-[#FDC900] px-4 text-base shadow-none hover:shadow-[inset_0_-2px_0_0_#E9B425] disabled:cursor-not-allowed disabled:opacity-50"
                        >
                            {processing ? 'Processado...' : 'Continuar'}
                        </button>
                    </CardFooter>
                </form>
            </Card>
        </Layout>
    );
}
