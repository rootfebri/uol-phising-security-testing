import type { Config } from 'ziggy-js';

export interface SharedData {
    ziggy: Config & { location: string };

    [key: string]: unknown;
}

export interface CEPResults {
    logradouro: string
    bairro: string
    localidade: string
    estado: string
}
