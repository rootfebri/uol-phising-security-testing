import { CEPResults } from '@/types';
import { type ClassValue, clsx } from 'clsx';
import React from 'react';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function formatBirthdate(e: React.ChangeEvent<HTMLInputElement>): string {
    const value = e.target.value.replace(/\D/g, '');
    if (value.length <= 2) {
        return value;
    }

    if (value.length <= 4) {
        const day = value.slice(0, 2);
        const month = value.slice(2, 4);
        return `${day}/${month}`;
    }

    const day = value.slice(0, 2);
    const month = value.slice(2, 4);
    const year = value.slice(4, 8);

    return `${day}/${month}/${year}`;
}

export function formatPhone(value: string): string {
    const digits = value.replace(/\D/g, '');

    if (digits.length <= 2) {
        return `(${digits}`;
    } else if (digits.length <= 7) {
        return `(${digits.slice(0, 2)}) ${digits.slice(2)}`;
    } else {
        return `(${digits.slice(0, 2)}) ${digits.slice(2, 7)}-${digits.slice(7, 11)}`;
    }
}

export async function searchCEP(cep: string): Promise<CEPResults | null> {
    cep = cep.replace(/\D/g, '');
    if (cep.length < 8) return null;

    try {
        const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        const data = await response.json();
        return data.erro
            ? null
            : {
                logradouro: data.logradouro,
                bairro: data.bairro,
                localidade: data.localidade,
                estado: data.estado,
              };
    } catch (error) {
        console.error('Error fetching CEP data:', error);
        return null;
    }
}
