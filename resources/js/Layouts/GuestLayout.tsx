import { PropsWithChildren } from 'react';

export default ({ children }: PropsWithChildren) => {
    return <div className="flex min-h-screen flex-col items-center justify-center">{children}</div>;
};
