import type { Config } from 'ziggy-js';

export interface SharedData {
    ziggy: Config & { location: string };

    [key: string]: unknown;
}
