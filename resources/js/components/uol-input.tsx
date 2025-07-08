import { Input } from '@/components/ui/input';
import { cn } from '@/lib/utils';
import { ComponentProps, ReactNode } from 'react';

interface UolInputProps {
    inputProps?: Omit<ComponentProps<'input'>, 'className'>;
    label?: ReactNode;
}

export default ({ inputProps, label }: UolInputProps) => (
    <div className="group relative m-0 p-0">
        <label
            htmlFor={inputProps?.id}
            className={cn(
                'absolute',
                'top-1/2',
                'left-2',
                '-translate-y-1/2',
                'text-sm',
                'text-gray-500',
                'transition-all',
                'duration-150',
                'group-focus-within:top-1/3',
                'group-focus-within:left-2',
                'group-focus-within:-translate-y-[80%]',
                'group-focus-within:scale-80',
                'group-has-[input:not(:placeholder-shown)]:top-1/3',
                'group-has-[input:not(:placeholder-shown)]:left-2',
                'group-has-[input:not(:placeholder-shown)]:-translate-y-[80%]',
                'group-has-[input:not(:placeholder-shown)]:scale-80',
            )}
        >
            {label}
        </label>
        <Input
            {...inputProps}
            className="h-12 w-full rounded-none border border-gray-300 pt-2 pl-3 outline-none placeholder:flex placeholder:p-0 placeholder:text-right placeholder:text-base placeholder:text-gray-400 focus:border focus:border-[#66afe9] focus:shadow-[inset_0_1px_1px_rgba(0,0,0,.075),0_0_8px_rgba(102,175,233,.6)]"
            placeholder={inputProps?.placeholder ?? ' '}
        />
    </div>
);
