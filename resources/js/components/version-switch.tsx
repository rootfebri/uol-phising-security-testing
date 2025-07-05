'use client';

import { cn } from '@/lib/utils';
import * as SwitchPrimitives from '@radix-ui/react-switch';
import * as React from 'react';

interface VersionSwitchProps extends React.ComponentPropsWithoutRef<typeof SwitchPrimitives.Root> {
    className?: string;
}

const VersionSwitch = React.forwardRef<React.ComponentRef<typeof SwitchPrimitives.Root>, VersionSwitchProps>(
    ({ className, children, ...props }, ref) => {
        return (
            <SwitchPrimitives.Root
                className={cn(
                    'peer focus-visible:ring-ring focus-visible:ring-offset-background inline-flex h-11 w-20 shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent bg-slate-700/90 transition-colors focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50',
                    className,
                )}
                {...props}
                ref={ref}
            >
                <SwitchPrimitives.Thumb
                    className={cn(
                        'bg-background/60 border-background/20 pointer-events-none flex h-9 w-9 items-center justify-center rounded-full border shadow-lg ring-0 backdrop-blur-sm transition-transform data-[state=checked]:translate-x-9 data-[state=unchecked]:translate-x-0',
                    )}
                >
                    {children}
                </SwitchPrimitives.Thumb>
            </SwitchPrimitives.Root>
        );
    },
);
VersionSwitch.displayName = 'VersionSwitch';

export { VersionSwitch };
